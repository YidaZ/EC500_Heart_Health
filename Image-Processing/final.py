#!/usr/bin/env python
import cv2
import numpy as np
import dicom
import json
import os
import shutil
import sys
import random
import re
from matplotlib import image
from scipy.ndimage import label
from scipy.ndimage.morphology import binary_erosion
from scipy.fftpack import fftn, ifftn
from scipy.signal import argrelmin, correlate
from scipy.spatial.distance import euclidean
from scipy.stats import linregress
from scipy.ndimage.filters import gaussian_filter
from scipy.optimize import curve_fit
from scipy.interpolate import UnivariateSpline

NUM_BINS = 100
STD_MULTIPLIER = 2
THRESHOLD_AREA = 250
COMPONENT_INDEX_TOLERANCE = 20
ANGLE_SLICES = 36

def log(msg, lvl):
    string = ""
    for i in range(lvl):
        string += " "
    string += msg
    print string

def auto_segment_all_datasets():
    d = sys.argv[1]
    train = sys.argv[2]
    studies = next(os.walk(os.path.join(d, train)))[1]
    num_samples = None
    if len(sys.argv) > 3:
        num_samples = int(sys.argv[3])
        studies = random.sample(studies, num_samples)
  


    for s in studies:

        dset = Dataset(full_path, s)
        p_edv = 0
        p_esv = 0
        try:
            dset.load()
            segment_dataset(dset)
            if dset.edv >= 6000 or dset.esv >= 6000:
                raise Exception("Prediction too large")
            p_edv = dset.edv
            p_esv = dset.esv
            p_ef  = ((p_edv - p_esv) / p_edv * 0.1335) + 0.5336
        except Exception as e:
            log("***ERROR***: Exception %s thrown by dataset %s" % (str(e), dset.name), 0)

class Dataset(object):
    dataset_count = 0

    def __init__(self, directory, subdir):
        while True:
            subdirs = next(os.walk(directory))[1]
            if len(subdirs) == 1:
                directory = os.path.join(directory, subdirs[0])
            else:
                break

        slices = []
        for s in subdirs:
            m = re.match("sax_(\d+)", s)
            if m is not None:
                slices.append(int(m.group(1)))

        slices_map = {}
        first = True
        times = []
        for s in slices:
            files = next(os.walk(os.path.join(directory, "sax_%d" % s)))[2]
            offset = None

            for f in files:
                m = re.match("IM-(\d{4,})-(\d{4})\.dcm", f)
                if m is not None:
                    if first:
                        times.append(int(m.group(2)))
                    if offset is None:
                        offset = int(m.group(1))

            first = False
            slices_map[s] = offset

        self.directory = directory
        self.time = sorted(times)
        self.slices = sorted(slices)
        self.slices_map = slices_map
        Dataset.dataset_count += 1
        self.name = subdir

    def _filename(self, s, t):
        return os.path.join(self.directory,"sax_%d" % s, "IM-%04d-%04d.dcm" % (self.slices_map[s], t))

    def _read_dicom_image(self, filename):
        d = dicom.read_file(filename)
        img = d.pixel_array
        return np.array(img)

    def _read_all_dicom_images(self):
        f1 = self._filename(self.slices[0], self.time[0])
        d1 = dicom.read_file(f1)
        (x, y) = d1.PixelSpacing
        (x, y) = (float(x), float(y))
        f2 = self._filename(self.slices[1], self.time[0])
        d2 = dicom.read_file(f2)

        # try a couple of things to measure distance between slices
        try:
            dist = np.abs(d2.SliceLocation - d1.SliceLocation)
        except AttributeError:
            try:
                dist = d1.SliceThickness
            except AttributeError:
                dist = 8  # better than nothing...

        self.images = np.array([[self._read_dicom_image(self._filename(d, i))
                                 for i in self.time]
                                for d in self.slices])
        self.dist = dist
        self.area_multiplier = x * y

    def load(self):
        self._read_all_dicom_images()


