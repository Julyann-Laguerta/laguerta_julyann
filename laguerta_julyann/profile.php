<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            max-width: 500px;
            margin: 60px auto;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            text-align: center;
            padding: 30px;
            border-top: 8px solid maroon;
        }
        h1 {
            color: maroon;
            margin-bottom: 20px;
        }
        .name {
            font-size: 1.4em;
            font-weight: bold;
            color: #550000;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>My Profile</h1>
        <div class="name">
            <?php
            echo htmlspecialchars($fname . ' ' . $lname);
            ?>
        </div>
    </div>
</body>
</html>
