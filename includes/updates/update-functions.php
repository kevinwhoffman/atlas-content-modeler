<?php
/**
 * Plugin updates related functions.
 *
 * @package AtlasContentModeler
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Retrieve and convert custom endpoint response for the WordPress plugin api.
 *
 * Retrieve data from a custom endpoint then create a custom object that can be used by WordPress.
 *
 * @param object $args Plugin API arguments.
 *
 * @return false|stdClass $api Plugin API arguments.
 */
function atlas_content_modeler_get_plugin_data( object $args ) {
	$product_info = atlas_content_modeler_get_remote_plugin_info();
	if ( empty( $product_info ) || is_wp_error( $product_info ) ) {
		return;
	}

	$current_plugin_data = get_plugin_data( ATLAS_CONTENT_MODELER_FILE );
	$meets_wp_req        = version_compare( get_bloginfo( 'version' ), $product_info->requires_at_least, '>=' );

	$api                        = new stdClass();
	$api->author                = 'WP Engine';
	$api->homepage              = 'https://wpengine.com';
	$api->name                  = $product_info->name;
	$api->requires              = isset( $product_info->requires_at_least ) ? $product_info->requires_at_least : $current_plugin_data['RequiresWP'];
	$api->sections['changelog'] = isset( $product_info->sections->changelog ) ? $product_info->sections->changelog : '<h4>1.0</h4><ul><li>Initial release.</li></ul>';
	$api->slug                  = $args->slug;

	// Only pass along the update info if the requirements are met and there's actually a newer version.
	if ( $meets_wp_req && version_compare( $current_plugin_data['Version'], $product_info->version, '<' ) ) {
		$api->version       = $product_info->version;
		$api->download_link = $product_info->download_link;
	}

	return $api;
}

/**
 * Fetches and returns the plugin info api error.
 *
 * @return mixed|false The plugin api error or false.
 */
function atlas_content_modeler_get_plugin_api_error() {
	return get_option( 'atlas_content_modeler_product_info_api_error', false );
}

/**
 * Retrieve remote plugin information from the custom endpoint.
 *
 * @return stdClass
 */
function atlas_content_modeler_get_remote_plugin_info() {
	$current_plugin_data = get_plugin_data( ATLAS_CONTENT_MODELER_FILE );
	$response            = get_transient( 'atlas_content_modeler_product_info' );

	if ( false === $response ) {
		$request_args = array(
			'timeout'    => ( ( defined( 'DOING_CRON' ) && DOING_CRON ) ? 30 : 3 ),
			'user-agent' => 'WordPress/' . get_bloginfo( 'version' ) . '; ' . get_bloginfo( 'url' ),
			'body'       => array(
				'version' => $current_plugin_data['Version'],
			),
		);

		$response = atlas_content_modeler_request_plugin_updates( $request_args );
		if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
			if ( is_wp_error( $response ) ) {
				update_option( 'atlas_content_modeler_product_info_api_error', $response->get_error_code(), false );
			} else {
				$response_body = json_decode( wp_remote_retrieve_body( $response ), false );
				$error_code    = ! empty( $response_body->error_code ) ? $response_body->error_code : 'unknown';
				update_option( 'atlas_content_modeler_product_info_api_error', $error_code, false );
			}

			$response = new stdClass();

			set_transient( 'atlas_content_modeler_product_info', $response, MINUTE_IN_SECONDS * 5 );

			return $response;
		}

		delete_option( 'atlas_content_modeler_product_info_api_error' );

		$response = json_decode(
			wp_remote_retrieve_body( $response )
		);

		if ( ! property_exists( $response, 'icons' ) || empty( $response->icons['default'] ) ) {
			$response->icons['default'] = ATLAS_CONTENT_MODELER_URL . 'includes/settings/img/Atlas.svg';
		}

		set_transient( 'atlas_content_modeler_product_info', $response, HOUR_IN_SECONDS * 12 );
	}

	return $response;
}

/**
 * Get the remote plugin api error message.
 *
 * @param string $reason The reason/error code received the API.
 *
 * @return string The error message.
 */
function atlas_content_modeler_get_api_error_text( $reason ) {
	switch ( $reason ) {
		case 'key-unknown':
			return __( 'The product you requested information for is unknown. Please contact support.', 'atlas-content-modeler' );

		default:
			/* translators: %1$s: Link to account portal. %2$s: The text that is linked. */
			return sprintf(
				__(
					'Atlas Content Modeler encountered an unknown error connecting to the update service. This issue could be temporary. Please contact support if this error persists.',
					'atlas-content-modeler'
				),
				'https://my.wpengine.com/products',
				esc_html__( 'WP Engine Account Portal', 'atlas-content-modeler' )
			);
	}
}

/**
 * Retrieve plugin update information via http GET request.
 *
 * @uses wp_remote_get()
 * @link https://developer.wordpress.org/reference/functions/wp_remote_get/
 *
 * @param array $args Array of request args.
 *
 * @return array|WP_Error A response as an array or WP_Error.
 */
function atlas_content_modeler_request_plugin_updates( $args ) {
	return wp_remote_get(
		'https://wp-product-info.wpesvc.net/v1/plugins/atlas-content-modeler',
		$args
	);
}
