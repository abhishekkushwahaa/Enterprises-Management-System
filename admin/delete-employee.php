<?php
include '../databases/db.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $conn->begin_transaction();

        try {
            $sql = "DELETE FROM leave_applications WHERE employees_id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            if (!$stmt->execute()) {
                throw new Exception("Error deleting from leave_applications: " . $stmt->error);
            }

            $sql = "DELETE FROM managers WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();

            $sql = "DELETE FROM employees WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();

            $conn->commit();

            echo "<script>alert('Employee deleted successfully'); window.location.href='?page=employees';</script>";
        } catch (Exception $e) {
            $conn->rollback();
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        }
        exit();
    }
}
?>