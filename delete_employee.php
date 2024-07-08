<!DOCTYPE html>
<html>

<head>
    <title>Delete/Update Employee</title>
</head>

<body>
    <h1>Delete/Update Employee</h1>
    <?php
    // Start the session
    session_start();

    // Check if the user is an admin
    if ($_SESSION["user_type"] != "admin") {
        echo "<p>Access denied. Only admins can access this page.</p>";
        exit;
    }

    // Database connection
    include('db.php');

    // Delete employee
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $employeeId = $_POST["employee_id"];
        $sql = "DELETE FROM employees WHERE id='$employeeId'";
        if ($conn->query($sql) === TRUE) {
            echo "<p>Employee deleted successfully</p>";
        } else {
            echo "<p>Error deleting employee: " . $conn->error . "</p>";
        }
    }

    // Update employee
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $employeeId = $_POST["employee_id"];
        $name = $_POST["name"];
        $email = $_POST["email"];
        // ... (add other fields as needed)

        $sql = "UPDATE employees SET name='$name', email='$email' WHERE id='$employeeId'";
        if ($conn->query($sql) === TRUE) {
            echo "<p>Employee updated successfully</p>";
        } else {
            echo "<p>Error updating employee: " . $conn->error . "</p>";
        }
    }

    // Display employees
    $sql = "SELECT * FROM employees";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table><tr><th>ID</th><th>Name</th><th>Email</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["id"] . "</td><td>" . $row["name"] . "</td><td>" . $row["email"] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No employees found</p>";
    }

    // Close the database connection
    $conn->close();
    ?>
</body>

</html>