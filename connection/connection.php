<?php
if (isset($conn) && $conn instanceof mysqli) {
    return;
}
?>
<?php
$DB_HOST = "localhost";
$DB_USER = "root";
$DB_PASS = "";
$DB_NAME = "duka_store";

$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
$conn->set_charset("utf8mb4");

$RAJAONGKIR_API_KEY = "YOUR_RAJAONGKIR_API_KEY";
$STORE_CITY_ID = "441"; // origin city id for shipping calculation
?>