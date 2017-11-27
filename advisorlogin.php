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
  $sql = "SELECT * FROM Advisors A WHERE A.email = '$email'";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();

  // /* create a prepared statement */
  // if ($stmt = $mysqli->prepare("SELECT * FROM Advisors A WHERE A.email=?")) {
  //     /* bind parameters for markers */
  //     $stmt->bind_param("s", $city);
  //     /* execute query */
  //     $stmt->execute();
  //     /* bind result variables */
  //     $stmt->bind_result($district);
  //     /* fetch value */
  //     $stmt->fetch();
  //     printf("%s is in district %s\n", $city, $district);
  //     /* close statement */
  //     $stmt->close();
  // }

  // Verify the password, but redirect if not correct
  if(password_verify($password,$row['password'])) {
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
