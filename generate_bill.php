<!DOCTYPE html>
<html>

<head>
    <title>Generate Bill</title>
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

        .bill-container {
            background-color: #f0f0f0;
            border-radius: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 800px;
            padding: 20px;
            margin-top: 50px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        h1 {
            color: white;
            font-size: 50px;
            padding-bottom: 40px;
        }

        form {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .membership-container {
            width: 100%;
            display: flex;
            justify-content: flex-start;
            align-items: center;
            margin-bottom: 20px;
        }

        .membership-container label {
            font-weight: bold;
            margin-right: 10px;
        }

        .membership-container select {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #008CBA;
            color: white;
        }

        .total {
            font-size: 24px;
            font-weight: bold;
            text-align: right;
            padding: 20px 0;
        }

        .button-container {
            margin-top: 20px;
            text-align: center;
            width: 100%;
        }

        .button-container button {
            text-decoration: none;
            background-color: #008CBA;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 20px;
            transition: background-color 0.3s ease;
            cursor: pointer;
        }

        .button-container button:hover {
            background-color: #005f6b;
        }

        .payment-option-container {
            margin-top: 20px;
            text-align: left;
            width: 100%;
        }

        .payment-option-container label {
            margin-right: 10px;
        }

        .payment-option-container p {
            text-align: left;
            margin-bottom: 10px;
            margin-left: 20px;
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
    </style>
</head>

<body>
    <?php
    session_start();
    if (!isset($_SESSION['username'])) {
        header("Location: index.php");
        exit();
    }

    // Database connection
    include('db.php');
    ?>

    <a href="home.php" class="back-button">Back</a>
    <h1>Generate Bill</h1>
    <div class="bill-container">
        <form action="download_bill.php" method="post">
            <div class="membership-container">
                <label for="membershipno">Membership No. (Optional):</label>
                <select id="membershipno" name="membershipno">
                    <option value="">Select Membership No.</option>
                    <?php
                    // Fetch membership numbers from the customers table
                    $sql = "SELECT DISTINCT membershipno FROM customers";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $membershipno = $row["membershipno"];
                            echo "<option value='$membershipno'>$membershipno</option>";
                        }
                    }
                    ?>
                </select>
            </div>

            <table>
                <tr>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Select</th>
                </tr>
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
                        $quantity = 0; 
                        $total = $price * $quantity;

                        echo "<tr class='product-row'>";
                        echo "<td>$name</td>";
                        echo "<td>$category</td>";
                        echo "<td class='price'>Rs. $price</td>";
                        echo "<td class='stock'>$stock</td>";
                        echo "<td><input type='number' name='quantity[$id]' value='$quantity' min='0' max='$stock' class='quantity-input' oninput='updateTotal()'></td>";
                        echo "<td class='total-cell'>Rs. $total</td>";
                        echo "<td><input type='checkbox' name='selected_products[]' value='$id' onchange='updateTotal()'></td>";
                        echo "</tr>";
                    }

                    echo "<tr>";
                    echo "<td colspan='5' class='total'>Total Amount:</td>";
                    echo "<td class='total' id='total-amount'>Rs. 0.00</td>";
                    echo "<td></td>";
                    echo "</tr>";
                } else {
                    echo "<tr><td colspan='7'><p>No products found</p></td></tr>";
                }

               
                $conn->close();
                ?>
            </table>
            <div class="payment-option-container">
                <p>Mode of Payment</p>
                <label><input type="radio" name="payment_option" value="esewa" required> eSewa</label>
                <label><input type="radio" name="payment_option" value="khalti" required> Khalti</label>
                <label><input type="radio" name="payment_option" value="cash" required> Cash</label>
            </div>
            <div class="button-container">
                <button type="submit">Download Bill</button>
            </div>
            <div class="button-container">
                <button type="submit" formaction="save_bill.php">Save Bill</button>
            </div>
        </form>
    </div>
    <script>
        function updateTotal() {
            let totalAmount = 0;
            document.querySelectorAll('tr.product-row').forEach(function(row) {
                const quantityInput = row.querySelector('.quantity-input');
                const price = parseFloat(row.querySelector('.price').textContent.replace('Rs. ', ''));
                const totalCell = row.querySelector('.total-cell');
                const checkbox = row.querySelector('input[type="checkbox"]');
                const stock = parseInt(row.querySelector('.stock').textContent);

                if (checkbox.checked) {
                    let quantity = parseInt(quantityInput.value);
                    if (!isNaN(quantity) && quantity > 0) {
                        if (quantity > stock) {
                            quantity = stock;
                            quantityInput.value = stock;
                        }
                        const total = price * quantity;
                        totalCell.textContent = 'Rs. ' + total.toFixed(2);
                        totalAmount += total;
                    } else {
                        totalCell.textContent = 'Rs. 0.00';
                    }
                } else {
                    totalCell.textContent = 'Rs. 0.00';
                }
            });

            document.getElementById('total-amount').textContent = 'Rs. ' + totalAmount.toFixed(2);
        }
    </script>
</body>

</html>