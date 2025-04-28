<?php

if(!isset($_SESSION)){
    session_start();
}

$db= mysqli_connect('localhost', 'root', '', 'proudct');

$error= array();

if(isset($_POST['register'])){
    $email= mysqli_real_escape_string($db, $_POST['em']);
    $password= mysqli_real_escape_string($db, $_POST['pas']);
}

if(empty($email)){
    array_push($error, 'PLEASE ENTER YOUR EMAIL');
}<?php
if(isset($_POST['register'])){
    $email = mysqli_real_escape_string($db, $_POST['em']);
    $password = mysqli_real_escape_string($db, $_POST['pas']);
    
    if(empty($email)){
        array_push($error, 'PLEASE ENTER YOUR EMAIL');
    }
    if(empty($password)){
        array_push($error, 'PLEASE ENTER THE PASSWORD');
    }
    
    if(count($error) == 0){
        $query = "SELECT * FROM signup WHERE email='$email' AND password='$password'";
        $result = mysqli_query($db, $query);
        
        if(mysqli_num_rows($result) == 1){
            $user_data = mysqli_fetch_assoc($result);
            $_SESSION['username'] = $user_data['name'];
            $_SESSION['success'] = 'welcome!';
            header('location: home page.html');
            exit();
        } else {
            array_push($error, "Wrong email or password");
        }
    }
}
?>

if(empty($password)){
    array_push($error, 'PLEASE ENTER THE PASSWORD');
}

if(count($error)== 0){
    $query= "SELECT * FROM login WHERE email= '$email' AND password= '$password'";
    $result= mysqli_query($db, $query);
}

if(mysqli_num_rows($result)== 1){
    $_SESSION['username']= $email;
    $_SESSION['success']= 'welcome!';
    header('location: index.php');
}

?>