<?php

/**
 * Get Amazon Attributes
 */
require_once('Amazon_Base.php');
require_once('Interfaces/I_Amazon_Get.php');

Class Amazon_Get extends Amazon_Base implements I_Amazon_GET {

    /**
     * Stores amazon xml data
     * @var array
     */
    private $_datas = array();

    /**
     * Initializes Amazon data into $datas array
     */
    public function __construct() {
        //This is the XML document string
        //We loop through the XML string starting at child node Items -> Item
        $this->_datas = parent::_getArrayData()->Items->Item;
    }
    
    public function title() {
        return $this->_getValue("ItemAttributes", "Title");
    }
    
    public function description() {
        return $this->_getValue("EditorialReviews", "EditorialReview", "Content");
    }
    
    public function url() {
        return $this->_getValue("DetailPageURL");
    }
    
    public function numOffers($type) {
        return $this->_getValue("OfferSummary", $type);
    }

    public function image($imageSize) {
        if ($imageSize == "SmallImage") {
            $width = 50;
        }
        if ($imageSize == "MediumImage") {
            $width = 100;
        }
        if ($imageSize == "LargeImage") {
            $width = 130;
        }
        $height = $width * 1.5;

        $images = $this->_getValue($imageSize, "URL");
        $i = 0;
        foreach ($images as $image) {
            $images[$i] = "<img class='thumbnail' style='width:{$width}px;height:{$height}px' src='$image'/>";
            $i++;
        }
        return $images;
    }
    
    public function price($type) {
        if ($type == "regular") {
            return $this->_getValue("Offers", "Offer", "OfferListing", "Price", "FormattedPrice");
        }
        if ($type == "lowestNew") {
            return $this->_getValue("OfferSummary", "LowestNewPrice", "FormattedPrice");
        }
        if ($type == "lowestUsed") {
            return $this->_getValue("OfferSummary", "LowestUsedPrice", "FormattedPrice");
        }
        if ($type == "collectible") {
            return $this->_getValue("OfferSummary", "LowestCollectiblePrice", "FormattedPrice");
        }
        if ($type == "list") {
            return $this->_getValue("ItemAttributes", "ListPrice", "FormattedPrice");
        }
    }
    
    /**
     * Gets the average price of listing, based on average of (regular, lowestNew, lowestUsed, collectible and list price)
     * @return string In dollar format
     */
    public function averagePrice() {
        $regArr = $this->_getValue("Offers", "Offer", "OfferListing", "Price", "FormattedPrice");
        $lowNewArr = $this->_getValue("OfferSummary", "LowestNewPrice", "FormattedPrice");
        $lowUsedArr = $this->_getValue("OfferSummary", "LowestUsedPrice", "FormattedPrice");
        $colArr = $this->_getValue("OfferSummary", "LowestCollectiblePrice", "FormattedPrice");
        $listArr = $this->_getValue("ItemAttributes", "ListPrice", "FormattedPrice");

        $cnt = count($regArr);
        for ($i = 0; $i < $cnt; $i++) {
            $price[$i] = "$" . round((preg_replace('/\$/', '', $regArr[$i]) + preg_replace('/\$/', '', $lowNewArr[$i]) + preg_replace('/\$/', '', $lowUsedArr[$i]) + preg_replace('/\$/', '', $colArr[$i]) + preg_replace('/\$/', '', $listArr[$i])) / 5, 2);
        }
        return $price;
    }

    /**
     * Get the xml value and stores it into an array
     * @return array
     */
    private function _getValue() {
        $argNum = func_num_args();
        $argVal = func_get_args();
        $i = 0;

        foreach ($this->_datas as $item) {
            if ($argNum == 1) {
                $item = $item->$argVal[0];
            }
            if ($argNum == 2) {
                $item = $item->$argVal[0]->$argVal[1];
            }
            if ($argNum == 3) {
                $item = $item->$argVal[0]->$argVal[1]->$argVal[2];
            }
            if ($argNum == 4) {
                $item = $item->$argVal[0]->$argVal[1]->$argVal[2]->$argVal[3];
            }
            if ($argNum == 5) {
                $item = $item->$argVal[0]->$argVal[1]->$argVal[2]->$argVal[3]->$argVal[4];
            }
            if ($argNum == 6) {
                $item = $item->$argVal[0]->$argVal[1]->$argVal[2]->$argVal[3]->$argVal[4]->$argVal[5];
            }
            $result[$i] = $item;
            $i++;
            
            //Only display # of results based on maxResults, set in config
            if ($i == self::$_maxResults) {
                break;
            }
        }
        return $result;
    }

}

?>