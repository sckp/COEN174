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

// Hash password
$hash = password_hash ($_POST['password'], PASSWORD_BCRYPT);

// Prepare Insert statement and execute
$stmt=$conn->prepare("INSERT INTO Advisors (advisor_id, first_name, last_name, email, password) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("issss", $id, $first_name, $last_name, $email, $password);

$id = $highestID;
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$password = $hash;

$stmt->execute();
$stmt->close();

redirect('advisorlogin.html');


mysqli_close($conn);
?>
