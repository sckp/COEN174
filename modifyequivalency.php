<?php
require 'db_config.php';
require 'library.php';

// Connect to database
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if (! $conn) {
  die('Could not connect: ' . mysql_error());
}


$sql = "UPDATE Equivalencies SET notes ='".$_POST['notes']."', approved=".$_POST['gender']." WHERE equivalency_id=".$_POST['equivalencyid'];



if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
    redirect("advisorhome.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

mysqli_close($conn);
?>
