<?php
require 'db_config.php';
require 'library.php';

// Redirect user to login if cookie is not available
if (!isset($_COOKIE["advisor"])) {
  redirect("advisorlogin.html");
}

// Connect to database
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if (! $conn) {
  die('Could not connect: ' . mysql_error());
}

// Check for current ID Value
$sql = "SELECT MAX(equivalency_id) AS id FROM Equivalencies";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  $row = mysqli_fetch_assoc($result);
  $highestID = $row["id"];
  $highestID++;
}

// Change Yes or No from HTML form to 1 or 0 for database
if($_POST['gender'] == "yes") {
  $equivalent=1;
} else {
  $equivalent=0;
}

// Remove spaces and make lowercase
$ScuCourseAbbrv = $_POST['scucourseabbrv'];
$ScuCourseAbbrv = preg_replace('/\s+/', '', $ScuCourseAbbrv);
$ScuCourseAbbrv = strtolower($ScuCourseAbbrv);
$NonScuCourseAbbrv = $_POST['courseabbrv'];
$NonScuCourseAbbrv = preg_replace('/\s+/', '', $NonScuCourseAbbrv);
$NonScuCourseAbbrv = strtolower($NonScuCourseAbbrv);

// Post to database
$sql = "INSERT INTO Equivalencies VALUES (".$highestID.", '"
. $_POST['scucoursetitle']."', '"
. $ScuCourseAbbrv."', '"
. $_POST['schooltaken']."', '"
. $_POST['coursetitle']."', '"
. $NonScuCourseAbbrv."', "
. $equivalent.", '"
. $_POST['notes']
."')";
if ($conn->query($sql) === TRUE) {
  logToFile("New record created successfully");
  redirect('advisorhome.php');
} else {
  logToFile("Error: " . $sql . "<br>" . $conn->error);
  redirect('advisorhome.php');
}

mysqli_close($conn);
?>
