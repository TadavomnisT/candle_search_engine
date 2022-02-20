<?php



class Web_crawler
{

    private $black_list , $enable_log , $proxy;
    public function __construct( $black_list = [] , $enable_log = TRUE , $proxy = FALSE )
    {
        $this->black_list = $black_list;
        $this->enable_log = $enable_log;
        $this->proxy = $proxy;
    }

    public function crawl_url(String $url , $depth = PHP_INT_MAX)
    {
        while (true) {
            $this->fetchHyperLinks( 
                $this->getUrlContents(
                    $url
                )
            );
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

    public setProxy( $proxy = FALSE )
    {
        $this->proxy = $proxy;
    }

    public getProxy( )
    {
        return $this->proxy;
    }

    public enableLog( )
    {
        $this->enable_log = TRUE;
    }
    
    public disableLog( )
    {
        $this->enable_log = FALSE;
    }

    private function fetchHyperLinks( string $contents )
    {
        $pattern = '~[a-z]+://\S+~';
        if($num_found = preg_match_all($pattern, $html, $out))
        {
            echo "FOUND ".$num_found." LINKS:\n";
            var_dump($out);
        }
    }

    private function getUrlContents( string $url )
    {
        # code... 
    }
    
}




?>