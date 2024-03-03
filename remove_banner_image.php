<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "summernote_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the note ID and image index from the GET parameters
$noteId = $_GET['id'];
$imageIndex = $_GET['index'];

// Retrieve note details from the database
$sql = "SELECT * FROM notes WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $noteId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$bannerImages = json_decode($row['banner_images'], true);

// Remove the image associated with the given index from the note
if (array_key_exists($imageIndex, $bannerImages)) {
    $removedImage = $bannerImages[$imageIndex];
    unset($bannerImages[$imageIndex]);

    // Update the banner images in the note's data
    $bannerImages = json_encode($bannerImages);
    $updateSql = "UPDATE notes SET banner_images = ? WHERE id = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("si", $bannerImages, $noteId);
    $stmt->execute();

    // TODO: Remove the image file from the server (optional)

    // Redirect to the edit page after removing the image
    header("Location: edit_note.php?id=" . $noteId);
    exit();
}

$conn->close();
?>
