<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'lepc' );

/** Database username */
define( 'DB_USER', 'lepc' );

/** Database password */
define( 'DB_PASSWORD', 'lepc' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '2DxJ;7cK7>%:~h!F-{TKO8cozQmBR<d=Mi~au2xocG:k0=VKm{wz,O~_+HO^%lDi' );
define( 'SECURE_AUTH_KEY',  'Tg 9);VlXL[{Y/N&YmHn3HOh~BUiWMOo%>&(H1orkRZwqpSI}HG-r3UP^:ea{(m|' );
define( 'LOGGED_IN_KEY',    ' }MZ~aij]cOvPvS LOL#x_@5_gkBc#4m.$?/az+iPen0iu~ne-l_*DL {F[ ]92>' );
define( 'NONCE_KEY',        'Mfv]Yi?&kD5qQ{W7<;oDC<ImSVgV_ ;Jb_)c_FQ.Bw!|5Vb1C~cH:O*xWvT}ovsB' );
define( 'AUTH_SALT',        'm2E<F#8@D{uTHH{HI5Z`,]pVS0uYABI{/8Eqc`;,,R5[g:v~rV<nu${mQp#H!,Ne' );
define( 'SECURE_AUTH_SALT', 'zB h{5|`s>C+AG{s$C;E^g_OYFebdxeJx0edPijKkj|*k<Lk{!yX,kiZAZnNpN-;' );
define( 'LOGGED_IN_SALT',   '3%W5G]t3n}7]w0PwI:?2Zo|{p]QG(;EFp8GK{za;aI2,%$3!k: EMWm$+FD&)bcU' );
define( 'NONCE_SALT',       '3/$C9wlXyXcuDQ6j:Y4Qe3u=ngBcoRkdb(g:x(I;Q)/)[(7oUGQWj7j8 #Gg:TSA' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
