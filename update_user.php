<!DOCTYPE html>
<html>

<head>
    <title>Update Account</title>
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

        input[type="text"],
        input[type="password"],
        input[type="email"],
        select,
        input[type="submit"] {
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
        }    </style>
</head>

<body>
    <?php
    // Start the session
    session_start();

    // Database connection
    include('db.php');

    // Fetch user data for updating
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $id = $_GET["id"];
        $sql = "SELECT * FROM users WHERE id = $id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $username = $row["username"];
            $password = $row["password"];
            $email = $row["email"];
            $user_type = $row["user_type"];
        } else {
            echo "<p>User not found</p>";
            exit(); // Stop further execution
        }
    }

    // Update account data
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST["id"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $email = $_POST["email"];
        $user_type = $_POST["user_type"];

        $sql = "UPDATE users SET username='$username', password='$password', email='$email', user_type='$user_type' WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            echo "<p>Account updated successfully. Redirecting...</p>";
            header("refresh:1;url=admin_home.php"); // Redirect after 1 seconds
            exit(); // Ensure no further code is executed
        } else {
            echo "<p>Error updating account: " . $conn->error . "</p>";
        }
    }

    // Close the database connection
    $conn->close();
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="hidden" name="id" value="<?php echo $id; ?>"> <!-- Hidden input to pass user ID -->

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo $username; ?>" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" value="<?php echo $password; ?>" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $email; ?>" required><br>

        <label for="user_type">User Type:</label>
        <select id="user_type" name="user_type" required>
            <option value="employee" <?php echo ($user_type == 'employee') ? 'selected' : ''; ?>>Employee</option>
            <option value="admin" <?php echo ($user_type == 'admin') ? 'selected' : ''; ?>>Admin</option>
        </select><br>

        <input type="submit" value="Update">
    </form>
</body>

</html>
