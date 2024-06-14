<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="./css/forgot-password.css">
</head>

<body>
    <form method="POST" action="./password-reset-token.php">
        <img src="/public/iitspath.svg" alt="logo" width="100px" height="100px" id="logo" />
        <h1>Forgot Password</h1>
        <input type="text" name="email" placeholder="Username or Email" id="username" required />
        <br />
        <button type="submit" id="login-button">Forget Password</button>
        <p><a href="./login.php">Go Back!</a></p>
    </form>
</body>

</html>