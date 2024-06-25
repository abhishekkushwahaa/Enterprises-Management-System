<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            background-color: #d3ead8;
        }

        #back {
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #222222;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>

<body>

</body>

</html>
<?php
include "../databases/db.php";

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $sql = "SELECT * FROM admin WHERE email='$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $token = bin2hex(random_bytes(50));
        $sql = "UPDATE admin SET token='$token' WHERE email='$email'";
        if ($conn->query($sql) === TRUE) {
            include "forgot-password-mail.php";
            $message = "<a href='http://localhost:3000/admin/reset-password.php?key=" . $email . "&token=" . $token . "'>Click To Reset password</a>";
            sendEmail($env, $email, $message);
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "<script>alert('User not found!')</script>";
    }

    $conn->close();
}
?>