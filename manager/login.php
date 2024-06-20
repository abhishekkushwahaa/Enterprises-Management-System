<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./css/login.css" />
    <link rel="icon" type="image/x-icon" href="public/iitspath.svg">
    <title>Manager Site</title>
</head>

<body>
    <form method="POST">
        <img src="/public/iitspath.svg" alt="logo" width="100px" height="100px" id="logo">
        <h1>Manager Login</h1>
        <input type="text" name="email" placeholder="Username or Email" id="email" required>
        <input type="password" name="password" placeholder="Password" id="password" required> <br>
        <button type="submit" id="login-button">Login as Manager</button>
        <p><a href="./forgot-password.php">Forget password?</a></p>
    </form>
    <?php
    session_start();
    include "../databases/db.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM managers WHERE email = ? AND password = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['id'] = $row['id'];
            $_SESSION['name'] = $row['name'];
            echo "<script>alert('Login Successful'); window.location.href='dashboard.php';</script>";
        } else {
            echo "<script>alert('Login Failed'); window.location.href='login.php';</script>";
        }

        $stmt->close();
        $conn->close();
    }
    ?>
</body>

</html>
