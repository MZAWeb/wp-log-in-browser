<?php
class WPFirePHP implements iBrowser {

	private $api;

	public function __construct() {
		include 'api/firephp/lib/FirePHPCore/FirePHP.class.php';
		$this->api = FirePHP::getInstance( true );
	}

	public function log( $var, $label = null ) {
		$this->api->log( $var, $label );
	}

	public function info( $var, $label = null ) {
		$this->api->info( $var, $label );
	}

	public function warn( $var, $label = null ) {
		$this->api->warn( $var, $label );
	}

	public function error( $var, $label = null ) {
		$this->api->error( $var, $label );
	}


}
