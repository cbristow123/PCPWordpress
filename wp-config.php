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
define( 'DB_NAME', 'Wordpress' );

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
define( 'AUTH_KEY',         ';p0wRVW%GIub4Wyk:effG{4=#IW4&o;(Bz[w^2er=,N(_@arSY)s.NbR-^Cbw?!Z' );
define( 'SECURE_AUTH_KEY',  'Z}zi2479lvOQjtXja})+^8sAl*;.s?A3doH+KJfeyr/K$C~iMW3E0i!Y69QO$_1Y' );
define( 'LOGGED_IN_KEY',    '@M|eHS_/0ftAH,o<VxwQ/,sK3aUE+*A-YYyyESJ}mL]`cDU9]CZYH<B<Ep|zPI${' );
define( 'NONCE_KEY',        'r?XO%Dql^f/=!w3v|O|IOLFFW7D8~Qmz]_PrbG;N0yPSDo/(!Z8*yG^Rz5mz$~2)' );
define( 'AUTH_SALT',        '(ZFtxOh/iV(y(^>mw<aExyH.].?Yk]UE <$Q|Ywv?b_{/{SOcJ>n*NsmC73m88o}' );
define( 'SECURE_AUTH_SALT', ';c73}xbfXiy3{Lf-dF.;3$#,D):An=[9:NCENK^K_7Y^^X1gF|Oj^^]i*>bT@c3g' );
define( 'LOGGED_IN_SALT',   '6.[Ril  ,YsvKZqM(}HZjDP),Q(|$t8xg~PCY.*7!$MMnjOq3f/v1)=~0<S$pkIp' );
define( 'NONCE_SALT',       '-V9u)^B>&9-JAuBSoSUUF$[J<U6)8IL]HOBWj:czbb?g/6s`ZyQ.A6$wBph`ElGe' );

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
