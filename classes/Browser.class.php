<?php

if ( class_exists( "Browser" ) )
	return;

class Browser implements iBrowser {

	private static $instance;
	private $interfaces = array();
	private $path;

	public function __construct() {

		$this->path = trailingslashit( dirname( dirname( __FILE__ ) ) );

		$this->_get_interfaces();

		add_action( 'init', array( $this, 'init' ) );
		add_action( 'shutdown', array( $this, 'shutdown' ) );

	}

	/************* API **************/

	/**
	 *
	 * @param mixed  $var
	 * @param string $label
	 *
	 * @return Browser
	 */
	public function log( $var, $label = null ) {
		$this->_run( 'log', array( $var, $label ) );
		return $this;
	}

	/**
	 *
	 * @param mixed  $var
	 * @param string $label
	 *
	 * @return Browser
	 */
	public function info( $var, $label = null ) {
		$this->_run( 'info', array( $var, $label ) );
		return $this;
	}

	/**
	 * @param mixed  $var
	 * @param string $label
	 *
	 * @return Browser
	 */
	public function warn( $var, $label = null ) {
		$this->_run( 'warn', array( $var, $label ) );
		return $this;
	}

	/**
	 * @param mixed  $var
	 * @param string $label
	 *
	 * @return Browser
	 */
	public function error( $var, $label = null ) {
		$this->_run( 'error', array( $var, $label ) );
		return $this;
	}

	/************* API **************/

	public function init() {
		ob_start();
	}

	public function shutdown() {
		if ( ob_get_level() )
			ob_end_flush();
	}

	/**
	 * @return bool
	 */
	private function _should_run() {

		$enabled        = apply_filters( 'wplinb-enabled', true );
		$match_wp_debug = apply_filters( 'wplinb-match-wp-debug', false );

		if ( !$enabled )
			return false;

		if ( !$match_wp_debug )
			return true;

		if ( WP_DEBUG )
			return true;

		return false;

	}

	/**
	 * @param  string $command
	 * @param array   $params
	 */
	private function _run( $command, $params = array() ) {

		if ( !$this->_should_run() )
			return;

		if ( empty( $this->interfaces ) )
			return;

		foreach ( $this->interfaces as $interface ) {
			try {
				call_user_func_array( array( $interface, $command ), $params );
			} catch ( Exception $e ) {

			}
		}
	}

	/**
	 *
	 */
	private function _get_interfaces() {
		// This will come from the admin config
		$selected_interfaces = array( 'FirePHP', 'ChromePHP' );

		$selected_interfaces = apply_filters( 'wplinb-selected-interfaces', $selected_interfaces );

		foreach ( (array)$selected_interfaces as $interface_name ) {
			$interface = $this->_get_interface( $interface_name );
			if ( !empty( $interface ) )
				$this->interfaces[] = $interface;

		}
	}

	/**
	 * @param $interface_name
	 *
	 * @return mixed|null|WPChromePHP|WPFirePHP
	 */
	private function _get_interface( $interface_name ) {

		switch ( $interface_name ) {

			case 'FirePHP':
				include $this->path . 'browsers/WPFirePHP.class.php';
				$interface = new WPFirePHP();
				break;

			case 'ChromePHP':
				include $this->path . 'browsers/WPChromePHP.class.php';
				$interface = new WPChromePHP();
				break;

			default:
				$interface = apply_filters( 'wplinb-get-interface', null, $interface_name );

				if ( $interface && !in_array( 'iBrowser', class_implements( $interface ) ) )
					$interface = null;

				break;
		}

		return $interface;
	}

	/**
	 * @static
	 * @return Browser
	 *
	 * Return an instance of this class. Singleton.
	 */
	public static function instance() {
		if ( !isset( self::$instance ) ) {
			$className      = __CLASS__;
			self::$instance = new $className;
		}
		return self::$instance;
	}
}

if ( !function_exists( 'browser' ) ) {
	/**
	 * Returns a browser instance.
	 *
	 * @return Browser
	 */
	function browser() {
		return Browser::instance();
	}
}
