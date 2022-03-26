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

define('DB_NAME', 'cheetah_ORG');

/** MySQL database username */

define('DB_USER', 'root');

/** MySQL database password */

define('DB_PASSWORD', 'ElginNebraska1!');

/** MySQL hostname */

define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */

define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */

define('DB_COLLATE', '');

define('WP_SITEURL', 'http://cheetah-2020/');

define('WP_HOME', 'http://cheetah-2020/');

/**#@+

 * Authentication Unique Keys and Salts.

 *

 * Change these to different unique phrases!

 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}

 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.

 *

 * @since 2.6.0

 */

define('AUTH_KEY',         '*1*j.b.G*V&^-wN3nG5 E0U{MwrM]R&h`h;>nbR[jE9q.ww=v(DU]f.)&]<EBhXa');

define('SECURE_AUTH_KEY',  'TB.F9tYRh_FP}YIY>NneFD3J}Hq< hUFu%q4S:Z?cgGjjaWU&?P0p!RAlezY0nE,');

define('LOGGED_IN_KEY',    'nL/v[S}kl?IqN,I;0x_Fy5TMPh0NFP29C} (vOip 9+^@PDw.Y!>kx|i|sqMA2i[');

define('NONCE_KEY',        '`|T*Yw#oU4[zol}iU5jY-T[=ZQ.:l1&kW8.}MKCmo~t;$Tz$N_cHJh5!x$b(fEHG');

define('AUTH_SALT',        '%*Ij%@b ^:st5Y$E`%!AG*Qk?lG8|8YKS[hP-()}m{pbEZ?68+L1- 8hLasMK`r{');

define('SECURE_AUTH_SALT', '=[,1EFY1>iU!hlXh}O;)p#D,X#ZIY{o/A<hxFk{aKPH?a0]jyBR>%uTG%;Cly}6F');

define('LOGGED_IN_SALT',   'V6R>%tGP4$| B^yW:v)K`LeG(fmy`v 3? vMcy]*UuNV0ZgPDD=;v[`dpoAVNM&3');

define('NONCE_SALT',       'G7NH&wvR7UB9n1}5)>MLpy7cVUJYgwIu=.CiXxe=6d>8o2]DQIZ9.X0Paz?<c<7f');

/**#@-*/

/**

 * WordPress Database Table prefix.

 *

 * You can have multiple installations in one database if you give each

 * a unique prefix. Only numbers, letters, and underscores please!

 */

$table_prefix  = 'ccf_';

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

/* Debug */
define('WP_DEBUG', false);

/* Multisite */
define('WP_ALLOW_MULTISITE', true);

define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', false);
define('DOMAIN_CURRENT_SITE', 'cheetah-2020');

define('ADMIN_COOKIE_PATH', '/');
define('COOKIE_DOMAIN', '');
define('COOKIEPATH', '');
define('SITECOOKIEPATH', '');

define('WP_MEMORY_LIMIT', '64M');

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */

if ( !defined('ABSPATH') )

	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */

require_once(ABSPATH . 'wp-settings.php');