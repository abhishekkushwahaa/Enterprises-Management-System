<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" type="text/css" href="./css/login.css" />
  <link rel="icon" type="image/x-icon" href="public/iitspath.svg">
  <title>Reset Password</title>
</head>

<body>
  <?php
  include "../databases/db.php";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST['password'];
    $email = $_GET['key'];
    $token = $_GET['token'];

    if (isset($_POST['confirm-password'])) {
      $confirm_password = $_POST['confirm-password'];
    } else {
      echo "<script>alert('Confirm password is not set!')</script>";
    }

    if ($password === $confirm_password) {
      $sql = "UPDATE managers SET password='$password' WHERE email='$email' AND token='$token'";
      if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Congratulations! Your password has been updated successfully!')</script>";
      } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
    } else {
      echo "<script>alert('Passwords do not match!')</script>";
    }
  }
  ?>
  <form method="POST">
    <img src="/public/iitspath.svg" alt="logo" width="100px" height="100px" id="logo" />
    <h1>Reset Password</h1>
    <input type="password" name="password" placeholder="Password" id="password" required />
    <input type="password" name="confirm-password" placeholder="Confirm Password" id="confirm-password" required />
    <br />
    <button type="submit" id="login-button">Reset Password</button>
    <p><a href="./login.php">Go Login!</a></p>
  </form>
</body>

</html>