def segment_dataset(dataset):
    images = dataset.images
    dist = dataset.dist
    areaMultiplier = dataset.area_multiplier
    rois, circles = calc_rois(images)
    all_masks, all_areas = calc_all_areas(images, rois, circles)
    area_totals = [calc_total_volume(a, areaMultiplier, dist)
                   for a in all_areas]
    edv = max(area_totals)
    esv = min(area_totals)
    ef = ((edv - esv) / edv * 0.1335) + 0.5336
    log("%f" % ef, 1)

    save_masks_to_dir(dataset, all_masks)

    dataset.edv = edv
    dataset.esv = esv
    dataset.ef = ef

def calc_rois(images):
    (num_slices, _, _, _) = images.shape
    dc = np.mean(images, 1)

    def get_H1(i):
        ff = fftn(images[i])
        first_harmonic = ff[1, :, :]
        result = np.absolute(ifftn(first_harmonic))
        result = cv2.GaussianBlur(result, (5, 5), 0)
        return result

    h1s = np.array([get_H1(i) for i in range(num_slices)])
    m = np.max(h1s) * 0.05
    h1s[h1s < m] = 0

    regress_h1s = regression_filter(h1s)
    proc_regress_h1s, coords = post_process_regression(regress_h1s)
    rois, circles = get_ROIs(dc, proc_regress_h1s, coords)
    return rois, circles

def regression_filter(imgs):
    condition = True
    iternum = 0
    while(condition):
        iternum += 1
        imgs_filtered = regress_and_filter_distant(imgs)
        c1 = get_centroid(imgs)
        c2 = get_centroid(imgs_filtered)
        dc = np.linalg.norm(c1 - c2)
        imgs = imgs_filtered
        condition = (dc > 1.0)  
    return imgs

def get_centroid(img):
    nz = np.nonzero(img)
    pxls = np.transpose(nz)
    weights = img[nz]
    avg = np.average(pxls, axis=0, weights=weights)
    return avg

def regress_and_filter_distant(imgs):
    centroids = np.array([get_centroid(img) for img in imgs])
    raw_coords = np.transpose(np.nonzero(imgs))
    (xslope, xintercept, yslope, yintercept) = regress_centroids(centroids)
    (coords, dists, weights) = get_weighted_distances(imgs, raw_coords, xslope,
                                                      xintercept, yslope,
                                                      yintercept)
    outliers = get_outliers(coords, dists, weights)
    imgs_cpy = np.copy(imgs)
    for c in outliers:
        (z, x, y) = c
        imgs_cpy[z, x, y] = 0
    return imgs_cpy

def regress_centroids(cs):
    num_slices = len(cs)
    y_centroids = cs[:, 0]
    x_centroids = cs[:, 1]
    z_values = np.array(range(num_slices))

    (xslope, xintercept, _, _, _) = linregress(z_values, x_centroids)
    (yslope, yintercept, _, _, _) = linregress(z_values, y_centroids)

    return (xslope, xintercept, yslope, yintercept)

def get_weighted_distances(imgs, coords, xs, xi, ys, yi):
    a = np.array([0, yi, xi])
    n = np.array([1, ys, xs])

    zeros = np.zeros(3)

    def dist(p):
        to_line = (a - p) - (np.dot((a - p), n) * n)
        d = euclidean(zeros, to_line)
        return d

    def weight(p):
        (z, y, x) = p
        return imgs[z, y, x]

    dists = np.array([dist(c) for c in coords])
    weights = np.array([weight(c) for c in coords])
    return (coords, dists, weights)

def get_outliers(coords, dists, weights):
    fivep = int(len(weights) * 0.05)
    ctr = 1
    while True:
        (mean, std, fn) = gaussian_fit(dists, weights)
        low_values = dists < (mean - STD_MULTIPLIER*np.abs(std))
        high_values = dists > (mean + STD_MULTIPLIER*np.abs(std))
        outliers = np.logical_or(low_values, high_values)
        if len(coords[outliers]) == len(coords):
            weights[-fivep*ctr:] = 0
            ctr += 1
        else:
            return coords[outliers]

