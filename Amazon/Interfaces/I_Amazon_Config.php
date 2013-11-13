<?php

interface I_Amazon_Config {

    /**
     * The Amazon domain location
     * @param string $value Values can be "com", "co.uk", "co.jp", "it", "in", "fr", "es", "de", "cn", "ca"
     * @example For United States, use "com" 
     */
    public function locale($value);

    /**
     * This is your Secret Key
     * @param string $value Key provided to you when you sign up for Amazon Affiliates program
     * @see https://affiliate-program.amazon.com/gp/advertising/api/detail/your-account.html
     */
    public function SECRET_KEY($value);

    /**
     * This is your API Key
     * @param string $value Key provided to you when you sign up for Amazon Affiliates program
     * @see https://affiliate-program.amazon.com/gp/advertising/api/detail/your-account.html
     */
    public function API_KEY($value);

    /**
     * This is your associate tag that you create when logged into your associates account.  Very Important!
     * @param string $value Associate Tag provided to you when you sign up for Amazon Affiliates program
     * @see https://affiliate-program.amazon.com/
     */
    public function associate_tag($value);

    /**
     * @param int Set Amazon Max Results (1 through 10)
     */
    public function maxResults($value);
    
  /**
   * Enables or disables the request delay.
   * If it is enabled (true) every request is delayed one second eliminating the api request limit.
   * By default the requestdelay is disabled
   * @param boolean $value true = enabled, false = disabled
   * @return boolean
   * @see https://affiliate-program.amazon.com/gp/advertising/api/detail/faq.html
   */
    public function requestDelay($value);
}
