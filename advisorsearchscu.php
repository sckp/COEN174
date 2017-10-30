<?php
require 'db_config.php';
require 'library.php';

logToFile("I got to this point1");

// Connect to database
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if (! $conn) {
  die('Could not connect: ' . mysql_error());
}

if( !empty($_POST['SCUCourseAbbrv'])) {
  $SCUCourseAbbrv = $_POST['SCUCourseAbbrv'];

  $sql = "SELECT * FROM Equivalencies";
  $result = $conn->query($sql);

  logToFile("I got to this point2");

  if ($result->num_rows > 0) {
    // output the data of each row
    while($row = $result->fetch_assoc()) {
      logToFile($row["scu_course_name"] . $row["scu_course_abbrv"] . $row["nonscu_university_name"] . $row["nonscu_course_name"] . $row["nonscu_course_abbrv"] . $row["approved"] . $row["notes"]);
    }
  }
}

mysqli_close($conn);
?>
