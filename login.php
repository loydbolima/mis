<?php
// Start the session
session_start();

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Get the submitted username and password
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Connect to the database
  $host = 'localhost';
  $user = 'username';
  $pass = 'password';
  $db = 'database_name';
  $conn = mysqli_connect($host, $user, $pass, $db);

  // Check if the connection was successful
  if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
  }

  // Prepare the SQL statement
  $sql = "SELECT * FROM users WHERE username='$username'";

  // Execute the SQL statement
  $result = mysqli_query($conn, $sql);

  // Check if the query returned a row
  if (mysqli_num_rows($result) == 1) {
    // Get the row as an associative array
    $row = mysqli_fetch_assoc($result);

    // Verify the password hash
    if (password_verify($password, $row['password'])) {
      // Authentication successful, set session variables and redirect to homepage
      $_SESSION['username'] = $username;
      header('Location: homepage.html');
      exit; // Make sure to exit the script after the redirect
    } else {
      // Authentication failed, display error message
      echo 'Invalid password';
    }
  } else {
    // Authentication failed, display error message
    echo 'Invalid username';
  }

  // Close the database connection
  mysqli_close($conn);
}
?>
