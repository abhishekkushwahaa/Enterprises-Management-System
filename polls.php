<?php

include './databases/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $poll = $_POST['poll'];
    $sql = "INSERT INTO dashboard (poll) VALUES ('$poll')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo "<script>alert('Poll submitted successfully!')</script>";
        echo "<script>window.location = 'index.php'</script>";
    } else {
        echo "<script>alert('Failed to submit poll!')</script>";
        echo "<script>window.location = 'index.php'</script>";
    }
}
?>