

define('DB_NAME', '{{ wordpress_database_name }}');

define('DB_USER', '{{ wordpress_database_user }}');

define('DB_PASSWORD', 'mestre');

define('DB_HOST', '{{ wordpress_mysql_host }}');

define('DB_CHARSET', 'utf8mb4');

define('DB_COLLATE', '');


{{ wp_salt.stdout}}