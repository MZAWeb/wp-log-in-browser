wp-debug-in-browser
===================

Allows you to log data from your PHP WordPress code to your browser's console.

For Chrome you need to install [ChromePHP](http://www.chromephp.com/).
For Firefox you need to install [FireBug](http://getfirebug.com/) and [FirePHP](http://www.firephp.org/).

I'm working in a nice admin screen to config auto-logging of some common things (like wp_query in pre_get_posts and wp), and some other goodies.

To log things manually, you can use:

    browser()->log( $var, $label );
    browser()->warn( $var, $label );
    browser()->info( $var, $label );
    browser()->error( $var, $label );

For example, to log all your main query's query_vars:

    add_filter( 'pre_get_posts', 'dlog_wp_queryani', 10000 );

    function log_wp_query( $query ) {
        if ($query->is_main_query()){
            browser()->log( $query->query_vars, 'pre_get_posts' );
            return $query;
        }
    }

I *only* tested this in a vanilla installation of WordPress using TwentyTwelve. I'll test how this plays along with popular themes/plugins, but please be aware I didn't do it yet. Use it under your own risk.