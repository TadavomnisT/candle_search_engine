<?php



class Web_crawler
{

    private $black_list , $enable_log;
    public function __construct( $black_list = [] , $enable_log = TRUE )
    {
        $this->black_list = $black_list;
        $this->enable_log = $enable_log;
    }

    public function crawl_url(String $url , $depth = PHP_INT_MAX)
    {
        while (true) {
            # code...
        }
    }

    public setBlackList( $black_list = [] )
    {
        $this->black_list = $black_list;
    }

    public getBlackList( )
    {
        return $this->black_list;
    }

    public enableLog( )
    {
        $this->enable_log = TRUE;
    }
    
    public disableLog( )
    {
        $this->enable_log = FALSE;
    }

    private function fetchUrlHyperLinks( string $html )
    {
        # code...
    }
    
}




?>