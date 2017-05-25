library(tm)
library(tmcn)
library(Rwordseg)
library(RMySQL)
library(plyr)

con<- dbConnect(MySQL(), user="root", password="", dbname="main", host="127.0.0.1")
Sys.setlocale(category='LC_ALL', locale='')
#設定big5
dbSendQuery(con,"SET NAMES big5")
#data=dbGetQuery(con, "select PostMessage from post WHERE PostTime<'2016-01-10'")
#data2=dbGetQuery(con, "select PostMessage from post WHERE  affect=0 AND PostTime BETWEEN '2016-01-10' AND '2016-01-14'")
#data3=dbGetQuery(con, "select PostMessage from post WHERE  affect=0 AND PostTime BETWEEN '2016-01-14' AND '2016-01-15'")
#data4=dbGetQuery(con, "select PostMessage from post WHERE  affect=0 AND PostTime BETWEEN '2016-01-15' AND '2016-01-18'")
#data5=dbGetQuery(con, "select PostMessage from post WHERE  affect=0 AND PostTime BETWEEN '2016-01-18' AND '2016-01-22'")
#data6=dbGetQuery(con, "select PostMessage from post WHERE  affect=0 AND PostTime BETWEEN '2016-01-22' AND '2016-01-25'")
#data7=dbGetQuery(con, "select PostMessage from post WHERE  affect=0 AND PostTime BETWEEN '2016-01-25' AND '2016-01-28'")
#data8=dbGetQuery(con, "select PostMessage from post WHERE  affect=0 AND PostTime BETWEEN '2016-01-28' AND '2016-02-01'")
#data9=rbind(data,data2,data3,data4,data5,data6,data7,data8)
#############################################################01~09   09~17   17~25  25~01
data=dbGetQuery(con, "select PostMessage from post WHERE number!='79957' And affect='0' AND PostPN='-1' AND PostTime BETWEEN '2016-07-25' AND '2016-08-01'")


#data=dbGetQuery(con, "select PostMessage from post WHERE number!='79957' And affect=0 AND PostTime BETWEEN '2016-03-09' AND '2016-03-17'")
#names(mycorpus)=sprintf(mycorpus[[1]],1:length(mycorpus))
#mycorpus=mycorpus
##########################################################
mycorpus=Corpus(VectorSource(data[[1]]))

mycorpus=tm_map(mycorpus,PlainTextDocument)
mycorpus=tm_map(mycorpus,stripWhitespace)
mycorpus=tm_map(mycorpus,removeWords,stopwords("english"))

mycorpus<- tm_map(mycorpus, removePunctuation) # 移除標點符號
mycorpus<- tm_map(mycorpus, removeNumbers) # 移除數字

#匯入新詞彙
#newwords=readLines(file("C:/data/newwords.txt",open="r"))
#newwords=toTrad(newwords,rev=TRUE)
#newwords=union(newwords,"太平島")
#insertWords(newwords)

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
	w[names(w)=="userDefine"|names(w)=="v"|names(w)=="n"|names(w)=="i"|names(w)=="ad"|names(w)=="an"|names(w)=="vn"|names(w)=="null"|names(w)=="l"|names(w)=="d"]
	})

}
unlist(noun)

})


#存成純文字
mycorpus4=Corpus(VectorSource(mycorpus3))
#去除停止詞
stopwords=readLines(file("C:/data/stopwords.txt"))
stopwords=toTrad(stopwords,rev=TRUE)
myStopWords=c(stopwordsCN(),"典范","國民黨","總統",stopwords)
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

##################### 畫雲  #####################
tdm <- TermDocumentMatrix(mycorpus7, control = list(wordLengths = c(2, Inf)))
inspect(tdm[1:10, 1:2])
library(wordcloud)
m1 <- as.matrix(tdm)
v <- sort(rowSums(m1), decreasing = TRUE)
d <- data.frame(word = names(v), freq = v)
png(filename="C:/Users/user/Desktop/104/R學長姐/暑假/程式碼/文字雲/七月4負.png", width=1000, height=1000)
wordcloud(d$word, d$freq, min.freq = 10,scale=c(6,2), max.words =80, random.order = F, ordered.colors = F, 
    colors = rainbow(length(row.names(m1))))
dev.off()


