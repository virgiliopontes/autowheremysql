# Auto Where MySQL for PHP

This package to create the where part of your MySQL queries from a simple form submission, and everything automatically.

## Install

```
composer require virgiliopontes/autowheremysql
```
<!-- 
## Introduction

This package aims to be a solution to compile and process JasperReports (.jrxml & .jasper files).

### Why?

Did you ever had to create a good looking Invoice with a lot of fields for your great web app?

I had to, and the solutions out there were not perfect. Generating *HTML* + *CSS* to make a *PDF*? WTF? That doesn't make any sense! :)

Then I found **JasperReports** the best open source solution for reporting.

### What can I do with this?

Well, everything. JasperReports is a powerful tool for **reporting** and **BI**.

**From their website:**

> The JasperReports Library is the world's most popular open source reporting engine. It is entirely written in Java and it is able to use data coming from any kind of data source and produce pixel-perfect documents that can be viewed, printed or exported in a variety of document formats including HTML, PDF, Excel, OpenOffice and Word.

I recommend using [Jaspersoft Studio](http://community.jaspersoft.com/project/jaspersoft-studio) to build your reports, connect it to your datasource (ex: MySQL), loop thru the results and output it to PDF, XLS, DOC, RTF, ODF, etc.

*Some examples of what you can do:*

* Invoices
* Reports
* Listings -->

## Examples

### The *Hello World* example.

Go to the examples directory in the root of the repository (`vendor/virgiliopontes/autowheremysql/examples`).

Open the `index.php` with your favorite text editor and take a look at the source code.

#### Open the browser

Navigate to the directory where the `index.php` is allocated.


**Exemple**
```
http://127.0.0.1/vendor/virgiliopontes/autowheremysql/
```

**Note:** You need to replace `127.0.0.1` with the machine address where the example is

## Installation

### Composer

Install [Composer](http://getcomposer.org) if you don't have it.

```
composer require virgiliopontes/autowheremysql
```

Or in your `composer.json` file add:

```javascript
{
    "require": {
		"virgiliopontes/autowheremysql": "~2",
    }
}
```

And the just run:

	composer update

and thats it.

### Using

Uses in Controller by adding `use AutoWhere/AutoWhereMysql` after namespace
```php
<?php
namespace App\Controllers;

use AutoWhere\AutoWhereMysql; //<--- Here

class YourClass
{
	//...

    public function YourMethod()
    {        
        $autoWhereMysql = new AutoWhere\AutoWhereMysql();
        if(isset($_POST['campofiltro'])){
            $where = $autoWhereMysql->make_where($_POST['campofiltro'],$_POST['operador'],$_POST['valorfiltro']);
            echo $where;
        }

    }
}    
```
<!-- 
## Performance

Depends on the complexity, amount of data and the resources of your machine (let me know your use case).

I have a report that generates a *Invoice* with a DB connection, images and multiple pages and it takes about **3/4 seconds** to process. I suggest that you use a worker to generate the reports in the background.


## Thanks

Thanks to [Cenote GmbH](http://www.cenote.de/) for the [JasperStarter](http://jasperstarter.sourceforge.net/) tool.
 -->
## Questions?

Call me on Twitter [@virgiliopontes](https://twitter.com/virgiliopontes).

## License

MIT
