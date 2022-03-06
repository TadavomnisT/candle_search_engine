<?php

/*
Proxy format: [ "proxy_type" => "host:port" ]
    Examle:
    $proxy = [ "http" => "127.0.0.1:8585" ];
    $proxy = [ "socks" => "127.0.0.1:9050" ];
*/

class Web_crawler
{

    private $black_list , $enable_log , $proxy;
    public function __construct( $black_list = [] , $enable_log = TRUE , $proxy = FALSE )
    {
        $this->black_list = $black_list;
        $this->enable_log = $enable_log;
        $this->proxy = $proxy;
    }

    public function crawl_url(String $url , $max_degree = 0 , $depth = PHP_INT_MAX)
    {
        while (true) {
            $this->fetchHyperLinks( 
                $this->getUrlContents(
                    $url
                )
            );
        }
    }

    public function setBlackList( $black_list = [] )
    {
        $this->black_list = $black_list;
    }

    public function getBlackList( )
    {
        return $this->black_list;
    }

    public function setProxy( $proxy = FALSE )
    {
        $this->proxy = $proxy;
    }

    public function getProxy( )
    {
        return $this->proxy;
    }

    public function enableLog( )
    {
        $this->enable_log = TRUE;
    }
    
    public function disableLog( )
    {
        $this->enable_log = FALSE;
    }

    private function fetchHyperLinks( string $contents )
    {
        $pattern = '~[a-z]+://\S+~';
        if( preg_match_all( $pattern, $contents, $links ) )
            return $links;
        return false;
    }

    private function getUrlContents( string $url )
    {
        $ch = curl_init (); 
        curl_setopt ($ch, CURLOPT_URL, $url); 
        if ( isset( $this->proxy["socks"] ) || isset( $this->proxy["http"] ) )
            curl_setopt ($ch, CURLOPT_PROXY, ( isset( $this->proxy["http"] ) ) ? $this->proxy["http"] : $this->proxy["socks"] ); 
        if ( isset( $this->proxy["socks"] ) )
            curl_setopt ($ch, CURLOPT_PROXYTYPE, 7);        
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, TRUE); 
        curl_setopt ($ch, CURLOPT_FAILONERROR, true); 
        curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1); 
        $data = curl_exec($ch); 
        curl_close ($ch);
        return $data;
    }

    // ===============================TESING=================================
    public function test_fetchHyperLinks($contents)
    {
        return $this->fetchHyperLinks( $contents );
    }
    public function test_getUrlContents($url)
    {
        return $this-> getUrlContents ( $url );
    }
    
}




?>