<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('location:../admin/index.php');
    exit;
}
require_once __DIR__ . '/../connection/connection.php';

$schemaFile = __DIR__ . '/../database/schema.sql';
$seedFile   = __DIR__ . '/../database/seed.sql';

if (!file_exists($schemaFile) || !file_exists($seedFile)) {
    echo "<script>alert('Schema or seed SQL file not found.');window.location='../admin/dashboard.php';</script>";
    exit;
}

$sql = file_get_contents($schemaFile) . "\n" . file_get_contents($seedFile);

if (mysqli_multi_query($conn, $sql)) {
    while (mysqli_more_results($conn) && mysqli_next_result($conn)) { ; }
    echo "<script>
        alert('Database restored successfully');
        window.location = '../admin/dashboard.php';
    </script>";
} else {
    $err = mysqli_error($conn);
    echo "<script>
        alert('Restore failed: " . addslashes($err) . "');
        window.location = '../admin/dashboard.php';
    </script>";
}
exit;
?>