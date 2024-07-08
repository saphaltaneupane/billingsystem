<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
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

        .login-container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            max-width: 400px;
            width: 100%;
        }

        h1 {
            margin-top: 0;
            color: #333;
        }

        form {
            margin-top: 20px;
        }

        label {
            font-size: 18px;
            color: #333;
        }

        input[type="text"],
        input[type="password"],
        input[type="submit"],
        button {
            width: calc(50% - 5px);
            height: 40px;
            margin: 10px;
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

        button {
            background-color: #008CBA;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #005f6b;
        }

        p {
            color: red;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h1>Supermarket Billing System Login</h1>
        <?php
       
        session_start();

        // Database connection
        include('db.php');

        // Login functionality
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST["username"];
            $password = $_POST["password"];

            // Use prepared statements to prevent SQL injection
            $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
            $stmt->bind_param("ss", $username, $password);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $_SESSION["user_type"] = $row["user_type"];
                $_SESSION["username"] = $username;

                // Redirect based on user type
                if ($row["user_type"] == "admin") {
                    header("Location: admin_home.php");
                } else {
                    header("Location: home.php");
                }
                exit(); // Ensure no further code is executed
            } else {
                echo "<p>Invalid username or password</p>";
            }

            $stmt->close();
        }

        // Close the database connection
        $conn->close();
        ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>

            <input type="submit" value="Login">
            <button type="button" onclick="window.location.href='register_account.php'">Register</button>
        </form>
    </div>
</body>

</html>
