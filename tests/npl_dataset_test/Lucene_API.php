<?php



class Lucene_API
{

    public function index(array $directories = [] , array $files = [] , array $links = [] )
    {
        $json = json_encode( 
            [
                "directories" => $directories,
                "files" => $files,
                "links" => $links
            ]
        );
        $command =  "cd ../../back-end/Java/ &&  php API_wrapper.php -index \"" . str_replace( "\"" , "\\\"" , $json ) . "\" && cd ../../front-end";
        $result = shell_exec( $command );
        return $result ;
    }

    public function query( string $query = "" )
    {
        $command =  "cd ../../back-end/Java/ &&  php API_wrapper.php -query \"" . str_replace( "\"" , "\\\"" , $query ) . "\" && cd ../../front-end";
        $result = shell_exec( $command );
        return $result ;
    }

    
}



?>