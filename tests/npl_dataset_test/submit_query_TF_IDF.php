<?php


// Assume we use TF-IDF

// Submit queries and store results ===========================


require_once "Lucene_API.php";
$lucene_api = new Lucene_API;

$query_files = scandir( "splited_queries" );

$counter = 1;
foreach ($query_files as $query_file) {
    if (strpos($query_file, 'txt') !== false)
    {
        $result = $lucene_api -> query( trim( file_get_contents( "splited_queries/" . $query_file) ) );
        file_put_contents( "query_results_TF_IDF" , $counter . PHP_EOL . $result . "///" . PHP_EOL , FILE_APPEND );
        ++ $counter;
    }
}


?>