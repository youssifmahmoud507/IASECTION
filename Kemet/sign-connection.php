<?php
// Start session if not already started
if (!isset($_SESSION)) {
    session_start();
}

// Database connection
$db = mysqli_connect('localhost', 'root', '', 'proudct');
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize errors array
$errors = array();
$success_message = "";

// SIGNUP PROCESS
if (isset($_POST['signup'])) {
    // Get form data and sanitize
    $username = mysqli_real_escape_string($db, $_POST['name']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $pass = mysqli_real_escape_string($db, $_POST['password']);
    $pass2 = mysqli_real_escape_string($db, $_POST['confirm-password']);

    // Form validation
    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($email)) {
        array_push($errors, "Email is required");
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Invalid email format");
    }
    if (empty($pass)) {
        array_push($errors, "Password is required");
    } elseif (strlen($pass) < 6) {
        array_push($errors, "Password must be at least 6 characters");
    }
    if ($pass2 != $pass) {
        array_push($errors, "Passwords do not match");
    }

    // Check if username or email already exists
    $user_check_query = "SELECT * FROM users WHERE email='$email' OR username='$username' LIMIT 1";
    $check_result = mysqli_query($db, $user_check_query);
    
    if (mysqli_num_rows($check_result) > 0) {
        $existing_user = mysqli_fetch_assoc($check_result);
        if ($existing_user['username'] === $username) {
            array_push($errors, "Username already exists");
        }
        if ($existing_user['email'] === $email) {
            array_push($errors, "Email already exists");
        }
    }

    // If no errors, save user to database
    if (count($errors) == 0) {
        // Hash password for security
        $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO users (username, email, password, created_at) 
                VALUES ('$username', '$email', '$hashed_password', NOW())";
        
        if (mysqli_query($db, $sql)) {
            $success_message = "Registration successful! You can now log in.";
            // Redirect to login page
            header('Location: login.php');
            exit();
        } else {
            array_push($errors, "Database error: " . mysqli_error($db));
        }
    }
}

// LOGIN PROCESS
if (isset($_POST['login'])) {
    // Get form data
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    // Form validation
    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    // Login if no errors
    if (count($errors) == 0) {
        // Get user from database
        $query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
        $result = mysqli_query($db, $query);
        
        if ($result && mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Password is correct, create session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['logged_in'] = true;
                $_SESSION['success'] = "Welcome back, " . $user['username'] . "!";
                
                // Redirect to home page
                header('Location: index.php');
                exit();
            } else {
                array_push($errors, "Incorrect email or password");
            }
        } else {
            array_push($errors, "Incorrect email or password");
        }
    }
}

// LOGOUT PROCESS
if (isset($_GET['logout'])) {
    // Destroy session
    session_destroy();
    $_SESSION = array();
    
    // Redirect to login page
    header('Location: login.php');
    exit();
}
?>