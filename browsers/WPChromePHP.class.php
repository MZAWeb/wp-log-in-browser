<?php
class WPChromePHP implements iBrowser {

	public function __construct() {
		include 'api/chromephp/ChromePhp.php';
		$this->api = ChromePhp::getInstance();
	}


	public function log( $var, $label = null ) {
		$this->api->log( $label, $var );
	}

	public function info( $var, $label = null ) {
		$this->api->info( $label, $var );
	}

	public function warn( $var, $label = null ) {
		$this->api->warn( $label, $var );
	}

	public function error( $var, $label = null ) {
		$this->api->error( $label, $var );
	}
}
