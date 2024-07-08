<!DOCTYPE html>
<html>
<head>
    <title>Product Catalog</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            min-height: 100vh;
        }

        .card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin: 50px 0;
            padding: 0 20px;
            max-width: 1200px;
        }

        .card {
            background-color: #f0f0f0;
            border-radius: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            max-width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            transition: transform 0.3s ease;
            text-align: left;
            padding: 20px;
            position: relative;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card-content {
            width: 100%;
        }

        .card-content h2 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }

        .card-content p {
            margin: 5px 0;
            font-size: 18px;
            color: #666;
        }

        .card-content img {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .button-container {
            position: absolute;
            bottom: 20px;
            width: 100%;
            display: flex;
            justify-content: center;
        }

        .button-container a {
            text-decoration: none;
            color: white;
            padding: 8px 20px;
            border-radius: 20px;
            transition: background-color 0.3s ease;
            margin: 0 5px;
        }

        .button-container a:hover {
            background-color: #005f6b;
        }

        .delete-btn {
            background-color: #ff3333;
        }

        .bottom-button-container {
            margin-top: auto;
            padding: 20px;
        }

        .bottom-button-container a {
            text-decoration: none;
            background-color: #4CAF50;
            color: white;
            padding: 12px 30px;
            border-radius: 30px;
            transition: background-color 0.3s ease;
            font-size: 20px;
        }

        .bottom-button-container a:hover {
            background-color: #3e8e41;
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

        h1 {
            color: white;
        }
    </style>
</head>
<body>
    <?php
    session_start();
    if (!isset($_SESSION['username'])) {
        header("Location: index.php");
        exit();
    }
    ?>
    <a href="home.php" class="back-button">Back</a>
    <h1>Product Catalog</h1>
    <div class="card-container">
        <?php
        include('db.php');

        $sql = "SELECT id, name, category, price, stock, image FROM products";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id = $row["id"];
                $name = htmlspecialchars($row["name"]);
                $category = htmlspecialchars($row["category"]);
                $price = htmlspecialchars($row["price"]);
                $stock = htmlspecialchars($row["stock"]);
                $image = $row["image"];

                echo "<div class='card'>";
                echo "<div class='card-content'>";
                echo "<h2>$name</h2>";
                echo "<p>Category: $category</p>";
                echo "<p>Price: Rs.$price</p>";
                echo "<p>Stock: $stock</p>";
                echo "<img src='$image' alt='$name'>";
                echo "</div>";

                echo "<div class='button-container'>";
                echo "<a href='delete_product.php?id=$id' class='delete-btn'>Delete</a>";
                echo "</div>";

                echo "</div>";
            }
        } else {
            echo "<p>No products found</p>";
        }

        $conn->close();
        ?>
    </div>
    <div class="bottom-button-container">
        <a href="add_product.php">Add Product</a>
    </div>
</body>
</html>