# A laravel package to easily use Monday.com API

[![Latest Version on Packagist](https://img.shields.io/packagist/v/robinthijsen/laravel-monday.svg?style=flat-square)](https://packagist.org/packages/robinthijsen/laravel-monday)
<!--delete-->
---
## Installation
This is a Laravel package to easily use the Monday.com API. <br/>
You can also use it in vanilla PHP.

First install the package via composer:

```bash
composer require robinthijsen/laravel-monday
```

(Optionally) You can publish the config file to change the default configuration.

```bash
# That's currently changing anything so don't do it
# I'm planning to add some config for future version
php artisan vendor:publish --tag="monday-config"
```

This is the contents of the published config file: <br/>
You should define your monday.com API token in the `.env` file.

```php
return [
    'token' => env('MONDAY_API_TOKEN'),
    'version' => env('MONDAY_API_VERSION', '2024-04'),
];
```

## Usage

Before starting to use the package, you should get your API token from [Monday.com](https://monday.com/) <br/>
and look about the documentation of monday object on the [Monday.com API documentation](https://monday.com/developers/v2).

Okay, let's start using the package. <br/>
If you know a bit about dynamic classes and props, this package work this way. <br/>

```php
# This is a list of every Monday object you can use in this package
# Or find them in the src/Objects directory
use \RobinThijsen\LaravelMonday\Objects\Account;
use \RobinThijsen\LaravelMonday\Objects\AccountProduct;
use \RobinThijsen\LaravelMonday\Objects\Block;
use \RobinThijsen\LaravelMonday\Objects\Board;
use \RobinThijsen\LaravelMonday\Objects\Column;
use \RobinThijsen\LaravelMonday\Objects\ColumnValue;
use \RobinThijsen\LaravelMonday\Objects\Doc;
use \RobinThijsen\LaravelMonday\Objects\Group;
use \RobinThijsen\LaravelMonday\Objects\Icon;
use \RobinThijsen\LaravelMonday\Objects\Item;
use \RobinThijsen\LaravelMonday\Objects\Plan;
use \RobinThijsen\LaravelMonday\Objects\Team;
use \RobinThijsen\LaravelMonday\Objects\User;
use \RobinThijsen\LaravelMonday\Objects\Workspace;
use \RobinThijsen\LaravelMonday\Objects\WorkspaceSetting;
```

You can start a query builder by calling the `::query()` or `::find()` method on the object you want to query (If the object doesn't accept querying and unique querying, an Exception will be thrown). <br/>

```php
use \RobinThijsen\LaravelMonday\Objects\Board;

# This is an example of querying all the boards
# The following params are for Board object
# Check params for other objects in the src/Objects directory
/**
* @param int|array|null $ids => default null
 * @param int|array|null $workspaceIds => default null
 * @param int $limit => default 25
 * @param int $page => default 1
 * @param string $kind => default BoardKind::PUBLIC
 * @param string $state => default State::ACTIVE
 * @return \RobinThijsen\LaravelMonday\Objects\Board[]
 */
$boards = Board::query();
```

`::query()` and `::find()` accept dynamic arguments depending on the object you are querying. <br/>

Then, you can chain the query builder with the following methods: `->with()` and `->withObject()` <br/>

```php
use \RobinThijsen\LaravelMonday\Objects\Board;
use \RobinThijsen\LaravelMonday\Objects\Item;

# This is an example of querying all the boards with the items
$boards = Board::query()
    ->with('id', 'name')
    ->withObject(Item::class, [], ['id', 'name']);
```
```php
/**
 * FieldsName are the fields you want to get from the object
 * If the field is not in the object or if it is an object field, an Exception will be thrown
 * 
 * @param string ...$fieldNames
 */
public function with(...$fieldNames)
```
```php
/**
 * Get an object with the given field names
 * 
 * @param string $fieldName
 * @param array|Closure $params
 * @param array $fields
 */
public function withObject($fieldName, $params = [], $fields = [])
```
To call object of object, you need to use the withObject method. <br/>
but with a Closure method replacing param $params. <br/>

```php
use \RobinThijsen\LaravelMonday\Objects\Board;
use \RobinThijsen\LaravelMonday\Objects\Item;
use \RobinThijsen\LaravelMonday\Objects\ColumnValue;

// In this exemple, I recover the board with id 123456
// with all is items and all the column values of each item with specific default fields for each object
$board = Board::find(123456)
    ->with('id', 'name')
    ->withObject(Item::class, function ($builder) {
        $builder->with('id', 'name')
        ->withObject(ColumnValue::class, [], ['text', 'value']);
    });
````

When your query is ready, you can call the `->get()` method to get the results. <br/>

```php
// This will return you an instance of Board class with asked fields as props
// For this exemple, it will be id and name
$board = Board::find(123456)
    ->with('id', 'name')
    ->get();
```

## Author

[Robin Thijsen](https://github.com/robinthijsen)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
