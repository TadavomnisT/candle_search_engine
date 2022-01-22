<?php


class Evaluation_measures
{

    public function precision( array $relevant_documents , array $retrieved_documnets )
    {
        if ( count($retrieved_documnets) ==  0 ) return 0;
        return count( array_intersect( $relevant_documents , $retrieved_documnets ) ) / count( $retrieved_documnets );
    }

    public function recall( array $relevant_documents , array $retrieved_documnets )
    {
        if ( count($relevant_documents) ==  0 ) return 0;
        return count( array_intersect( $relevant_documents , $retrieved_documnets ) ) / count( $relevant_documents );
    }

    public function f_score( $precision , $recall )
    {
        if ( ( $precision + $recall ) ==  0 ) return 0;
        return (2 * $precision * $recall) / ( $precision + $recall );
    }

    public function mean_average_precision( array $relevant_documents , array $retrieved_documnets )
    {
        $retrieved_documnets_pool = [];
        $average_precision = 0;
        $count = 0;
        foreach ($retrieved_documnets as $retrieved_documnet) {
            $retrieved_documnets_pool[] = $retrieved_documnet;
            $average_precision =+ $this -> precision( $relevant_documents , $retrieved_documnets_pool );
            ++ $count;
        }
        if ( $count == 0 ) return 0;
        return $average_precision / $count;
    }

    public function nDCG()
    {
        # I should put sth here...
    }
    
}




?>