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

    <?php
    include "../databases/db.php";
    require '../manager/vendor/autoload.php';

    use PHPMailer\PHPMailer\PHPMailer;

    error_reporting(E_ALL);
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
        $sql = "SELECT * FROM managers WHERE email='$email'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $token = bin2hex(random_bytes(50));
            $sql = "UPDATE managers SET token='$token' WHERE email='$email'";
            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Password reset token sent to your email!')</script>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "<script>alert('User not found!')</script>";
        }

        $link = "<a href='http://localhost:3000/manager/reset-password.php?key=" . $email . "&token=" . $token . "'>Click To Reset password</a>";

        $conn->close();

        // Send email
        $resend = Resend::client('re_XWBhdceZ_PeTT6hfkSbW47ZPLC7dbSz1R');

        try {
            $resend->emails->send([
                'from' => 'onboarding@resend.dev',
                'to' => 'genius.abhishek.sir@gmail.com',
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

</body>

</html>