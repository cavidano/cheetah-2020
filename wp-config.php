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
define('DB_NAME', 'ccf_2020');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         'k-gkt[^1T*tMI F!!ZVWe12HqYvC^IarZDd~_j(w{e%YV0pB&-N6EwE]<}}f(u&Z');
define('SECURE_AUTH_KEY',  'RKCTZ^+]FtTSEz~8-MM}N>_&QY,0;wn&W)OIF`1&2N9kU%*-ejnNb6/*~S?B4OxI');
define('LOGGED_IN_KEY',    ')#&&OlEA@Ytiau!ey|R*LH0?{ZkU8$vP0IGmnrW4paNx_m |O`eXj,y}[u;gx}kT');
define('NONCE_KEY',        'oe$ [Pg%(sX8PKbWA#Z|]rUP9f}VO:oQR7tcE([b >F_XzwXlF)t<BZ,7z<[yvpD');
define('AUTH_SALT',        'zc6djRT).E~0i6A$Y<EmoY*N~B@^ukj?vR:}{dr0m>uZ^?C48#M96Zwd3L9h)f_Z');
define('SECURE_AUTH_SALT', 'FL;7{2wMiTr;V6JIKaNC:=#<GW|3o24I1{/P`/!:&jq:^N<u@+aM!!N{]pg&L`EL');
define('LOGGED_IN_SALT',   'M2<D?iW^{*?a%?6WfNxihQPb::i;l!%j)U{gtk5ptaus=gT0jA~p6ZS3-KQ+.kI[');
define('NONCE_SALT',       '_dQN|hnE)4oIBuJ=N|]Ja[)w/oM(Eh8(yqcaGN!>H;;U8?%%=IshWO;PQAf%w9;v');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
