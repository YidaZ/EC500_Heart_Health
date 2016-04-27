##Summary:
Our data analysis contains mainly two part.
One is pre-diagnose system, which enables patients to do just a simple quiz and can give feedback of their risk of hypertension and high blood sugar level.
The other part is for modifying the ejection fraction we get from pure image processing. In this part we try different regression algorithms and find out robust linear model best fits our requirement.

Following are how to test our code:(BTW in the fold, '.m' and '.mat' files need to be opened by MATLAB)

###1.For the pre-diagnose system:

use the 'dataload.m' to upload 'newdat.xlsx'

'knn.m' and 'logistic_reg.m' are codes I write to see what machine learning model the training data fits. And 'w1.mat' and 'w2.mat' are the result coefficients for logistic regression.

"measure.m' is used to test on a single patient diagnose and gives the results of hypertention risk and blood sugar risk.


###2.For regression model of the final result:

'regression.m' is used for cleaning the data set, calculate predict ejection fraction and finally analyze different regression models on it.

'svr_trainer.m' is a called function file gonna to be uesd in regression.
