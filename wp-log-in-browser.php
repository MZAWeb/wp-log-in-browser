<?php
/*
Plugin Name: WP Log in Browser
Description: Allows you to send debug info to your browser console.
Version: 0.1.2
Author: Daniel Dvorkin
Author URI: http://danieldvork.in
License: GPLv3
*/

include 'classes/Browser.interface.php';
include 'classes/BrowserAdmin.class.php';
include 'classes/Browser.class.php';

Browser::instance();