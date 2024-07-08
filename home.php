<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
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
        .logout-button {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #f44336;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 20px;
            transition: background-color 0.3s ease;
            cursor: pointer;
            text-decoration: none;
        }
        .logout-button:hover {
            background-color: #d32f2f;
        }
        .card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 100px;
        }
        .card {
            background-color: #ffffff;
            border-radius: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            width: 350px;
            height: 250px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
            overflow: hidden;
            position: relative;
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        }
        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 140, 186, 0.1);
            transition: background 0.3s ease;
            z-index: 1;
        }
        .card:hover::before {
            background: rgba(0, 140, 186, 0.2);
        }
        .card-content {
            padding: 20px;
            text-align: center;
            z-index: 2;
        }
        .card-content h1 {
            margin: 0;
            font-size: 24px;
            color: #008CBA;
        }
        .button-container {
            margin-top: 20px;
        }
        .button-container a {
            text-decoration: none;
            background-color: #008CBA;
            color: white;
            padding: 10px 20px;
            border-radius: 20px;
            transition: background-color 0.3s ease;
        }
        .button-container a:hover {
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
    <?php
    session_start();
    if (!isset($_SESSION['username'])) {
        header("Location: index.php");
        exit();
    }
    ?>
    <h1>Dashboard</h1>
    <a href="logout.php" class="logout-button">Logout</a>
    <div class="card-container">
        <div class="card" onclick="window.location.href='view_product.php'">
            <div class="card-content">
                <h1>Products</h1>
                <div class="button-container">
                    <a href="view_product.php">View Products</a>
                </div>
            </div>
        </div>
        <div class="card" onclick="window.location.href='generate_bill.php'">
            <div class="card-content">
                <h1>Bills and Payments</h1>
                <div class="button-container">
                    <a href="generate_bill.php">Generate Bill</a>
                </div>
            </div>
        </div>
        <div class="card" onclick="window.location.href='addcustomerdetail.php'">
            <div class="card-content">
                <h1>Membership Details</h1>
                <div class="button-container">
                    <a href="addcustomerdetail.php">Add Customer Detail</a>
                </div>
            </div>
        </div>
        <div class="card" onclick="window.location.href='stock.php'">
            <div class="card-content">
                <h1>Stock</h1>
                <div class="button-container">
                    <a href="stock.php">View Stock</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>