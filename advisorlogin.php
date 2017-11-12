<?php
require 'db_config.php';
require 'library.php';

// Connect to database
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if (! $conn) {
  die('Could not connect: ' . mysql_error());
}

// Check login credentials
if( !empty($_POST['email']) && !empty($_POST['password']) ) {
  $email = $_POST['email'];
  $password = $_POST['password'];
  $sql = "SELECT * FROM Advisors A WHERE A.email = '$email' and A.password = '$password'";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();

  $count = mysqli_num_rows($result);
  if($count == 1) {
    logToFile('Successful Login');
    $advisorID = $row['advisor_id'];
    setcookie("advisor", $advisorID, time() + (86400));
    redirect('advisorhome.php');
  }
  else {
    redirect('advisorlogin.html');
    logToFile("Email or Password Incorrect");
  }
}

mysqli_close($conn);
?>
