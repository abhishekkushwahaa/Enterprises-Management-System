<?php
$page = isset($_GET['page']) ? $_GET['page'] : '';
if ($page == "pass-change") {
    include "pass-change.php";
    exit();
}
ini_set('session.save_path', realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/tmp'));
ini_set('session.gc_probability', 1);
session_start();
include "../databases/db.php";
$managers_sql = "SELECT * FROM managers";
$managers_result = $conn->query($managers_sql);
$managers = [];
if ($managers_result->num_rows > 0) {
    while ($row = $managers_result->fetch_assoc()) {
        $managers[] = $row;
    }
}
$manager_email = 'N/A';
?>