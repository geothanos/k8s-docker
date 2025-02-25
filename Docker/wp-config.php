<?php
define( 'DB_NAME', 'wordpress' );
define( 'DB_USER', '${DB_USER}' );
define( 'DB_PASSWORD', '${DB_PASSWORD}' );
define( 'DB_HOST', '${DB_HOST}' );
define( 'DB_CHARSET', 'utf8' );
define( 'DB_COLLATE', '' );
    
$table_prefix = 'wp_';
    
define( 'WP_DEBUG', false );

define('WP_MEMORY_LIMIT', '300M');

define('WP_HOME', 'https://k8s-wordomeka.gr');
define('WP_SITEURL', 'https://k8s-wordomeka.gr');

if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
    $_SERVER['HTTPS'] = 'on';
}
    
if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', __DIR__ . '/' );
}
    
require_once ABSPATH . 'wp-settings.php';
