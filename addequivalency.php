<?php
require 'db_config.php';
require 'library.php';

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

// Change Yes or No to 1 or 0
if($_POST['gender'] == "yes") {
  $equivalent=1;
} else {
  $equivalent=0;
}

// Post to database
$sql = "INSERT INTO Equivalencies VALUES (".$highestID.", '"
. $_POST['scucoursetitle']."', '".$_POST['scucourseabbrv']."', '"
. $_POST['schooltaken']."', '"
. $_POST['coursetitle'] . "', '"
. $_POST['courseabbrv']."', ".$equivalent.", '"
. $_POST['notes']
."')";
if ($conn->query($sql) === TRUE) {
  logToFile("New record created successfully");
  redirect('advisorhome.html');
} else {
  logToFile("Error: " . $sql . "<br>" . $conn->error);
  redirect('advisorhome.html');
}

mysqli_close($conn);
?>
