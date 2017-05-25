library(RMySQL)
library(wordcloud)

con<- dbConnect(MySQL(), user="root", password="", dbname="main", host="127.0.0.1")
Sys.setlocale(category='LC_ALL', locale='')
#³]©wbig5
dbSendQuery(con,"SET NAMES big5")

data=dbGetQuery(con, "select keyword from keyword where nametype='n'")
names(data)='word'

#data2=dbGetQuery(con, "select (rfidf) * (DF) from date_idf WHERE date BETWEEN '2016-01-01' AND '2016-02-01' ")
#names(data2)='freq'

#data2=dbGetQuery(con, "select (rfidf) * (DF) from date_idf WHERE (date BETWEEN '2016-01-01' AND '2016-02-01') AND (id in(SELECT wordid from keyword WHERE nametype='n'))")
#names(data2)='freq'

data2<-paste("select (rfidf) * (DF) from date_idf WHERE (date='2016-01-01') AND (id in(SELECT wordid from keyword WHERE nametype='n'))",sep="")
data2=try(dbGetQuery(con,data2),silent = TRUE)

i=2
while(i!=32)
{

data1<-paste("select (rfidf) * (DF) from date_idf WHERE (date='2016-01-",i,"') AND (id in(SELECT wordid from keyword WHERE nametype='n'))",sep="")
data1=try(dbGetQuery(con,data1),silent = TRUE)
data2=data2+data1

print(i)
i=i+1
}
names(data2)='freq'



data3=cbind(data,data2)
d=data3[order(data3$freq, decreasing=TRUE),]
 
##################### µe¶³  #####################
png(filename="C:/xampp/htdocs/data/interface/wordcloud_rfidf_month/month1.png", width=1000, height=1000)
wordcloud(d$word, d$freq, min.freq = 100,scale=c(5,2), max.words =80, random.order = F, ordered.colors = F, 
   colors = rainbow(length(row.names(d))))
dev.off()
