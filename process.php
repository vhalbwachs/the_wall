<?php
session_start();
require_once('conn.php');

function logout()
{
        $_SESSION = array();
        session_destroy();
        header("Location: index.php");
}

function register($conn, $post)
{
        foreach ($post as $name => $value) 
        {
                if(empty($value))
                {
                        $_SESSION['error'][$name] = "Sorry, " . $name . " cannot be blank";
                }
                else
                {
                        switch ($name) {
                                case 'first_name':
                                case 'last_name':
                                        if(is_numeric($value))
                                        {
                                                $_SESSION['error'][$name] = $name . ' cannot contain numbers';
                                        }
                                break;
                                case 'email': //TODO: need to check for duplicate emails
                                        if(!filter_var($value, FILTER_VALIDATE_EMAIL))
                                        {
                                                $_SESSION['error'][$name] = $name . ' is not a valid email';
                                        }
                                break;
                                case 'password':
                                        $password = $value;
                                        if(strlen($value) < 5)
                                        {
                                                $_SESSION['error'][$name] = $name . ' must be greater than 5 characters';
                                        }
                                break;
                                case 'confirm_password':
                                        if($password != $value)
                                        {
                                                $_SESSION['error'][$name] = 'Passwords do not match';
                                        }
                                break;
                        }
                }        
        }

        if(!isset($_SESSION['error']))
        {
                $_SESSION['success_message'] = "Congratulations you are now a member!";

                $salt = bin2hex(openssl_random_pseudo_bytes(22)); 
                $hash = crypt($post['password'], $salt);

                $query = "INSERT INTO users (first_name, last_name, email, password, created_at, updated_at)
                                  VALUES('".$post['first_name']."', '".$post['last_name']."', '".$post['email']."', '".$hash."', NOW(), NOW())";
                mysqli_query($conn, $query);

                $user_id = mysqli_insert_id($conn);
                $_SESSION['user_id'] = $user_id;
                // $_SESSION['full_name'] = $full_name;
                $_SESSION['first_name'] = $post['first_name'];
                $_SESSION['last_name'] = $post['last_name'];
                $_SESSION['email'] = $post['email'];
                header('Location: messages.php');
                exit;

        }
}

function login($conn, $post)
{
        if(empty($post['email']) || empty($post['password']))
        {
                $_SESSION['error']['message'] = "Email or Password cannot be blank";
        }
        else
        {
                $query = "SELECT id, password, first_name, last_name, email
                                  FROM users
                                  WHERE email = '".$post['email']."'";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($result);

                if(empty($row))
                {
                        $_SESSION['error']['message'] = 'Could not find Email in database';
                }
                else
                {
                        if(crypt($post['password'], $row['password']) != $row['password'])
                        {
                                $_SESSION['error']['message'] = 'Incorrect Password';
                        }
                        else
                        {
                            $full_name = $row['first_name'].' '.$row['last_name'];
                            $_SESSION['user_id'] = $row['id'];
                            $_SESSION['full_name'] = $full_name;
                            $_SESSION['first_name'] = $row['first_name'];
                            $_SESSION['last_name'] = $row['last_name'];
                            $_SESSION['email'] = $row['email'];
                            header('Location: messages.php');
                            exit;
                        }
                }
        }
        header('Location: login.php');
        exit;
}

function post_message($conn, $post)
{
    $query = "INSERT INTO messages (users_id, message, created_at, updated_at) VALUES ('".$_SESSION['user_id']."','".$_POST['wall_message']."', NOW(), NOW())";
    mysqli_query($conn, $query);
    header('Location: messages.php');
}

function post_comment($conn, $post)
{
    $query = "INSERT INTO comments (messages_id, users_id, comment, created_at, updated_at) VALUES ('".$_POST['message_id']."','".$_SESSION['user_id']."','".$_POST['comment']."', now(), now())";
    mysqli_query($conn, $query);
    header('Location: messages.php');
}

if(isset($_POST['action']) && $_POST['action'] == 'register')
{
    register($conn, $_POST);
}
else if(isset($_POST['action']) && $_POST['action'] == 'login')
{
    login($conn, $_POST);
}
else if(isset($_POST['action']) && $_POST['action'] == 'message')
{
    post_message($conn, $_POST);
}
else if(isset($_POST['action']) && $_POST['action'] == 'post_comment')
{
    post_comment($conn, $_POST);
}
else if(isset($_GET['logout']))
{
    logout();
}
// var_dump($_POST)
// header('Location: index.php');

?>