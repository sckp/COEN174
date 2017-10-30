<?php
require 'db_config.php';
require 'library.php';

// Connect to database
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if (! $conn) {
  die('Could not connect: ' . mysql_error());
}

if( !empty($_POST['SCUCourseAbbrv'])) {
  $SCUCourseAbbrv = $_POST['SCUCourseAbbrv'];

  $sql = "SELECT * FROM Equivalencies";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    echo "<table><tr><th>SCU Course Name</th><th>SCU Course Abbreviation</th><th>NONSCU University Name</th><th>NONSCU Course Name</th><th>NONSCU Course Abbreviation</th><th>Is it approved?</th><th>Notes</th></tr>";
    while($row = $result->fetch_assoc()) {
      echo "<tr><td>".$row["scu_course_name"]."</td><td>".$row["scu_course_abbrv"]."</td><td>".$row["nonscu_university_name"]."</td><td>".$row["nonscu_course_name"]."</td><td>".$row["nonscu_course_abbrv"]."</td><td>".$row["approved"]."</td><td>".$row["notes"]."</td></tr>";
    }
    echo "</table>";
  }
}

mysqli_close($conn);
?>
