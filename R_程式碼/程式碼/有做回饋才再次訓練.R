#連接資料庫
con<- dbConnect(MySQL(), user="root", password="", dbname="main", host="127.0.0.1")
Sys.setlocale(category='LC_ALL', locale='')
#設定big5
dbSendQuery(con,"SET NAMES big5")
########################  PSO  ##################################

##抓資料 first留言 + 回櫃的留言
fp=dbGetQuery(con, "select message from firstdata WHERE target=1")
fpn=dbGetQuery(con, "select id from firstdata WHERE target=1")
fpnt=dbGetQuery(con, "select target from firstdata WHERE target=1")
pp=dbGetQuery(con, "select PostMessage from post WHERE POST_FeedBack=1")
ppn=dbGetQuery(con, "select PostId from post WHERE POST_FeedBack=1")
ppnt=dbGetQuery(con, "select POST_FeedBack from post WHERE POST_FeedBack=1")

names(pp)='message'
names(ppn)='id'
names(ppnt)='target'
pr=rbind(fp,pp)
prn=rbind(fpn,ppn)
prnt=rbind(fpnt,ppnt)

fp_mycorpus=Corpus(VectorSource(pr[[1]]))
names(fp_mycorpus)=sprintf(prn[[1]],1:length(fp_mycorpus))
mycorpus=fp_mycorpus



#轉成存文字
mycorpus=tm_map(mycorpus,PlainTextDocument)
mycorpus=tm_map(mycorpus,stripWhitespace)
mycorpus=tm_map(mycorpus,removeWords,stopwords("english"))
#匯入新詞彙
newwords=readLines(file("C:/data/newwords.txt",open="r"))
newwords=toTrad(newwords,rev=TRUE)
insertWords(newwords)
#進行斷詞
mycorpus2=tm_map(mycorpus,segmentCN,nature=TRUE)
mycorpus2=tm_map(mycorpus2,function(w){list(w);})

#只保留(動詞v,形容詞a,名詞n,名形詞an,userDefine)，並轉成純文字存下來
mycorpus3=tm_map(mycorpus2,function(sentence){

if(is.list(sentence)){
	noun=lapply(sentence, function(w) {
	w[names(w)=="userDefine"|names(w)=="a"|names(w)=="v"|names(w)=="n"|names(w)=="i"|names(w)=="ad"|names(w)=="an"|names(w)=="vn"|names(w)=="null"|names(w)=="l"|names(w)=="d"]
	})

}else{
	noun=lapply(list(sentence), function(w) {
	w[names(w)=="userDefine"|names(w)=="a"|names(w)=="v"|names(w)=="n"|names(w)=="i"|names(w)=="ad"|names(w)=="an"|names(w)=="vn"|names(w)=="null"|names(w)=="l"|names(w)=="d"]
	})

}
unlist(noun)

})
#存成純文字
mycorpus4=Corpus(VectorSource(mycorpus3))
#去除停止詞
stopwords=readLines(file("C:/data/stopwords.txt"))
stopwords=toTrad(stopwords,rev=TRUE)
myStopWords=c(stopwordsCN(),stopwords)
mycorpus5=tm_map(mycorpus4,removeWords,myStopWords)
#去除空格
mycorpus6=tm_map(mycorpus5,function(sentence){
noun=lapply(sentence, function(w) {
w[w!=""]
})
unlist(noun)
})
#存成純文字
mycorpus7=Corpus(VectorSource(mycorpus6))
#轉矩陣
pdtm=DocumentTermMatrix(mycorpus7,control=list(wordLengths=c(1,Inf)))
#Find the sum of words in each Document
rowTotals=apply(pdtm, 1,sum) 
pdtm1=pdtm[rowTotals>0,]
#計算Dwp
Dwp=apply(pdtm1, 2, function(x) {sum(x!=0)})
######################## NSO ###################################

##抓資料 first留言 + 回櫃的留言
fn=dbGetQuery(con, "select message from firstdata WHERE target=-1")
fnn=dbGetQuery(con, "select id from firstdata WHERE target=-1")
fnnt=dbGetQuery(con, "select target from firstdata WHERE target=-1")
pn=dbGetQuery(con, "select PostMessage from post WHERE POST_FeedBack=-1")
pnn=dbGetQuery(con, "select PostId from post WHERE POST_FeedBack=-1")
pnnt=dbGetQuery(con, "select POST_FeedBack from post WHERE POST_FeedBack=-1")

