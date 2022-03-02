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

  $file_type_err = "";
  $title_err = "";
  $description_err = "";
  $ref_no_err = "";
  $org_err = "";
  $officer_err = "";
  $date = "";

if(isset($_POST['id']) && !empty($_POST['id']))
{
  $id = $_POST['id'];
  $input_file_type = trim($_POST["file_type"]);
    if(empty($input_file_type))
    {
      $file_type_err = "Please input a file type.";
    }
    elseif(!filter_var($input_file_type, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/"))))
    {
      $file_type_err = "Please enter a valid file type.";
    }
    else
    {
      $file_type = $input_file_type;
    }

    $input_title = trim($_POST["title"]);
    if(empty($input_title))
    {
      $title_err = "Please input a title.";
    }
    else
    {
      $title = $input_title;
    }

    $input_description = trim($_POST["description"]);
    if(empty($input_description))
    {
      $description_err = "Please input a description.";
    }
    else
    {
      $description = $input_description;
    }

    $input_ref_no = trim($_POST["ref_no"]);
    if(empty($input_ref_no))
    {
      $ref_no_err = "Please input a ref_no.";
    }
    else
    {
      $ref_no = $input_ref_no;
    }

    $input_org = trim($_POST["org"]);
    if(empty($input_org))
    {
      $org_err = "Please input a org";
    }
    else
    {
      $org = $input_org;
    }

    $input_officer = trim($_POST["officer"]);
    if(empty($input_officer))
    {
      $officer_err = "Please input a officer";
    }
    else
    {
      $officer = $input_officer;
    }

    $input_date = trim($_POST["date"]);
    if(empty($input_date))
    {
      $date_err = "Please input a date";
    }
    else
    {
      $date = $input_date;
    }

  if(empty($file_type_err) && empty($title_err) && empty($description_err) && empty($ref_no_err) && empty($org_err) && empty($officer_err) && empty($date_err))
  {
      $sql = "UPDATE students SET file_type = ?, title =?, description =?, ref_no =?, org =?, officer =?, date =? WHERE id = ?";

    if($stmt = mysqli_prepare($link, $sql))
    {
      mysqli_stmt_bind_param($stmt, "sssisssi", $param_file_type, $param_title, $param_description, $param_ref_no, $param_org, $param_officer, $param_date, $param_id);

      $param_id = $id;
      $param_file_type = $file_type;
      $param_title = $title;
      $param_description = $description;
      $param_ref_no = $ref_no;
      $param_org = $org;
      $param_officer = $officer;
      $param_date = $date;

      if(mysqli_stmt_execute($stmt))
      {
        header('location: index.php');
        exit();
      }
      else
      {
        echo "Oops! Something went wrong. Try again later.";
      }
    }
   mysqli_stmt_close($stmt);
 }
   mysqli_close($link);
}
else
{
  if(isset($_GET['id']) && !empty(trim($_GET['id'])))
  {
    $id = trim($_GET['id']);

    $sql = "SELECT * FROM students WHERE id = ?";
    if($stmt = mysqli_prepare($link, $sql))
    {
      mysqli_stmt_bind_param($stmt, "i", $param_id);

      $param_id = $id;

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
    <link rel="stylesheet" href="fontawesome/css/all.css"/>
    <title>Sample CRUD</title>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-md-6 offset-md-3">
            <h1>Modify Students Information</h1>
            <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                <div class="form-group">
                    <label>File Type</label>
                    <input type="text" name="file_type" class="form-control <?php echo(!empty($file_type_err)) ? 'is-invalid':''?>" value="<?= $file_type ?>">
                    <span class="invalid-feedback"><?= $file_type_err ?></span>
                </div>
                <div class="form-group">
                    <label>Title</label>
                    <textarea name="title" class="form-control <?php echo(!empty($title_err)) ? 'is-invalid':''?>"><?= $title?></textarea>
                    <span class="invalid-feedback"><?= $title_err ?></span>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control <?php echo(!empty($description_err)) ? 'is-invalid':''?>"><?= $description?></textarea>
                    <span class="invalid-feedback"><?= $description_err ?></span>
                </div>
                <div class="form-group">
                    <label>Ref.no</label>
                    <textarea name="ref_no" class="form-control <?php echo(!empty($ref_no_err)) ? 'is-invalid':''?>"><?= $ref_no?></textarea>
                    <span class="invalid-feedback"><?= $ref_no_err ?></span>
                </div>
                <div class="form-group">
                    <label>Organization</label>
                    <textarea name="org" class="form-control <?php echo(!empty($org_err)) ? 'is-invalid':''?>"><?= $org?></textarea>
                    <span class="invalid-feedback"><?= $org_err ?></span>
                </div>
                <div class="form-group">
                    <label>Officer</label>
                    <textarea name="officer" class="form-control <?php echo(!empty($officer_err)) ? 'is-invalid':''?>"><?= $officer?></textarea>
                    <span class="invalid-feedback"><?= $officer_err ?></span>
                </div>
                <div class="form-group">
                    <label>Date</label>
                    <textarea name="date" class="form-control <?php echo(!empty($date_err)) ? 'is-invalid':''?>"><?= $date?></textarea>
                    <span class="invalid-feedback"><?= $date_err ?></span>
                </div>
                <hr>
                <input type="hidden" name="id" value="<?= $id ?>">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
            </form>
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
