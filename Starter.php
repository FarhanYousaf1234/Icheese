<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cheese Shop Home</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3l0fZXHY4z72m1z8Nq4Jw7R9q+Xb0w2oK7hKqorY//qLvrt6yP5foh49M2"
        crossorigin="anonymous">
</head>
<style>
        body {
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            color: #ffffff;
        }

        .custom-container {
            background-color: rgba(0, 0, 0, 0.7);
            border-radius: 15px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.5);
            padding: 50px;
            margin-top: 100px;
        }

        h1 {
            color: #ffc107;
            text-align: center;
            margin-bottom: 50px;
        }

        .btn-primary {
            background-color: #ffc107;
            border-color: #ffc107;
            width: 100%;
            font-weight: bold;
            font-size: 18px;
            padding: 15px;
            margin-top: 20px;
        }

        .btn-primary:hover {
            background-color: #ffca28;
            border-color: #ffca28;
        }

        .radio-label {
            font-size: 20px;
        }

        .form-check-input:checked+.form-check-label:before {
            border-color: #ffc107;
            background-color: #ffc107;
        }
    </style>
<body>

<div class="container custom-container">
        <h1>Welcome to Icheese</h1>
        <h3>Do you want to Login as manager or Go to Customer Page</h3>
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <form id="userForm">
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="userType" id="customerRadio" value="customer" checked>
                            <label class="form-check-label radio-label" for="customerRadio">
                                Customer
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="userType" id="managerRadio" value="manager">
                            <label class="form-check-label radio-label" for="managerRadio">
                                Manager
                            </label>
                        </div>
                    </div>
                    <button type="button" id="submitButton" onclick="redirectToPage()" class="btn btn-primary">Continue</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4Ck4bOZO6+GaXn2mO/+dAy/4+QpGJOZ26g5ksq"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"
        integrity="sha384-ykZ5o2TA0kKz79V+3u+swTWOT2Oz8DhkIZGhdT7q+TMfYjvOQw+3J4uXkIIv+8Pp"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8sh+8AfozeNf6FfnC0qyy1K6tqjZt6yFV8oswX"
        crossorigin="anonymous"></script>

    <script>
        function redirectToPage() {
            let userType = document.querySelector('input[name="userType"]:checked').value;
            if (userType === "customer") {
                window.location.href = "http://localhost/Webapp/Customer.php";
            } else if (userType === "manager") {
                window.location.href = "http://localhost/Webapp/Login.php";
            }
        }
    </script>

</body>

</html>
