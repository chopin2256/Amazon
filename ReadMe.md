#Amazon Product API -v4
####Purpose
The purpose of this library is to make use of Amazon's associates program and pull Amazon product information via rest quite easily.

####Notes
The documentation for this API is not very straightforward, and there aren't too many easy to understand libraries out there that make use of API version 4 for Amazon's associates program.  Furthermore, the documentation to authenticate URL's is painful to read through.  Thus, I've created my own library in hopes to help others out there, and my library is VERY easy to understand, especially with my example framework provided.  Extending this library is also easy and adding more attributes is a breeze!  Here are the current attributes this library will handle:

*  title
*  description
*  url
*  numOffers
*  image
*  price
*  averagePrice

####References
* [Amazon API and Secret Key] (https://affiliate-program.amazon.com/gp/advertising/api/detail/your-account.html)
* [Get your associates tag] (https://affiliate-program.amazon.com/)

####How To Use
*  In index.php, be sure to require Amazon.php: `require_once('Amazon.php');`
*  Instantiate your object: `$amazon = new Amazon();`
*  Set your Amazon configuration:

```php
$amazon->config()
	->API_KEY('Your API')
	->SECRET_KEY('Your Secret Key')
	->associate_tag('associatetag-20')
	->locale('com')
	->maxResults($numResults);
```
*  Note: Another config option is requestDelay.  Set this option to true if you want to add a one second delay to your request, which eliminates the api request limit.  By default, this option is set to false (for example, don't bother setting it at all).  You may also explicitly set this value to false.
 *  Example: `$amazon->config()->requestDelay(true)` or `$amazon->config()->requestDelay(false)` or just don't set it like in the above example.
 *  See [Documentation] (https://affiliate-program.amazon.com/gp/advertising/api/detail/faq.html) about this.
*  Search for a keyword: `$amazon->search($kw);`
*  Attributes can now easily be retrieved, and all attributes have a data type of an array.  For example, if maxResults is set to 10, each attribute will return an array of 10 results:
 *  `$title = $amazon->get()->title();` 10 titles are returned and saved to the $title variable
 *  `$url = $amazon->get()->url();`  10 urls are returned and saved to the $url variable
*  With just some basic knowledge of PHP, if you know how to iterate through an array you can get creative from here and output values in whatever html markup you desire!
*  So, once you get your Amazon attributes (title, url, price, etc), I suggest that you set up a `for loop` like this:

```php
for ($i = 0; $i < $numResults; $i++) {
        $result .= $this->amazonLayout($i, $amazon);
    }
```

*  Notice the variable $amazon.  $amazon is actually an object, and we can pass this object as a parameter into a new function with data type Amazon, like this:

```php

function amazonLayout($i, Amazon $amazon) {
    //Get your amazon attributes here
    $title = $amazon->get()->title();
    $url = $amazon->get()->url();
    .
    .
    .

    //Your custom code and formatting here
    $newTitle = "<div>$title[$i]</div>";
    $newUrl = "<div>$url[$i]</div>";

    //..etc
    return $newTitle;
}


```

*  Let's say we wanted to print a list of 5 titles, the shell code to do that would like something like:

```php

    $amazon = new Amazon();  //Instantiate Amazon object
    $kw = "product title";  //Set keyword
    $numResults = 5;  //Set amazon max results, up to 10
    
    //Set config options
    $amazon->config()
            ->API_KEY('Your API')
            ->SECRET_KEY('Your Secret Key')
            ->associate_tag('associatetag-20')
            ->locale('com')
            ->maxResults($numResults);

    //Search for keyword
    $amazon->search($kw);

    //Loop through array in for loop to save your Amazon results
    for ($i = 0; $i < $cnt; $i++) {
        $result .= $this->amazonLayout($i, $amazon);
    }

    //Clear amazon object
    $amazon->clear();

    //Set and return results, in this case, 5 product titles
    echo $result;
```

*  Where the function `amazonLayout($i, $amazon)` is defined above.
*  Be sure you call the `clear` function after you are done retrieving results since the url string is cached in order to save on API hits, and speed up the request: `$amazon->clear();`
*  A full shell example is provided in `index.php`

####Real Example Usage
*  This script is used to power the amazon results section part of [Game Binder] (http://www.gamebinder.com/)
*  Link to [Assassin's Creed Amazon Results] (http://www.gamebinder.com/12/assassins-creed/buy/)