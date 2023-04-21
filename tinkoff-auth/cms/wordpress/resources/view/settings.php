<div class="wrap">
    <h1>Настройки авторизации через Тинькофф ID</h1>

    <form method="post" action="options.php" novalidate="novalidate">
		<?php
		settings_fields( 'tinkoff_auth' );
		do_settings_sections( 'tinkoff-auth-settings-page' );
		submit_button();
		?>
    </form>

</div>