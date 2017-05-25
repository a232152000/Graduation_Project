first_data=dbGetQuery(con, "SELECT PostMessage FROM post LIMIT 501,1000")
first_data_name=dbGetQuery(con, "SELECT PostId FROM post LIMIT 501,1000")

#first_data=dbGetQuery(con, "select message from firstdata WHERE target=1 limit 0,50")
#first_data_name=dbGetQuery(con, "select id from firstdata WHERE target=1 limit 0,50")

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


namelist=names(tfrfidf5)
w=match(namelist,names(test.set))####已經訓練好模型了
tfrfidf5=tfrfidf5[!is.na(w)]
t=tfrfidf5
ts=test.set[1,]
RBIND <- function(datalist) {
  require(plyr)
  temp <- rbind.fill(datalist)
  rownames(temp) <- unlist(lapply(datalist, row.names))
  temp
}
tfrfidf5=RBIND(list(ts, tfrfidf5))
#tfrfidf5=rbind.fill(ts,tfrfidf5)

#######svm#########
###tfrfidf5=tfrfidf5[, colSums(is.na(tfrfidf5)) != nrow(tfrfidf5)]


tfrfidf5[is.na(tfrfidf5)]=0

tfrfidf5[,term_col]=as.numeric(tfrfidf5[,term_col])

svm.pred <- predict(model, tfrfidf5[,-term_col])

tfrfidfsvm1=table(pred = svm.pred, true = tfrfidf5[,term_col])  
svm.pred
tfrfidfsvm1


#轉成無編碼
Sys.setlocale(category='LC_ALL', locale='C')
#設定UTF8
dbSendQuery(con,"SET NAMES utf8")
#insert資料到資料庫
for(i in 2:length(svm.pred)){
	pred_name=names(svm.pred[i])
	pred_value=svm.pred[[i]]
	c<-paste("UPDATE post SET PostPN=",pred_value," WHERE PostId='",pred_name,"'",sep="")
	dbSendQuery(con,c)

}
