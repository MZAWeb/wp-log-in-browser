=== Plugin Name ===
Contributors: MZAWeb
Donate link: http://danieldvork.in/
Tags: develop, debug, console
Requires at least: 3.4
Tested up to: 3.5
Stable tag: 0.1.2
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Allows you to log data from your PHP WordPress code to your browser's console.

Annoyed you can't var_dump from an AJAX handler? Not anymore!

== Description ==

I'm working on a nice admin screen to config auto-logging of some common things (like wp_query in pre_get_posts and wp), and some other goodies.

To log things manually, you can use:

`browser()->log  ( $var, $label );`
`browser()->warn ( $var, $label );`
`browser()->info ( $var, $label );`
`browser()->error( $var, $label );`

Also, commandas are chainable:

`browser()->log( 'This is a log...' )->error( '...and this is an error' );`

For example, to log all your main query's query_vars:

`add_filter( 'pre_get_posts', 'log_wp_query', 10000 );

function log_wp_query( $query ) {
	if ( $query->is_main_query() )
		browser()->log( $query->query_vars, 'pre_get_posts' );

	return $query;
}`

= Filters =

*wplinb-match-wp-debug*: Set to true to only log when wp_debug is true. To prevent logging when wp_debug is false:

`add_filter( 'wplinb-match-wp-debug', '__return_true' );`

*wplinb-enabled*: To disable logging completely. It takes precedence over *wplinb-match-wp-debug*. To disable logging:

`add_filter( 'wplinb-enabled', '__return_false' );`

= Profiling =

The plugin includes a really simple function to allow you to track execution time of different parts of your code.

`browser()->timer( $key, $log = false );`

The first time you call this function with a given $key (string) it will start a timer, and return false. You can start as many timers as you want, using different $key values. You can ignore the second parameter for this first call.

The second time you call this function with a given $key, it will return the ellapsed time in seconds since you started this $key timer. If you set the second parameter to true, it will also log this value to the browser.

Example 1: Sequential use, log manually.

`browser()->timer( 'Mega loop' );
for ( $i = 0; $i < 1000000; $i++ ) {
	//do something
}
$time = browser()->timer( 'Mega loop' );
browser()->log( $time, 'The mega loop took:' );`

Example 2: Start and end in different places, log automatically.

`add_action( 'posts_selection', 'start_timer', 100 );
add_filter( 'the_posts', 'end_timer', 1, 2 );

function start_timer( $query ) {
	browser()->timer( 'Main query time' );
}

function end_timer( $posts, $query ) {
	browser()->timer( 'Main query time', true );
	return $posts;
}`

*This is not a good way of measuring how much time a query takes to run, it's just to illustrate how to use the timer.*

In exactly the same way, you can use the function

`Browser()->memory( $key, $log = false );`

to measure delta of memory consumption from your first call and your second call with the same $key.

Example:

`Browser()->memory( 'testing' );
$test = array();
for ( $i = 0; $i < 100; $i++ ) {
	$test[$i] = md5( rand( 1, $i ) );
}
Browser()->memory( 'testing', true );


Browser()->memory( 'testing' );
$test = array();
for ( $i = 0; $i < 10000; $i++ ) {
	$test[$i] = md5( rand( 1, $i ) );
}
Browser()->memory( 'testing', true );`

== Installation ==

For Chrome you need to install the [ChromePHP](http://www.chromephp.com/) extension.
For Firefox you need to install both the [FireBug](http://getfirebug.com/) and [FirePHP](http://www.firephp.org/) extensions.

1. Upload to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress


== Changelog ==

= 0.1.2 =
* Fix output buffering. It was failing in some scenarios.
* Added timer function to easily profile execution time.
* Added memory function to easily profile memory consumption.

= 0.1.1 =
* Fix case on include for ChromePhp (props faction23)
* Make the logger work from an AJAX handler
* Add filter *wplinb-match-wp-debug* to log only when wp_debug is on
* Add filter *wplinb-enabled* to disable logging completely. It has precedence over *wplinb-match-wp-debug*

= 0.1 =
* First release