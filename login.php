<?php
session_start();

?>
<!doctype html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <title>Login</title>
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
</head>
<body>
        <?php
        if(isset($_SESSION['error']))
        {
                ?>
                <p><?= $_SESSION['error']['message'] ?></p>
                <?php
        }

        ?>
        <div class="container">
        <h1>Login</h1>
        <form action="process.php" method="post">
                <input type="hidden" name="action" value="login">
                <input type="text" name="email" placeholder="Enter Email">
                <input type="password" name="password" placeholder="Password">
                <input type="submit" value="Login">
        </form>
        <p>Not registered? <a href="index.php">Sign up here</a></p>
        </div>
</body>
</html>