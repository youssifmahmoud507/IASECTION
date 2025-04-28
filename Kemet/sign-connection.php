<?php
if(!isset($_SESSION)){
    session_start();
}
$db = mysqli_connect('localhost', 'root', '', 'proudct');
if (!$db) {
    die(" error in database Connection  " . mysqli_connect_error());
}
$error = array();

if(isset($_POST['signup'])){
    
//  make sure  that the string didnot lose any letter
$username=mysqli_real_escape_string($db,$_POST['name']);
$email=mysqli_real_escape_string($db,$_POST['email']);
$pass=mysqli_real_escape_string($db,$_POST['password']);
$pass2=mysqli_real_escape_string($db,$_POST['confirm-Password']);

if(empty($username)){
     
    array_push($error,"username is required");
}

if(empty($email)){
          
    array_push($error,"Email is required");
}
if(empty($pass)){
       
    array_push($error,"password is required");
}
if(empty($pass2!=$pass)){
    array_push($error,"passwords do not match");
}

if(count($error)==0){
    // user is the name of table in the database that i want to insert the data into it
    // values is the name of variables i created here
    // (user_name,email,password) name of columns in the table
    $sql="INSERT INTO signup (name,email,password) values('$username','$email','$pass')";
    mysqli_query($db,$sql);
                   

}


///login

if(isset($_POST['register'])){
    $email= mysqli_real_escape_string($db, $_POST['em']);
    $password= mysqli_real_escape_string($db, $_POST['pas']);
}

if(empty($email)){
    array_push($error, 'PLEASE ENTER YOUR EMAIL');
}

if(empty($password)){
    array_push($error, 'PLEASE ENTER THE PASSWORD');
}

if(count($error)== 0){
    $query= "SELECT * FROM signup WHERE email= '$email' AND password= '$password'";
    $result= mysqli_query($db, $query);
    if(mysqli_num_rows($result==1)){
        $_SESSION['name']=$username;
        $_SESSION['success']="Welcome !";
    }
    else{
        array_push($error,"wrong email or password");
    }
}

// if ($result && mysqli_num_rows($result) == 1) {
//     $row = mysqli_fetch_assoc($result);
//     // Continue login logic
// } else {
//     array_push($errors, "Wrong email or password.");
// }



}















?>