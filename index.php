<?php
session_start();
$_SESSION = array();
?>
<!doctype html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <title>The Wall</title>
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <?php
        if(isset($_SESSION['error']))
        {
                foreach($_SESSION['error'] as $name => $message)
                {
                       ?> <p> <?php echo $message.'t' ?></p>
                        <?php
                }
        }
        elseif(isset($_SESSION['success_message']))
        {
                ?>
                <p><?=$_SESSION['success_message'] ?></p>
                <?php
        }
        ?>
        <h1>Register for the wall!</h1>
        <form class="form" action="process.php" method="post" enctype="multipart/form-data">
                <div class="form-group"><input type="hidden" name="action" value="register"></div>
                <div class="form-group"><input type="text" name="first_name" placeholder="Enter First Name"></div>
                <div class="form-group"><input type="text" name="last_name" placeholder="Enter Last Name"></div>
                <div class="form-group"><input type="text" name="email" placeholder="Enter Email"></div>
                <div class="form-group"><input type="password" name="password" placeholder="Password"></div>
                <div class="form-group"><input type="password" name="confirm_password" placeholder="Confirm Password"></div>
                <div class="form-group"><input type="submit" value="Register"></div>
        </form>
        <p>Or if you're already registered, <a href="login.php"> login here</a></p>
</div>
</body>
</html>
<?php
$_SESSION = array();
?>


    </div>