<!DOCTYPE html>
<html>

<head>
    <title>Add Product</title>
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
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 350px;
            margin-top: 50px;
        }

        .form-container h2 {
            margin: 0;
            padding-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .form-container label {
            display: block;
            text-align: left;
            margin: 10px 0 5px;
        }

        .form-container input,
        .form-container select {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .form-container .button-container {
            text-align: center;
        }

        .form-container .button-container input {
            text-decoration: none;
            background-color: #008CBA;
            color: white;
            padding: 10px 20px;
            border-radius: 20px;
            border: none;
            transition: background-color 0.3s ease;
        }

        .form-container .button-container input:hover {
            background-color: #005f6b;
        }

        .button-container {
            margin-top: 20px;
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
            font-size: 50px;
            padding-bottom: 40px;
        }
    </style>
</head>

<body>
    <a href="view_product.php" class="back-button">Back</a>
    <h1>Add Product</h1>
    <div class="form-container">
        <h2>Add New Product</h2>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Database connection
            include('db.php');

            $name = htmlspecialchars($_POST["name"]);
            $category = htmlspecialchars($_POST["category"]);
            $price = htmlspecialchars($_POST["price"]);

            // Validate price
            if ($price <= 0) {
                echo "<p>Price must be greater than zero.</p>";
            } else {
                // Image upload
                $target_dir = "uploads/";
                $target_file = $target_dir . basename($_FILES["image"]["name"]);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                // Check if image file is an actual image or fake image
                $check = getimagesize($_FILES["image"]["tmp_name"]);
                if ($check !== false) {
                    $uploadOk = 1;
                } else {
                    echo "<p>File is not an image.</p>";
                    $uploadOk = 0;
                }

                // Check if file already exists
                if (file_exists($target_file)) {
                    echo "<p>Sorry, file already exists.</p>";
                    $uploadOk = 0;
                }

                // Check file size
                if ($_FILES["image"]["size"] > 500000) {
                    echo "<p>Sorry, your file is too large.</p>";
                    $uploadOk = 0;
                }

                // Allow certain file formats
                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                    echo "<p>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</p>";
                    $uploadOk = 0;
                }

                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "<p>Sorry, your file was not uploaded.</p>";
                } else {
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                        echo "<p>The file " . htmlspecialchars(basename($_FILES["image"]["name"])) . " has been uploaded.</p>";

                        // Insert data into database
                        $stmt = $conn->prepare("INSERT INTO products (name, category, price, image) VALUES (?, ?, ?, ?)");
                        $stmt->bind_param("ssds", $name, $category, $price, $target_file);
                        if ($stmt->execute()) {
                            // Redirect to view_product.php after successful insertion
                            header("Location: view_product.php");
                            exit(); // Ensure no further code is executed
                        } else {
                            echo "<p>Error: " . $stmt->error . "</p>";
                        }

                        $stmt->close();
                    } else {
                        echo "<p>Sorry, there was an error uploading your file.</p>";
                    }
                }
            }

            $conn->close();
        }
        ?>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
            <label for="name">Product Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="category">Category:</label>
            <select id="category" name="category" required>
                <option value="fruits">Fruits</option>
                <option value="vegetables">Vegetables</option>
                <option value="meat">Meat</option>
                <option value="dairy">Dairy</option>
                <option value="processed_food">Processed Food</option>
                <option value="bakery">Bakery</option>
                <option value="beverages">Beverages</option>
                <option value="snacks">Snacks</option>
                <option value="seafood">Seafood</option>
                <option value="frozen_food">Frozen Food</option>
            </select>

            <label for="price">Price:</label>
            <input type="number" step="0.01" id="price" name="price" required>

            <label for="image">Product Image:</label>
            <input type="file" id="image" name="image" accept="image/*" required>

            <div class="button-container">
                <input type="submit" value="Add Product">
            </div>
        </form>
    </div>
</body>

</html>
