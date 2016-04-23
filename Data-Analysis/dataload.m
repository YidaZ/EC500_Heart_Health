data=importdata('newdata.xlsx');
n=length(data.textdata.Sheet1(:,1));
I=[];
II=[];
for j=1:9
    for i=1:n
        if strcmp(data.textdata.Sheet1(i,j),'N')| strcmp(data.textdata.Sheet1(i,j),'Y');
        else
            I=[I,i];
        end
    end
end
nset=2:1:n;
Idata=setdiff(nset,I);
for j=14:15
    for i=1:n
        if strcmp(data.textdata.Sheet1(i,j),'LO')| strcmp(data.textdata.Sheet1(i,j),'HI');
        else
            II=[II,i];
        end
    end
end
Idata=setdiff(nset,II);  
III=[];
for j=1:4
    for i=1:n-1
        if isnan(data.data.Sheet1(i,j))       
            III=[III,i+1];
        end
    end
end
Idata=setdiff(nset,III);
Idata=sort(Idata);
nfinal=length(Idata);
train=zeros(nfinal,12);
label=zeros(nfinal,2);

 for j=1:2
    for i=1:nfinal
        if strcmp(data.textdata.Sheet1(Idata(i),j+13),'HI')
            label(i,j)=1;
         elseif    strcmp(data.textdata.Sheet1(Idata(i),j+13),'LO')
             label(i,j)=-1;
        end
    end
end
for j=1:9
    for i=1:nfinal
        if strcmp(data.textdata.Sheet1(Idata(i),j),'Y')
            train(i,j)=1;
%         elseif    strcmp(data.textdata.Sheet1(Idata(i),j),'N')
%             train(i,j)=0;
        end
    end
end
for j=11:12
    for i=1:nfinal
            train(i,j)=data.data.Sheet1(Idata(i)-1,j-8);
      
    end
end

for i=1:nfinal
train(i,10)=2.54*(12*data.data.Sheet1(Idata(i)-1,1)+data.data.Sheet1(Idata(i)-1,2));      
end




for j=10:12
    temp=sum(train(:,j))/nfinal;
    train(:,j)=train(:,j)/temp;
end
