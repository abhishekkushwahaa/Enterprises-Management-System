<?php
include "../databases/db.php";

$result = $mysqli->query("SELECT COUNT(*) AS total FROM emoloyees");
$row = $result->fetch_assoc();
$total_records = $row['total'];

$records_per_page = 10;
$total_pages = ceil($total_records / $records_per_page);

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $current_page = (int) $_GET['page'];
} else {
    $current_page = 1;
}

if ($current_page < 1) {
    $current_page = 1;
} elseif ($current_page > $total_pages) {
    $current_page = $total_pages;
}

$offset = ($current_page - 1) * $records_per_page;

$query = "SELECT * FROM emoloyees LIMIT $offset, $records_per_page";
$result = $mysqli->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pagination</title>
    <style>
        .pagination a {
            margin: 0 5px;
            text-decoration: none;
            color: #007bff;
        }

        .pagination a.active {
            font-weight: bold;
            color: #000;
        }

        .pagination a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <div class="pagination">
        <?php if ($current_page > 1): ?>
        <a href="?page=<?php echo $current_page - 1; ?>">&laquo; Previous</a>
        <?php endif; ?>

        <?php for ($page = 1; $page <= $total_pages; $page++): ?>
        <a href="?page=<?php echo $page; ?>" <?php if ($page == $current_page) echo 'class="active"'; ?>><?php echo $page; ?></a>
        <?php endfor; ?>

        <?php if ($current_page < $total_pages): ?>
        <a href="?page=<?php echo $current_page + 1; ?>">Next &raquo;</a>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
$mysqli->close();
?>
