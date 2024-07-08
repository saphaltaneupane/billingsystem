<!DOCTYPE html>
<html>

<head>
    <title>Update Products</title>
</head>

<body>
    <h1>Update Products</h1>
    <?php
    // Start the session
    session_start();

    // Check if the user is an employee
    if ($_SESSION["user_type"] != "employee") {
        echo "<p>Access denied. Only employees can access this page.</p>";
        exit;
    }

    // Database connection
    // ... (same as the previous code)

    // Update product
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $productId = $_POST["product_id"];
        $name = $_POST["name"];
        $price = $_POST["price"];
        $quantity = $_POST["quantity"];

        $sql = "UPDATE products SET name='$name', price='$price', quantity='$quantity' WHERE id='$productId'";
        if ($conn->query($sql) === TRUE) {
            echo "<p>Product updated successfully</p>";
        } else {
            echo "<p>Error updating product: " . $conn->error . "</p>";
        }
    }

    // Display products
    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table><tr><th>Product ID</th><th>Name</th><th>Price</th><th>Quantity</th><th>Action</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["id"] . "</td><td>" . $row["name"] . "</td><td>" . $row["price"] . "</td><td>" . $row["quantity"] . "</td><td><a href='update_product.php?id=" . $row["id"] . "'>Update</a></td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No products found</p>";
    }

    // Close the database connection
    $conn->close();
    ?>
    <h2>Update Product</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="product_id">Product ID:</label>
        <input type="text" id="product_id" name="product_id" required><br>

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="price">Price:</label>
        <input type="number" step="0.01" id="price" name="price" required><br>

        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" required><br>

        <input type="submit" value="Update Product">
    </form>
</body>

</html>