<?php
define( 'WP_MEMORY_LIMIT', '256M' );
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'esthima-com_local' );

/** Database username */
define( 'DB_USER', 'esthima-9c2673' );

/** Database password */
define( 'DB_PASSWORD', 'cJAFAxsLZ7GdV4Le' );

/** Database hostname */
define( 'DB_HOST', '127.0.0.1' );

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
define('AUTH_KEY',         ':K0Q!SyV~<[RU84Ps=SN8hEr_:7[&zrK+ZwXtoZW}UgX0tQv7t/gfx^::KAuKjmk');
define('SECURE_AUTH_KEY',  'rnMIH|~o)n_enW)P-TeGWVXZ[c)zZk]-mmBzNwU;}W//,$6o/KMP!3mB$}pxsj}Z');
define('LOGGED_IN_KEY',    'J DVPhUUz4Z[3ofoOL}#CS[cd9$aa6=zm|rl)XuDLZg`c~|$O>pDg&M}0Vz@&{6)');
define('NONCE_KEY',        't[ut5t%sDZR9{(^ls2G]pcVy-&//OI|e3+E>%.aXl2zK+|1{{yA+0-~sD h|qXY;');
define('AUTH_SALT',        'rk?DN0r6uMbZY}n[7>![8Zlu?sraxgY4QDbwp.ipJM}D|wZTx77iZm/BW_m~7%^R');
define('SECURE_AUTH_SALT', ';/7XJ6~2N]Z#Hg5+ RWY<X</Mn|mej#(<:;{Y[t t9Tc?b+xf@g_tE>2T];H?v+o');
define('LOGGED_IN_SALT',   '@yL/RH-q50))k3Eg;R[Q=<Tp&FX25IC/P*B5@2?6G+EeQ8<fB6m+(9&I{`R+c0FM');
define('NONCE_SALT',       'f{bfy/`e!R@5> {Xa{X$>XIJ:&R-eAl 5c2^wB-`vVM7#jGoB*>Vr~N-v-T4dk0@');

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'est_';

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );
define( 'WP_DEBUG_DISPLAY', false );

/* Add any custom values between this line and the "stop editing" line. */

define('ENV', 'staging');

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
