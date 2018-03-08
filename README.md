# WP-Post-Meta-Transients
WordPress post meta transient cache implementation.

It's a small library which can be used as a [MU-Plugin](https://codex.wordpress.org/Must_Use_Plugins) or as a third-party asset in your plugin or theme.

This code provides API similar to [WordPress Transients](https://codex.wordpress.org/Transients_API). The main difference is that it provides you ability to store cache data associated with posts.
Unlike the default Transients API, the WP Post Meta Transients stores the data in `wp_postmeta` database table rather than `wp_options` table.

## Function Reference

### Saving Transients
To save a post transient you use pm_set_transient() :

`pm_set_transient( $post_id, $key, $data, $expiration );`

**$post_id**

(int) (required) Post ID.

**$key**

(string) (required) Transient name.

**$data**

(string|array|object) (required) Data to save, either a regular variable or an array/object. The API will handle serialization of complex data for you.

**$expiration**

(int) (required) The maximum of seconds to keep the data before refreshing.

### Fetching Transients
To get a saved post transient you use pm_get_transient() :

`pm_get_transient( $post_id, $key );`

**$post_id**

(int) (required) Post ID.

**$key**

(string) (required) Transient name.

### Deleting Transients
To delete a post transient you use pm_delete_transient() :

`pm_delete_transient( $post_id, $key )`

**$post_id**

(int) (required) Post ID.

**$key**

(string) (required) Transient name.

## Complete Example
Putting it all together here is an example of how to use posts transients in your code.

```php
$post_id   = get_the_ID();
$some_data = pm_get_transient( $post_id, 'saved_data' );

if ( empty( $some_data ) ) {
	$some_data = get_posts( array( 'post_type' => 'article' ) ); // any expensive query

	if ( $some_data ) {
		pm_set_transient( $post_id, 'saved_data', $some_data, DAY_IN_SECONDS );
	}
}
```
