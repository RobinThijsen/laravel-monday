# A laravel package to easily use Monday.com API

[![Latest Version on Packagist](https://img.shields.io/packagist/v/robinthijsen/laravel-monday.svg?style=flat-square)](https://packagist.org/packages/robinthijsen/laravel-monday)
<!--delete-->
---
## Installation

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
];
```

## Usage

To initialize monday call API this package depends on the [tblack-it/monday-api](https://github.com/Softinthebox/monday-api) package. <br/>
You need to instantiate a QueryBuilder object with the static method `::query()`. <br/>
There isn't `__construct()` methods in the QueryBuilder class. <br/>
Reason : prettier...

```php
use RobinThijsen\LaravelMonday\QueryBuilder

$queryResult = QueryBuilder::query();
```

You can start building your query on chaining methods on the `::query()` one.

```php
use RobinThijsen\LaravelMonday\QueryBuilder

$queryResult = QueryBuilder::query()
    ->getBoards()     // get boards depending on the arguments and the fields specify
    ->columns()       // get columns of the boards
    ->items()         // get items of the boards
    ->columnValues(); // get the items column values
```

Most of the methods are taking 2 optional arguments : `array|string $arguments` and `array|string $fields` <br/>
Sometimes, there aren't any arguments depending on the monday.com API.

## BIG 4

You need to always start your query (after `::query()`) with `the BIG4 (getDocs, getBoards, getWorkspaces, getItems)` methods. <br/>
Theses 4 methods are the main one. They define what ur looking for in the API. <br/>
You can pass an array of fields and arguments to get the data you want.

```php
    public function getDocs(array|string $attributes = MondayDoc::ARGUMENTS, array|string $fields = MondayDoc::FIELDS): self {...}

    public function getBoards(array|string $attributes = MondayBoard::ARGUMENTS, array|string $fields = MondayBoard::FIELDS): self {...}

    public function getWorkspaces(array|string $attributes = MondayWorkspace::ARGUMENTS, array|string $fields = MondayWorkspace::FIELDS): self {...}

    public function getItems(array|string $attributes = MondayItem::ARGUMENTS, array|string $fields = MondayItem::FIELDS): self {...}
```

To see all the available fields, arguments and methods available, you can check the MondayObject in the package or go to the [monday.com API documentation](https://developer.monday.com/api-reference/reference/docs)

When you are done building your query, you need to close it. <br/>
For that you should call the `->get()` method;

```php
use RobinThijsen\LaravelMonday\QueryBuilder

$queryResult = QueryBuilder::query()
    ->getBoards()
    ->items()
    ->columnValues()
    ->get(); // return an QueryResult object
```

This will return you a QueryResult Object with :

```php
public ?array $boards = null;     // array of MondayBoard instance
public ?array $docs = null;       // array of MondayDoc instance
public ?array $workspaces = null; // array of MondayWorkspace instance
public ?array $items = null;      // array of MondayItem instance
public ?array $errors = null;     // array of errors send by monday.com API

public ?int $countOfOpenBrackets;
public ?int $countOfCloseBrackets;
public string $query = ""; // the query generated
```

There are some methods to get objects in the BIG4 that should chain or not them. <br/>
A `ChainedNotAllowException` will be thrown if you try to chain a method that should not be chained with one of the BIG4. <br/>
An `InvalidTokenException` will be thrown if you mentionned an invalid token in your `.env` file or if there isn't any.

## Author

[Robin Thijsen](https://github.com/robinthijsen)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
