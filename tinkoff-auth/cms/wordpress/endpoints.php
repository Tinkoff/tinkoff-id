<?php

use TinkoffAuth\Config\Api;
use TinkoffAuth\Config\Auth;
use TinkoffAuth\Facades\Tinkoff;
use TinkoffAuth\View\AuthButton\AuthButton;

add_action( 'rest_api_init', function () {
	register_rest_route( 'tinkoff_auth/v1', '/callback', [
		'methods'  => 'GET',
		'callback' => 'tinkoff_auth_auth_callback',
	] );
	register_rest_route( 'tinkoff_auth/v1', '/button', [
		'methods'  => 'GET',
		'callback' => 'tinkoff_auth_button_callback',
	] );
} );
function tinkoff_auth_button_callback( WP_REST_Request $request ) {
	$auth_config = Auth::getInstance();

	$tinkoff = new Tinkoff();
	$link    = $tinkoff->getAuthURL( $auth_config->get( Auth::REDIRECT_URI ) );

	$buttonSize  = get_option( 'tinkoff_auth_button_size' ) ? get_option( 'tinkoff_auth_button_size' ) : '';
	$buttonColor = get_option( 'tinkoff_auth_button_color' ) ? get_option( 'tinkoff_auth_button_color' ) : '';
	$lang        = get_option( 'tinkoff_auth_button_lang' ) ? get_option( 'tinkoff_auth_button_lang' ) : '';

	return [ 'button' => ( new AuthButton( $link, $buttonSize, $buttonColor, $lang ) )->render() ];
}

