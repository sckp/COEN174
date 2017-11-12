<?php
require 'db_config.php';
require 'library.php';

// Connect to database
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if (! $conn) {
  die('Could not connect: ' . mysql_error());
}

// Determine which advisor is making the edits
$sql = "SELECT first_name AS firstName, last_name AS lastName FROM Advisors WHERE advisor_id=".$_COOKIE["advisor"];
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$firstName = $row['firstName'];
$lastName = $row['lastName'];
$name = $firstName." ".$lastName;

// Update the notes and whether the course is equivalent
$sql = "UPDATE Equivalencies SET notes ='".$_POST['notes']."', approved=".$_POST['gender'].", last_modified='".$name."' WHERE equivalency_id=".$_POST['equivalencyid'];
if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
    redirect("advisorhome.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    redirect("advisorhome.php");
}
mysqli_close($conn);
?>
