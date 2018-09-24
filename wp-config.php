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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'mocha');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '.yw<SDlU?RBV*q0Pw5T=oskC$W4gK6L2:u~W;8dA0Y=0joc[PA4XL.w>tpykLZx9');
define('SECURE_AUTH_KEY',  '0R-m/ueY&cD!$X:_!m%}js>bHNL0<x[%MKD>3kkn1{x/nZoOfq%Ib ,|DpqKU*f.');
define('LOGGED_IN_KEY',    'G7{n;iPlRKe:SYB(RQIT<veGWwVt|d=$t;yw9B_QyqVlik~+IAH|]g:J&E$pil|s');
define('NONCE_KEY',        'z;$8 W2xX7qya8GZ%0a&NL:Dz]pEpY< se?q{s`Tj,l$/^DWu.MTUZM0WXGPlW}H');
define('AUTH_SALT',        'T!A|8_LB,bQ?6q#J,l>G${X%BDu,$<4X1FI.|1ENz2I!3u-0J1Hs_.*XF:mmK8+F');
define('SECURE_AUTH_SALT', '_ZgIB[EsI@!m]Gd7Bi0F58?@H)LRz_:fsh`,Z~N*b5&y(yjuDoei+C3VR0H*&9pX');
define('LOGGED_IN_SALT',   'OhnI{r`xq@8t6Ql}j&M+r!huA$)]UC2ONk}TC!q 6>s8<g9$~A uLfm+<v:v/[z>');
define('NONCE_SALT',       'viS?>&*?Ien8M]n,KsVW&hnv5&E<[>voed%H+633[^.c:B;8 @N:-nQ_+#K@nS@b');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
define('WP_MEMORY_LIMIT', '256M');
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
