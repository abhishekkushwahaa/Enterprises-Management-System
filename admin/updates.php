<?php 
echo "<h1 id='fileh1'>Here, You can upload all type of documents for latests updates!</h1>";

include "../databases/db.php";

if (isset($_POST['submit'])) {
    $file = $_FILES['file'];

    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png', 'pdf', 'docx', 'doc', 'ppt', 'pptx', 'xls', 'xlsx', 'txt');

    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 1000000) {
                $fileNameNew = uniqid('', true).".".$fileActualExt;
                $fileDestination = '../public/uploads/'.$fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);
                $sql = "INSERT INTO updates (file_name) VALUES ('$fileNameNew')";
                $result = mysqli_query($conn, $sql);
                echo "<h1 id='fileh1'>File uploaded successfully!</h1>";
            } else {
                echo "<h1 id='fileh1'>Your file is too big!</h1>";
            }
        } else {
            echo "<h1 id='fileh1'>There was an error uploading your file!</h1>";
        }
    } else {
        echo "<h1 id='fileh1'>You cannot upload files of this type!</h1>";
    }
}

?>

<link rel="stylesheet" href="./css/upload.css">

<form id="file" action="" method="post" enctype="multipart/form-data">
    <input id="fileinput" type="file" name="file">
    <button id="upload" type="submit" name="submit">Upload</button>
</form>

<div>
    <h1 id="uploadfileh1">Uploaded Files</h1>
    <table id="tbl">
        <tr>
            <th>S.no.</th>
            <th>File Name</th>
            <th>Download</th>
            <th>Delete</th>
        </tr>
        <?php
        $sql = "SELECT * FROM updates";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>".$row['id']."</td>";
            echo "<td>".$row['file_name']."</td>";
            echo "<td><a id='download' href='../public/uploads/".$row['file_name']."' download><img id='downloadicon' src='../public/download.svg' /></a></td>";
            echo "<td><a id='delete' href='file-delete.php?id=".$row['id']."'><img id='deleteicon' src='../public/trash.svg' /></a></td>";
            echo "</tr>";
        }
        ?>
    </table>
</div>