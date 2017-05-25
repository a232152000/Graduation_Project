memory.limit(100000)
#載入套件
library(tm)
library(tmcn)
library(Rwordseg)
library(RMySQL)
library(plyr)
library(e1071)
model=readRDS("C:/Users/user/Desktop/104/R學長姐/暑假/程式碼/預測/jackop60506.rds")
rf3=readRDS("C:/Users/user/Desktop/104/R學長姐/暑假/程式碼/預測/rf3.rds")
test.set=readRDS("C:/Users/user/Desktop/104/R學長姐/暑假/程式碼/預測/test_set.rds")

#連接資料庫
con<- dbConnect(MySQL(), user="root", password="", dbname="main", host="127.0.0.1")
Sys.setlocale(category='LC_ALL', locale='')

top_r=165000
bottom_r=160001
dbSendQuery(con,"SET NAMES big5")
post=dbGetQuery(con, paste("select PostMessage from  post WHERE affect=0 AND number>=",bottom_r," AND number<=",top_r,sep=""))
post_name=dbGetQuery(con, paste("select number from post WHERE affect=0 AND number>=",bottom_r," AND number<=",top_r,sep=""))

post_num=nrow(post)

f=dbGetQuery(con, "select message from firstdata WHERE affect=0")
fn=dbGetQuery(con, "select id from firstdata WHERE affect=0")
n=dbGetQuery(con, "select PostMessage from test WHERE number<=1000 AND affect=0")
nn=dbGetQuery(con, "select PostId from test WHERE number<=1000 AND affect=0")

names(n)='message'
names(nn)='id'
first_test=rbind(f,n)
first_test_name=rbind(fn,nn)

names(post)='message'
names(post_name)='id'

first_data=rbind(post,first_test)
first_data_name=rbind(post_name,first_test_name)

mycorpus=Corpus(VectorSource(first_data[[1]]))
names(mycorpus)=sprintf(as.character(first_data_name[[1]]),1:length(mycorpus))

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
dtm=DocumentTermMatrix(mycorpus7[1:post_num],control=list(wordLengths=c(1,Inf)))
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
as.numeric(x)*log(as.numeric(x[data_row]))
})
tfidf2=t(tfidf)
colnames(tfidf2)=colnames(tfidfmatrix)
tfidf3=data.frame(tfidf2,check.names = FALSE)
tfidf3[,data_row]=NULL
######################## TF-RF-IDF ###################################
tfrfidfmatrix=merge(tfidf3, rf3, by=0, all=TRUE)
rownames(tfrfidfmatrix)=tfrfidfmatrix[,1]
tfrfidfmatrix[,1]=NULL
tfrfidfmatrix[is.na(tfrfidfmatrix[,data_row]),data_row]=log(2)

tfrfidf=apply(tfrfidfmatrix, 1, function(x){
as.numeric(x)*as.numeric(x[data_row])
})
tfrfidf2=t(tfrfidf)
colnames(tfrfidf2)=colnames(tfrfidfmatrix)
tfrfidf3=t(tfrfidf2)
tfrfidf3[is.na(tfrfidf3)]=0
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
#######svm#########

term_col=ncol(tfrfidf5)
tfrfidf5[,term_col]=as.numeric(tfrfidf5[,term_col])

svm.pred <- predict(model, tfrfidf5[-1,-term_col])

tfrfidfsvm1=table(pred = svm.pred, true = tfrfidf5[,term_col])  
svm.pred
tfrfidfsvm1

pre_name=names(svm.pred)
pre_value=as.numeric(levels(svm.pred))[svm.pred]
arr=''
arr_value=''
arr_end=0
arr_n=signif(length(pre_name)/100,digit=1)
#設定UTF8
dbSendQuery(con,"SET NAMES utf8")

#insert資料到資料庫
for(i in 2:length(pre_name)){
	
	c<-paste("UPDATE post SET PostPN=",pre_value[i]," WHERE number=(",pre_name[i],")",sep="")
	dbSendQuery(con,c)

}
#tfrfidf5[2,apply(tfrfidf5[2,],1,function(x){x})>0]
#10153495681531065_1094788173941475 2896 1757
#	0.3112059                           0.5726188
			0.693   0.3887012 0.4804530

