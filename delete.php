<?php
         $servername = "fdb7.biz.nf";
        $username = "2504457_songs";
        $password = "abc12345678";
        $dbname = "2504457_songs";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// sql to delete a record
$sql = 'DELETE FROM SongsTable WHERE name= "' . $_POST["name"] .'"';

if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();
?>



