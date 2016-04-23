w=importdata('w1.mat');
train=importdata('train.mat');
label=importdata('label.mat');
n=length(train);
hgtmean=156.4506;
wgtmean=60.3399;
waistmean=34.4181;
mean=[hgtmean,wgtmean,waistmean];
test=xlsread('test.xlsx',1,'A2:L2');
test(10:12)=test(10:12)./mean;


tempA=w*test';
    if tempA(1)>=tempA(2)
      lpredict1='High Risk of blood pressure level ';
    else
        lpredict1='Low Risk of blood pressure level';
    end


for i=1:n
    d(i)=norm(test-train(i,:));
end

[dmin,Imin]=min(d);
 if label(Imin,2)==1
     lpredict2='High Risk of blood sugar level ';
 else
     lpredict2='High Risk of blood sugar level ';
 end
 
 lpredict1
 lpredict2




