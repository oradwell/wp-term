WP-Term
=======

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ockcyp/wp-term/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/ockcyp/wp-term/?branch=master)

Pointless PHP script that provides visitors of your [WordPress](http://wordpress.org/) website a unix-like CLI to view and navigate posts / pages.

Not to be confused with [WP-CLI](http://wp-cli.org/) or [WP-Terminal](http://wordpress.org/plugins/wp-terminal/).

Demo
----
![demo.gif](https://raw.githubusercontent.com/ockcyp/wp-term/master/demo.gif)

GIF image recorded using [ScreenToGif](http://screentogif.codeplex.com/)

Test it on my blog:
[blog.omer.london](http://blog.omer.london/)

Configuration
-------------
Configuration is stored in `config/` directory as `app.php` for production
and `app_test.php` for unit tests.

Tests
-----

### PHPUnit

Code is fully covered by PHPUnit unit tests.

Assuming you have `phpunit.phar` in the project root directory, run PHPUnit
tests using this command:
```
php phpunit.phar
```

### Behat

For behat tests you need to do ``composer install`` and have Selenium2 running

By default tests are run on [my blog](http://blog.omer.london/)
but can be changed by modifying behat config.

Run the tests by executing:
```
vendor/bin/behat
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
