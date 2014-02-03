<?php

//Require the class file

require_once('Amazon.php');

//Run Amazon
runAmazon();

function runAmazon() {
    $amazon = new Amazon();  //Instantiate Amazon object
    $kw = "product title";  //Set keyword
    $cnt = 5;  //Set amazon max results, up to 10
    
    //Set config options
    $amazon->config()
            ->API_KEY('Your API')
            ->SECRET_KEY('Your Secret Key')
            ->associate_tag('associatetag-20')
            ->locale('com')
            ->maxResults($cnt);

    //Search for keyword
    $amazon->search($kw);

    //Loop through array in for loop to save your Amazon results
    for ($i = 0; $i < $cnt; $i++) {
        $result .= amazonLayout($i, $amazon);
    }

    //Clear amazon object
    $amazon->clear();

    //Set and return results, in this case, 5 product titles
    echo $result;
}

function amazonLayout($i, Amazon $amazon) {
    //Get your amazon attributes here
    $image = $amazon->get()->image("LargeImage");
    $priceLowNew = $amazon->get()->price("lowestNew");
    $priceUsed = $amazon->get()->price("lowestUsed");
    $offersNew = $amazon->get()->numOffers("TotalNew");
    $offersUsed = $amazon->get()->numOffers("TotalUsed");
    $url = $amazon->get()->url();
    $title = $amazon->get()->title();
    $desc = $amazon->get()->description();

    //Your custom code and formatting here
    $newTitle = "<div>$title[$i]</div>";
    $newUrl = "<div>$url[$i]</div>";

    //..etc
    return $newTitle;
}
?>