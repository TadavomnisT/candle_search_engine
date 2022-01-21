
<?php

$result = "";

if ( isset( $_GET["q"] ) && ( trim($_GET["q"]) != "" ) ) {

    require_once "Lucene_API.php";
    $lucene_api = new Lucene_API;
    $result = $lucene_api -> query( $_GET["q"] );
    if (strpos($result, 'hits') !== false) {
        $result_array = explode( PHP_EOL , trim($result) );
        $result = "Search results for: <b>" . $_GET["q"] . "</b><br>" . trim($result_array[0]) . "<br><br><br>";
        unset( $result_array[0] );
        foreach ($result_array as $key => $value) {
            $array = explode( " " , trim( $value ) );
            $result .= "<a href=\"" . $array[1] . "\">" . $array[1] . "</a><br>" .
            "<span style=\"color:green;\" >" . $array[1] . "</span><br>" .
            $array[0] . " Rank = " . $key . " Document " . $array[2] . "<br><br>";
        }
    }
    else {
        $result = "ERROR : No doucument indexed?";
    }
    
    
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" >
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candle</title>

    <link rel="apple-touch-icon" sizes="76x76" href="/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/favicon/site.webmanifest">
    <link rel="mask-icon" href="/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">


    <style>

    body {background-color: black;} 
    #container{
        height : 100%;
        width : 100%;
    }

    #candle{
        align-items: center;
        display: flex;
        justify-content: center;
    }
    #candle_result{
        align-items: center;
        display: flex;
        justify-content: center;
    }

    .result{
        color : white;
        width : 960px;
    }


    #caption{
        color : white;
        align-items: center;
        display: flex;
        justify-content: center;
    }

    #button{
        align-items: center;
        display: flex;
        justify-content: center;
    }


    </style>
</head>
<body>


<div id="container" >

    <div id="adjust_height" >
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
    </div>

    <div id="candle" >

        <form action="" method="get">

            <div id="logo" >
                <img src="/images/candle.png" alt="Candle">
            </div>

            <div id="searchbox" >
                <input type="text" id="text" name="q" size="73">
            </div>

            <div id="caption" >
                no parenthesis, no boolean operators, no quotes, just words
            </div>

            <div id="button">
                <input type="submit" value="Search" >
            </div>

        </form>
    </div>

    <div id="candle_result" >
        <div class="result" >
            <?php echo $result; ?> 
        </div>
    </div>

</div>


</body>
</html>
