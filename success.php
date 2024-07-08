<!DOCTYPE html>
<html>

<head>
    <title>Success</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .success-container {
            text-align: center;
        }

        .success-message {
            font-size: 24px;
            color: #4CAF50;
        }

        .checkmark {
            font-size: 100px;
            color: #4CAF50;
        }
    </style>
    <script>
        // Redirect to home.php after 2 seconds
        setTimeout(function() {
            window.location.href = 'home.php';
        }, 2000);
    </script>
</head>

<body>
    <div class="success-container">
        <div class="checkmark">&#10004;</div>
        <div class="success-message">Successfully registered!</div>
    </div>
</body>

</html>