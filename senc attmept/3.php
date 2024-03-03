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
$bannerImages = json_decode($row['banner_images'], true);

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="view.php">My App</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="view_notes.php">View Notes</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title"><b>System Information</b></h5>
            </div>
            <div class="card-body">
                <form method="POST" action="update_note.php" enctype="multipart/form-data">
                    <input type="hidden" name="noteId" value="<?php echo $noteId; ?>">
                    <div class="form-group">
                        <label>Banner Images</label>
                        <input type="file" name="banner_images[]" class="form-control-file border border-1" style="padding: 5px; border-radius: 5px; margin-bottom: 10px;" multiple>
                        <?php foreach ($bannerImages as $key => $bannerImage): ?>
                            <div class="banner-image">
                                <img src="<?php echo $bannerImage; ?>" width="200" alt="Banner Image" style="width: 150px; height: 150px; border-style: solid; border-width: 1px; border-radius: 5px; margin-right: 10px;">
                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(<?php echo $key; ?>)"><i class="fa fa-trash"></i> Remove</button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="form-group">
                        <label><b>Title</b></label>
                        <input type="text" name="title" class="form-control" value="<?php echo $title; ?>">
                    </div>
                    <div class="form-group">
                        <label><b>About Us</b></label>
                        <textarea name="content" id="summernote" class="form-control"><?php echo $content; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label><b>Privacy Policy</b></label>
                        <textarea name="second_content" id="second_summernote" class="form-control"><?php echo $secondContent; ?></textarea>
                    </div>
                    <div class="form-group ">
                        <label><b>System logo</b></label>
                        <input type="file" name="image" class="form-control-file border border-1" style="padding: 5px; border-radius: 5px;5px;">

                        <?php if ($image != ""): ?>
                            <div class="mt-3 mb-2 text-center">
                                <img src="<?php echo $image; ?>" width="200" alt="Note Image" style="width: 150px; height: 150px; border-radius: 50%; border-style: solid; border-width: 5px; border-color: aliceblue; object-fit: cover; object-position: center;">
                            </div>
                        <?php endif; ?>

                    </div>
                    <div class="form-group border border-1 mt-3" style="padding: 10px; border-radius: 5px; 5px;">
                        <label>Image 2</label>
                        <input type="file" name="image2" class="form-control-file border border-1" style="padding: 5px; border-radius: 5px;5px;">
                        <?php if ($image2 != ""): ?>
                            <div class="mt-3 mb-2 text-center">
                                <img src="<?php echo $image2; ?>" width="200" alt="Note Image 2" style="width: 500px; height: 400px; ">
                            </div>
                        <?php endif; ?>

                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" class="form-control"><?php echo $description; ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#summernote').summernote({
                height: 300,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']]
                ],
                fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Georgia', 'Impact', 'Lucida Console', 'Tahoma', 'Times New Roman', 'Verdana'],
                fontNamesIgnoreCheck: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Georgia', 'Impact', 'Lucida Console', 'Tahoma', 'Times New Roman', 'Verdana'],
                fontSizes: ['8', '10', '12', '14', '16', '18', '20', '24', '28', '32', '36', '40', '48', '56', '64', '72', '96']
            });

            $('#second_summernote').summernote({
                height: 300,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']]
                ],
                fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Georgia', 'Impact', 'Lucida Console', 'Tahoma', 'Times New Roman', 'Verdana'],
                fontNamesIgnoreCheck: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Georgia', 'Impact', 'Lucida Console', 'Tahoma', 'Times New Roman', 'Verdana'],
                fontSizes: ['8', '10', '12', '14', '16', '18', '20', '24', '28', '32', '36', '40', '48', '56', '64', '72', '96']
            });
        });

        function confirmDelete(index) {
            if (confirm("Are you sure you want to remove this image?")) {
                window.location.href = "remove_banner_image.php?id=<?php echo $noteId; ?>&index=" + index;
            }
        }
    </script>
</body>
</html>
