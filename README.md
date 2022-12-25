# Candle search engine

![Candle](https://raw.githubusercontent.com/TadavomnisT/candle_search_engine/main/front-end/images/candle.png)

A simple search engine, implemented with ```Java``` and ```PHP```



## Candle GUI:

![candle GUI](https://github.com/TadavomnisT/candle_search_engine/raw/main/Documentation/Images/candle_search_sample.png)



## History:

Those folks who used Tor alot, may remember "candle search engine" .

I believe the URL was : http://xmh57jrzrnw6insl.onion/

Not sure if it still operates...

#### Somthing look like this:
![candle1](https://github.com/TadavomnisT/candle_search_engine/raw/main/Documentation/Images/image1.png)

IDK the creator , and honestly IDK who used to run the system , but the logicality of the system was outstanding to me, that's why this project is dedicated to "candle search engine". 

The main aim is to use PHP alongside with Java.
The base system will be java and I'm gonna use `Apcahe-lucecne` for indexing, then a PHP wrapper will be implemented over base system to prepare APIs and eventually to run the engine as a website.
I'll probably use modular structures to provide APIs.

I intend to implement a decent web-crawler for the project later.

Let's see how it goes.

## Requirements:

* ```java``` and ```javac```

* ```php```

* ```git``` (if you'd like to clone the repo then build)


## Installation:

1. Clone the Repo:

`git clone https://github.com/TadavomnisT/candle_search_engine.git`

2. Complie Java codes:

`cd candle_search_engine/back-end/Java/`

`javac -cp "./includes/lucene-analyzers-common-4.0.0.jar:includes/lucene-core-4.0.0.jar:includes/lucene-queryparser-4.0.0.jar:includes/json-20211205.jar" *.java`

3. Start php server to run the GUI:

#### For Candle-Indexer GUI:

`cd indexer` (Suppose You are in "candle_search_engine" directory)

`php -S 127.0.0.1:8586`

#### For Candle-Search-Engine GUI:

`cd front-end` (Suppose You are in "candle_search_engine" directory)

`php -S 127.0.0.1:8585`


now open a browser and check out these two URLs:

`http://127.0.0.1:8585/` , `http://127.0.0.1:8586/`


__________________________________________________________________







## Search API:

In this version , you can use `GET` protocol with `q` parameter as query.

Suppose "Candle-Search-Engine GUI" is running on `http://127.0.0.1:8585/` , the simply:

`http://127.0.0.1:8585/?q=anime` will search "anime" query.

Be aware that in this methode , your query must be URL-Encoded.








## Use Lucene-API in PHP code:

```php

<?php

require_once "Lucene_API.php";
$lucene_api = new Lucene_API;

//index documents:
$directories = [];
$files = [];
$links = []; //means URLs
$result = $lucene_api -> index( $directories , $files , $links );

//search a query:
$query = "string of query";
$result = $lucene_api -> query( $query );
var_dump( $result );

?>

```




## Development Info
* Homepage: https://github.com/TadavomnisT/candle_search_engine
* Repo: https://github.com/TadavomnisT/candle_search_engine

## Author
* Behrad.B
* Contact: http://TadavomnisT.iR , t.me/TadavomnisT

## License
*  GPL-3.0 license 

Have fun!
