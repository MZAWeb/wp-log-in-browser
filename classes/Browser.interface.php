<?php
interface iBrowser {

	public function log( $var, $label = null );

	public function info( $var, $label = null );

	public function warn( $var, $label = null );

	public function error( $var, $label = null );
}