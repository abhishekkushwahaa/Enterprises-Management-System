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
require '../admin/vendor/autoload.php';

use DevCoder\DotEnv;

$absolutePathToEnvFile = __DIR__ . '/.env';

(new DotEnv($absolutePathToEnvFile))->load();

error_reporting(E_ALL);
if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $sql = "SELECT * FROM admin WHERE email='$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $token = bin2hex(random_bytes(50));
        $sql = "UPDATE admin SET token='$token' WHERE email='$email'";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Password reset token sent to your email!')</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "<script>alert('User not found!')</script>";
    }

    $link = "<a href='http://localhost:3000/admin/reset-password.php?key=" . $email . "&token=" . $token . "'>Click To Reset password</a>";

    $conn->close();

    // Send email
    $resend = Resend::client(getenv('RESEND_API_KEY'));


    try {
        $resend->emails->send([
            'from' => getenv('FROM_GMAIL'),
            'to' => getenv('TO_GMAIL'),
            'subject' => 'Reset Password',
            'html' => $link,
        ]);
        echo "Password reset token sent to your email!";
        echo "<br>";
        echo "<button id='back' onclick='window.history.back()'>Go Back</button>";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        echo "<br>";
        echo "<button id='back' onclick='window.history.back()'>Go Back</button>";
    }
}
?>