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

// Determine which advisor is making the edits
$sql = "SELECT first_name AS firstName, last_name AS lastName FROM Advisors WHERE advisor_id=".$_COOKIE["advisor"];
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$firstName = $row['firstName'];
$lastName = $row['lastName'];
$name = $firstName." ".$lastName;

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

// // Post to database
// $sql = "INSERT INTO Equivalencies VALUES (".$highestID.", '"
// . $_POST['scucoursetitle']."', '"
// . $ScuCourseAbbrv."', '"
// . $_POST['schooltaken']."', '"
// . $_POST['coursetitle']."', '"
// . $NonScuCourseAbbrv."', "
// . $equivalent.", '"
// . $_POST['notes']."', '"
// . $name
// ."')";
// if ($conn->query($sql) === TRUE) {
//   logToFile("New record created successfully");
//   redirect('advisorhome.php');
// } else {
//   logToFile("Error: " . $sql . "<br>" . $conn->error);
//   redirect('advisorhome.php');
// }

// Prepare Insert statement and execute
$stmt=$conn->prepare("INSERT INTO Equivalencies (equivalency_id, scu_course_name, scu_course_abbrv, nonscu_university_name, nonscu_course_name, nonscu_course_abbrv, approved, notes, last_modified) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("isssssiss", $id, $scu_course_name, $scu_course_abbrv, $nonscu_university_name, $nonscu_course_name, $nonscu_course_abbrv, $approved, $notes, $last_modified);

$id = $highestID;
$scu_course_name = $_POST['scucoursetitle'];
$scu_course_abbrv = $ScuCourseAbbrv;
$nonscu_university_name = $_POST['schooltaken'];
$nonscu_course_name = $_POST['coursetitle'];
$nonscu_course_abbrv = $NonScuCourseAbbrv;
$approved = $equivalent;
$notes = $_POST['notes'];
$last_modified = $name;

$stmt->execute();
$stmt->close();

redirect('advisorhome.php');

mysqli_close($conn);
?>
