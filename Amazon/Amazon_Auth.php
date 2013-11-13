<?php
/**
 * Authenticate V4
 * Create parameters, canonicalizedQuery, signature and authenticated URL
 */

require_once('Amazon_Base.php');

class Amazon_Auth extends Amazon_Base {  
    
    /**
     * 
     * @return string URI '/onca/xml'
     */
    private function _getUri() {
        return '/onca/xml';
    }
    
    /**
     * 
     * @return string Host 'webservices.amazon'
     */
    private function _getHost() {
        return 'webservices.amazon.' . parent::$_locale;
    }
    
    /**
     * Some of the common parameters in an Amazon rest query are set here
     * @param string $value
     * @reference http://docs.aws.amazon.com/AWSECommerceService/latest/DG/CommonRequestParameters.html
     */
    public function parameters($value) {
        $params['Service'] = 'AWSECommerceService'; 
        $params['AWSAccessKeyId'] = parent::$_public_key;
        $params['Timestamp'] = gmdate("Y-m-d\TH:i:s\Z");
        $params['Version'] = '2011-08-01';
        $params['AssociateTag'] = parent::$_associate_tag;
        $params['XMLEscaping'] = 'Double';
        $params['Keywords'] = $value;
        $params['ItemPage'] = 1;
        $params['Operation'] = 'ItemSearch';
        $params['SearchIndex'] = 'All';
        $params['ResponseGroup'] = 'Medium';
        //$params['ResponseGroup'] = 'ItemAttributes,Offers,Images,Reviews';
        ksort($params);
        return $params;
    }

    /**
     * To begin the signing process, you create a string that includes information from your request in a standardized (canonical) format. Formatting the request into an unambiguous, canonical format before signing it ensures that when AWS receives the request, it calculates the same signature that you calculated. (Non-standardized formatting can result in you and AWS calculating different signatures for the request, and the request will be denied.) 
     * @return string
     * @reference http://docs.aws.amazon.com/general/latest/gr/sigv4-create-canonical-request.html
     */
    public function canonicalizedQuery($params) {
        // Create the canonicalized query
        $canonicalized_query = array();
        foreach ($params as $param => $value) {
            $param = str_replace('%7E', '~', rawurlencode($param));
            $value = str_replace('%7E', '~', rawurlencode($value));
            $canonicalized_query[] = $param . '=' . $value;
        }
        return implode('&', $canonicalized_query);
    }

    /**
     * A signature is created by using the request type, domain, the URI, and a sorted string of every parameter in the request (except the Signature parameter itself) with the following format parameter=value&. Once properly formatted, you create a base64-encoded HMAC_SHA256 signature using your AWS secret key.
     * @return string
     * @reference http://docs.aws.amazon.com/AWSECommerceService/latest/DG/rest-signature.html
     */
    public function signature($canonicalizedQuery) {
        // Create the string to sign
        $string_to_sign = "GET" . "\n" . $this->_getHost() . "\n" . $this->_getUri() . "\n" . $canonicalizedQuery;

        // Calculate HMAC with SHA256 and base64-encoding
        $signature = base64_encode(hash_hmac('sha256', $string_to_sign, parent::$_private_key, TRUE));

        // Encode the signature for the request
        return str_replace('%7E', '~', rawurlencode($signature));
    }

    /**
     * The finalized authenticated URL to be processed by CURL, consists of host, uri, canonicalizedQuery and signature
     * @return string
     */
    public function authenticatedUrl($canonicalizedQuery, $signature) {       
        return 'http://' . $this->_getHost() . $this->_getUri() . '?' . $canonicalizedQuery . '&Signature=' . $signature;
    }     

}
