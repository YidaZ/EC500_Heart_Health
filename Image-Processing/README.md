##This folder contains the code for image processing using python 2.7.6 and Opencv 3.0.0

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


##Load Data

##Caculate ROIs

##Clculate Areas

##Calculate Total Volume
  At the end of the last step, the segmentation task is complete; We apply the simple mathmetical model to calculate the total volume via a series of quick calculations on the areas using the following idea:
  
  The total volume is the product of the millimeter distance between pixels of the image, so it's equivalent to the height and width of a single pixel in millimeters. In this way we convert our total areas in pixels into total areas in square millimeters. Next, we apply the formula for a frustum to estimate the volume (assuming the two regions are roughly similar and circular), using the distance between slices in step 1 as the height, then divide by a factor of 1000 to get from cubic millimeters to milliliters.
  
  Once we can get the EDV and ESV after this step, the ejection fraction can be calculated using the basic formula :EF = (EDV-ESV)*100/EDV.
  
  Here is one important improvemnt to ungrade the accuracy. In the data-anslysis part, the data model we built can be used to amend this formula based on all the running results of the whole dataset. So the formula we applied is: EF = (EDV-ESV)*100/EDV.

##Limitations

