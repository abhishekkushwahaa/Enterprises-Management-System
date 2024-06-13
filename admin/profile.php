<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="icon" type="image/x-icon" href="public/iitspath.svg">
    <link rel="stylesheet" href="./css/profile.css">
</head>

<body>
    <div id="profile">
        <h1 id="h1profile">Edit Profile</h1>
    </div>

    <?php
    include "../databases/db.php";
    $id = 2; 
    $sql = "SELECT name, email, password FROM admin WHERE id=$id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "<script>alert('Admin data not found');</script>";
        exit();
    }
    ?>

    <form method="POST" id="form">
        <label for="name">Username:</label><br>
        <input type="text" name="name" id="name" disabled value="<?php echo htmlspecialchars($row['name']); ?>"><br>
        <label for="email">Email:</label><br>
        <input type="email" name="email" id="email" disabled value="<?php echo htmlspecialchars($row['email']); ?>"><br>
        <label for="password">Current Password:</label><br>
        <input type="password" name="password" id="current-password" required value="<?php echo htmlspecialchars($row['password']); ?>"><br>
        <label for="new-password">New Password:</label><br>
        <input type="password" name="new-password" id="new-password" required><br>
        <input type="submit" value="Update Profile" id="submit">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $new_password = $_POST['new-password'];
        $sql = "UPDATE admin SET password=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $new_password, $id);
        if ($stmt->execute()) {
            echo "<script>alert('admin updated successfully'); window.location.href='?page=dashboard';</script>";
            exit();
        } else {
            echo "<script>alert('Error: " . $conn->error . "');</script>";
        }
    }
    ?>
</body>

</html>
