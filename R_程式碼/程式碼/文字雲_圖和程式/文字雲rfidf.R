library(RMySQL)
library(wordcloud)

con<- dbConnect(MySQL(), user="root", password="", dbname="main", host="127.0.0.1")
Sys.setlocale(category='LC_ALL', locale='')
#設定big5
dbSendQuery(con,"SET NAMES big5")

data=dbGetQuery(con, "select keyword from keyword where nametype='n'")
names(data)='word'

#data2=dbGetQuery(con, "select (rfidf) * (DF) from idf WHERE week='1'")
#names(data2)='freq'

#data2=dbGetQuery(con, "select (rfidf) * (DF) from idf WHERE (week=1) AND (id in(SELECT wordid from keyword WHERE nametype='n'))")
#select (rfidf) * (DF) from idf WHERE (week=1) AND (id in(SELECT wordid from keyword WHERE nametype='n'))

i=1
while(i<=4)
{
if(i==1)
{
data2<-paste("select (rfidf) * (DF) from idf WHERE (week='",i,"') AND (id in(SELECT wordid from keyword WHERE nametype='n'))",sep="")
data2=try(dbGetQuery(con,data2),silent = TRUE)
}
if(i>1)
{
data1<-paste("select (rfidf) * (DF) from idf WHERE (week='",i,"') AND (id in(SELECT wordid from keyword WHERE nametype='n'))",sep="")
data1=try(dbGetQuery(con,data1),silent = TRUE)
data2=data2+data1
}
print(i)
i=i+1
}
names(data2)='freq'


data3=cbind(data,data2)
d=data3[order(data3$freq, decreasing=TRUE),]
 
##################### 畫雲  #####################
png(filename="C:/Users/user/Desktop/104/R學長姐/暑假/程式碼/文字雲rfidf/第一週.png", width=1000, height=1000)
wordcloud(d$word, d$freq, min.freq = 100,scale=c(4,1), max.words =80, random.order = F, ordered.colors = F, 
   colors = rainbow(length(row.names(d))))
dev.off()
