n=length(train);
n2=1000;
n1=n-n2;
d=zeros(n1,1);
Imin=zeros(n2,1);
Ipredict=zeros(n2,2);
for j=1:n2
    for i=1:n1
        d(i)=norm(train(n1+j,:)-train(i,:));
    end
    [dmin,Imin(j)]=min(d);
    Ipredict(j,:)=label(Imin(j),:);
end
[C1,order]=confusionmat(Ipredict(:,1),label(n1+1:n,1));
[C2,order]=confusionmat(Ipredict(:,2),label(n1+1:n,2));
CCR1=sum(diag(C1))/n2
CCR2=sum(diag(C2))/n2