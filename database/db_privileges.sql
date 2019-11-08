# Privileges for `root`@`127.0.0.1`

GRANT ALL PRIVILEGES ON *.* TO 'root'@'127.0.0.1' WITH GRANT OPTION;


# Privileges for `root`@`::1`

GRANT ALL PRIVILEGES ON *.* TO 'root'@'::1' WITH GRANT OPTION;


# Privileges for `root`@`localhost`

GRANT ALL PRIVILEGES ON *.* TO 'root'@'localhost' WITH GRANT OPTION;

GRANT PROXY ON ''@'%' TO 'root'@'localhost' WITH GRANT OPTION;
