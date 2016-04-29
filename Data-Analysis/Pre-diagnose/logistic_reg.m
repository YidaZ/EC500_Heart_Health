% CCR=zeros(100,1);
nll=0;
nll11=zeros(n,1);
nll1=0;
nll2=0;
nll21=zeros(1,12);
ntemp=0;
dnll=zeros(2,12);
n=length(train);  
n2=1000;
w=zeros(2,12);
ita=5*10^-6; 
Itemp=[];
Itemp=find(label(1:n-n2,1)==1);
xsum1(1,:)=sum(train(Itemp,:));  
Itemp=[];
Itemp=find(label(1:n-n2,1)==-1);
xsum1(2,:)=sum(train(Itemp,:)); 
train_=train(1:n-n2,:);
 gamma=6
for time=1:50000
matrix=train_*w';
ematrix=exp(matrix);
nll11=sum(ematrix');
nll1=sum(log(nll11));
    for i=1:2
        nll2=nll2+dot(w(i,:),xsum1(i,:));
    end
nll=nll1-nll2;

    for i=1:2
        dtemp=ematrix(:,i)./nll11';
        nll21=dtemp'*train_;
        dnll(i,:)=nll21-xsum1(i,:);
    end
    for i=1:2
    ntemp=ntemp+norm(w(i,:))^2;
    df(i,:)=dnll(i,:)+gamma*w(i,:);
    end
f(time)=nll+gamma/2*ntemp;

    for i=1:2
    w(i,:)=w(i,:)-ita*df(i,:);
    end
    
nll=0;
nll11=zeros(n,1);
nll1=0;
nll2=0;
nll21=zeros(1,12);
ntemp=0;
dnll=zeros(2,12);

time;
f(time);


end
test=train(n-n2+1:n,:);
tempA=w*test';
lpredict=zeros(1000,1);
for i=1:1000
    if tempA(1,i)>=tempA(2,i)
      lpredict(i)=1;
    else
        lpredict(i)=-1;
    end
end

[C,order]=confusionmat(label(n-n2+1:n,1),lpredict);
CCR=sum(diag(C))/1000;


      





   













