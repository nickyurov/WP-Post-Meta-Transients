<?php
/**
 * Plugin Name: Post Meta Transients
 * Plugin URI: https://github.com/nickyurov/WP-Post-Meta-Transients
 * Version: 1.0
 * Author: Nick Yurov
 * Author URI: https://nickyurov.com/
 */

/**
 * Retrieve post meta transient
 *
 * @param $post_id
 * @param $key
 *
 * @return bool|mixed
 */
function pm_get_transient( $post_id, $key ) {
	$pm_key = '_transient_' . $key;
	$value  = get_post_meta( $post_id, $pm_key, true );

	if ( $value ) {
		if ( $value['expiration'] < time() ) {
			pm_delete_transient( $post_id, $key );

			return false;
		}

		return $value['data'];
	}

	return false;
}

/**
 * Set post meta transient
 *
 * @param $post_id
 * @param $key
 * @param $data
 * @param $expiration
 *
 * @return false|int
 */
function pm_set_transient( $post_id, $key, $data, $expiration ) {
	$pm_key = '_transient_' . $key;

	pm_delete_transient( $post_id, $key );

	$value = array(
		'expiration' => time() + $expiration,
		'data'       => $data,
	);

	$result = add_post_meta( $post_id, $pm_key, $value, true );

	return $result;
}

/**
 * Delete post meta transient
 *
 * @param $post_id
 * @param $key
 *
 * @return bool
 */
function pm_delete_transient( $post_id, $key ) {
	$pm_key = '_transient_' . $key;
	$result = delete_post_meta( $post_id, $pm_key );

	return $result;
}