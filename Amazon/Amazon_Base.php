<?php

require_once('Amazon_Auth.php');

class Amazon_Base {

    /**
     * Curl Method constant
     * @var string
     */
    private $_method = "GET";

    /**
     * Product keyword to be searched in Amazon
     * @var string
     */
    private $_keyword;

    /**
     * Set the Authenticated URL, to be used by _getArrayData
     * @var string
     */
    private $_authenticatedUrl;

    /**
     * Holds Amazon array data, to be utilized by "get" commands
     * @var array
     */
    static private $_arrayData;

    /**
     * Counter to ensure _getArrayData is only run once during "get" actions.  This saves on API hits.
     * 
     */
    static private $_counter = 0;

    /**
     * Set the local variable
     * @var string Accessed by Amazon_Config
     */
    static protected $_locale;

    /**
     * Set Amazon Secret Key
     * @var string Accessed by Amazon_Config
     */
    static protected $_private_key;

    /**
     * Set Amazon API Key
     * @var string Accessed by Amazon_Config
     */
    static protected $_public_key;

    /**
     * Set Amazon Associates Tag
     * @var string Accessed by Amazon_Config
     */
    static protected $_associate_tag;
    
    /**
     * Set Amazon max results per listing (up to 10)
     * @var string 
     */
    static protected $_maxResults;
    
    /**
     * Set Amazon Delay to 1 second
     * @var bool 
     */
    static protected $_requestDelay;
    
    /**
     * Initialize Amazon and tell it which product to search for
     * @param string $keyword
     */    
    private function _init($kw) {
        $this->_requestDelay(); //Request Delay
        $this->_keyword = $kw;  //Set keyword
        $this->_runAuth();      //Run auth
        $this->_getArrayData(); //Run XML Data Stream
    }
    
    /**
     * Authorizes request
     */
    private function _runAuth() {
        $auth = new Amazon_Auth();
        $params = $auth->parameters($this->_keyword);  //Run parameters and set dynamic keyword value
        $canonicalizedQuery = $auth->canonicalizedQuery($params);
        $signature = $auth->signature($canonicalizedQuery);
        $this->_authenticatedUrl = $auth->authenticatedUrl($canonicalizedQuery, $signature);
    }
    
    /**
     * Main request to grab Amazon data in xml format.  This is where the api gets called.
     * @return xml array
     */
    protected function _getArrayData() {
        if (self::$_counter == 0) {  //Only run curl on first iteration, until data has been purged
            $curl = curl_init($this->_authenticatedUrl);  //Initialize the url
            $this->_curlOptions($curl, $this->_method);  //Set the options, also set GET command
            self::$_arrayData = simplexml_load_string(curl_exec($curl)); //Executes rest command via curl, and converts json output into php array  
        }
        self::$_counter = 1;
        return self::$_arrayData;
    }
    
    /**
     * Delays request by 0 or 1 second
     */
    private function _requestDelay() {
        if (self::$_requestDelay == true) {
            sleep(1);
        }
    }
    
    /**
     * 
     * @param string $curl The initialized curl url
     * @param string $type Get, Post
     * @return array Array of options
     */
    private function _curlOptions($curl, $type) {
        return curl_setopt_array(
                $curl, array(
            CURLOPT_HTTPHEADER => array('Content-type: application/xml'), //Options for XML
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => $type  //The type of request (can be Put, Get or Delete)
                )
        );
    }

}
