<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    $user_type = $_POST["user_type"];

    $stmt = $conn->prepare("INSERT INTO users (username, password, email, user_type) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $password, $email, $user_type);

    if ($stmt->execute()) {
        echo "<script>alert('Account registered successfully.');</script>";
    } else {
        echo "<script>alert('Error registering account: " . $conn->error . "');</script>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Account</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #ecf0f1;
            margin: 0;
            padding: 0;
            display: flex;
        }
        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: white;
            padding: 20px;
            height: 100vh;
        }
        .sidebar h2 {
            margin-bottom: 20px;
        }
        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }
        .sidebar ul li {
            margin-bottom: 10px;
        }
        .sidebar ul li a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .sidebar ul li a:hover, .sidebar ul li a.active {
            background-color: green;
        }
        .content {
            flex-grow: 1;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .logout {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #e74c3c;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }
        form {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        h1 {
            text-align: center;
            color: #2c3e50;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input[type="text"], input[type="password"], input[type="email"], select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #2c3e50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 20px;
        }
        input[type="submit"]:hover {
            background-color: #34495e;
        }
        #passwordCriteria p {
            color: #e74c3c;
            font-size: 12px;
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Admin Dashboard</h2>
        <ul>
            <li><a href="register_account_admin.php" class="active">Add User</a></li>
            <li><a href="view_users.php">View Users</a></li>
            <li><a href="view_bills.php">View Saved Bills</a></li>
            <li><a href="view_customer.php">View Customers</a></li>
            <li><a href="report.php">View report</a></li>
        </ul>
    </div>
    <div class="content">
        <a href="logout.php" class="logout">Logout</a>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <h1>Register New User</h1>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" oninput="validatePassword()" required>
            <input type="checkbox" id="showPasswordCheckbox" onclick="togglePasswordVisibility()">
            <label for="showPasswordCheckbox">Show Password</label>
            <div id="passwordCriteria">
                <p id="lengthMessage"></p>
                <p id="charMessage"></p>
                <p id="numMessage"></p>
            </div>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="user_type">User Type:</label>
            <select id="user_type" name="user_type" required>
                <option value="employee">Employee</option>
            </select>

            <input type="submit" value="Register">
        </form>
    </div>

    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("password");
            var checkbox = document.getElementById("showPasswordCheckbox");
            passwordInput.type = checkbox.checked ? "text" : "password";
        }

        function validatePassword() {
            var password = document.getElementById("password").value;
            var lengthMessage = document.getElementById("lengthMessage");
            var charMessage = document.getElementById("charMessage");
            var numMessage = document.getElementById("numMessage");

            lengthMessage.textContent = password.length < 8 ? "Password must be at least 8 characters long." : "";
            charMessage.textContent = !/[a-zA-Z]/.test(password) ? "Password must contain at least one letter." : "";
            numMessage.textContent = !/\d/.test(password) ? "Password must contain at least one number." : "";
        }
    </script>
</body>
</html>