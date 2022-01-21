<?php

define('USE_BM25', 'TRUE');

switch ( USE_BM25 ) {
    case 'TRUE':
        $java_class = "Lucene_API_with_BM25";
        break;
    default:
        $java_class = "Lucene_API";
        break;
}

( isset($argv[1]) && isset($argv[2]) ) or die ( " Send me proper Input." );
switch ($argv[1]) {
    case '-index':
        $command = "java -cp .:includes/json-20211205.jar:includes/lucene-core-4.0.0.jar:includes/lucene-analyzers-common-4.0.0.jar:includes/lucene-queryparser-4.0.0.jar:includes/lucene-queryparser-4.0.0.jar " . $java_class . " -index ";
        break;
    case '-query':
        $command = "java -cp .:includes/json-20211205.jar:includes/lucene-core-4.0.0.jar:includes/lucene-analyzers-common-4.0.0.jar:includes/lucene-queryparser-4.0.0.jar:includes/lucene-queryparser-4.0.0.jar " . $java_class . " -query ";
        break;
    default:
        die ( " Send me proper Input." );
        break;
} 
$command .=  "\"" . str_replace( "\"" , "\\\"" , $argv[2] ) . "\"";
$result = shell_exec( $command );
echo $result ;


?>