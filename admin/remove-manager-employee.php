<?php
include "../databases/db.php";
$id = $_GET['id'];
$sql = "DELETE FROM managers WHERE id=$id";
if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully";
    header("Location: /admin/dashboard.php?page=managers");
} else {
    echo "Error deleting record: " . $conn->error;
}
?>