names(pn)='message'
names(pnn)='id'
names(pnnt)='target'
nr=rbind(fp,pn)
nrn=rbind(fpn,pnn)
nrnt=rbind(fpnt,pnnt)

fn_mycorpus=Corpus(VectorSource(nr[[1]]))
names(fn_mycorpus)=sprintf(nrn[[1]],1:length(fn_mycorpus))
mycorpus=fn_mycorpus

#轉成存文字
#mycorpus=Corpus(DirSource("C:/data/fb_ndata"),list(language=NA))
mycorpus=tm_map(mycorpus,PlainTextDocument)
mycorpus=tm_map(mycorpus,stripWhitespace)
mycorpus=tm_map(mycorpus,removeWords,stopwords("english"))
#匯入新詞彙
newwords=readLines(file("C:/data/newwords.txt",open="r"))
newwords=toTrad(newwords,rev=TRUE)
insertWords(newwords)
#進行斷詞
mycorpus2=tm_map(mycorpus,segmentCN,nature=TRUE)
mycorpus2=tm_map(mycorpus2,function(w){list(w);})

#只保留(動詞v,形容詞a,名詞n,名形詞an,userDefine)，並轉成純文字存下來
mycorpus3=tm_map(mycorpus2,function(sentence){

if(is.list(sentence)){
	noun=lapply(sentence, function(w) {
	w[names(w)=="userDefine"|names(w)=="a"|names(w)=="v"|names(w)=="n"|names(w)=="i"|names(w)=="ad"|names(w)=="an"|names(w)=="vn"|names(w)=="null"|names(w)=="l"|names(w)=="d"]
	})

}else{
	noun=lapply(list(sentence), function(w) {
	w[names(w)=="userDefine"|names(w)=="a"|names(w)=="v"|names(w)=="n"|names(w)=="i"|names(w)=="ad"|names(w)=="an"|names(w)=="vn"|names(w)=="null"|names(w)=="l"|names(w)=="d"]
	})

}
unlist(noun)

})
#存成純文字
mycorpus4=Corpus(VectorSource(mycorpus3))
#去除停止詞
stopwords=readLines(file("C:/data/stopwords.txt"))
stopwords=toTrad(stopwords,rev=TRUE)
myStopWords=c(stopwordsCN(),stopwords)
mycorpus5=tm_map(mycorpus4,removeWords,myStopWords)
#去除空格
mycorpus6=tm_map(mycorpus5,function(sentence){
noun=lapply(sentence, function(w) {
w[w!=""]
})
unlist(noun)
})
#存成純文字
mycorpus7=Corpus(VectorSource(mycorpus6))
#轉矩陣
ndtm=DocumentTermMatrix(mycorpus7,control=list(wordLengths=c(1,Inf)))
#Find the sum of words in each Document
rowTotals=apply(ndtm, 1,sum) 
ndtm1=ndtm[rowTotals>0,]
#計算Dwn
Dwn=apply(ndtm1, 2, function(x) {sum(x!=0)})
######################## RF ###################################
Dwpmatrix=data.frame(names(Dwp),Dwp)
Dwnmatrix=data.frame(names(Dwn),Dwn)
rfmatrix=merge(Dwpmatrix, Dwnmatrix, by.x = "names.Dwp.", by.y = "names.Dwn.", all=TRUE)
rf=apply(rfmatrix, 1, function(x) {
  if(is.na(x[2])) {
   c(term=unname(x[1]), RF=log((0/as.numeric(x[3]))+1))
  } else if (is.na(x[3])) {
    c(term=unname(x[1]),  RF=log((as.numeric(x[2])/0)+1))
  }
  else{
    c(term=unname(x[1]), RF=log((as.numeric(x[2])/as.numeric(x[3]))+1))
  }
})
rf2=t(rf)
rf3=data.frame(rf2)
rownames(rf3)=rf3[,1]
rf3[,1]=NULL

##############讀取資料####################

