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

$targetFileCarousel1 = $targetDir . basename($_FILES["carousel1"]["name"]);
$imageFileTypeCarousel1 = strtolower(pathinfo($targetFileCarousel1, PATHINFO_EXTENSION));

$targetFileCarousel2 = $targetDir . basename($_FILES["carousel2"]["name"]);
$imageFileTypeCarousel2 = strtolower(pathinfo($targetFileCarousel2, PATHINFO_EXTENSION));

$targetFileCarousel3 = $targetDir . basename($_FILES["carousel3"]["name"]);
$imageFileTypeCarousel3 = strtolower(pathinfo($targetFileCarousel3, PATHINFO_EXTENSION));

// Check if the uploaded file is an image
$isImage = exif_imagetype($_FILES["image"]["tmp_name"]) !== false;
$isImage2 = exif_imagetype($_FILES["image2"]["tmp_name"]) !== false;
$isCarousel1Image = exif_imagetype($_FILES["carousel1"]["tmp_name"]) !== false;
$isCarousel2Image = exif_imagetype($_FILES["carousel2"]["tmp_name"]) !== false;
$isCarousel3Image = exif_imagetype($_FILES["carousel3"]["tmp_name"]) !== false;

// Handle image upload
if ($isImage && move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
    // Handle image2 upload
    if ($isImage2 && move_uploaded_file($_FILES["image2"]["tmp_name"], $targetFile2)) {
        // Handle carousel1 upload
        if ($isCarousel1Image && move_uploaded_file($_FILES["carousel1"]["tmp_name"], $targetFileCarousel1)) {
            // Handle carousel2 upload
            if ($isCarousel2Image && move_uploaded_file($_FILES["carousel2"]["tmp_name"], $targetFileCarousel2)) {
                // Handle carousel3 upload
                if ($isCarousel3Image && move_uploaded_file($_FILES["carousel3"]["tmp_name"], $targetFileCarousel3)) {
                    $sql = "INSERT INTO notes (title, content, second_content, description, image, image2, carousel1, carousel2, carousel3) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("sssssssss", $title, $content, $secondContent, $description, $targetFile, $targetFile2, $targetFileCarousel1, $targetFileCarousel2, $targetFileCarousel3);
                } else {
                    echo '<div style="color: red;">Error uploading Carousel 3.</div>';
                }
            } else {
                echo '<div style="color: red;">Error uploading Carousel 2.</div>';
            }
        } else {
            echo '<div style="color: red;">Error uploading Carousel 1.</div>';
        }
    } else {
        $sql = "INSERT INTO notes (title, content, second_content, description, image, carousel1, carousel2, carousel3) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssss", $title, $content, $secondContent, $description, $targetFile, $targetFileCarousel1, $targetFileCarousel2, $targetFileCarousel3);
    }

    if ($stmt->execute()) {
        echo '<script>
        alert("Note saved successfully!");
        setTimeout(function() {
            window.location.href = "view_notes.php";
        }, 1000);
        </script>';
    } else {
        echo '<div style="color: red;">Error saving note: ' . $stmt->error . '</div>';
    }
} else {
    echo '<div style="color: red;">Error uploading image.</div>';
}

$conn->close();
?>
