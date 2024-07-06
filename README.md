# A laravel package to easily use Monday.com API

[![Latest Version on Packagist](https://img.shields.io/packagist/v/robinthijsen/laravel-monday.svg?style=flat-square)](https://packagist.org/packages/robinthijsen/laravel-monday)
<!--delete-->
---
## Installation

First install the package via composer:

```bash
composer require robinthijsen/laravel-monday
```

Then you should install the package with the following command:

```bash
php artisan laravel-monday:install
```

This is the contents of the published config file: <br/>
You chould define your monday.com API in the .env file.

```php
return [
    'token' => env('MONDAY_API_TOKEN'),
];
```

## Usage

To initialize monday call API this package depending on the [tblack-it/monday-api](https://github.com/Softinthebox/monday-api) package. <br/>
You need to instance an QueryBuilder object with static method `::query()`. <br/>
This method start.

```php
use RobinThijsen\LaravelMonday\QueryBuilder

$queryResult = QueryBuilder::query();
```

Then you can start building your query on chaining methods on the query() one with `the BIG3 (getDocs, getBoards, getWorkspaces)` methods. <br/>
Theses 3 methods are the main one. They define what ur looking for in the API. <br/>
You can pass an array of fields and arguments to get the data you want.

```php
    /**
     * Init a doc(s) query.
     * See list of fields available in the Doc Model
     * See list of attributes available in the Doc Model
     *
     * @param array|string $attributes
     * @param array|string $fields
     * @return $this
     */
    public function getDocs(array|string $attributes = MondayDoc::ARGUMENTS, array|string $fields = MondayDoc::FIELDS): self

    /**
     * Init a boards(s) query.
     * See list of fields available in the Board Model
     * See list of attributes available in the Board Model
     *
     * @param array|string $attributes
     * @param array|string $fields
     * @return $this
     */
    public function getBoards(array|string $attributes = MondayBoard::ARGUMENTS, array|string $fields = MondayBoard::FIELDS): self

    /**
     * Init a workspaces(s) query.
     * See list of fields available in the Workspace Model
     * See list of attributes available in the Workspace Model
     *
     * @param array|string $attributes
     * @param array|string $fields
     * @return $this
     */
    public function getWorkspaces(array|string $attributes = MondayWorkspace::ARGUMENTS, array|string $fields = MondayWorkspace::FIELDS): self
```

To see all the available fields, arguments and methods available, you can check the models in the package or go to the [monday.com API documentation](https://developer.monday.com/api-reference/reference/docs)

There are some methods to get objects in the BIG3 that should chain or not them. <br/>
A `ChainedNotAllowException` will be throw if you try to chain a method that should not be chained with one of the BIG3.

## Author

- [Robin Thijsen](https://github.com/robinthijsen)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