f=dbGetQuery(con, "select message from firstdata WHERE affect=0")
fn=dbGetQuery(con, "select id from firstdata WHERE affect=0")
fnt=dbGetQuery(con, "select target from firstdata WHERE affect=0")
n=dbGetQuery(con, "select PostMessage from post WHERE POST_FeedBack!='NA' AND affect!=1")
nn=dbGetQuery(con, "select PostId from post WHERE POST_FeedBack!='NA' AND affect!=1")
nnt=dbGetQuery(con, "select POST_FeedBack from post WHERE POST_FeedBack!='NA' AND affect!=1")

names(n)='message'
names(nn)='id'
names(nnt)='target'
first_data=rbind(f,n)
first_data_name=rbind(fn,nn)
type=rbind(fnt,nnt)

######################## IDF ###################################
mycorpus=Corpus(VectorSource(first_data[[1]]))
names(mycorpus)=sprintf(first_data_name[[1]],1:length(mycorpus))

mycorpus=tm_map(mycorpus,PlainTextDocument)
mycorpus=tm_map(mycorpus,stripWhitespace)
mycorpus=tm_map(mycorpus,removeWords,stopwords("english"))



newwords=readLines(file("C:/data/newwords.txt",open="r"))
newwords=toTrad(newwords,rev=TRUE)
insertWords(newwords)
#進行斷詞
mycorpus2=tm_map(mycorpus,segmentCN,nature=TRUE)
mycorpus2=tm_map(mycorpus2,function(w){list(w);})

#只保留(動詞v,形容詞a,名詞n,名形詞an,userDefine)，並轉成純文字存下來
mycorpus3=tm_map(mycorpus2,function(sentence){

if(is.list(sentence)){
	noun=lapply(sentence, function(w) {
	w[names(w)=="userDefine"|names(w)=="a"|names(w)=="v"|names(w)=="n"|names(w)=="i"|names(w)=="ad"|names(w)=="an"|names(w)=="vn"|names(w)=="null"|names(w)=="l"|names(w)=="d"]
	})

}else{
	noun=lapply(list(sentence), function(w) {
	w[names(w)=="userDefine"|names(w)=="a"|names(w)=="v"|names(w)=="n"|names(w)=="i"|names(w)=="ad"|names(w)=="an"|names(w)=="vn"|names(w)=="null"|names(w)=="l"|names(w)=="d"]
	})

}
unlist(noun)

})
#存成純文字
mycorpus4=Corpus(VectorSource(mycorpus3))
#去除停止詞
stopwords=readLines(file("C:/data/stopwords.txt"))
stopwords=toTrad(stopwords,rev=TRUE)
myStopWords=c(stopwordsCN(),stopwords)
mycorpus5=tm_map(mycorpus4,removeWords,myStopWords)
#去除空格
mycorpus6=tm_map(mycorpus5,function(sentence){
noun=lapply(sentence, function(w) {
w[w!=""]
})
unlist(noun)
})
#存成純文字
mycorpus7=Corpus(VectorSource(mycorpus6))
#轉矩陣
dtm=DocumentTermMatrix(mycorpus7,control=list(wordLengths=c(1,Inf)))
#Find the sum of words in each Document
rowTotals=apply(dtm, 1,sum) 
dtm1=dtm[rowTotals>0,]
#計算IDF
D=nrow(dtm1)
DF=apply(dtm1, 2, function(x){sum(x!=0)})
idf=D/DF
idf2=data.frame(idf)
############################ TF ##########################
dtm=DocumentTermMatrix(mycorpus7,control=list(wordLengths=c(1,Inf)))
#Find the sum of words in each Document
rowTotals=apply(dtm, 1,sum) #734修改 不計算到type
dtm1=dtm[rowTotals>0,]
data_row=dtm1$nrow+1
#計算TF
rowTotals=apply(dtm1, 1, sum)
tf=apply(dtm1, 2, function(x){x/rowTotals})
tf1=t(tf)
tf2=data.frame(tf1,check.names = FALSE)
################# TF-IDF############
tfidfmatrix=merge(tf2, idf2, by=0, all=TRUE)
rownames(tfidfmatrix)=tfidfmatrix[,1]
tfidfmatrix[,1]=NULL
tfidf=apply(tfidfmatrix, 1, function(x){
as.numeric(x)*log(as.numeric(data_row))
})
tfidf2=t(tfidf)
colnames(tfidf2)=colnames(tfidfmatrix)
tfidf3=data.frame(tfidf2,check.names = FALSE)
tfidf3[,data_row]=NULL
######################## TF-RF-IDF ###################################
tfrfidfmatrix=merge(tfidf3, rf3, by=0, all=TRUE)
rownames(tfrfidfmatrix)=tfrfidfmatrix[,1]
tfrfidfmatrix[,1]=NULL
tfrfidf=apply(tfrfidfmatrix, 1, function(x){
if(is.na(x[data_row])){
x[data_row]=log(2)

as.numeric(x)*as.numeric(x[data_row])
}
else {
as.numeric(x)*as.numeric(x[data_row])
}
})
tfrfidf2=t(tfrfidf)
colnames(tfrfidf2)=colnames(tfrfidfmatrix)
tfrfidf3=apply(tfrfidf2, 1, function(x){
for (i in 1:length(x)) {
if(is.nan(x[i])){
x[i]=0
}
if(is.infinite(x[i])&x[i]>0){
x[i]=9.9e10
}
else if(is.infinite(x[i])&x[i]<0){
x[i]=-9.9e10
}
}
x
})
tfrfidf4=t(tfrfidf3)
tfrfidf4=data.frame(tfrfidf4,check.names = FALSE)
tfrfidf4[,data_row]=NULL
tfrfidf5=t(tfrfidf4)
tfrfidf5=data.frame(tfrfidf5,check.names = FALSE)

