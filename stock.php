<!DOCTYPE html>
<html>
<head>
    <title>Manage Stock</title>
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

        .card-content form {
            margin-top: 10px;
        }

        .card-content input[type="number"] {
            width: 60px;
            padding: 5px;
        }

        .card-content input[type="submit"] {
            background-color: #008CBA;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 15px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .card-content input[type="submit"]:hover {
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

    include('db.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST['id'];
        $new_stock = $_POST['stock'];

        $update_sql = "UPDATE products SET stock = ? WHERE id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("ii", $new_stock, $id);
        $stmt->execute();
        $stmt->close();
    }
    ?>

    <a href="home.php" class="back-button">Back</a>
    <h1>Manage Stock</h1>
    <div class="card-container">
        <?php
        $sql = "SELECT id, name, category, price, stock FROM products";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id = $row["id"];
                $name = htmlspecialchars($row["name"]);
                $category = htmlspecialchars($row["category"]);
                $price = htmlspecialchars($row["price"]);
                $stock = htmlspecialchars($row["stock"]);

                echo "<div class='card'>";
                echo "<div class='card-content'>";
                echo "<h2>$name</h2>";
                echo "<p>Category: $category</p>";
                echo "<p>Price: Rs.$price</p>";
                echo "<form method='post' action=''>";
                echo "<input type='hidden' name='id' value='$id'>";
                echo "<label for='stock'>Stock:</label>";
                echo "<input type='number' name='stock' value='$stock' min='0'>";
                echo "<input type='submit' value='Update'>";
                echo "</form>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p>No products found</p>";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>