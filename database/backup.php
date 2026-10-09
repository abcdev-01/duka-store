<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('location:../admin/index.php');
    exit;
}
require_once __DIR__ . '/../connection/connection.php';

// Collect all tables
$tables = [];
$result = mysqli_query($conn, "SHOW TABLES");
while ($row = mysqli_fetch_row($result)) {
    $tables[] = $row[0];
}

$sqlScript = "-- Batik Store backup\n";
$sqlScript .= "-- Generated: " . date('Y-m-d H:i:s') . "\n\n";
$sqlScript .= "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\n";
$sqlScript .= "SET time_zone = \"+00:00\";\n\n";

foreach ($tables as $table) {
    $create = mysqli_fetch_row(mysqli_query($conn, "SHOW CREATE TABLE `$table`"));
    $sqlScript .= "DROP TABLE IF EXISTS `$table`;\n";
    $sqlScript .= $create[1] . ";\n\n";

    $rows = mysqli_query($conn, "SELECT * FROM `$table`");
    $columnCount = mysqli_num_fields($rows);

    while ($row = mysqli_fetch_row($rows)) {
        $sqlScript .= "INSERT INTO `$table` VALUES(";
        for ($j = 0; $j < $columnCount; $j++) {
            $value = addslashes($row[$j]);
            $sqlScript .= isset($row[$j]) ? '"' . $value . '"' : '""';
            if ($j < ($columnCount - 1)) $sqlScript .= ',';
        }
        $sqlScript .= ");\n";
    }
    $sqlScript .= "\n";
}

$backupFile = 'batik_store_backup_' . date('Ymd_His') . '.sql';
file_put_contents($backupFile, $sqlScript);

header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=' . basename($backupFile));
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($backupFile));

if (ob_get_level()) ob_end_clean();
flush();
readfile($backupFile);
@unlink($backupFile);
exit;
?>