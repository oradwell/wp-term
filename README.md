WP-Term
=======

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ockcyp/wp-term/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/ockcyp/wp-term/?branch=master)

Pointless PHP script that provides visitors of your [WordPress](http://wordpress.org/) website a unix-like CLI to view and navigate posts / pages.

Not to be confused with [WP-CLI](http://wp-cli.org/) or [WP-Terminal](http://wordpress.org/plugins/wp-terminal/).

Demo
----
![demo.gif](https://raw.githubusercontent.com/ockcyp/wp-term/master/demo.gif)

GIF image recorded using [ScreenToGif](http://screentogif.codeplex.com/)

Test it on my website:
[www.ockwebs.com](http://www.ockwebs.com/)

Configuration
-------------
Configuration is stored in `config/` directory as `app.php` for production
and `app_test.php` for unit tests.

Tests
-----
Code is fully covered by PHPUnit unit tests.

Assuming you have `phpunit.phar` in the project root directory, run PHPUnit
tests using this command
```
php phpunit.phar
```

Deployment
----------
Requirements:
* WordPress
* Linux
* patch command
* twentythirteen theme

Execute the following command:
```
./deploy.sh -d /path/to/wordpress
```
