WP-Term
=======

Pointless PHP script that provides visitors of your [WordPress](https://github.com/WordPress/WordPress) website an unix-like CLI to view and navigate posts / pages.

Not to be confused with [WP-CLI](https://github.com/wp-cli/wp-cli) or [WP-Terminal](http://wordpress.org/plugins/wp-terminal/).

Demo
----
![demo.gif](https://raw.githubusercontent.com/ockcyp/wp-term/master/demo.gif)

GIF image recorded using [ScreenToGif](http://screentogif.codeplex.com/)

Configuration
-------------
Configuration is stored in `config/` directory as `app.php` for production
and `app_test.php` for unit tests.

Deployment
----------
Requirements
* Linux
* patch command
* twentythirteen theme

Execute the following command:
```
./deploy.sh -d /path/to/wordpress
```
