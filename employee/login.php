<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="public/iitspath.svg">
    <link rel="stylesheet" type="text/css" href="./css/login.css">
    <title>Employee Site</title>
</head>

<body>
    <form method="POST">
        <img src="/public/iitspath.svg" alt="logo" width="100px" height="100px" id="logo">
        <h1>Employee Login</h1>
        <input type="text" name="email" placeholder="Username or Email" id="email" required>
        <input type="password" name="password" placeholder="Password" id="password" required> <br>
        <button type="submit" id="login-button">Login as Employee</button>
        <p><a href="./forgot-password.php">Forget password?</a></p>
    </form>

    <?php
    ini_set('session.save_path', realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/tmp'));
    ini_set('session.gc_probability', 1);
    session_start();
    include "../databases/db.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];

        $login_sql = "SELECT * FROM employees WHERE email = ? AND password = ?";
        $stmt = $conn->prepare($login_sql);
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $employee = $result->fetch_assoc();
            $_SESSION['employees_id'] = $employee['id'];
            $_SESSION['email'] = $employee['email'];
            $_SESSION['name'] = $employee['name'];

            echo "<script>
                alert('Login successful');
                window.location.href = '/employee/dashboard.php';
              </script>";
        } else {
            echo "<script>
                alert('Invalid email or password');
                window.location.href = '/employee/login.php';
              </script>";
        }

        $stmt->close();
        $conn->close();
    }
    ?>

</body>

</html>
