#EC500 C1 Heart Health Project
Our website : http://52.39.61.199/heart
Welcome anyone who wish to try this!
## Introduction

This is a project for the course EC500 C1 in Bosotn University.
There are five us in total and we want to build a website for the kaggle project: Heart Diease Diagnosing.
The main goal of this project is to build a dynamic website which allows cardiologists to upload MRI images of their patients and get reliable ejection fraction (EF) value, a key factor to predict cardiovasucular disease. This website may save vast amount of time and energy of cardiologists and benefits patients as well.

We would refer the database provided by Kaggle project sample data.
As you can see, we mainly distribute our project to four parts: Data-analysis, Image-processing and Website-building. We have set each part a folder where you can find more detailed information. 


##How to use our website

####Patients: Prediagnose

 If you sign up and log in as a patient, you can simply take a short quiz based on your physical conditions, and get a prediction of your risk of hypertension and high blood sugar. The algorithm behind this is built on the data modal that we build from a large dataset. The instruction to use this site is very self-explanatory, simple and convenient. 

####Doctor: Heart health analysis

 Since this project is based on Kaggle, so the MRI images uploaded by user should follow the format of the data from Kaggle. It is something like: train/1/study/sax_50... . Your can name the top folder as whatever you like, which means it doesn't have to be train. But after that the standard format should followed, or you might not be able to get the right result. You can download the sample data under the Dataset folder using the link we offered there.
 As a doctor, these are steps you should follow:
 
#####Step 1 Format your testing data:
       1.1 Orgnize all your MRI images in the folder following the format;
 
       1.2 Compress the folder in .zip；
       
#####Step 2
       2.1 Sign up and log in as a doctor;
       
       2.2 Add existing patient to your patient list;
       
       2.3 Choose the patient that you want to upload MRI images of
       
       2.4 Choose the formatted zip file with that patient MRI images
       
       2.5 Click the "upload" button and wait for the analysis result.
##Instruction to build the website:
####Environment and Tools:
Set up a EC2 instance, install apache, PHP, MySQL to host the website and Pyhton with OpenCV, numpy for image processing.
####Database Design:       
#####The database contains three tables. 
         1. Patient Account.
         2. Doctor Account.
         3. Patient and Doctor. (for doctors adding patients as contacts)
         4. File. (Columns: file_id file_oldname, file_name, file_type, upload_time, upload_path, patient_email,    doctor_email, EF, report)
####Repository Contents & Hierarchy: 
The website/heart.zip contains the integrated whole website. You can download it and run on your own server.
#####In the heart.zip:
         1./startbootstrap/doctor contains all the code for doctor pages.
         2./startbootstrap/doctor/upload/ is set to be the directory where all MRI files uploaded to.
         3./startbootstrap/doctor/patient contains all the code for patient pages.
            
 
