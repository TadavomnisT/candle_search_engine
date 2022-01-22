<?php


require_once "Lucene_API.php";
$lucene_api = new Lucene_API;

// First step : Split documents in different files===========================

mkdir("splited_docs");

$input_file_name = "../collection/npl/doc-text";
$file = fopen($input_file_name,'r');

$counter = 0;
while(!feof($file)) {
    $line = trim( fgets($file) );

    if ( $line == "/" ) {
        $counter = 0;
        fclose($fp);
    }else {
        if ($line != "") {
            if ( $counter === 0 ) {
                $fp = fopen( "splited_docs/" . $line . ".txt" ,'w+');
            }
            else {
                fputs($fp, $line . " ");
            }
            ++ $counter;
        }
    }
}

fclose($file);





// Second step : Split queries in different files===========================

mkdir("splited_queries");

$input_file_name = "../collection/npl/query-text";
$file = fopen($input_file_name,'r');

$counter = 0;
while(!feof($file)) {
    $line = trim( fgets($file) );

    if ( $line == "/" ) {
        $counter = 0;
        fclose($fp);
    }else {
        if ($line != "") {
            if ( $counter === 0 ) {
                $fp = fopen( "splited_queries/" . $line . ".txt" ,'w+');
            }
            else {
                fputs($fp, $line . " ");
            }
            ++ $counter;
        }
    }
}

fclose($file);



// Third step : Index npl doc ===========================

$result = $lucene_api -> index( [ realpath("splited_docs") ] , [] , [] );

echo $result ;





?>