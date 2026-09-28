<?php

$host = getenv("DB_HOST") ?: "localhost";
$username = getenv("DB_USER") ?: "root";
$password = getenv("DB_PASSWORD") ?: "";
$database = getenv("DB_NAME") ?: "portfolio_db";
$configuredPort = getenv("DB_PORT");
$sslCa = getenv("DB_SSL_CA");
$port = $configuredPort === false || $configuredPort === ""
    ? 3306
    : filter_var($configuredPort, FILTER_VALIDATE_INT, [
        "options" => ["min_range" => 1, "max_range" => 65535]
    ]);

if ($port === false) {
    error_log("Database configuration error: DB_PORT must be a valid port number.");
    die("Unable to connect to the database. Please try again later.");
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {

    $conn = mysqli_init();

    if (!$conn) {
        throw new mysqli_sql_exception("Unable to initialize the database connection.");
    }

    $connectionFlags = 0;
    if ($sslCa !== false && $sslCa !== "") {
        $conn->options(MYSQLI_OPT_SSL_VERIFY_SERVER_CERT, true);
        $conn->ssl_set(null, null, $sslCa, null, null);
        $connectionFlags = MYSQLI_CLIENT_SSL;
    }

    $conn->real_connect(
        $host,
        $username,
        $password,
        $database,
        $port,
        null,
        $connectionFlags
    );
    $conn->set_charset("utf8mb4");

} catch (mysqli_sql_exception $e) {

    error_log("Database connection error: " . $e->getMessage());

    die("Unable to connect to the database. Please try again later.");
}
?>