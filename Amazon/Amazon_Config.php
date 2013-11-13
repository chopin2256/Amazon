<?php

require_once('Amazon_Base.php');
require_once('Interfaces/I_Amazon_Config.php');

class Amazon_Config extends Amazon_Base implements I_Amazon_Config {

    public function locale($value) {
        parent::$_locale = $value;
        return $this;
    }

    public function SECRET_KEY($value) {
        parent::$_private_key = $value;
        return $this;
    }

    public function API_KEY($value) {
        parent::$_public_key = $value;
        return $this;
    }

    public function associate_tag($value) {
        parent::$_associate_tag = $value;
        return $this;
    }

    public function maxResults($value) {
        parent::$_maxResults = $value;
        return $this;
    }
    
    public function requestDelay($value) {
        parent::$_requestDelay = $value;
        return $this;
    }

}
