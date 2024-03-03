<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "summernote_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$noteId = $_GET['id'];

$sql = "DELETE FROM notes WHERE id=$noteId";

if ($conn->query($sql) === TRUE) {
    echo '<script>
        alert("Note deleted successfully!");
        setTimeout(function() {
            window.location.href = "view_notes.php";
        }, 100);
    </script>';
} else {
    echo '<script>
        alert("Error deleting the note: ' . $conn->error . '");
        setTimeout(function() {
            window.location.href = "view_notes.php";
        }, 100);
    </script>';
}

$conn->close();
?>
