# Eco Env
 
A small set of tools for easily manipulating your project .env files.

[![Latest Stable Version](https://poser.pugx.org/hotmeteor/eco-env/v)](//packagist.org/packages/hotmeteor/eco-env)

### Installation

```sh
composer require hotmeteor/eco-env
```

### Usage

For most of the methods you'll need to provide the relative or absolute `$file` path to your `.env` file.

In a Laravel app, this is as easy as `base_path('.env')`.

All `$key` values, for all methods, is case-insensitive. Keys will always be set in uppercase. 

#### Get

`Env::get($file, $key)`

Returns the full key/value string.

#### Set

`Env::set($file, $key, $value)`

Sets a value by key.

#### Unset

`Env::unset($file, $key, $value)`

Removes a value by key.

#### Has

`Env::has($file, $key, $value)`

Checks if a value exists, by key.

#### Format

`Env::formatValue($value)`

Exposes the internal method for formatting an .env value.

### Notes

This package isn't intended to be used instead of the fabulous [Dotenv](https://github.com/vlucas/phpdotenv) package. Dotenv is for automagically loading environment variables, Eco Env is for manipulating them.
