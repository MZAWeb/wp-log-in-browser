wp-log-in-browser
=================

Allows you to log data from your PHP WordPress code to your browser's console.

(a.k.a Annoyed you can't var_dump from an AJAX handler? Not anymore!)

For Chrome you need to install [ChromePHP](http://www.chromephp.com/).
For Firefox you need to install [FireBug](http://getfirebug.com/) and [FirePHP](http://www.firephp.org/).

I'm working on a nice admin screen to config auto-logging of some common things (like wp_query in pre_get_posts and wp), and some other goodies.

To log things manually, you can use:

    browser()->log( $var, $label );
    browser()->warn( $var, $label );
    browser()->info( $var, $label );
    browser()->error( $var, $label );

For example, to log all your main query's query_vars:

    add_filter( 'pre_get_posts', 'log_wp_query', 10000 );

    function log_wp_query( $query ) {
        if ( $query->is_main_query() )
            browser()->log( $query->query_vars, 'pre_get_posts' );

        return $query;
    }

I *only* tested this in a vanilla installation of WordPress using TwentyTwelve. I'll test how this plays along with popular themes/plugins, but please be aware I didn't do it yet. Use it under your own risk.


Installation
------------

1. Clone this repository in your wp-content/plugins folder
2. Make sure you **init and update the submodules**
3. Activate in your WordPress admin as any other plugin

Filters
-----------

**wplinb-match-wp-debug**: Set to true to only log when wp_debug is true. To prevent logging when wp_debug is false:

    add_filter( 'wplinb-match-wp-debug', '__return_true' );

**wplinb-enabled**: To disable logging completely. It takes precedence over *wplinb-match-wp-debug*. To disable logging:

    add_filter( 'wplinb-enabled', '__return_false' );


Screenshots
-----------

In Chrome:
![Chrome](http://screenshots.mzaweb.com/hFXw)

In Firefox:
![Firefox](http://screenshots.mzaweb.com/hFY6)

Log even from and AJAX handler!
![AJAX](http://screenshots.mzaweb.com/hGnY)


Changelog:

0.1.1
* Fix case on include for ChromePhp (props faction23)
* Make the logger work from and AJAX handler
* Add filter *wplinb-match-wp-debug* to log only when wp_debug is on
* Add filter *wplinb-enabled* to disable logging completely. It has precedence over *wplinb-match-wp-debug*

0.1
* First release