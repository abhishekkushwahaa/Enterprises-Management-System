<?php
include '../databases/db.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM updates WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $file = $row['file_name'];
    $fileDestination = '../public/uploads/'.$file;
    unlink($fileDestination);
    $sql = "DELETE FROM updates WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    echo "<script>alert('File deleted successfully!')</script>";
    echo "<script>window.location.href='dashboard.php?page=updates';</script>";
}
echo $file;
?>