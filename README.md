# Product`s description sentiment analyzer

This app is dedicated to the most possible sentiment prediction of product descriptions.

`Input`: CSV file with product's name and description.

`Output:` sorted by sentiment's score table of products.


For score calculation, there are 3 basic approaches:
1. Internal ([Twinword](https://www.twinword.com/api/)) 
2. External ([PHP Sentiment Analyzer](https://github.com/davmixcool/php-sentiment-analyzer))
3. Mixed (average between internal and external scores)

<sub> In the future, it is possible to add new APIs or libraries for internal/external methods.</sub> 

This is a console app. To run this you will need to have php-cli ver. >= 8.1

```
php analyzer.php print -internal
php analyzer.php print -external
php analyzer.php print -all
```

Also you can use docker-compose (by default it will calculate internal scores)
```
docker-compose up
```

The table consists of products sorted by score, with minimum and maximum values displayed at the end.

**<p>Table output of _Internal_ service</p>**
<img src="https://i.imgur.com/ORUDjsx.png" alt="main-page" width="700">
. . .
<img src="https://i.imgur.com/5CeclWf.png" alt="main-page" width="700">

**<p>Table output of _External_ service</p>**
<img src="https://i.imgur.com/jfQMGSY.png" alt="main-page" width="700">

**<p>Table output of _Average (Mixed)_ score of services</p>**
<img src="https://i.imgur.com/GdYMm6e.png" alt="main-page" width="700">
