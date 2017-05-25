#載入套件
library(tm)
library(tmcn)
library(Rwordseg)
library(RMySQL)
library(plyr)
library(e1071)
rf3=readRDS("C:/Users/user/Desktop/104/R學長姐/暑假/程式碼/rf3.rds")
##################資料前處理##############
con<- dbConnect(MySQL(), user="root", password="", dbname="main", host="127.0.0.1")
dbSendQuery(con,"SET NAMES big5")

ptm <- proc.time()
top_r=160000
bottom_r=140001

post=dbGetQuery(con, paste("select number as id,PostMessage as message from  post WHERE affect=0 AND number>=",bottom_r," AND number<=",top_r,sep=""))
total=post
mycorpus=Corpus(VectorSource(total[,"message",FALSE][[1]]))
names(mycorpus)=sprintf(as.character(total[,"id",FALSE][[1]]),1:length(mycorpus))
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
dbSendQuery(con,"SET NAMES utf8")

for(a in 1:(floor(length(mycorpus7)/100)+1)){
	temp=""
	sp=100
	if(a==(floor(length(mycorpus7)/100)+1)){
		sp=(length(mycorpus7)%%100)
	}
	for(aa in 1:sp){
		keynum=unique(match(mycorpus7[[(a-1)*100+aa]],rownames(rf3))[!is.na(match(mycorpus7[[(a-1)*100+aa]],rownames(rf3)))])
		if(length(keynum)==0){
			keynum=0
		}
		if(aa==1){
			temp=paste("",temp,sep="(")
			value=paste(keynum,names(mycorpus7)[(a-1)*100+aa],collapse="),(",sep=",")
			temp=paste(temp,value,sep="")
			next
		}
		value=paste(keynum,names(mycorpus7)[(a-1)*100+aa],collapse="),(",sep=",")
		temp=paste(temp,value,sep="),(")
		if(aa==sp){
			temp=paste(temp,")",sep="")
			
		}
	}
	c<-paste("INSERT INTO key_post (keyword,PostId) VALUES ",temp,"",sep="")
	dbSendQuery(con,c)
	

}

proc.time() - ptm
