<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Employees</title>
   <link rel="icon" type="image/x-icon" href="public/iitspath.svg">
   <link rel="stylesheet" href="./css/employees.css">
</head>
<body>
   <div id="employees">
      <h1 id="emp">Employees</h1>
      <button id="emp-add"><a href="?page=add-employee">Add New</a></button>
   </div>
   <?php
      include "../databases/db.php";
      $sql = "SELECT id, name, email, password, joining_date FROM employees";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
          echo "<div id='table-responsive'>";
          echo "<table><tr><th>Id</th><th>Name</th><th>Email</th><th>View Employee</th><th>Joining Date</th><th>Make Manager</th><th>Edit</th><th>Delete</th></tr>";
          while($row = $result->fetch_assoc()) {
              $id = $row["id"];
              $sql_manager = "SELECT id FROM managers WHERE id=$id";
              $result_manager = $conn->query($sql_manager);
              $is_manager = $result_manager->num_rows > 0 ? true : false;
              echo "<tr><td>" . $row["id"]. "</td><td>" . $row["name"] . "</td><td>" . $row["email"]. "</td><td><a id='view' href='?page=view-employee&id=".$row["id"]."'>View</a></td><td>" . $row["joining_date"]. "</td><td>";
              if ($is_manager) {
                  echo "Already Manager";
              } else {
                  echo "<a id='edit' href='?page=add-manager-employee&id=".$row["id"]."'>Make Manager</a>";
              }
              echo "</td><td><a id='edit' href='?page=edit-employee&id=".$row["id"]."'>Edit</a></td><td><a id='delete' href='?page=delete-employee&id=".$row["id"]."'>Delete</a></td></tr>";
          }
          echo "</table>";
            echo "</div>";
      } else { 
         echo "<h3 id='NoRecord'>No Record Found!</h3>";
      }

      $conn->close();
      ?>
</body>
</html>