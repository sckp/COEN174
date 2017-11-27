<?php
require 'db_config.php';
require 'library.php';

// Connect to database
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if (! $conn) {
  die('Could not connect: ' . mysql_error());
}

// Check for current ID Value
$sql = "SELECT MAX(advisor_id) AS id FROM Advisors";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  $row = mysqli_fetch_assoc($result);
  $highestID = $row["id"];
  $highestID++;
}

// Check for the proper access code
if ($_POST['accesscode'] != 1) {
	logToFile("Invalid access code");
	redirect('advisorregister.html');
}

// Check email address
$sql = "SELECT * FROM Advisors A WHERE A.email = '$email'";
$result = $conn->query($sql);
if($result->num_rows>0){
	logToFile("repeat use of email");
	redirect('advisorregister.html');
}

// Hash password
$hash = password_hash ($_POST['password'], PASSWORD_BCRYPT);

// Post to database
$sql = "INSERT INTO Advisors VALUES (".$highestID.", '"
. $_POST['first_name']."', '".$_POST['last_name']."', '"
. $_POST['email']."', '"
. $hash
."')";
if ($conn->query($sql) === TRUE) {
  logToFile("New advisor account created successfully");
  redirect('advisorhome.php');
} else {
  logToFile("Error: " . $sql . "<br>" . $conn->error);
  redirect('advisorregister.html');
}
mysqli_close($conn);
?>
