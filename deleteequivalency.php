<?php
require 'db_config.php';
require 'library.php';

// Connect to database
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if (! $conn) {
  die('Could not connect: ' . mysql_error());
}

$sql = "DELETE FROM Equivalencies WHERE equivalency_id=". $_POST['courseid'];

if ($conn->query($sql) === TRUE) {
    logToFile( "Record deleted successfully");
    redirect('advisorhome.php');
} else {
    logToFile( "Error deleting record");
    redirect('advisorhome.php');
}


mysqli_close($conn);
?>
