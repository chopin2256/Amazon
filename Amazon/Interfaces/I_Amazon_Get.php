<?php

interface I_Amazon_GET {

    /**
     * Gets the title of the Amazon product
     */
    public function title();

    /**
     * Gets the product description of the Amazon product
     */
    public function description();

    /**
     * Gets the url of the Amazon product
     */
    public function url();

    /**
     * Gets the number of product listings for sale of a particular item.  Values can be wither "TotalNew" or "TotalUsed"
     * @param string $type Values can be "TotalNew", "TotalUsed"
     */
    public function numOffers($type);

    /**
     * Gets the image of the Amazon product, already embedded in an img tag, with a class of 'thumbnail'
     * @param string $imageSize Values can be "SmallImage", "MediumImage", "LargeImage"
     */
    public function image($imageSize);

    /**
     * Gets the price of listing
     * @param string $type Values can be "regular", "lowestNew", "lowestUsed", "collectible", "list"
     */
    public function price($type);

    /**
     * Gets the average price of listing, based on average of (regular, lowestNew, lowestUsed, collectible and list price)
     * @return string In dollar format
     */
    public function averagePrice();
}
