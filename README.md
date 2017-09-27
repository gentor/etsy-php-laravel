# Etsy PHP SDK for Laravel

Based on [Etsy Rest API description](http://www.etsy.com/developers/documentation/reference/apimethod) output, this wrapper provides a simple client with all available methods on Etsy API (thanks to the `__call` magic PHP method!), validating its arguments on each request (Take a look to [methods.json](https://github.com/gentor/etsy-php-laravel/blob/master/src/methods.json) for full list of methods and its arguments).

Used some code from [etsy-php](https://github.com/inakiabt/etsy-php) by **Iñaki Abete**

## Installation

The following recommended installation requires [composer](http://getcomposer.org/). If you are unfamiliar with composer see the [composer installation instructions](http://getcomposer.org/doc/01-basic-usage.md#installation).

```
composer require gentor/etsy-php-laravel
```


Add the service provider in `config/app.php`:

```php
Gentor\Etsy\Providers\EtsyServiceProvider::class,
```

Add the facade alias in `config/app.php`:

```php
Gentor\Etsy\Facades\Etsy::class,
```

Copy the config file and enter your Etsy App settings in `app/config/etsy.php`:

```php
<?php

return array(
    'consumer_key' => '',
    'consumer_secret' => '',
    'access_token' => '',
    'access_token_secret' => '',
    'scope' => ''
);
```

## Usage ##

All methods has only one argument, an array with two items (both are optional, depends on the method):

- *params*: an array with all required params to build the endpoint url.
  > Example:
  > [getSubSubCategory](http://www.etsy.com/developers/documentation/reference/category#method_getsubsubcategory): GET /categories/:tag/:subtag/:subsubtag
```php
  # it will request /categories/tag1/subtag1/subsubtag1
  Etsy::getSubSubCategory(array(
          'params' => array(
                         'tag' => 'tag1',
                         'subtag' => 'subtag1',
                         'subsubtag' => 'subsubtag1'
           )));
```

- *data*: an array with post data required by the method
  > Example:
  > [createShippingTemplate](http://www.etsy.com/developers/documentation/reference/shippingtemplate#method_createshippingtemplate): POST /shipping/templates
```php
  # it will request /shipping/templates sending the "data" array as the post data
  Etsy::createShippingTemplate(array(
    						'data' => array(
   							    "title" => "First API Template",
   							    "origin_country_id" => 209,
   							    "destination_country_id" => 209,
   							    "primary_cost" => 10.0,
   							    "secondary_cost" => 10.0
           )));
```

## Get OAuth token credentials ##

Etsy API uses OAuth 1.0 authentication, so we need token credentials (access_token and access_token_secret).

```php
// The $callbackUrl is the url of your app where Etsy sends the data needed for getting token credentials
$callbackUrl = 'http://your-app/etsy/approve';

// The $authorizationUrl is the Etsy url where the user approves your app
$authorizationUrl = Etsy::authorize($callbackUrl);

// On the callback endpoint run this code to get the token credentials and add them to your config
$tokenCredentials = Etsy::approve($request->get('oauth_token'), $request->get('oauth_verifier'));

return [
    'access_token' => $tokenCredentials->getIdentifier(),
    'access_token_secret' => $tokenCredentials->getSecret(),
];
```

## Examples ##

```php
$shipping_template = [
    'data' => [
        "title" => "First API Template",
        "origin_country_id" => 209,
        "destination_country_id" => 209,
        "primary_cost" => 10.0,
        "secondary_cost" => 10.0
    ]
];
print_r(Etsy::createShippingTemplate($shipping_template));

# Upload image files:

$listing_image = [
    'params' => [
        'listing_id' => '152326352'
    ],
    'data' => [
        'image' => '/path/to/file.jpg'
    ]
];
print_r(Etsy::uploadListingImage($listing_image));

$listing_file = [
    'params' => [
        'listing_id' => '152326352'
    ],
    'data' => [
        'file' => '/path/to/file.jpg'
    ]
];
print_r(Etsy::uploadListingFile($listing_file));

```

## Asociations ##
You would be able to fetch associations of your resources using a simple interface:
```php
$args = array(
        'params' => array(
            'listing_id' => 654321
        ),
        // A list of associations
        'associations' => array(
            // Could be a simple association, sending something like: ?includes=Images
            'Images',
            // Or a composed one with (all are optional as Etsy API says) "scope", "limit", "offset", "select" and sub-associations ("associations")
            // ?includes=ShippingInfo(currency_code, primary_cost):active:1:0/DestinationCountry(name,slug)
            'ShippingInfo' => array(
                'scope' => 'active',
                'limit' => 1,
                'offset' => 0,
                'select' => array('currency_code', 'primary_cost'),
                // The only issue here is that sub-associations couldn't be more than one, I guess.
                'associations' => array(
                    'DestinationCountry' => array(
                        'select' => array('name', 'slug')
                    )
                )
            )
        )
    );

$result = Etsy::getListing($args);
```
To read more about associations: https://www.etsy.com/developers/documentation/getting_started/resources#section_associations

## JSON params ##
There are some methods that Etsy requires to be a JSON string encoded param (ie: param "variations" for "createListingVariations"). For these cases, those params should be defined like this:
```php
    $args = array(
        'params' => array(
            'listing_id' => 654321
        ),
        'data' => array(
          'variations' => array(
            'json' => json_encode(
                array(
                    array(
                        'property_id' => 200,
                        'value' => "Black"
                    ),
                    array(
                        'property_id' => 200,
                        'value' => "White"
                    )
                )
            )
        )
      )
    );

    $result = Etsy::createListingVariations($args);
```

## Documentation ##

[Etsy API Reference](https://www.etsy.com/developers/documentation)