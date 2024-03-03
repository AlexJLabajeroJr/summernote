<!DOCTYPE html>
<html>
<head>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <!-- Add Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="view.php">My App</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
        <h1>Create Note</h1>
        <form method="POST" action="save.php" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input class="form-control" type="text" name="title" id="title" placeholder="Title">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" name="description" id="description"></textarea>
            </div>
            <div class="mb-3">
                <label for="summernote" class="form-label">Content</label>
                <textarea class="form-control" name="content" id="summernote"></textarea>
            </div>
            <div class="mb-3">
                <label for="second_summernote" class="form-label">Additional Content</label>
                <textarea class="form-control" name="second_content" id="second_summernote"></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input class="form-control" type="file" name="image" id="image">
            </div>
            <div class="mb-3">
                <label for="image2" class="form-label">Image 2</label>
                <input class="form-control" type="file" name="image2" id="image2">
            </div>
            <div class="mb-3">
                <label for="banner_images" class="form-label">Banner Images</label>
                <input class="form-control" type="file" name="banner_images[]" id="banner_images" multiple>
            </div>
            <div class="mb-3">
                <span id="bannerCount"></span>
            </div>
            <button type="submit" class="btn btn-primary">Save Note</button>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                placeholder: 'Type here',
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
                fontSizes: ['8', '10', '12', '14', '16', '18', '20', '24', '28', '32', '36', '40', '48', '56', '64', '72', '96'] // Customize the font sizes
            });

            $('#second_summernote').summernote({
                placeholder: 'Type here',
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
                fontSizes: ['8', '10', '12', '14', '16', '18', '20', '24', '28', '32', '36', '40', '48', '56', '64', '72', '96'] // Customize the font sizes
            });

            $('#banner_images').on('change', function() {
                var fileCount = $(this)[0].files.length;
                var message = fileCount > 1 ? fileCount + ' images selected' : fileCount + ' image selected';
                $('#bannerCount').text(message);
            });
        });
    </script>

    <!-- Add Bootstrap JS links -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
