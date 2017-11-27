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
  $formPassword = $_POST['password'];

  // Get the advisor's id for the cookie, and verify the password
  if ($stmt = $conn->prepare("SELECT advisor_id, password FROM Advisors A WHERE A.email=?")) {
      $stmt->bind_param("s", $email);
      $stmt->execute();

      $stmt->bind_result($advisor_id, $password);
      $stmt->fetch();

      logToFile($advisor_id);
      logToFile($password);

      // Verify the password, but redirect if not correct
      if(password_verify($formPassword,$password)) {
        logToFile('Successful Login');
        setcookie("advisor", $advisor_id, time() + (86400));
        redirect('advisorhome.php');
      }
      else {
        redirect('advisorlogin.html');
        logToFile("Email or Password Incorrect");
      }

      $stmt->close();
  }
}
mysqli_close($conn);
?>
