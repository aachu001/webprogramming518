<?php
require_once 'sendemail.php';
session_start();

// initializing variables
$username = "";
$fn = "";
$country = "";
$email    = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'admin', 'monarchs', 'm2');

if (isset($_POST['reg_user'])) {
    if (empty($_POST['username'])) {
        $errors['username'] = 'Username required';
    }
    if (empty($_POST['email'])) {
        $errors['email'] = 'Email required';
    }
    if (empty($_POST['password_1'])) {
        $errors['password'] = 'Password required';
    }
    if (empty($_POST['fn'])) { 
      array_push($errors, "Firstname is required"); 
    }
    if ($_POST['password_1'] != $_POST['password_2']) {
      array_push($errors, "The two passwords do not match");
    }
    if (empty($_POST['country'])) { 
      array_push($errors, "Country is required"); 
    }


    $username = $_POST['username'];
    $fn = $_POST['fn'];
    $country = $_POST['country'];
    $email = $_POST['email'];
    $token = bin2hex(random_bytes(50)); // generate unique token
    $password = password_hash($_POST['password_1'], PASSWORD_DEFAULT); //encrypt password

    // Check if email already exists
    $sql = "SELECT * FROM users WHERE email='$email' LIMIT 1";  
    $result = mysqli_query($db, $sql);
    if (mysqli_num_rows($result) > 0) {
        $errors['email'] = "Email already exists";
    }

    if (count($errors) === 0) {
        $query = "INSERT INTO users SET username=?, firstname=?,country=?,email=?, token=?, password=?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('ssssss', $username, $fn, $country ,$email, $token, $password);
        $result = $stmt->execute();

        if ($result) {
            $user_id = $stmt->insert_id;
            $stmt->close();

            // TO DO: send verification email to user
            sendVerificationEmail($email, $token);

            $_SESSION['id'] = $user_id;
            $_SESSION['username'] = $username;
            $_SESSION['fn'] = $fn;
            $_SESSION['country'] = $country;
            $_SESSION['email'] = $email;
            $_SESSION['verified'] = false;
            $_SESSION['message'] = 'You are logged in!';
            $_SESSION['type'] = 'alert-success';
            echo "please verify your email";
            header('location: login.php');
        } else {
            $_SESSION['error_msg'] = "Database error: Could not register user";
        }
    }
}


// REGISTER USER
if (isset($_POST['reg1_user'])) {
  // receive all input values from the form
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $fn = mysqli_real_escape_string($db, $_POST['fn']);
  $country = mysqli_real_escape_string($db, $_POST['country']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
  $token = bin2hex(random_bytes(50));

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($fn)) { array_push($errors, "Firstname is required"); }
  if (empty($country)) { array_push($errors, "Country is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['username'] === $username) {
      array_push($errors, "Username already exists");
    }

    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) === 0) {
        $query = "INSERT INTO users SET username=?, email=?, token=?, password=?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('ssss', $username, $email, $token, $password);
        $result = $stmt->execute();

        if ($result) {
            $user_id = $stmt->insert_id;
            $stmt->close();

            // TO DO: send verification email to user
            sendVerificationEmail($email, $token);

            $_SESSION['id'] = $user_id;
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['verified'] = false;
            $_SESSION['message'] = 'You are logged in!';
            $_SESSION['type'] = 'alert-success';
            header('location: login.php');
        } else {
            $_SESSION['error_msg'] = "Database error: Could not register user";
        }
    }
}

if (isset($_POST['login_user'])) {
    if (empty($_POST['username'])) {
        $errors['username'] = 'Username or email required';
    }
    if (empty($_POST['password'])) {
        $errors['password'] = 'Password required';
    }
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (count($errors) === 0) {
        $query = "SELECT * FROM users WHERE username=? OR email=? LIMIT 1";
        $stmt = $db->prepare($query);
        $stmt->bind_param('ss', $username, $password);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) { // if password matches
                $stmt->close();

                $_SESSION['id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['verified'] = $user['verified'];
                $_SESSION['message'] = 'You are logged in!';
                $_SESSION['type'] = 'alert-success';
                header('location: index1.php');
                exit(0);
            } else { // if password does not match
                $errors['login_fail'] = "Wrong username / password";
            }
        } else {
            $_SESSION['message'] = "Database error. Login failed!";
            $_SESSION['type'] = "alert-danger";
        }
    }
}

if (isset($_POST['resetpass_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($email)) { array_push($errors, "password is required"); }
  if (empty($password_1)) { array_push($errors, "new password is required"); }
  if (empty($password_2)) { array_push($errors, "confirm Password is required"); }
  if ($password_1 != $password_2) {
  array_push($errors, "The two passwords do not match");
  }

  if (count($errors) == 0) {
    $result = mysqli_query($db, "SELECT * from users WHERE username='$username' AND email='$email'");
    $row = mysqli_fetch_array($result);
    if($username=$row["username"]){
        mysqli_query($db, "UPDATE users set password='$password_1' WHERE username='$username'");
        header('location: index.php');
    }
  }
  else
       array_push($errors, "Wrong  combination please check");
}

if (isset($_POST['changepass_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($password)) { array_push($errors, "password is required"); }
  if (empty($password_1)) { array_push($errors, "new password is required"); }
  if (empty($password_2)) { array_push($errors, "confirm Password is required"); }
  if ($password_1 != $password_2) {
  array_push($errors, "The two passwords do not match");
  }

  if (count($errors) == 0) {
    $result = mysqli_query($db, "SELECT * from users WHERE username='$username'");
    $row = mysqli_fetch_array($result);
    if ($password == $row["password"]) {
        mysqli_query($db, "UPDATE users set password='$password_1' WHERE username='$username'");
        header('location: logout.php');
    } else
       array_push($errors, "Wrong  combination please check");
}

  
}


if (isset($_POST['updateinfo_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);
  $firstname = mysqli_real_escape_string($db, $_POST['fn']);
  $country = mysqli_real_escape_string($db, $_POST['country']);

  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($password)) { array_push($errors, "password is required"); }
  if (empty($firstname)) { array_push($errors, "firstname  is required"); }
  if (empty($country)) { array_push($errors, "country is required"); }
  

  if (count($errors) == 0) {
    $result = mysqli_query($db, "SELECT * from users WHERE username='$username'");
    $row = mysqli_fetch_array($result);
    if ($password == $row["password"]) {
        mysqli_query($db, "UPDATE users set firstname='$firstname' , country='$country' WHERE username='$username'");
        header('location: logout.php');
    } else
       array_push($errors, "Wrong  combination please check");
}

  
}


?>
