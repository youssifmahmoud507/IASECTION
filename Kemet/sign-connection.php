<?php

// Start session if not already started
if (!isset($_SESSION)) {
    session_start();
}

// متغير لتخزين معلومات التصحيح
$debug_info = array();

// Database connection
$db = mysqli_connect('localhost', 'root', '', 'proudct');
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize errors array
$errors = array();
$success_message = "";

// إنشاء جدول المستخدمين إذا لم يكن موجوداً
function ensure_tables_exist($db) {
    global $debug_info;
    
    // التحقق من وجود جدول users
    $check_users_table = mysqli_query($db, "SHOW TABLES LIKE 'users'");
    if (mysqli_num_rows($check_users_table) == 0) {
        // إنشاء جدول users
        $create_users_table = "CREATE TABLE users (
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        
        if (!mysqli_query($db, $create_users_table)) {
            $debug_info[] = "Error creating users table: " . mysqli_error($db);
            die("Error creating users table: " . mysqli_error($db));
        } else {
            $debug_info[] = "Table 'users' created successfully";
        }
    } else {
        $debug_info[] = "Table 'users' already exists";
    }
}

// التأكد من وجود الجداول المطلوبة
ensure_tables_exist($db);

// عرض بنية الجدول للتأكد من صحتها
$show_structure = mysqli_query($db, "DESCRIBE users");
if ($show_structure) {
    while ($row = mysqli_fetch_assoc($show_structure)) {
        $debug_info[] = "Field: " . $row['Field'] . ", Type: " . $row['Type'];
    }
} else {
    $debug_info[] = "Error getting table structure: " . mysqli_error($db);
}

// SIGNUP PROCESS
if (isset($_POST['signup'])) {
    $debug_info[] = "Signup form submitted";
    
    // Get form data and sanitize
    $username = mysqli_real_escape_string($db, $_POST['name']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $pass = mysqli_real_escape_string($db, $_POST['password']);
    
    $debug_info[] = "Form data: username=$username, email=$email";
    
    // التحقق من وجود حقل تأكيد كلمة المرور
    $pass2 = isset($_POST['confirm-password']) ? mysqli_real_escape_string($db, $_POST['confirm-password']) : '';

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

    $debug_info[] = "Validation errors count: " . count($errors);
    
    try {
        // Check if username or email already exists
        $user_check_query = "SELECT * FROM users WHERE email='$email' OR username='$username' LIMIT 1";
        $debug_info[] = "User check query: $user_check_query";
        
        $check_result = mysqli_query($db, $user_check_query);
        
        if (!$check_result) {
            $debug_info[] = "Error in user check query: " . mysqli_error($db);
            array_push($errors, "Database error: " . mysqli_error($db));
        } else {
            $debug_info[] = "User check result rows: " . mysqli_num_rows($check_result);
            
            if (mysqli_num_rows($check_result) > 0) {
                $existing_user = mysqli_fetch_assoc($check_result);
                if (isset($existing_user['username']) && $existing_user['username'] === $username) {
                    array_push($errors, "Username already exists");
                }
                if (isset($existing_user['email']) && $existing_user['email'] === $email) {
                    array_push($errors, "Email already exists");
                }
            }
        }

        // If no errors, save user to database
        if (count($errors) == 0) {
            $debug_info[] = "No errors, proceeding with insertion";
            
            // Hash password for security
            $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
            
            $sql = "INSERT INTO users (username, email, password, created_at) 
                   VALUES ('$username', '$email', '$hashed_password', NOW())";
            
            $debug_info[] = "Insert query: $sql";
            
            if (mysqli_query($db, $sql)) {
                $debug_info[] = "User inserted successfully! User ID: " . mysqli_insert_id($db);
                $success_message = "Registration successful! You can now log in.";
                // Redirect to login page
                header('Location: login.php');
                exit();
            } else {
                $error_message = mysqli_error($db);
                $debug_info[] = "Insert error: " . $error_message;
                array_push($errors, "Database error: " . $error_message);
            }
        }
    } catch (Exception $e) {
        $debug_info[] = "Exception: " . $e->getMessage();
        array_push($errors, "Error: " . $e->getMessage());
    }
}

// LOGIN PROCESS
if (isset($_POST['login'])) {
    $debug_info[] = "Login form submitted";
    
    // Get form data
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    
    $debug_info[] = "Login attempt for email: $email";

    // Form validation
    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    // Login if no errors
    if (count($errors) == 0) {
        try {
            // Get user from database
            $query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
            $debug_info[] = "Login query: $query";
            
            $result = mysqli_query($db, $query);
            
            if (!$result) {
                $debug_info[] = "Login query error: " . mysqli_error($db);
                array_push($errors, "Database error: " . mysqli_error($db));
            } else {
                $debug_info[] = "Result rows: " . mysqli_num_rows($result);
                
                if ($result && mysqli_num_rows($result) == 1) {
                    $user = mysqli_fetch_assoc($result);
                    $debug_info[] = "User found with ID: " . $user['id'];
                    
                    // Verify password
                    if (password_verify($password, $user['password'])) {
                        $debug_info[] = "Password verified successfully";
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
                        $debug_info[] = "Password verification failed";
                        array_push($errors, "Incorrect email or password");
                    }
                } else {
                    $debug_info[] = "No user found with this email";
                    array_push($errors, "Incorrect email or password");
                }
            }
        } catch (Exception $e) {
            $debug_info[] = "Login exception: " . $e->getMessage();
            array_push($errors, "Error: " . $e->getMessage());
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

// Save debug info to session for retrieval
$_SESSION['debug_info'] = $debug_info;
?>