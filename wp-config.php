<?php
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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'utopiawinds.com' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         'Nf#r>5oHDy>)<JKY8E%>dln${8/@4c7!SRwM?z>.SGUASSetr,;z;6-j6__sm.a%' );
define( 'SECURE_AUTH_KEY',  '/-__n$u&. $R#$Bn|?9pueJeuwD?(|Y^YNvSt-xg_U$nxR2-InLrj][hen!f+ZW-' );
define( 'LOGGED_IN_KEY',    'xM?dBy$Cr1xJl|>}8Yf__95pFb:_#p=[Ocaqw*5;egbz;MpX`$C$qb+9)`8WReDG' );
define( 'NONCE_KEY',        'ol!8%,olJ,T5P^=XP8U5@C299V_Dt!Y]q1b&~L%H`%!ot,icMTs|CH9?]g$$PY|Z' );
define( 'AUTH_SALT',        '_I_FTS@]}E@4>4z :R*D$EeS!h:}g&3Jk~SkXgDgGC$Y9I?H=hmC N^*~*hCx8bF' );
define( 'SECURE_AUTH_SALT', '~jr.%Wga[M(v|)Vru/SGwszXq3^|$(B^?sBO&O3Xj_f8!&(g37rGo/X&!1x=-XaH' );
define( 'LOGGED_IN_SALT',   ':eb:IukJM2ML[|SEg!1Qk!#U]J#W=-&f*JCF_.:ktnsUL|X7K;pzL3@X4b?i8ZpB' );
define( 'NONCE_SALT',       'G!X[JHN*PLXVB^5.h3mtK^%%lYfw.7O{`ZBWqynX;}RVUg!NebXw_9:Gq|3I0N8f' );

/**#@-*/

/**
 * WordPress database table prefix.
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

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