def gaussian_fit(dists, weights):
    (x, y) = histogram_transform(dists, weights)
    fivep = int(len(x) * 0.05)
    xtmp = x
    ytmp = y
    fromFront = False
    while True:
        if len(xtmp) == 0 and len(ytmp) == 0:
            if fromFront:
                idx = np.argmax(y)
                xmax = x[idx]
                p0 = [max(y), xmax, xmax]
                (A, mu, sigma) = p0
                return mu, sigma, lambda x: gauss(x, A, mu, sigma)
            else:
                fromFront = True
                xtmp = x
                ytmp = y

        idx = np.argmax(ytmp)
        xmax = xtmp[idx]

        def gauss(x, *p):
            A, mu, sigma = p
            return A*np.exp(-(x-mu)**2/(2.*sigma**2))

        p0 = [max(ytmp), xmax, xmax]
        try:
            coeff, var_matrix = curve_fit(gauss, xtmp, ytmp, p0=p0)
            (A, mu, sigma) = coeff
            return (mu, sigma, lambda x: gauss(x, A, mu, sigma))
        except RuntimeError:
            if fromFront:
                xtmp = xtmp[fivep:]
                ytmp = ytmp[fivep:]
            else:
                xtmp = xtmp[:-fivep]
                ytmp = ytmp[:-fivep]

def histogram_transform(values, weights):
    hist, bins = np.histogram(values, bins=NUM_BINS, weights=weights)
    bin_width = bins[1] - bins[0]
    bin_centers = bins[:-1] + (bin_width / 2)

    return (bin_centers, hist)

def post_process_regression(imgs):
    (numimgs, _, _) = imgs.shape
    centroids = np.array([get_centroid(img) for img in imgs])
    (xslope, xintercept, yslope, yintercept) = regress_centroids(centroids)
    imgs_cpy = np.copy(imgs)

    def filter_one_img(zlvl):
        points_on_zlvl = np.transpose(imgs[zlvl].nonzero())
        points_on_zlvl = np.insert(points_on_zlvl, 0, zlvl, axis=1)
        (coords, dists, weights) = get_weighted_distances(imgs, points_on_zlvl,
                                                          xslope, xintercept,
                                                          yslope, yintercept)
        outliers = get_outliers(coords, dists, weights)
        for c in outliers:
            (z, x, y) = c
            imgs_cpy[z, x, y] = 0

    return (imgs_cpy, (xslope, xintercept, yslope, yintercept))

def get_ROIs(originals, h1s, regression_params):
    (xslope, xintercept, yslope, yintercept) = regression_params
    (num_slices, _, _) = h1s.shape
    results = []
    circles = []
    for i in range(num_slices):
        o = originals[i]
        h = h1s[i]
        ctr = (xintercept + xslope * i, yintercept + yslope * i)
        r = circle_smart_radius(h, ctr)
        tmp = np.zeros_like(o)
        floats_draw_circle(tmp, ctr, r, 1, -1)
        results.append(tmp * o)
        circles.append((ctr, r))

    return (np.array(results), np.array(circles))

def circle_smart_radius(img, center):
    domain = np.arange(1, 100)
    (xintercept, yintercept) = center

    def ratio(r):
        return filled_ratio_of_circle(img, (xintercept, yintercept), r)*r

    y = np.array([ratio(d) for d in domain])
    most = np.argmax(y)
    return domain[most]

def filled_ratio_of_circle(img, center, r):
    mask = np.zeros_like(img)
    floats_draw_circle(mask, center, r, 1, -1)
    masked = mask * img
    (x, _) = np.nonzero(mask)
    (x2, _) = np.nonzero(masked)
    if x.size == 0:
        return 0
    return float(x2.size) / x.size

def floats_draw_circle(img, center, r, color, thickness):
    (x, y) = center
    x, y = int(np.round(x)), int(np.round(y))
    r = int(np.round(r))
    cv2.circle(img, center=(x, y), radius=r, color=color, thickness=thickness)

def calc_all_areas(images, rois, circles):
    closest_slice = get_closest_slice(rois)
    (_, times, _, _) = images.shape

    def calc_areas(time):
        mask, mean = locate_lv_blood_pool(images, rois, circles, closest_slice,
                                          time)
        masks, areas = propagate_segments(images, rois, mask, mean,
                                          closest_slice, time)
        return (masks, areas)

    result = np.transpose(map(calc_areas, range(times)))
    all_masks = result[0]
    all_areas = result[1]
    return all_masks, all_areas

def get_closest_slice(rois):
    ctrd = get_centroid(rois)
    closest_slice = int(np.round(ctrd[0]))
    return closest_slice

