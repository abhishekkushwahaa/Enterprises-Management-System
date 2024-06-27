<?php
include './databases/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $suggestion = $_POST['suggestion'];
    $sql = "INSERT INTO dashboard (suggestion) VALUES ('$suggestion')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo "<script>alert('Suggestion submitted successfully!')</script>";
        echo "<script>window.location = 'index.php'</script>";
    } else {
        echo "<script>alert('Failed to submit suggestion!')</script>";
        echo "<script>window.location = 'index.php'</script>";
    }
}
?>