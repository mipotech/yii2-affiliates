# Yii2 Cardcom SDK

This package provides a simple way to integrate with the Cardcom API.


## Installation
The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

First add this entry to the `repositories` section of your composer.json:

```
"repositories": [{
    ...
},{
    "type": "git",
    "url": "https://github.com/mipotech/yii2-affiliates.git"
},{
    ...
}],
```

then add this line:

```
"mipotech/yii2-affiliates": "dev-master",
```

to the `require` section of your `composer.json` file and perform a composer update.

## Configuration

Add the following section to the params file (@app/config/params.php):

```php
return [
    ...
    
    'affiliates' => [
        /* Required settings */
        'class' => 'mipotech\affiliates\Affiliates',
        'affiliateClass' => '\app\models\user\User', //require
        'affiliateIdAttribute' => 'aff_id', //require
        'affiliateExpiredDays' =>  30,
        'affiliateIdUrlParam' => 'ref',
        'campaignIdUrlParam' => 'camp', 
    ],
    ...
];
```

That's it. The package is set up and ready to go.

## Usage

To create an instance of the SDK:

```php
	//Fixme
```

### Initiate a new low profile transaction

Standard:

```php
	// Fixme
```
