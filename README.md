wp-log-in-browser
=================

Allows you to log data from your PHP WordPress code to your browser's console.

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
============

1. Clone this repository in your wp-content/plugins folder
2. Make sure you init and update the submodules
3. Activate in your WordPress admin as any other plugin


![Chrome](http://screenshots.mzaweb.com/hFXw)
![Firefox](http://screenshots.mzaweb.com/hFY6)
