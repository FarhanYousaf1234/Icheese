<?php
$insert = false;
$update = false;
$delete = false;

// Connect to the Database 
$servername = "localhost";
$username = "root";
$password = "";
$database = "cheese_shop";

// Create a connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Die if connection was not successful
if (!$conn) {
  die("Sorry we failed to connect: " . mysqli_connect_error());
}

if (isset($_GET['delete'])) {
  $title = $_GET['delete'];
  $delete = true;
  $sql = "DELETE FROM `cheese` WHERE `title` = '$title'";
  $result = mysqli_query($conn, $sql);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['snoEdit'])) {
    // Update the record
    $sno = $_POST["snoEdit"];
    $title = $_POST["titleEdit"];
    $description = $_POST["descriptionEdit"];
    $type = $_POST["typeEdit"];
    $origin = $_POST["originEdit"];
    $strength = $_POST["strengthEdit"];
    $price = $_POST["priceEdit"];

    // Sql query to be executed
    $sql = "UPDATE `cheese` SET `title` = '$title' , `description` = '$description', `type` = '$type', `origin` = '$origin', `strength` = '$strength', `price` = '$price' WHERE `sno` = $sno";
    $result = mysqli_query($conn, $sql);

    if ($result) {
      $update = true;
    } else {
      echo "We could not update the record successfully";
    }
  } else {
    $title = $_POST["title"];
    $description = $_POST["description"];
    $type = $_POST["type"];
    $origin = $_POST["origin"];
    $strength = $_POST["strength"];
    $price = $_POST["price"];

    // Sql query to be executed without specifying sno
    $sql = "INSERT INTO `cheese` (`title`, `description`, `type`, `origin`, `strength`, `price`) VALUES ('$title', '$description', '$type', '$origin', '$strength', '$price')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
      $insert = true;
    } else {
      echo "The record was not inserted successfully because of this error ---> " . mysqli_error($conn);
    }
  }
  if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: Login.php");
    exit;
  }
}
?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">

  <title>No Cheese for the Wicked - Cheese Shop</title>
</head>

<body>

  <!-- Edit Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit Cheese details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="/Webapp/Manager.php" method="POST">
          <div class="modal-body">
            <input type="hidden" name="snoEdit" id="snoEdit">
            <div class="form-group">
              <label for="titleEdit">Cheese Title</label>
              <input type="text" class="form-control" id="titleEdit" name="titleEdit" required>
            </div>

            <div class="form-group">
              <label for="descriptionEdit">Description</label>
              <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3" required></textarea>
            </div>

            <div class="form-group">
              <label for="typeEdit">Type (Hard/Soft)</label>
              <select class="form-control" id="typeEdit" name="typeEdit" required>
                <option value="Hard">Hard</option>
                <option value="Soft">Soft</option>
              </select>
            </div>

            <div class="form-group">
              <label for="originEdit">Country of Origin</label>
              <input type="text" class="form-control" id="originEdit" name="originEdit" required>
            </div>

            <div class="form-group">
              <label for="strengthEdit">Strength (1-5)</label>
              <input type="number" class="form-control" id="strengthEdit" name="strengthEdit" min="1" max="5" required>
            </div>

            <div class="form-group">
              <label for="priceEdit">Price per gram</label>
              <input type="number" class="form-control" id="priceEdit" name="priceEdit" step="0.01" required>
            </div>
          </div>
          <div class="modal-footer d-block mr-auto">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Icheese</a>
    <a class="navbar-brand">Welcome Manager</a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="starter.php">Home <span class="sr-only">(current)</span></a>
        </li>


      </ul>
      <div class="container mt-4">
        <a href="Login.php" class="btn btn-danger">Logout</a>
      </div>
      <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" id="search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="button" onclick="searchCheese()">Search</button>
      </form>
    </div>

  </nav>

  <?php
  if ($insert) {
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your Cheese has been inserted successfully
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
  }
  ?>
  <?php
  if ($delete) {
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your Cheese has been deleted successfully
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
  }
  ?>
  <?php
  if ($update) {
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your Cheese has been updated successfully
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
  }
  ?>

  <div class="container my-4">
    <h2>ICheese</h2>
    <form action="/Webapp/Manager.php" method="POST">
      <div class="form-group">
        <label for="title">Cheese Title</label>
        <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp" required>
      </div>

      <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
      </div>

      <div class="form-group">
        <label for="type">Type (Hard/Soft)</label>
        <select class="form-control" id="type" name="type" required>
          <option value="Hard">Hard</option>
          <option value="Soft">Soft</option>
        </select>
      </div>

      <div class="form-group">
        <label for="origin">Country of Origin</label>
        <input type="text" class="form-control" id="origin" name="origin" required>
      </div>

      <div class="form-group">
        <label for="strength">Strength (1-5)</label>
        <input type="number" class="form-control" id="strength" name="strength" min="1" max="5" required>
      </div>

      <div class="form-group">
        <label for="price">Price per gram</label>
        <input type="number" class="form-control" id="price" name="price" step="0.01" required>
      </div>
      <button type="submit" class="btn btn-primary">Add Cheese</button>
    </form>
  </div>

  <div class="container my-4">
    <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">S.No</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Type</th>
          <th scope="col">Origin</th>
          <th scope="col">Strength</th>
          <th scope="col">Price per gram</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = "SELECT * FROM `cheese`";
        $result = mysqli_query($conn, $sql);
        $sno = 1;
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<tr>
            <th scope='row'>" . $sno . "</th>
            <td>" . $row['title'] . "</td>
            <td>" . $row['description'] . "</td>
            <td>" . $row['type'] . "</td>
            <td>" . $row['origin'] . "</td>
            <td>" . $row['strength'] . "</td>
            <td>" . $row['price'] . "</td>
            <td> <button class='edit btn btn-sm btn-primary' id=" . $row['sno'] . ">Edit</button> <button class='delete btn btn-sm btn-danger' id='" . $row['title'] . "'>Delete</button>  </td>
            </tr>";
          $sno = $sno + 1;
        }
        ?>
      </tbody>
    </table>

  </div>


  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#myTable').DataTable();

    });

    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
      element.addEventListener("click", (e) => {
        tr = e.target.parentNode.parentNode;
        title = tr.getElementsByTagName("td")[1].innerText;
        description = tr.getElementsByTagName("td")[2].innerText;
        type = tr.getElementsByTagName("td")[3].innerText;
        origin = tr.getElementsByTagName("td")[4].innerText;
        strength = tr.getElementsByTagName("td")[5].innerText;
        price = tr.getElementsByTagName("td")[6].innerText;

        titleEdit.value = title;
        descriptionEdit.value = description;
        typeEdit.value = type;
        originEdit.value = origin;
        strengthEdit.value = strength;
        priceEdit.value = price;
        snoEdit.value = e.target.id;
        $('#editModal').modal('toggle');
      })
    })

    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
      element.addEventListener("click", (e) => {
        if (confirm("Are you sure you want to delete this Cheese!")) {
          window.location = `/Webapp/Manager.php?delete=${e.target.id}`;
        }
      })
    })

    function searchCheese() {
      let query = document.getElementById('search').value;
      window.location = `/Webapp/Manager.php?query=${query}`;
    }
  </script>
</body>

</html>