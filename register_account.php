<!DOCTYPE html>
<html>
<head>
    <title>Register Account</title>
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
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        h1 {
            color: #fff;
        }

        form {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            max-width: 400px;
            width: 100%;
        }

        label {
            font-size: 18px;
            color: #333;
        }

        input[type="text"], input[type="password"], input[type="email"], select, input[type="submit"] {
            width: calc(100% - 22px);
            height: 40px;
            margin: 10px 0;
            border-radius: 20px;
            border: none;
            padding: 10px;
            font-size: 18px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
<?php
// Start the session
session_start();

// Database connection
include('db.php');

// Register a new account if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    $user_type = $_POST["user_type"];

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO users (username, password, email, user_type) VALUES (?, ?, ?, ?)");

    // Bind the parameters
    $stmt->bind_param("ssss", $username, $password, $email, $user_type);

    // Execute the statement
    if ($stmt->execute()) {
        echo "<p>Account registered successfully. Redirecting to login page...</p>";
        header("refresh:0.5;url=index.php"); // Redirect after 2 seconds
        exit();
    } else {
        echo "<p>Error registering account: " . $conn->error . "</p>";
    }

    // Close the prepared statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required><br>
    <label for="password">Password:</label>
    <div style="position: relative;">
        <input type="password" id="password" name="password" oninput="validatePassword()" required>
        <input type="checkbox" id="showPasswordCheckbox" onclick="togglePasswordVisibility()">
        <label for="showPasswordCheckbox">Show Password</label>
        <div id="passwordCriteria">
            <p id="lengthMessage"></p>
            <p id="charMessage"></p>
            <p id="numMessage"></p>
        </div>
    </div>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br>
    <label for="user_type">User Type:</label>
    <select id="user_type" name="user_type" required>
        <option value="employee">Employee</option>
    </select><br>
    <input type="submit" value="Register">
</form>
<script>
    function togglePasswordVisibility() {
        var passwordInput = document.getElementById("password");
        var checkbox = document.getElementById("showPasswordCheckbox");
        if (checkbox.checked) {
            passwordInput.type = "text";
        } else {
            passwordInput.type = "password";
        }
    }

    function validatePassword() {
        var password = document.getElementById("password").value;
        var lengthMessage = document.getElementById("lengthMessage");
        var charMessage = document.getElementById("charMessage");
        var numMessage = document.getElementById("numMessage");

        // Check length
        if (password.length < 8) {
            lengthMessage.textContent = "Password must be at least 8 characters long.";
        } else {
            lengthMessage.textContent = "";
        }

        // Check for characters
        if (!/[a-zA-Z]/.test(password)) {
            charMessage.textContent = "Password must contain at least one letter.";
        } else {
            charMessage.textContent = "";
        }

        // Check for numbers
        if (!/\d/.test(password)) {
            numMessage.textContent = "Password must contain at least one number.";
        } else {
            numMessage.textContent = "";
        }
    }
</script>
</body>
</html>
