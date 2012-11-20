<?php
interface iBrowser {
	public function log( $var );
	public function info( $var );
	public function warn( $var );
	public function error( $var );
}