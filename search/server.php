<?php
session_start();

// initializing variables
$username = "";
$fn = "";
$country = "";
$email    = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'admin', 'monarchs', 'se');

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $fn = mysqli_real_escape_string($db, $_POST['fn']);
  $country = mysqli_real_escape_string($db, $_POST['country']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

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
  if (count($errors) == 0) {
//encrypt the password before saving in the database

  	$query = "INSERT INTO users (username,email,firstname,country,password) 
  			  VALUES('$username', '$email','$fn', '$country', '$password_1')";
  	mysqli_query($db, $query);
  	header('location: index.php');
  }
}

if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if (empty($username)) {
    array_push($errors, "Username is required");
  }
  if (empty($password)) {
    array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
    
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $results = mysqli_query($db, $query);
    if (mysqli_num_rows($results) == 1) {
      $_SESSION['username'] = $username;
      $_SESSION['success'] = "You are now logged in";
      header('location: login1.php');
    }else {
      array_push($errors, "Wrong username/password combination");
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
