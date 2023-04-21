<?php

use TinkoffAuth\Config\Auth;
use TinkoffAuth\View\WordPress\ButtonLoader;

require_once __DIR__ . '/spl.php';
require_once __DIR__ . '/wordpress/settings.php';

$authConfig = Auth::getInstance();
$authConfig->push( Auth::CLIENT_ID, get_option( 'tinkoff_auth_client_id' ) );
$authConfig->push( Auth::CLIENT_SECRET, get_option( 'tinkoff_auth_client_secret' ) );
$authConfig->push( Auth::REDIRECT_URI, get_site_url() . '/wp-json/tinkoff_auth/v1/callback' );

add_shortcode( 'tinkoff-button', 'tinkoff_auth_show_button_shortcode' );
function tinkoff_auth_show_button_shortcode() {
	return ( new ButtonLoader() )->render();
}

$button_hook = get_option( 'tinkoff_auth_button_hook' );
add_action( $button_hook, function () {
	echo do_shortcode( '[tinkoff-button]' );
} );


$button_hook = get_option( 'tinkoff_auth_button_hook_checkout' );
add_action( $button_hook, function () {
	if ( get_current_user_id() === 0 ) {
		echo do_shortcode( '[tinkoff-button]' );
	}
} );

require_once __DIR__ . '/wordpress/endpoints.php';
