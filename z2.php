<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "summernote_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$title = $_POST['title'];
$content = $_POST['content'];
$secondContent = $_POST['second_content'];
$description = $_POST['description'];

$targetDir = "uploads/";
$targetFile = $targetDir . basename($_FILES["image"]["name"]);
$imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

$targetFile2 = $targetDir . basename($_FILES["image2"]["name"]);
$imageFileType2 = strtolower(pathinfo($targetFile2, PATHINFO_EXTENSION));

// Check if the uploaded file is an image
$isImage = exif_imagetype($_FILES["image"]["tmp_name"]) !== false;
$isImage2 = exif_imagetype($_FILES["image2"]["tmp_name"]) !== false;

// Handle image upload
if ($isImage && move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
    // Handle image2 upload
    if ($isImage2 && move_uploaded_file($_FILES["image2"]["tmp_name"], $targetFile2)) {
        // Handle banner images upload
        $bannerImages = [];
        if (!empty($_FILES['banner_images']['name'][0])) {
            $totalFiles = count($_FILES['banner_images']['name']);
            for ($i = 0; $i < $totalFiles; $i++) {
                $bannerFileName = $targetDir . basename($_FILES['banner_images']['name'][$i]);
                $bannerFileType = strtolower(pathinfo($bannerFileName, PATHINFO_EXTENSION));
                $isBannerImage = exif_imagetype($_FILES['banner_images']['tmp_name'][$i]) !== false;
                if ($isBannerImage && move_uploaded_file($_FILES['banner_images']['tmp_name'][$i], $bannerFileName)) {
                    $bannerImages[] = $bannerFileName;
                }
            }
        }

        $sql = "INSERT INTO notes (title, content, second_content, description, image, image2, banner_images) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssss", $title, $content, $secondContent, $description, $targetFile, $targetFile2, implode(",", $bannerImages));
    } else {
        $sql = "INSERT INTO notes (title, content, second_content, description, image, banner_images) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $title, $content, $secondContent, $description, $targetFile, implode(",", $bannerImages));
    }

    if ($stmt->execute()) {
        echo '<script>
        alert("Note saved successfully!");
        setTimeout(function() {
            window.location.href = "view_notes.php";
        }, 100);
    </script>';
    } else {
        echo '<div style="color: red;">Error: ' . $stmt->error . '</div>';
    }

    $stmt->close();
} else {
    echo '<div style="color: red;">Error uploading the file.</div>';
}

$conn->close();
?>
