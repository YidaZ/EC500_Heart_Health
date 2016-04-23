% importdata('improcess.csv');
% Index=[];
% for i=1:500
%     if PredictedEDV(i)<10
%        Index=[Index,i] 
%     end
% end
% PredictedEDV(Index)=[];
% PredictedESV(Index)=[];
% ActualEDV(Index)=[];
% ActualESV(Index)=[];
% data=[PredictedEDV,PredictedESV];
% label=[ActualEDV,ActualESV];
% trainef=(data(:,1)-data(:,2))./data(:,1);
% labelef=(label(:,1)-label(:,2))./label(:,1);
% figure(1)
% [a1,b1]=hist(trainef,20);
% bar(b1,a1/sum(a1));
% title('Predicted Ejection Fraction')
% figure(2)
% [a2,b2]=hist(labelef,20);
% bar(b2,a2/sum(a2));
% title('Actual Ejection Fraction')
% figure(3)
% x=0:0.001:1
% plot(x,x)
% hold on
% % scatter(labelef,trainef,'filled')
% % xlabel('Actual Ejection Fraction');
% % ylabel('Predicted Ejection Fraction');
% % title('EF predictions against the actual EF values');
% % 

% % CVO = cvpartition(trainef,'k',5);
% %       err1 = zeros(CVO.NumTestSets,1);
% %       for i = 1:CVO.NumTestSets
% %           trIdx = CVO.training(i);
% %           teIdx = CVO.test(i);
% %           svrobj = svr_trainer(labelef(trIdx),trainef(trIdx),400,0.000000025,'spline',0.5);
% %           y = svrobj.predict(trainef(teIdx));
% %           err1(i) = sum((y-labelef(teIdx)).^2);
% %       end
% %       err=sum(err1)
% %       d1=sum((trainef-labelef).^2)
% %       improvement=d1/err
      
%%%%%%%%%%%%%%%y=0.5336x+0.1335      
% %       for i = 1:CVO.NumTestSets
% %           trIdx = CVO.training(i);
% %           teIdx = CVO.test(i);
% %           b = robustfit(trainef(trIdx),labelef(trIdx));
% %           y = b(1)+b(2)*trainef(teIdx);
% %           err1(i) = sum((y-labelef(teIdx)).^2);
% %       end  
% %       err=sum(err1)
% %       d1=sum((trainef-labelef).^2)
% %       improvement=d1/err

% % b=robustfit(trainef,labelef);
% % y = b(1)+b(2)*trainef;
% % count=0;
% % n=length(y);
% % for i=1:n
% %     if abs(y(i)-labelef(i))<0.15
% %         count=count+1;
% %     end
% % end
% %  corroect=count/n    
% scatter(labelef,y)  
% hold on
% scatter(labelef,trainef)
% legend('revised prediction','raw prediction')
% % for i = 1:CVO.NumTestSets
% %           trIdx = CVO.training(i);
% %           teIdx = CVO.test(i);
% %           b = regress(trainef(trIdx),labelef(trIdx));
% %           y = b(1)+b(2)*trainef(teIdx);
% %           err1(i) = sum((y-labelef(teIdx)).^2);
% %       end  
% %       err=sum(err1)
% %       d1=sum((trainef-labelef).^2)
% %       improvement=d1/err
% %             
      
      
      
      
      
      
      
      
      
      
      