function tinkoff_auth_auth_callback( WP_REST_Request $request ) {
	// Получение данных пользователя
	$tinkoff  = new Tinkoff();
	$mediator = $tinkoff->auth();
	if ( ! $mediator->getStatus() ) {
		return tinkoff_auth_helper_build_response( false, 'Ошибка авторизации' );
//		return tinkoff_auth_helper_build_response( false, $mediator->getMessage() );
	}

	$credentials = $mediator->getPayload();

	// Основная информация о пользователе
	$userinfo = $credentials[ Api::SCOPES_USERINFO ];

	// Паспорт пользователя
	$passportShort = $credentials[ Api::SCOPES_PASSPORT_SHORT ];
	$passportFull  = $credentials[ Api::SCOPES_PASSPORT ];
	$passport      = array_merge( $passportShort, $passportFull );

	// Водительские права
	$driveLicenses = $credentials[ Api::SCOPES_DRIVER_LICENSES ];

	// ИНН и Снилс
	$inn   = $credentials[ Api::SCOPES_INN ];
	$snils = $credentials[ Api::SCOPES_SNILS ];

	//Информации об идентификации и самозанятости
	$isIdentified   = $credentials[ Api::SCOPES_IDENTIFICATION ];
	$isSelfEmployed = $credentials[ Api::SCOPES_SELF_EMPLOYED_STATUS ];

	// Адреса
	$addresses = $credentials[ Api::SCOPES_ADDRESSES ];

	// Дебетовые карты, подписка и собренд
	$debitCards   = $credentials[ Api::SCOPES_DEBIT_CARDS ];
	$subscription = $credentials[ Api::SCOPES_SUBSCRIPTION ];
	$cobrand      = $credentials[ Api::SCOPES_COBRAND_STATUS ];

	// Публичное должностное лицо, ин агент и есть ли в черных списках
	$official_person  = $credentials[ Api::SCOPES_PUBLIC_OFFICIAL_PERSON ];
	$foreign_agent    = $credentials[ Api::SCOPES_FOREIGN_AGENT ];
	$blacklist_status = $credentials[ Api::SCOPES_BLACKLIST_STATUS ];

	// Формирование почты, имени пользователя и пароля
	$email    = isset( $userinfo['email'] ) && $userinfo['email'] ? $userinfo['email'] : null;
	$phone    = $userinfo['phone_number'];
	$username = str_replace( [ '+', ' ', '-' ], '', $phone );
	$username = $username ?: null;
	$password = md5( time() . rand( 0, 100 ) . rand( 0, 200 ) );

	$domain = $_SERVER['HTTP_HOST'];
	$email  = $email ?: $username . '@' . $domain;

	if ( ! $email || ! $username ) {
		return tinkoff_auth_helper_build_response( false, 'Предоставленных данных недостаточно' );
	}

	// Создание пользователя
	$user = get_user_by( 'email', $email );
	if ( $user !== false ) {
//		$is_tinkoff_user = $user->get( 'is_tinkoff' );
//		if ( ! $is_tinkoff_user ) {
//			return tinkoff_auth_helper_build_response( false, 'Пользователь с такой почтой уже существует' );
//		}

		$user_id = $user->get( 'id' );
	} else {
		$user_id = null;
		if ( function_exists( 'wc_create_new_customer' ) ) {
			$user_id = wc_create_new_customer( $email, $username, $password );
		}

		if ( is_null( $user_id ) ) {
			$user_id = wp_create_user( $username, $password, $email );
		}

		if ( ! $user_id || is_wp_error( $user_id ) ) {
			$message = $user_id->get_error_message()
				? $user_id->get_error_message()
				: 'Ошибка при создании пользователя';

			return tinkoff_auth_helper_build_response( false, $message );
		}
	}

	if ( user_can( $user_id, 'manage_options' )
	     || user_can( $user_id, 'shop_manager' )
	     || user_can( $user_id, 'administrator' ) ) {
		return tinkoff_auth_helper_build_response( false );
	}

	if ( tid_user_fields_getter( $userinfo, 'given_name' ) ) {
		$user_id = wp_update_user( [
			'ID'       => $user_id,
			'user_url' => tid_user_fields_getter( $userinfo, 'given_name' )
		] );
	}

	if ( tid_user_fields_getter( $userinfo, 'given_name' ) ) {
		$user_id = wp_update_user( [
			'ID'         => $user_id,
			'first_name' => tid_user_fields_getter( $userinfo, 'given_name' ),
			'last_name'  => tid_user_fields_getter( $userinfo, 'family_name' )
		] );
	}

	// Профиль WP
	tid_add_user_meta( $user_id, 'is_tinkoff', true );
	tid_add_user_meta( $user_id, 'first_name', tid_user_fields_getter( $userinfo, 'given_name' ) );
	tid_add_user_meta( $user_id, 'shipping_first_name', tid_user_fields_getter( $userinfo, 'given_name' ) );
	tid_add_user_meta( $user_id, 'last_name', tid_user_fields_getter( $userinfo, 'family_name' ) );
	tid_add_user_meta( $user_id, 'shipping_last_name', tid_user_fields_getter( $userinfo, 'family_name' ) );

	// Плагин iiko
	if ( get_option( 'tinkoff_auth_compatibility_iiko' ) ) {
		tid_add_user_meta( $user_id, 'iiko_email', tid_user_fields_getter( $userinfo, 'email' ) );
		tid_add_user_meta( $user_id, 'iiko_name', tid_user_fields_getter( $userinfo, 'given_name' ) );
		tid_add_user_meta( $user_id, 'iiko_middleName', tid_user_fields_getter( $userinfo, 'middle_name' ) );
		tid_add_user_meta( $user_id, 'iiko_middleName', tid_user_fields_getter( $userinfo, 'middle_name' ) );
		tid_add_user_meta( $user_id, 'iiko_surName', tid_user_fields_getter( $userinfo, 'family_name' ) );
		tid_add_user_meta( $user_id, 'iiko_phone', $username );
	}

	// Билинг
	tid_add_user_meta( $user_id, 'billing_first_name', tid_user_fields_getter( $userinfo, 'given_name' ) );
	tid_add_user_meta( $user_id, 'billing_last_name', tid_user_fields_getter( $userinfo, 'family_name' ) );
	tid_add_user_meta( $user_id, 'billing_phone', $username );
	tid_add_user_meta( $user_id, 'shipping_phone', $username );


	// Дополнительные данные от Тинькофф
	tid_add_user_meta( $user_id, 'tinkoff_auth_passport', $passport, true );
	tid_add_user_meta( $user_id, 'tinkoff_auth_drive_licenses', $driveLicenses, true );
	tid_add_user_meta( $user_id, 'tinkoff_auth_inn', $inn, true );
	tid_add_user_meta( $user_id, 'tinkoff_auth_snils', $snils, true );
	tid_add_user_meta( $user_id, 'tinkoff_auth_is_identified', $isIdentified, true );
	tid_add_user_meta( $user_id, 'tinkoff_auth_is_self_employed', $isSelfEmployed, true );
	tid_add_user_meta( $user_id, 'tinkoff_auth_addresses', $addresses, true );
	tid_add_user_meta( $user_id, 'tinkoff_auth_debitCards', $debitCards, true );
	tid_add_user_meta( $user_id, 'tinkoff_auth_subscription', $subscription, true );
	tid_add_user_meta( $user_id, 'tinkoff_auth_cobrand', $cobrand, true );

	tid_add_user_meta( $user_id, 'tinkoff_auth_official_person', $official_person, true );
	tid_add_user_meta( $user_id, 'tinkoff_auth_foreign_agent', $foreign_agent, true );
	tid_add_user_meta( $user_id, 'tinkoff_auth_blacklist_status', $blacklist_status, true );

	$customer = new WC_Customer( $user_id );
	if ( ! is_wp_error( $customer ) ) {
		$customer->set_billing_email( $email );
		$customer->set_billing_first_name( tid_user_fields_getter( $userinfo, 'given_name' ) );
		$customer->set_billing_first_name( tid_user_fields_getter( $userinfo, 'family_name' ) );
		$customer->set_billing_phone( $username );
		$customer->set_shipping_first_name( tid_user_fields_getter( $userinfo, 'given_name' ) );
		$customer->set_shipping_last_name( tid_user_fields_getter( $userinfo, 'family_name' ) );
	}

	wp_set_auth_cookie( $user_id );

	return tinkoff_auth_helper_build_response( true );
}

/**
 * Формирование Redirect URL
 *
 * @param $status
 * @param $message
 *
 * @return string
 */
function tinkoff_auth_helper_format_redirect_url( $status = true, $message = '' ) {
	$account_location = get_permalink( get_option( 'woocommerce_myaccount_page_id' ) );

	$url = $account_location . '?' . http_build_query( [ 'status' => $status, 'message' => $message ] );

	return apply_filters( 'tid_wp_redirect_url', $url, $status, $message );
}

/**
 * Форомирование ответа
 *
 * @param $status
 * @param $message
 *
 * @return WP_REST_Response
 */
function tinkoff_auth_helper_build_response( $status = true, $message = '' ) {
	$response = new WP_REST_Response();
	$response->set_status( 307 );

	$response->header( 'Location', tinkoff_auth_helper_format_redirect_url( $status, $message ) );

	return $response;
}

function tid_add_user_meta( $user_id, $field, $value, $forced = false ) {
	if ( ! $forced && ! $value ) {
		return false;
	}

	update_user_meta( $user_id, $field, $value );

	return true;
}

function tid_user_fields_getter( $array, $index, $default = '' ) {
	return isset( $array[ $index ] ) && $array[ $index ] ? $array[ $index ] : $default;
}