<?php
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

$search_query = "";
if (isset($_GET['query'])) {
    $search_query = $_GET['query'];
    $sql = "SELECT * FROM `cheese` WHERE `title` LIKE '%$search_query%' OR `description` LIKE '%$search_query%' OR `type` LIKE '%$search_query%' OR `origin` LIKE '%$search_query%' OR `strength` LIKE '%$search_query%' OR `price` LIKE '%$search_query%'";
} else {
    $sql = "SELECT * FROM `cheese`";
}
$result = mysqli_query($conn, $sql);
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

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Icheese</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="starter.php">Home <span class="sr-only">(current)</span></a>
                </li>

            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" id="search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="button" onclick="searchCheese()">Search</button>
            </form>
        </div>
    </nav>

    <div class="container my-4">
        <h2>ICheese - Customer Page</h2>

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
                    </tr>
                </thead>
                <tbody>
                    <?php
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

            function searchCheese() {
                let query = document.getElementById('search').value;
                window.location = `/Webapp/Customer/customer.php?query=${query}`;
            }
        </script>
</body>

</html>