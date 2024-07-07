<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["signUp"])) {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Create a new database connection
    $conn = new mysqli("localhost", "root", "", "mydatabase");

    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute SQL statement to insert user data
    $stmt = $conn->prepare("INSERT INTO `users` (`username`, `email`, `password`) VALUES ($username, $email, $password)");

    // Execute the statement
    $stmt->execute();

    // Close the statement and database connection
    $stmt->close();
    $conn->close();

    // Redirect to success page or do additional processing
    header("Location: signup-success.php");
    exit();
  }

  // Check if it's a sign-in form submission
  if (isset($_POST["signIn"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Perform validation and database operations for sign-in

    // Example: Authenticate user from the database
    // Replace this with your actual authentication logic
    $conn = new mysqli("localhost", "root", "", "mydatabase");

    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute SQL statement to select user data
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = $username AND password = $password");
    $stmt->bind_param("ss", $username, $password);

    // Execute the statement
    $stmt->execute();

    // Fetch the result
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
      // User authenticated successfully
      // Redirect to success page or do additional processing
      header("Location: signin-success.php");
      exit();
    } else {
      // Authentication failed
      // Handle the error or redirect to an error page
      header("Location: signin-error.php");
      exit();
    }

    // Close the statement and database connection
    $stmt->close();
    $conn->close();
  }
}
?>
