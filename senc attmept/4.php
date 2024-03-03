<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "summernote_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$noteId = $_POST['noteId'];

// Retrieve note details from the database
$sql = "SELECT * FROM notes WHERE id = $noteId";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$title = $row['title'];
$content = $row['content'];
$secondContent = $row['second_content'];
$image = $row['image'];
$image2 = $row['image2'];
$description = $row['description'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $secondContent = $_POST['second_content'];
    $description = $_POST['description'];

    // Check if image file is selected
    if (!empty($_FILES['image']['name'])) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if the uploaded file is an image
        $isImage = exif_imagetype($_FILES["image"]["tmp_name"]) !== false;

        if ($isImage && move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $image = $targetFile;
        } else {
            echo "Error uploading the image file.";
            exit;
        }
    } else {
        // Check if the image is removed
        $removeImage = isset($_POST['remove_image']) ? $_POST['remove_image'] : false;
        if ($removeImage) {
            $image = null;
        }
    }

    // Check if image2 file is selected
    if (!empty($_FILES['image2']['name'])) {
        $targetDir2 = "uploads/";
        $targetFile2 = $targetDir2 . basename($_FILES["image2"]["name"]);
        $imageFileType2 = strtolower(pathinfo($targetFile2, PATHINFO_EXTENSION));

        // Check if the uploaded file is an image
        $isImage2 = exif_imagetype($_FILES["image2"]["tmp_name"]) !== false;

        if ($isImage2 && move_uploaded_file($_FILES["image2"]["tmp_name"], $targetFile2)) {
            $image2 = $targetFile2;
        } else {
            echo "Error uploading the image2 file.";
            exit;
        }
    }

    $sql = "UPDATE notes SET";


    $setStatements = [];
    if (!empty($title)) {
        $setStatements[] = "title = '$title'";
    }
    if (!empty($content)) {
        $setStatements[] = "content = '$content'";
    }
    if (!empty($secondContent)) {
        $setStatements[] = "second_content = '$secondContent'";
    }
    if (!empty($description)) {
        $setStatements[] = "description = '$description'";
    }
    if (!empty($image)) {
        $setStatements[] = "image = '$image'";
    }
    if (!empty($image2)) {
        $setStatements[] = "image2 = '$image2'";
    }

    if (!empty($setStatements)) {
        $sql .= " " . implode(", ", $setStatements) . " WHERE id = $noteId";

        if ($conn->query($sql) === TRUE) {
            echo "Note updated successfully.";
        } else {
            echo "Error updating note: " . $conn->error;
        }
    } else {
        echo "No changes to update.";
    }
}

$conn->close();
?>