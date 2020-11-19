<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'g9}Zceq>;nPH<;-tcufv,|q5z0V5>1P3zf1-)N_]yi]wf^W<12~Dxax4~L,M)^Vj' );
define( 'SECURE_AUTH_KEY',  '`%iy&Z-$KwV0r40tlB@ibw0T27m(>dN2<QSX3$RWL6`/grUTBJ(T&s: ?N(YIj].' );
define( 'LOGGED_IN_KEY',    '?c s)-=<ojT<_dTF!q7:uvc^y[?&]oY$;p}5,|gX;%0.Bi/<`j[7MT HEA ~=E|E' );
define( 'NONCE_KEY',        'tKS6j52_i^uPsP3Yq@ C&#U:ox;#p2D09*NkXlL*Da.?l~Rzv:.thn[~alL*hx#q' );
define( 'AUTH_SALT',        '&3Zx`u1Wau{a+Rh8=t,!bMww`{fZ<|NxO<qcHVLBbN2p>=jS<B7BjA8Nk iC3$KO' );
define( 'SECURE_AUTH_SALT', 'tRwpro#D`,IJxuhOOq[QM|l8/;tT*Z#{S39[yRH3.ubb#,US)Bw{w6Q*ZQVrf9f(' );
define( 'LOGGED_IN_SALT',   'x5.gr}-4aQon@zPheV[DmIh=s$C$ZA>J`>V>7Nx!HNA]+ant(f^_0#]-kkd~&E$l' );
define( 'NONCE_SALT',       '~U-PHxzXqWa-MP8^L3.]eVz;E8f/q F@:A-l^;gco>*XhWt3A9YfgN),yFQxr}ne' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
