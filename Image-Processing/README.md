##This folder contains the code for image processing using python 2.7.6 and Opencv 3.0.0

 The segment.py is previous version of code which is test on local ubuntu. The final.py is the code is the final version which is integreted to the website.
##Introduction to Image Processing

-  Step 1: Load data 
	-  segmentation process
-  Step 2: Calculate ROIs 
	-  Regression Filtering
	-  Post-process regression
	-  Getting ROIs
-  Step 3: Calculate Areas 
	-  Locating the LV Blood Pool
	-  Propagating Segments
-  Step 4: Calculate Total Volume
  
  For each patient, their data come with a two chamber view, a four chamber view, and a series of longitudinal slices perpendicular to the heart's long axis known as the short-axis stack.  Here we are only focusing on short-axis stack. 

  The first step is to walk through the dataset and load all the MRI images.
  
  The second step is to segment the ROIS(a circle-shaped region of nonzero pixels which contains the left ventricle) and get its area.
  
  Next, the program will furtherly locate the LV(left-ventricle) blood pool and calculate its area.
  
  At the end of the last step, the segmentation task is complete; We apply the simple mathmetical model to calculate the total volume via a series of quick calculations on the areas using the following idea:
  
  The total volume is the product of the millimeter distance between pixels of the image, so it's equivalent to the height and width of a single pixel in millimeters. In this way we convert our total areas in pixels into total areas in square millimeters. Next, we apply the formula for a frustum to estimate the volume (assuming the two regions are roughly similar and circular), using the distance between slices in step 1 as the height, then divide by a factor of 1000 to get from cubic millimeters to milliliters.
  
  Once we can get the EDV and ESV after this step, the ejection fraction can be calculated using the basic formula :EF = (EDV-ESV)*100/EDV.
  
  Here is one important improvemnt to ungrade the accuracy. In the data-anslysis part, the data model we built can be used to amend this formula based on all the running results of the whole dataset. 
  So the formula we applied is: 
  
  EF = (EDV-ESV)*100/EDV, when EF > 0.75;
  
  EF = ((EDV-ESV)*100/EDV*0.1335)+0.533,6 when 0.5 < EF <0.75;
  
  EF = (EDV-ESV)*100/EDV, when EF < 0.5.
  

##Testing
Before you want to test locally on linux, you first need to set up the environment to make sure all the library requied can be imported.

#####Operating system
We are using ubuntu 14.04. 
Here is the link how to Install OpenCV 3.0 and Python 2.7+ on Ubuntu: http://www.pyimagesearch.com/2015/06/22/install-opencv-3-0-and-python-2-7-on-ubuntu/

#####Additional libraries
There are libraries requried for running the test: numpy,matplotlib,pydicom,scipy. There are many resources you can find online how to add these libraries to your ubuntu.

#####Instruction
To run the test, put segment.py and the sample data downloaded from the link we provided into a folder named as "train". The sample data here means a numbered folder like 2 or 3, which is the id number for each patient. Then getting terminal running under cv environment. 

Simply typing in : python segment.py . 

Then you should be able to get the result like this: 

edv: 182.773311175 esv: 115.509179634 ef: 0.368019439537





