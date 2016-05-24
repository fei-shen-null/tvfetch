# TvFetch
###Subscribe by email and stay tuned
`http://tv.shenfei.lol`
##How to use

>fetch the current TVs<br>
`artisan tv:getList`

>push 'getTvEpisodes' job for each TV<br>
`artisan tv:getEpisodes`

>listen to 'getTvEpisodes' queue and fetch episodes, push 'newEpisodesMail' job if new episodes detected<br>
`queue:work --queue=getTvEpisodes --daemon --tries=3`

>listen to 'newEpisodesMail' queue and email to subscribers<br>
`queue:work --queue=newEpisodesMail --daemon --tries=3`

