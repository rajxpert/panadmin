
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            background: url(./img/panbg.jpg);
            background-repeat: no-repeat;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 0;
    margin: 0;
    box-sizing: border-box;
        }
        .login-container {
            background-color:rgba(244, 244, 249, 0.94);
          
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 20%;
        }
        input {
            padding: 10px;
            margin: 10px 0;
            width: 93%;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2>User Login</h2>

        <!-- Display error message if login fails -->
        <?php
        if (isset($_GET['error'])) {
            echo '<p class="error">Invalid username or password.</p>';
        }
        ?>

        <form action="login.php" method="POST">
            <label for="username">User Email:</label>
            <input type="text" name="username" id="username" required>

            <label for="password">User Password:</label>
            <input type="password" name="password" id="password" required>

            <button type="submit">Login</button>
        </form>
    </div>

</body>
</html>
