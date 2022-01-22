<?php


require_once "evaluation_measures.php";
$evaluator = new Evaluation_measures ;

$input_file_name = "query_results_TF_IDF";
$file = fopen($input_file_name,'r');

$retrieved_documnets_TF_IDF = [];

$counter = 0;
$string_buffer = "";
while(!feof($file)) {
    $line = trim( fgets($file) );

    if ( $line == "///" ) {
        $counter = 0;
        $array_pool = [];
        $array = explode( " " , $string_buffer );
        foreach ($array as $value) {
            if ( strpos( $value , "txt" ) !== False )
                {
                    $temp_array = explode( "/" , $value );
                    $array_pool[] = (int) explode( "." , $temp_array[ count($temp_array) - 1 ] )[ 0 ];
                }
        }
        $retrieved_documnets_TF_IDF[ $lable ] = $array_pool;
        $string_buffer = "";
    }else {
        if ($line != "") {
            if ( $counter === 0 ) {
                $lable = $line;
            }
            else {
                $string_buffer .= " " . $line;
            }
            ++ $counter;
        }
    }
}

fclose($file);



$input_file_name = "query_results_BM25";
$file = fopen($input_file_name,'r');

$retrieved_documnets_BM25 = [];

$counter = 0;
$string_buffer = "";
while(!feof($file)) {
    $line = trim( fgets($file) );

    if ( $line == "///" ) {
        $counter = 0;
        $array_pool = [];
        $array = explode( " " , $string_buffer );
        foreach ($array as $value) {
            if ( strpos( $value , "txt" ) !== False )
                {
                    $temp_array = explode( "/" , $value );
                    $array_pool[] = (int) explode( "." , $temp_array[ count($temp_array) - 1 ] )[ 0 ];
                }
        }
        $retrieved_documnets_BM25[ $lable ] = $array_pool;
        $string_buffer = "";
    }else {
        if ($line != "") {
            if ( $counter === 0 ) {
                $lable = $line;
            }
            else {
                $string_buffer .= " " . $line;
            }
            ++ $counter;
        }
    }
}

fclose($file);



$input_file_name = "../collection/npl/rlv-ass";
$file = fopen($input_file_name,'r');

$relevant_documents = [];

$counter = 0;
$string_buffer = "";
while(!feof($file)) {
    $line = trim( fgets($file) );

    if ( $line == "/" ) {
        $string_buffer = preg_replace('!\s+!', ' ', trim( $string_buffer ) );
        $relevant_documents [ $lable ] = explode( " " , $string_buffer ); 
        $string_buffer = "";
        $counter = 0;
    }else {
        if ($line != "") {
            if ( $counter === 0 ) {
                $lable = $line;
            }
            else {
                $string_buffer .= " " . $line;
            }
            ++ $counter;
        }
    }
}

fclose($file);




// for TF-IDF
file_put_contents( "TF_IDF_EVALUATION" , "Query_Lable\tPrecision\tRecall\tF_score\tMean_average_precision" . PHP_EOL );
foreach ($relevant_documents as $key => $value) {
    $precision = $evaluator -> precision( $value , $retrieved_documnets_TF_IDF[ $key ]  );
    $recall = $evaluator -> recall( $value , $retrieved_documnets_TF_IDF[ $key ]  );
    file_put_contents( 
        "TF_IDF_EVALUATION" ,
        $key . "\t" .
        $precision . "\t" .
        $recall . "\t" .
        $evaluator -> f_score( $precision , $recall ) . "\t" .
        $evaluator -> mean_average_precision( $value , $retrieved_documnets_TF_IDF[ $key ]  ) . PHP_EOL ,
        FILE_APPEND
     );
}


// for BM25
file_put_contents( "BM25_EVALUATION" , "Query_Lable\tPrecision\tRecall\tF_score\tMean_average_precision" . PHP_EOL );
foreach ($relevant_documents as $key => $value) {
    $precision = $evaluator -> precision( $value , $retrieved_documnets_BM25[ $key ]  );
    $recall = $evaluator -> recall( $value , $retrieved_documnets_BM25[ $key ]  );
    file_put_contents( 
        "BM25_EVALUATION" ,
        $key . "\t" .
        $precision . "\t" .
        $recall . "\t" .
        $evaluator -> f_score( $precision , $recall ) . "\t" .
        $evaluator -> mean_average_precision( $value , $retrieved_documnets_TF_IDF[ $key ]  ) . PHP_EOL ,
        FILE_APPEND
     );
}



?>