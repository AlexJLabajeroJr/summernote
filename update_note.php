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
$carousel1 = $row['carousel1'];
$carousel2 = $row['carousel2'];
$carousel3 = $row['carousel3'];

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

    // Check if carousel1 file is selected
    if (!empty($_FILES['carousel1']['name'])) {
        $targetDirC1 = "uploads/";
        $targetFileC1 = $targetDirC1 . basename($_FILES["carousel1"]["name"]);
        $imageFileTypeC1 = strtolower(pathinfo($targetFileC1, PATHINFO_EXTENSION));

        // Check if the uploaded file is an image
        $isImageC1 = exif_imagetype($_FILES["carousel1"]["tmp_name"]) !== false;

        if ($isImageC1 && move_uploaded_file($_FILES["carousel1"]["tmp_name"], $targetFileC1)) {
            $carousel1 = $targetFileC1;
        } else {
            echo "Error uploading carousel1 image.";
            exit;
        }
    }

    // Check if carousel2 file is selected
    if (!empty($_FILES['carousel2']['name'])) {
        $targetDirC2 = "uploads/";
        $targetFileC2 = $targetDirC2 . basename($_FILES["carousel2"]["name"]);
        $imageFileTypeC2 = strtolower(pathinfo($targetFileC2, PATHINFO_EXTENSION));

        // Check if the uploaded file is an image
        $isImageC2 = exif_imagetype($_FILES["carousel2"]["tmp_name"]) !== false;

        if ($isImageC2 && move_uploaded_file($_FILES["carousel2"]["tmp_name"], $targetFileC2)) {
            $carousel2 = $targetFileC2;
        } else {
            echo "Error uploading carousel2 image.";
            exit;
        }
    }

    
    // Check if carousel3 file is selected
    if (!empty($_FILES['carousel3']['name'])) {
        $targetDirC3 = "uploads/";
        $targetFileC3 = $targetDirC3 . basename($_FILES["carousel3"]["name"]);
        $imageFileTypeC3 = strtolower(pathinfo($targetFileC3, PATHINFO_EXTENSION));

        // Check if the uploaded file is an image
        $isImageC3 = exif_imagetype($_FILES["carousel3"]["tmp_name"]) !== false;

        if ($isImageC3 && move_uploaded_file($_FILES["carousel3"]["tmp_name"], $targetFileC3)) {
            $carousel3 = $targetFileC3;
        } else {
            echo "Error uploading carousel3 image.";
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
    if (!is_null($image)) {
        $setStatements[] = "image = '$image'";
    }
    if (!is_null($image2)) {
        $setStatements[] = "image2 = '$image2'";
    }
    if (!is_null($carousel1)) {
        $setStatements[] = "carousel1 = '$carousel1'";
    }
    if (!is_null($carousel2)) {
        $setStatements[] = "carousel2 = '$carousel2'";
    }
    if (!is_null($carousel3)) {
        $setStatements[] = "carousel3 = '$carousel3'";
    }

    if (count($setStatements) > 0) {
        $sql .= " " . implode(", ", $setStatements);
        $sql .= " WHERE id = '$noteId'";

        if ($conn->query($sql) === TRUE) {
            echo '<script>
            alert("Updated successfully!");
            setTimeout(function() {
                window.location.href = "view_notes.php";
            }, 500);
            </script>';
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
}

$conn->close();
?>
