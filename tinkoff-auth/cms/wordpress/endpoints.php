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

	// Формирование почты, имени пользователя и пароля
	$email    = isset( $userinfo['email'] ) && $userinfo['email'] ? $userinfo['email'] : null;
	$username = str_replace( [ '+', ' ', '-' ], '', $userinfo['phone_number'] );
	$username = $username ?: null;
	$password = md5( time() . rand( 0, 100 ) . rand( 0, 200 ) );

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

	// Профиль WP
	tinkoff_auth_helper_add_user_meta( $user_id, 'is_tinkoff', true );
	tinkoff_auth_helper_add_user_meta(
		$user_id,
		'first_name',
		tinkoff_auth_helper_get_user_info_safely( $userinfo, 'given_name' )
	);
	tinkoff_auth_helper_add_user_meta(
		$user_id,
		'last_name',
		tinkoff_auth_helper_get_user_info_safely( $userinfo, 'family_name' )
	);

	// Плагин iiko
	if ( get_option( 'tinkoff_auth_compatibility_iiko' ) ) {
		tinkoff_auth_helper_add_user_meta(
			$user_id,
			'iiko_email',
			tinkoff_auth_helper_get_user_info_safely( $userinfo, 'email' )
		);
		tinkoff_auth_helper_add_user_meta(
			$user_id,
			'iiko_name',
			tinkoff_auth_helper_get_user_info_safely( $userinfo, 'given_name' )
		);
		tinkoff_auth_helper_add_user_meta(
			$user_id,
			'iiko_middleName',
			tinkoff_auth_helper_get_user_info_safely( $userinfo, 'middle_name' )
		);
		tinkoff_auth_helper_add_user_meta(
			$user_id,
			'iiko_middleName',
			tinkoff_auth_helper_get_user_info_safely( $userinfo, 'middle_name' )
		);
		tinkoff_auth_helper_add_user_meta(
			$user_id,
			'iiko_surName',
			tinkoff_auth_helper_get_user_info_safely( $userinfo, 'family_name' )
		);
		tinkoff_auth_helper_add_user_meta( $user_id, 'iiko_phone', $username );
	}

	// Билинг
	tinkoff_auth_helper_add_user_meta(
		$user_id,
		'billing_first_name',
		tinkoff_auth_helper_get_user_info_safely( $userinfo, 'given_name' )
	);
	tinkoff_auth_helper_add_user_meta( $user_id, 'billing_phone', $username );

	// Дополнительные данные от Тинькофф
	tinkoff_auth_helper_add_user_meta( $user_id, 'tinkof_auth_passport', $passport, true );
	tinkoff_auth_helper_add_user_meta( $user_id, 'tinkof_auth_drive_licenses', $driveLicenses, true );
	tinkoff_auth_helper_add_user_meta( $user_id, 'tinkof_auth_inn', $inn, true );
	tinkoff_auth_helper_add_user_meta( $user_id, 'tinkof_auth_snils', $snils, true );
	tinkoff_auth_helper_add_user_meta( $user_id, 'tinkof_auth_is_identified', $isIdentified, true );
	tinkoff_auth_helper_add_user_meta( $user_id, 'tinkof_auth_is_self_employed', $isSelfEmployed, true );
	tinkoff_auth_helper_add_user_meta( $user_id, 'tinkof_auth_addresses', $addresses, true );
	tinkoff_auth_helper_add_user_meta( $user_id, 'tinkof_auth_debitCards', $debitCards, true );
	tinkoff_auth_helper_add_user_meta( $user_id, 'tinkof_auth_subscription', $subscription, true );
	tinkoff_auth_helper_add_user_meta( $user_id, 'tinkof_auth_cobrand', $cobrand, true );

	// Авторизация
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

	return $account_location . '?' . http_build_query( [ 'status' => $status, 'message' => $message ] );
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

function tinkoff_auth_helper_add_user_meta( $user_id, $field, $value, $forced = false ) {
	if ( ! $forced && ! $value ) {
		return false;
	}

	update_user_meta( $user_id, $field, $value );

	return true;
}

function tinkoff_auth_helper_get_user_info_safely( $userinfo, $index, $default = '' ) {
	return isset( $userinfo[ $index ] ) && $userinfo[ $index ] ? $userinfo[ $index ] : $default;
}