##############讀取資料####################
dbSendQuery(con,"SET NAMES big5")
f=dbGetQuery(con, "select message from firstdata")
fn=dbGetQuery(con, "select id from firstdata")
fnt=dbGetQuery(con, "select target from firstdata ")

#n=dbGetQuery(con, "select PostMessage from post WHERE POST_FeedBack!='NA'")
#nn=dbGetQuery(con, "select PostId from post WHERE POST_FeedBack!='NA'")
#nnt=dbGetQuery(con, "select POST_FeedBack from post WHERE POST_FeedBack!='NA'")


#names(n)='message'
#names(nn)='id'
#names(nnt)='target'
first_data=f
first_data_name=fn
#type=rbind(fnt,nnt)



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
affect=dtm[rowTotals<1,]$dimnames$Docs



#設定UTF8
dbSendQuery(con,"SET NAMES utf8")
#insert資料到資料庫
c<-paste("UPDATE firstdata SET affect=0")
for(i in 1:length(affect)){
	c<-paste("UPDATE firstdata SET affect=1 WHERE id='",affect[i],"'",sep="")
	dbSendQuery(con,c)
}

