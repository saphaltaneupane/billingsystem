<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}


include "db.php";

$error_message = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $membershipno = $_POST["membershipno"];
    $phoneno = $_POST["phoneno"];
    $address = $_POST["address"];

    
    $sql = "SELECT membershipno FROM customers WHERE membershipno='$membershipno'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $error_message = "Membership number already exists. Please use a different number.";
    } else {
     
        $sql = "INSERT INTO customers (name, membershipno, phoneno, address) VALUES ('$name', '$membershipno', '$phoneno', '$address')";
        if ($conn->query($sql) === TRUE) {
            header("Location: success.php");
            exit(); 
        } else {
            $error_message = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}


$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Customer Details</title>
    <style>
        body {
            background-image: url('supermarket.jpg');
            background-size: cover;
            font-family: Arial, sans-serif;
            color: #333;
            text-align: center;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .form-container {
            background-color: #f0f0f0;
            border-radius: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 500px;
            padding: 20px;
            margin-top: 50px;
        }

        h1 {
            color: white;
            font-size: 50px;
            padding-bottom: 40px;
        }

        form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        input[type="submit"] {
            background-color: #008CBA;
            color: #ffffff;
            padding: 10px 20px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #005f6b;
        }

        .back-button {
            position: absolute;
            top: 20px;
            left: 20px;
            background-color: #008CBA;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: #005f6b;
        }

        .error-message {
            color: red;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <a href="home.php" class="back-button">Back</a>
    <h1>For membership</h1>
    <div class="form-container">
        <?php
        if ($error_message) {
            echo "<p class='error-message'>$error_message</p>";
        }
        ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="membershipno">Membership No:</label>
            <input type="text" id="membershipno" name="membershipno" required>

            <label for="phoneno">Phone No:</label>
            <input type="text" id="phoneno" name="phoneno" required>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required>

            <input type="submit" value="Submit">
        </form>
    </div>
</body>

</html>