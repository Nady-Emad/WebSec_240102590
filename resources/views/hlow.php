<?php
$name = "Welcome to WebSecService";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome Page</title>
    <style>
        body {
            background-color: #0f172a;
            color: white;
            text-align: center;
            font-family: Arial, sans-serif;
            margin-top: 100px;
        }

        .box {
            background: #1e293b;
            padding: 40px;
            border-radius: 10px;
            display: inline-block;
            box-shadow: 0 0 20px rgba(0,0,0,0.5);
        }

        h1 {
            color: #38bdf8;
        }
    </style>
</head>
<body>

    <div class="box">
        <h1><?php echo $name; ?></h1>
        <p>Laravel Environment is Running Successfully ✅</p>
        <p><?php echo "Today is: " . date("Y-m-d H:i:s"); ?></p>
    </div>

</body>
</html>