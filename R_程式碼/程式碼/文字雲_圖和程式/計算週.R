library(RMySQL)
library(wordcloud)

con<- dbConnect(MySQL(), user="root", password="", dbname="main", host="127.0.0.1")
Sys.setlocale(category='LC_ALL', locale='')
#³]©wbig5
dbSendQuery(con,"SET NAMES big5")

data=dbGetQuery(con, "select keyword from keyword_feed where nametype='n'")
names(data)='word'

data2=dbGetQuery(con, "select (rfidf) * (DF) from chen_idf_pos WHERE (week=30) AND (id in(SELECT wordid from keyword_feed WHERE nametype='n'))")
names(data2)='freq'


data3=cbind(data,data2)
d=data3[order(data3$freq, decreasing=TRUE),]
 
##################### µe¶³  #####################
wordcloud(d$word, d$freq, min.freq = 0,scale=c(4,2), max.words =80, random.order = F, ordered.colors = F, 
   colors = rainbow(length(row.names(d))))

png(filename="C:/xampp/htdocs/data/interface/chen_wordcloud_rfidf_pos/week30.png", width=800, height=800)
wordcloud(d$word, d$freq, min.freq = 0,scale=c(4,2), max.words =80, random.order = F, ordered.colors = F, 
   colors = rainbow(length(row.names(d))))
dev.off()

