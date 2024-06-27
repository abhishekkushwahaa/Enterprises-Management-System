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
    
    <!-- Some Interesting Struff to be added here -->
    <div id="employee-spotlight">
        <h2>Employee of the Month</h2>
        <img src="./public/avatar.svg" alt="Employee of the Month">
        <p>Congratulations to Abhishek for outstanding performance!</p>
    </div>
    <div id="polls">
        <h2>Poll of the Week</h2>
        <form action="polls.php" method="POST">
            <p>Do you prefer remote work or office work?</p>
            <input type="radio" id="remote" name="poll" value="remote">
            <label for="remote">Remote</label><br>
            <input type="radio" id="office" name="poll" value="office">
            <label for="office">Office</label><br>
            <input type="submit" value="Submit">
        </form>
    </div>
    <div id="upcoming-events">
        <h2>Upcoming Events</h2>
        <ul>
            <li>Annual Meeting - July 15, 2024</li>
            <li>Team Building Activity - August 22, 2024</li>
        </ul>
    </div>
    <div id="suggestion-box">
        <h2>Suggestion Box</h2>
        <form action="suggestions.php" method="POST">
            <textarea name="suggestion" rows="4" cols="50" placeholder="Enter your suggestion..."></textarea><br>
            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>
