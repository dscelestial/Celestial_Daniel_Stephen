<?php 
session_start();

  if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) 
  {
    header("location: login.php");
    exit();
  }

include_once("config.php") 
?>
<?php  
  $file_type = "";
  $title = "";
  $description = "";
  $ref_no = "";
  $org = "";
  $officer = "";
  $date = "";

  if(isset($_GET['id']) && !empty(trim($_GET['id'])))
  {
    $sql = "SELECT * FROM students WHERE id = ?";
    if($stmt = mysqli_prepare($link, $sql))
    {
      mysqli_stmt_bind_param($stmt, "i", $param_id);

      $param_id = trim($_GET['id']);

     if(mysqli_stmt_execute($stmt))
      {
        $result = mysqli_stmt_get_result($stmt);
        if(mysqli_num_rows($result) == 1)
        {
          $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

          $file_type = $row['file_type'];
          $title = $row['title'];
          $description = $row['description'];
          $ref_no = $row['ref_no'];
          $org = $row['org'];
          $officer = $row['officer'];
          $date = $row['date'];
        }
      }
      else
      {
        echo "Oops! Something went wrong. Please try again.";
      }
    }

    mysqli_stmt_close($stmt);

    mysqli_close($link);
  }
  else
  {
    header("location: error.php");
    exit();
  }

?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="fontawesome/css/all.css" rel="stylesheet">
    <title>Sample CRUD</title>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-md-10 offset-md-1">
            <h1>Show Details</h1>
            <a href="add.php" class="btn btn-primary float-end">
              <i class="fas fa-plus"></i>Add Record
            </a>
            <br><br>
            <div class="form-group">
              <label>File type</label>
              <p><b><?= $file_type ?></b></p>
            </div>
            <div class="form-group">
              <label>Title</label>
              <p><b><?= $title ?></b></p>
            </div>
            <div class="form-group">
              <label>Description</label>
              <p><b><?= $description ?></b></p>
            </div>
            <div class="form-group">
              <label>Ref.no</label>
              <p><b><?= $ref_no ?></b></p>
            </div>
            <div class="org">
              <label>Organization</label>
              <p><b><?= $org ?></b></p>
            </div>
            <div class="officer">
              <label>Officer</label>
              <p><b><?= $officer ?></b></p>
            </div>
            <div class="date">
              <label>Date</label>
              <p><b><?= $date ?></b></p>
            </div>
            <p><a href="index.php" class="btn btn-primary">Back</a></p>
        </div>
      </div>
    </div>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="js/bootstrap.bundle.min.js"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>
</html>