type=as.character(type[[1]])
tfrfidf5[,"Type"]=type

term_col=ncol(tfrfidf5)
###########################################################################
########################### SVM ###########################################
library(e1071)
tfrfidf5[is.na(tfrfidf5)]=0
tfrfidf5[,term_col]=as.numeric(tfrfidf5[,term_col])

'
test.index <- 1:nrow(tfrfidf5)
#取20%為測試語料
np = ceiling(0.2*nrow(tfrfidf5))
np
test.index <- sample(1:nrow(tfrfidf5),np)
#測試語料
test.set <- tfrfidf5[test.index,]
#訓練語料
train.set <- tfrfidf5[-test.index,]
'
#########  NEW VERSION#######################

test.set <- NULL
train.set <- NULL

by (tfrfidf5, tfrfidf5$Type, 

 function (x) {

   test.index <- 1:nrow(x)
   #取20%為測試語料
   np = ceiling(0.2*nrow(x))
   test.index <- sample(1:nrow(x),np)
   #測試語料
   testd <- x[test.index,]
   test.set <<- rbind(test.set, testd)
   #訓練語料
   traind <- x[-test.index,]
   train.set <<- rbind(train.set, traind)

 } )
##################################################

#train.set$Type = as.factor(train.set$Type)
#x = tune.svm(Type ~ ., data=train.set, type='C-classification', kernel="radial", gamma=seq(.1, .9, by = .1), cost = seq(1,1000, by = 100) )
#x$best.parameters

model<-svm(Type ~ ., data = train.set, type='C-classification', kernel="radial", gamma=0.1, cost=1) 

summary(model)
svm.pred <- predict(model, test.set[,-term_col])
svm.pred
## compute svm confusion matrix
tfrfidfsvm1=table(pred = svm.pred, true = test.set[,term_col])  
tfrfidfsvm1
tfrfidfn11=apply(tfrfidfsvm1, 1, function(x){sum(x)})
tfrfidfn31=apply(tfrfidfsvm1, 2, function(x){sum(x)})
tfrfidfm21=diag(tfrfidfsvm1)
tfrfidfx11=(tfrfidfm21/tfrfidfn11)*100
tfrfidfx11=data.frame(tfrfidfx11)
tfrfidfx21=apply(tfrfidfx11, 1, function(x){
for (i in 1:length(x)) {
if(is.nan(x[i])){
x[i]=0
}
}
x
})
tfrfidfx21=data.frame(tfrfidfx21)
tfrfidfx31=(tfrfidfm21/tfrfidfn31)*100
tfrfidfx31=data.frame(tfrfidfx31)
#精準率
tfrfidfx21
#召回率
tfrfidfx31
#調和平均數
tfrfidfx41=(2*tfrfidfx21*tfrfidfx31)/(tfrfidfx21+tfrfidfx31)
#準確率
tfrfidfx51=sum(tfrfidfm21)/sum(tfrfidfsvm1)
tfrfidfx51


