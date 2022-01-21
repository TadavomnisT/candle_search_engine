<?php

$result = "";

if ( isset( $_GET["directories"] ) && isset( $_GET["files"] ) && isset( $_GET["links"] ) ) {
    
    $directories = explode( "," , trim( $_GET["directories"] ) );
    $files = explode( "," , trim( $_GET["files"] ) );
    $links = explode( "," , trim( $_GET["links"] ) );

    foreach ($directories as $key => $value)
        if( $value == "" )
            unset( $directories[$key] );

    foreach ($files as $key => $value)
        if( $value == "" )
            unset( $files[$key] );

    foreach ($links as $key => $value)
        if( $value == "" )
            unset( $links[$key] );

    if ( (count( $directories ) + count( $files ) + count( $links )) > 0 ) {
        require_once "Lucene_API.php";
        $lucene_api = new Lucene_API;
        $result = $lucene_api -> index( $directories , $files , $links );
        $result = "RESULT:<br><br>" . str_replace( PHP_EOL , "<br>" , $result );
    }
    

}



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" >
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candle-Indexer</title>

    <link rel="apple-touch-icon" sizes="76x76" href="/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/favicon/site.webmanifest">
    <link rel="mask-icon" href="/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">


    <style>

    body {background-color: black;} 
    
    textarea {background-color: gray;} 
    
    #container{
        height : 100%;
        width : 100%;
    }

    #candle{
        align-items: center;
        display: flex;
        justify-content: center;
    }
    
    .caption{
        color : white;
        justify-content: center;
    }
    
    .result{
        color : white;
        width : 763px;
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

    </div>

    <div id="candle" >

        <form action="" method="get">

            <div id="logo" >
                <img src="/images/candle_indexer.png" alt="Candle-indexer">
            </div>

            <div class="caption" >
                Enter directories that you'd like to index (Separate them with comma "," ) : 
            </div>

            <div id="directories" >
                <textarea name="directories" id="directories" cols="100" rows="10"></textarea>
            </div>

            <div class="caption" >
                Enter files that you'd like to index (Separate them with comma "," ) : 
            </div>

            <div id="files" >
                <textarea name="files" id="files" cols="100" rows="10"></textarea>
            </div>

            <div class="caption" >
                Enter URLs that you'd like to index (Separate them with comma "," ) : 
            </div>

            <div id="links" >
                <textarea name="links" id="links" cols="100" rows="10"></textarea>
            </div>

            <div id="button">
                <input type="submit" value="index" >
            </div>

            <div class="result" >
                <?php echo $result; ?> 
            </div>

        </form>

    </div>
    
</div>


</body>
</html>
