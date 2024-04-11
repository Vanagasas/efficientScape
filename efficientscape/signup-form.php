<?php
    include_once 'database.php';
    session_start();
    
    $error = array();
    $errorLogin = '';
    $active = 0;

    //Signup
    if(isset($_POST['signup-btn'])){
        $active = 1;
        if (empty($_POST['username'])){
            $error['username'] = 'Username is required';
        }
        if (! preg_match('/[a-z]/i', $_POST['password'])){
            $error['password'] = 'Password must contain at least one letter';
        }
        if (! preg_match('/[0-9]/i', $_POST['password'])){
            $error['password'] = 'Password must contain at least one number';
        }
        
        if (strlen($_POST['password']) < 7){
            $error['password'] = 'Password must contain at least 7 characters';
        }
        if ($_POST['password'] !== $_POST['repeat_password']){
            $error['password'] = 'Passwords does not match';
        }
        if (! filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            $error['email'] = 'Invalid Email';
        }
        $username = $_POST['username'];
        $checkUsername = "SELECT username FROM users WHERE username = '$username' LIMIT 1; ";
        $resultUsername = mysqli_query($conn, $checkUsername);
        $resultCheckUsername = mysqli_num_rows($resultUsername);
        $email = $_POST['email'];
        $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $checkEmail = "SELECT email FROM users WHERE email = '$email' LIMIT 1;";
        $resultEmail = mysqli_query($conn, $checkEmail);
        $resultCheckEmail = mysqli_num_rows($resultEmail);
        if ($resultCheckUsername > 0){
            $error['username'] = "Username already exists";
        }
        if ($resultCheckEmail > 0){
            $error['email'] = "Email already exists";
        }
        if (count($error) === 0){
            $sql = "INSERT INTO users ( username, password, email, privileges) 
                                VALUES ('$username', '$hashed_password', '$email', 0);";
            mysqli_query($conn, $sql);
            $getId = "SELECT userid FROM users WHERE username = '$username' LIMIT 1;";
            $resultId = mysqli_query($conn, $getId);
            $id = mysqli_fetch_assoc($resultId);
            $idVal = $id['userid'];
            InsertTable('study', $conn, $idVal);
            InsertTable('work', $conn, $idVal);
            InsertTable('health', $conn, $idVal);
            InsertTable('sport', $conn, $idVal);
            $_SESSION['cat'] = "study";
            $_SESSION['username'] = $username;
            $_SESSION['id'] = $idVal;
            $_SESSION['lvl'] = 0;
            header('Location: stats.php');
        }
    }
    function InsertTable($name, $conn, $idVal){
        $sql = "INSERT INTO $name (userid) VALUES ('$idVal');";
        mysqli_query($conn, $sql);
    }

    //login
    if (isset($_POST['login-btn'])){
        $active = 0;
        if (empty($_POST['username'])){
            $errorLogin = 'Username is required';
        }
        else if (! preg_match('/[a-z]/i', $_POST['password'])){
            $errorLogin = 'Password must contain at least one letter';
        }
        else if (! preg_match('/[0-9]/i', $_POST['password'])){
            $errorLogin = 'Password must contain at least one number';
        }
        
        else if (strlen($_POST['password']) < 7){
            $errorLogin = 'Password must contain at least 7 characters';
        }
        else{
            $username = $_POST['username'];
            $checkUsername = "SELECT username FROM users WHERE username = '$username' LIMIT 1; ";
            $resultUsername = mysqli_query($conn, $checkUsername);
            $resultCheckUsername = mysqli_num_rows($resultUsername);
            $password = $_POST['password'];
            $checkPassword = "SELECT * FROM users WHERE username = '$username' LIMIT 1;";
            $resultPassword = mysqli_query($conn, $checkPassword);
            $resultCheckPassword = mysqli_fetch_array($resultPassword, MYSQLI_ASSOC);
            $getId = "SELECT userid FROM users WHERE username = '$username' LIMIT 1;";
            $resultId = mysqli_query($conn, $getId);
            $id = mysqli_fetch_assoc($resultId);
            $idVal = $id['userid'];
            if ($resultCheckPassword){
                if (password_verify($password, $resultCheckPassword['password'])){
                    $_SESSION['username'] = $username;
                    $_SESSION['id']= $idVal;
                    $_SESSION['cat'] = "study";
                    $_SESSION['lvl'] = 0;
                    header('Location: stats.php');
                }
                else{
                    $errorLogin = "Incorrect credentials";
                }
            }
            else{
                $errorLogin = "Incorrect credentials";
            }
        }
    }
?>