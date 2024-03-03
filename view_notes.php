<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "summernote_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM notes";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <style>
       .carousel-img {
    width: 100%;
    height: auto;
}
    </style>
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
        <h1>View Notes</h1>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $noteId = $row['id'];
                $title = $row['title'];
                $description = $row['description'];
                $content = htmlspecialchars_decode($row['content']);
                $secondContent = htmlspecialchars_decode($row['second_content']);
                $image = $row['image'];
                $image2 = $row['image2'];
                $carousel1 = $row['carousel1'];
                $carousel2 = $row['carousel2'];
                $carousel3 = $row['carousel3'];
        ?>

        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title"><?php echo $title; ?></h5>
                <p class="card-text"><?php echo $description; ?></p>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <?php if ($content != "") { ?>
                                <div class="card-text"><?php echo $content; ?></div>
                            <?php } ?>
                        </div>
                        <div class="col-sm-12">
                            <?php if ($secondContent != "") { ?>
                                <div class="card-text"><?php echo $secondContent; ?></div>
                            <?php } ?>

                            <?php if ($image != "" && file_exists($image)) { ?>
                                <?php if (strpos($image, ".mp4") !== false) { ?>
                                    <video src="<?php echo $image; ?>" class="img-fluid" controls></video>
                                <?php } else { ?>
                                    <img src="<?php echo $image; ?>" class="img-fluid first-image" alt="Note Image">
                                <?php } ?>
                            <?php } ?>

                            <?php if ($image2 != "" && file_exists($image2)) { ?>
                                <?php if (strpos($image2, ".mp4") !== false) { ?>
                                    <video src="<?php echo $image2; ?>" class="img-fluid" controls></video>
                                <?php } else { ?>
                                    <img src="<?php echo $image2; ?>" class="img-fluid second-image" alt="Note Image 2">
                                <?php } ?>
                            <?php } ?>
                            

                            <br>
                            <br>
                            <br>
                            <br>
                            <?php if ($carousel1 != "" && file_exists($carousel1)) { ?>
                                         <div class="container">
                                            <div class="row">
                                                <div class="col-sm-2">
   
                                                </div>
                                                
                                                <div class="col-sm-8">
                                                <div id="carouselExample" class="carousel slide border border-5" data-ride="carousel" >
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img src="<?php echo $carousel1; ?>" class="img-fluid carousel-img" alt="Carousel 1">
                                        </div>
                                        <?php if ($carousel2 != "" && file_exists($carousel2)) { ?>
                                            <div class="carousel-item">
                                                <img src="<?php echo $carousel2; ?>" class="img-fluid carousel-img" alt="Carousel 2">
                                            </div>
                                        <?php } ?>
                                        <?php if ($carousel3 != "" && file_exists($carousel3)) { ?>
                                            <div class="carousel-item">
                                                <img src="<?php echo $carousel3; ?>" class="img-fluid carousel-img" alt="Carousel 3">
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <a class="carousel-control-prev" href="#carouselExample" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#carouselExample" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                     </div>
                                      </div>
                                      <div class="col-sm-2">
   
   </div>

                                            </div>
                                         </div>
                              


                            <?php } ?>
                        </div>
                    </div>
                </div>
                <br>
                <br>
                <br>

                   <br>   <br>
                   <br>
                   <br>
                   <br>
                   <br>
                   <br>
                   <br>
                   <br>
                   <br>
                   <br>

                <a href="edit_note.php?id=<?php echo $noteId; ?>" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="delete.php?id=<?php echo $noteId; ?>" class="btn btn-danger">
                    <i class="fas fa-trash-alt"></i> Delete
                </a>
            </div>
        </div>

        <?php
            }
        } else {
            echo "No notes found.";
        }
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
