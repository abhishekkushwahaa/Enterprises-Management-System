<?php
if (!isset($_SESSION)) {
    session_start();
}

include "../databases/db.php";

$id = isset($_SESSION['id']) ? $_SESSION['id'] : '';
if (!empty($id)) {
    $sql = "SELECT * FROM admin WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo '
            <nav>
                <a href="/admin/dashboard.php">
                    <img src="/public/iitspath.svg" alt="logo" id="logo">
                </a>
                <h2>Welcome, <span id="welcome">' . htmlspecialchars($row['name']) . '</span>!</h2>
                <span><img src="../public/menu.svg" alt="menu" id="navbar-icon"></span>
                <a id="logout" href="/admin/login.php" role="button">Logout</a>
            </nav>';
    } else {
        echo "<script>alert('No admin found!'); window.location.href = '/admin/login.php';</script>";
    }
}