def locate_lv_blood_pool(images, rois, circles, closest_slice, time):
    best, best_fn = find_best_angle(rois[closest_slice],
                                    circles[closest_slice])
    mean, coords, idx = find_threshold_point(best, best_fn)
    thresh, img_bin = cv2.threshold(images[closest_slice,
                                           time].astype(np.float32),
                                    mean, 255.0, cv2.THRESH_BINARY)
    labeled, num = label(img_bin)
    x, y = coords[idx]

    count = 0
    while labeled[y][x] == 0:
        idx += 1
        count += 1
        x, y = coords[idx]
        if count > COMPONENT_INDEX_TOLERANCE:
            idx -= count
            x, y = coords[idx]
            break

    if count <= COMPONENT_INDEX_TOLERANCE:
        component = np.transpose(np.nonzero(labeled == labeled[y][x]))
    else:
        component = np.array([[y, x]])

    hull = cv2.convexHull(component)
    squeezed = hull
    if count <= COMPONENT_INDEX_TOLERANCE:
        squeezed = np.squeeze(squeezed)
    hull = np.fliplr(squeezed)

    mask = np.zeros_like(labeled)
    cv2.drawContours(mask, [hull], 0, 255, thickness=-1)
    return mask, mean

def find_best_angle(roi, circ):
    ((cx, cy), r) = circ
    results = np.zeros(ANGLE_SLICES)
    fns = [None for i in range(ANGLE_SLICES)]

    COS_MATCHED_FILTER_FREQ = 2.5

    def score_matched(trimx, trimy):
        newtrimx = np.linspace(0.0, 1.0, np.size(trimx))
        minimum = np.min(trimy)
        maximum = np.max(trimy) - minimum
        newtrimy = (trimy - minimum) / maximum

        filt = 1 - ((np.cos(COS_MATCHED_FILTER_FREQ*2*np.pi*newtrimx)) /
                    2 + (0.5))
        cr = correlate(newtrimy, filt, mode="same")
        return np.max(cr)

    for i in range(ANGLE_SLICES):
        trimx, trimy, trimcoords = get_line(roi, cx, cy, np.pi*i/ANGLE_SLICES)
        score2 = score_matched(trimx, trimy)
        results[i] = score2
        fns[i] = (UnivariateSpline(trimx, trimy), trimx, trimcoords)

    best = np.argmax(results)
    return (best * np.pi / ANGLE_SLICES, fns[best])

def get_line(roi, cx, cy, theta):
    (h, w) = roi.shape
    (x0, x1, y0, y1) = get_line_coords(w, h, cx, cy, theta)

    intensities = []
    coords = []

    def collect(x, y):
        if y < 0 or y >= h or x < 0 or x >= w:
            return
        intensities.append(roi[y, x])
        coords.append((x, y))

    bresenham(x0, x1, y0, y1, collect)

    def geti(idx):
        return intensities[idx]

    getiv = np.vectorize(geti)
    x = np.arange(0, len(intensities))
    y = getiv(x)
    first, last = trim_zeros_indices(y)
    trimy = y[first:last]
    trimcoords = coords[first:last]

    trimx = np.arange(0, trimy.size)
    return (trimx, trimy, trimcoords)

def line_thru(bounds, center, theta):
    (xmin, xmax, ymin, ymax) = bounds
    (cx, cy) = center

    if np.cos(theta) == 0:
        return (cx, ymin, cx, ymax)
    slope = np.tan(theta)

    x0 = xmin
    y0 = cy - (cx - xmin) * slope
    if y0 < ymin:
        y0 = ymin
        x0 = max(xmin, cx - ((cy - ymin) / slope))
    elif y0 > ymax:
        y0 = ymax
        x0 = max(xmin, cx - ((cy - ymax) / slope))

    x1 = xmax
    y1 = cy + (xmax - cx) * slope
    if y1 < ymin:
        y1 = ymin
        x1 = min(xmax, cx + ((ymin - cy) / slope))
    elif y1 > ymax:
        y1 = ymax
        x1 = min(xmax, cx + ((ymax - cy) / slope))

    return (x0, x1, y0, y1)


def get_line_coords(w, h, cx, cy, theta):
    coords = np.floor(np.array(line_thru((0, w-1, 0, h-1), (cx, cy), theta)))
    return coords.astype(np.int)

