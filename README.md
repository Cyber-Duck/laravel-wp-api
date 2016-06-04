# laravel-wp-api
Laravel 5 package for the [Wordpress JSON REST API](https://github.com/WP-API/WP-API) 

## Install

Simply add the following line to your `composer.json` and run install/update:

    "cyberduck/laravel-wp-api": "dev-master"

## Configuration

Publish the package config files to configure the location of your Wordpress install:

    php artisan vendor:publish

You will have to edit the file in `app/config/wp-api.php` to configure the right endpoint.

You will also need to add the service provider to your `app/config/app.php`::

```php
'providers' => array(
  'Cyberduck\LaravelWpApi\LaravelWpApiServiceProvider'
)
```

### Usage

The package provides a simplified interface to some of the existing api methods documented [here](http://wp-api.org/).
You can either use the Facade provided or inject the WpApi class.

#### Posts
```php
WpApi::posts($page);

```

#### Pages
```php
WpApi::pages($page);

```

#### Post
```php
WpApi::post($slug);

```

#### Categories
```php
WpApi::categories();

```

#### Tags
```php
WpApi::tags();

```

#### Category posts
```php
WpApi::categoryPosts($slug, $page);

```

#### Search
```php
WpApi::search($query, $page);

```

#### Archive
```php
WpApi::archive($year, $month, $page);

```
