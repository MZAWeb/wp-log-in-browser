<?php

if ( class_exists( "Browser" ) )
	return;

class Browser {

	private static $instance;
	private $interfaces = array();
	private $path;

	public function __construct() {
		$this->path = trailingslashit( dirname( dirname( __FILE__ ) ) );
		$this->_get_interfaces();
	}

	private function _get_interfaces() {
		// This will come from the admin config
		$selected_interfaces = array( 'FirePHP', 'ChromePHP' );

		$selected_interfaces = apply_filters( 'wpdib-selected-interfaces', $selected_interfaces );

		foreach ( (array)$selected_interfaces as $interface_name ) {
			$interface = $this->_get_interface( $interface_name );
			if ( !empty( $interface ) )
				$this->interfaces[] = $interface;

		}
	}

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
				$interface = apply_filters( 'wpdib-get-interface', null, $interface_name );

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
	function browser() {
		return Browser::instance();
	}
}