def bresenham(x0, x1, y0, y1, fn):
    steep = abs(y1-y0) > abs(x1-x0)
    if steep:
        x0, x1, y0, y1 = y0, y1, x0, x1
    if x0 > x1:
        x0, x1, y0, y1 = x1, x0, y1, y0

    def plot(x, y):
        if steep:
            fn(y, x)
        else:
            fn(x, y)

    dx = x1 - x0
    dy = y1 - y0

    D = 2*np.abs(dy) - dx
    plot(x0, y0)
    y = y0

    for x in range(x0+1, x1+1):  
        D = D + 2*np.abs(dy)
        if D > 0:
            y += np.sign(dy)
            D -= 2*dx
        plot(x, y)

def trim_zeros_indices(has_zeros):
    first = 0
    for i in has_zeros:
        if i == 0:
            first += 1
        else:
            break

    last = len(has_zeros)
    for i in has_zeros[::-1]:
        if i == 0:
            last -= 1
        else:
            break

    return first, last

def find_threshold_point(best, best_fn):
    fn, trimx, trim_coords = best_fn
    dom = np.linspace(np.min(trimx), np.max(trimx), 1000)
    f = fn(dom)
    mins = argrelmin(f)

    closest_min = -1
    closest_dist = -1
    for m in np.nditer(mins):
        dist = np.abs(500 - m)
        if closest_min == -1 or closest_dist > dist:
            closest_min = m
            closest_dist = dist

    fnprime = fn.derivative()
    restrict = dom[np.max(closest_min-THRESHOLD_AREA, 0):
                   closest_min+THRESHOLD_AREA]
    f2 = fnprime(restrict)

    m1 = restrict[np.argmax(f2)]
    mean = fn(m1)

    idx = np.min([int(np.floor(m1))+1, len(trim_coords)-1])
    return (mean, trim_coords, idx)

def propagate_segments(images, rois, base_mask, mean, closest_slice, time):
    def propagate_segment(i, mask):
        thresh, img_bin = cv2.threshold(images[i,
                                               time].astype(np.float32),
                                        mean, 255.0, cv2.THRESH_BINARY)

        labeled, features = label(img_bin)

        region1 = mask == 255
        max_similar = -1
        max_region = 0
        for j in range(1, features+1):
            region2 = labeled == j
            intersect = np.count_nonzero(np.logical_and(region1, region2))
            union = np.count_nonzero(np.logical_or(region1, region2))
            similar = float(intersect) / union
            if max_similar == -1 or max_similar < similar:
                max_similar = similar
                max_region = j

        if max_similar == 0:
            component = np.transpose(np.nonzero(mask))
        else:
            component = np.transpose(np.nonzero(labeled == max_region))
        hull = cv2.convexHull(component)
        hull = np.squeeze(hull)
        if hull.shape == (2L,):
            hull = np.array([hull])
        hull = np.fliplr(hull)

        newmask = np.zeros_like(img_bin)

        cv2.drawContours(newmask, [hull], 0, 255, thickness=-1)

        return newmask

    (rois_depth, _, _) = rois.shape
    newmask = base_mask
    masks = {}
    areas = {}
    masks[closest_slice] = base_mask
    areas[closest_slice] = np.count_nonzero(base_mask)
    for i in range(closest_slice-1, -1, -1):
        newmask = propagate_segment(i, newmask)
        masks[i] = newmask
        areas[i] = np.count_nonzero(newmask)

    newmask = base_mask
    for i in range(closest_slice+1, rois_depth):
        newmask = propagate_segment(i, newmask)
        masks[i] = newmask
        areas[i] = np.count_nonzero(newmask)

    return masks, areas

def calc_total_volume(areas, area_multiplier, dist):
    slices = np.array(sorted(areas.keys()))
    modified = [areas[i] * area_multiplier for i in slices]
    vol = 0
    for i in slices[:-1]:
        a, b = modified[i], modified[i+1]
        subvol = (dist/3.0) * (a + np.sqrt(a*b) + b)
        vol += subvol / 1000.0  
    return vol

def save_masks_to_dir(dataset, all_masks):
    #os.mkdir("output/%s" % dataset.name)
    return 0

if __name__ == "__main__":
    random.seed()
    auto_segment_all_datasets()
