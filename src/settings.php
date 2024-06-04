<?php
/**
 * Registers the provided Google API key in Advanced Custom Fields settings.
 *
 * @return void
 */
function ct_registerin_google_api_key() {

	acf_update_setting('google_api_key', 'AIzaSyCKGSShkh-DEczrl6Q58BMR_DOqUSs92P0');
}

add_action('acf/init', 'ct_registerin_google_api_key');
