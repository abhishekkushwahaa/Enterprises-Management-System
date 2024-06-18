<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Portal</title>
    <link rel="icon" type="image/x-icon" href="public/iitspath.svg">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <nav>
        <img src="./public/iitspath.svg" alt="logo">
        <p>All Login Links</p>
        <a href="admin/login.php">Admin</a>
        <a href="manager/login.php">Manager</a>
        <a href="employee/login.php">Employee</a>
    </nav>
    <div id="home-update">
        <h2 id="update">Lastest updates</h2>
        <h2 id="wish">Know whom you can wish</h2>
    </div>
    <div id="latest-updates">
        <?php 
        include './databases/db.php';
        $sql = "SELECT * FROM updates";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<a href='./public/uploads/".$row['file_name']."'>".$row['id'].".".$row['file_name']."</a><br>";
        }
        ?>
    </div>
    </img>
</body>
</html>