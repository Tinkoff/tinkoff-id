<?php

use TinkoffAuth\View\WordPress\Settings\CheckboxInput;
use TinkoffAuth\View\WordPress\Settings\OptionSelect;
use TinkoffAuth\View\WordPress\Settings\SettingInput;

function tinkoff_auth_credentials_settings_init() {
	// Register Settings
	register_setting( 'tinkoff_auth', 'tinkoff_auth_client_id', [ 'type' => 'string' ] );
	register_setting( 'tinkoff_auth', 'tinkoff_auth_client_secret', [ 'type' => 'string' ] );

	register_setting(
		'tinkoff_auth',
		'tinkoff_auth_button_hook',
		[ 'type' => 'string', 'default' => 'woocommerce_login_form_end' ]
	);

	register_setting(
		'tinkoff_auth',
		'tinkoff_auth_button_hook_checkout',
		[ 'type' => 'string' ]
	);

	register_setting( 'tinkoff_auth', 'tinkoff_auth_button_size', [ 'type' => 'string' ] );

	register_setting( 'tinkoff_auth', 'tinkoff_auth_button_color', [ 'type' => 'string' ] );

	register_setting( 'tinkoff_auth', 'tinkoff_auth_button_lang', [ 'type' => 'string' ] );

	register_setting( 'tinkoff_auth', 'tinkoff_auth_compatibility_iiko', [ 'type' => 'boolean' ] );

	// Create Sections
	add_settings_section(
		'tinkoff_auth_section_credentials',
		'Данные для авторизации в API Тинькофф ID',
		'tinkoff_auth_section_credentials_callback',
		'tinkoff-auth-settings-page'
	);

	add_settings_section(
		'tinkoff_auth_section_visual',
		'Настройки кнопки',
		'tinkoff_auth_section_visual_callback',
		'tinkoff-auth-settings-page'
	);

	add_settings_section(
		'tinkoff_auth_section_compatibility',
		'Совместимость с плагинами',
		'tinkoff_auth_section_compatibility_callback',
		'tinkoff-auth-settings-page'
	);

	// Crate fields
	add_settings_field(
		'tinkoff_auth_client_id',
		'client_id',
		'tinkoff_auth_client_id_callback',
		'tinkoff-auth-settings-page',
		'tinkoff_auth_section_credentials'
	);
	add_settings_field(
		'tinkoff_auth_client_secret',
		'client_secret',
		'tinkoff_auth_client_secret_callback',
		'tinkoff-auth-settings-page',
		'tinkoff_auth_section_credentials'
	);

	add_settings_field(
		'tinkoff_auth_button_hook',
		'Расположение на странице авторизации',
		'tinkoff_auth_button_hook_callback',
		'tinkoff-auth-settings-page',
		'tinkoff_auth_section_visual'
	);

	add_settings_field(
		'tinkoff_auth_button_hook_checkout',
		'Расположение на странице оформления заказа',
		'tinkoff_auth_button_hook_checkout_callback',
		'tinkoff-auth-settings-page',
		'tinkoff_auth_section_visual'
	);

	add_settings_field(
		'tinkoff_auth_button_size',
		'Размер кнопки',
		'tinkoff_auth_button_size_callback',
		'tinkoff-auth-settings-page',
		'tinkoff_auth_section_visual'
	);
	add_settings_field(
		'tinkoff_auth_button_color',
		'Цвет кнопки',
		'tinkoff_auth_button_color_callback',
		'tinkoff-auth-settings-page',
		'tinkoff_auth_section_visual'
	);
	add_settings_field(
		'tinkoff_auth_button_lang',
		'Язык кнопки',
		'tinkoff_auth_button_lang_callback',
		'tinkoff-auth-settings-page',
		'tinkoff_auth_section_visual'
	);

	add_settings_field(
		'tinkoff_auth_compatibility_iiko',
		'Добавление мета полей iiko',
		'tinkoff_auth_compatibility_iiko_callback',
		'tinkoff-auth-settings-page',
		'tinkoff_auth_section_compatibility'
	);
}

function tinkoff_auth_section_credentials_callback( $args ) {
	$link = '<a href="https://business.tinkoff.ru/openapi/docs#section/Partnerskij-scenarij/Registraciya">тут</a>';
	echo "<p>Данные для авторизации можно получить, следуя инструкции {$link}</p>";
}

function tinkoff_auth_section_visual_callback() {
	echo '<p>Можете выбрать расположение кнопки в шаблоне, либо самостоятельно использовать шордкод "[tinkoff-button]"</p>';
}

function tinkoff_auth_section_compatibility_callback() {
	echo '<p>При необходимости, вы можете включить совместимость с некоторыми сторонними плагинами</p>';
}

function tinkoff_auth_client_id_callback( $args ) {
	echo ( new SettingInput( 'tinkoff_auth_client_id' ) )->render();
}

function tinkoff_auth_client_secret_callback( $args ) {
	echo ( new SettingInput( 'tinkoff_auth_client_secret' ) )->render();
}

function tinkoff_auth_button_hook_callback() {
	echo ( new OptionSelect( 'tinkoff_auth_button_hook', OptionSelect::SELECT_HOOK_VALUES ) )->render();
}

function tinkoff_auth_button_hook_checkout_callback() {
	echo ( new OptionSelect(
		'tinkoff_auth_button_hook_checkout',
		OptionSelect::SELECT_HOOK_CHECKOUT_VALUES
	) )->render();
}

function tinkoff_auth_button_size_callback() {
	echo ( new OptionSelect( 'tinkoff_auth_button_size', OptionSelect::sizes() ) )->render();
}

function tinkoff_auth_button_color_callback() {
	echo ( new OptionSelect( 'tinkoff_auth_button_color', OptionSelect::colors() ) )->render();
}

function tinkoff_auth_button_lang_callback() {
	echo ( new OptionSelect( 'tinkoff_auth_button_lang', OptionSelect::languages() ) )->render();
}

function tinkoff_auth_compatibility_iiko_callback() {
	echo ( new CheckboxInput( 'tinkoff_auth_compatibility_iiko' ) )->render();
}

function tinkoff_auth_settings_init() {
	tinkoff_auth_credentials_settings_init();
}

add_action( 'admin_init', 'tinkoff_auth_settings_init' );

function tinkoff_auth_settings_subpage() {
	add_submenu_page(
		'options-general.php',
		'Настройки Tinkoff',
		'Тинькофф ID',
		'administrator',
		'tinkoff-auth-settings-page',
		'tinkoff_auth_show_settings_page',
		''
	);
}

add_action( 'admin_menu', 'tinkoff_auth_settings_subpage' );

function tinkoff_auth_show_settings_page() {
	require_once __DIR__ . '/resources/view/settings.php';
}