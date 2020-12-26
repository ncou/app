[Chiron Framework] is a light framework designed to allow developpers to quickly start a new console or web application.

<img src="https://user-images.githubusercontent.com/16743322/103154480-d428a780-4797-11eb-8f9e-3f3a916d5f38.jpg" height="135px" alt="Chiron Framework" align="left"/>

This repository contain an App Skeletton intended to show the basic Chiron features. Your first step to build amazing projects !

[![Latest Stable Version](https://poser.pugx.org/chiron/chiron/v/stable.png)](https://packagist.org/packages/chiron/chiron)
[![Total Downloads](https://img.shields.io/packagist/dt/chiron/chiron.svg?style=flat-square)](https://packagist.org/packages/chiron/chiron/stats)
[![Build Status](https://travis-ci.org/ncou/Chiron.svg?branch=master)](https://travis-ci.org/ncou/Chiron)

## Requirements

Make sure that your web server is configured with following PHP version and extensions:
* PHP >= 7.2
* *intl* PHP Extension
* *mbstring* PHP Extension

## Installation

If you do not have [Composer](http://getcomposer.org/), you may install it by following the instructions at [getcomposer.org](http://getcomposer.org/doc/00-intro.md).

You can then install this project template using the following command:

```bash
$ composer create-project chiron/app [my-app-name]
```
>Replace [my-app-name] with the desired directory name for your new application.

## Cloning

>This section applies only if you cloned this repo with `git clone`, not when you installed Chiron with `composer create-project ...`.

Make sure to properly configure your app project after cloning this repository.

```bash
$ bin/chiron dotenv:copy -d .env        # Create the .env file at the root path
$ bin/chiron dotenv:key -m .env         # Update the security key in .env file
$ bin/chiron package:discover           # Auto-discover the module bootloaders
```

## Web Server

You can launch a development web server to quickly test you application.

```bash
$ php -S localhost:8080 -t public/
```
or
```bash
$ bin/chiron serve
```
>Now you should be able to access the application through the URL printed in the console.

## Directory structure

The application template has the following structure:

```bash
config/                   #Configuration files.
docs/                     #Documentation.
public/                   #Files publically accessible from the Internet.
    assets/               #Published assets.
    index.php             #Entry script.
resources/                #Application resources.
    assets/               #Asset bundle resources.
    layout/               #Layout view templates.
    view/                 #View templates.
runtime/                  #Files generated during runtime.
src/                      #Application source code.
    Asset/                #Asset bundle definitions.
    Controller/           #Web controller classes.
    Provider/             #Providers that take configuration and configure services.
tests/                    #A set of Codeception tests for the application.
vendor/                   #Installed Composer packages.
```

## Testing

To test an application:

```bash
$ ./vendor/bin/phpunit
```
or
```bash
$ composer phpunit
```

## License

The Chiron framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
