<?php
if(!isset($_SESSION)){
    session_start();
}



$db=mysqli_connect('localhost','root','','proudct');
$error=array();

if(isset($_POST['signup'])){
    
// mysqli_real_escape_string make sure  that the string didnot lose any letter
$username=mysqli_real_escape_string($db,$_POST['name']);
$email=mysqli_real_escape_string($db,$_POST['email']);
$pass=mysqli_real_escape_string($db,$_POST['password']);


if(empty($username)){
     
    array_push($error,"username is required");
}

if(empty($email)){
          
    array_push($error,"Email is required");
}
if(empty($pass)){
       
    array_push($error,"password is required");
}

if(count($error)==0){
    // user is the name of table in the database that i want to insert the data into it
    // values is the name of variables i created here
    // (user_name,email,password) name of columns in the table
    $sql="INSERT INTO signup (name,email,password) values('$username','$email','$pass')";
    mysqli_query($db,$sql);
                   

}

}















?>