<?php

// Загрузка всех расширений
tinkoff_auth_ext_loader_init();

if ( count( tinkoff_auth_ext_get_filenames() ) > 0 ) {
	add_action( 'admin_init', 'tinkoff_auth_ext_add_section', 20 );
}

// Новый раздел настроек
function tinkoff_auth_ext_add_section() {
	add_settings_section(
		'tinkoff_auth_section_extensions',
		'Расширения',
		'tinkoff_auth_ext_loader_section_callback',
		'tinkoff-auth-settings-page'
	);
}

function tinkoff_auth_ext_loader_section_callback() {
	$extensions = implode( ', ', tinkoff_auth_ext_get_filenames() );
	echo "<hr>";
	echo "<p>Загруженные расширения: $extensions</p>";
}

// Загрузка расширений
function tinkoff_auth_ext_loader_init() {
	foreach ( tinkoff_auth_ext_get_filenames() as $ext ) {
		require_once __DIR__ . '/' . $ext;
	}
}

function tinkoff_auth_ext_get_filenames() {
	$ext = scandir( __DIR__ );

	$exceptions = [ '.gitkeep', 'autoload.php' ];
	$extensions = [];
	for ( $i = 2; $i < count( $ext ); $i ++ ) {
		$filename = $ext[ $i ];
		if ( in_array( $filename, $exceptions ) ) {
			continue;
		}

		if ( is_dir( __DIR__ . '/' . $filename ) ) {
			$filename = $filename . '/' . $filename . '.php';
		}


		$path = __DIR__ . '/' . $filename;
		if ( ! file_exists( $path ) || is_dir( $path ) ) {
			continue;
		}

		$extensions[] = $filename;
	}

	return $extensions;
}