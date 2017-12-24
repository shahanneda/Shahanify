
        
   <?php
      $name = $_POST['name'];
        


$servername = "";
$username = "";
$password = "";
$dbname = "";

$searchInput = $name;
$searchInput = strtolower($searchInput);
$matchingResults = array();
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT Name, Author, URL FROM SongsTable";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
   
    while($row = $result->fetch_assoc()) {
       
       if (contains($searchInput, $row["Name"] ) || contains($searchInput, $row["Author"] ) ) {
       
          echo "<div class='songListing'> <span class='name'>" . $row["Name"]. "</span><div class='selectCircle'> </div><br> <span class='aname'>" . $row["Author"]. "</span><span class='URL'>" . $row["URL"]. "</span> <span class='delete'> DELETE </span> </div> <br>";
       }
    }
}


$conn->close();  

       // $row["Name"]
//$row["Author"]
 //$row["URL"]
 
function contains($needle, $haystack)
{
    $needle = strtolower($needle);
    $haystack = strtolower($haystack);
    return strpos($haystack, $needle) !== false;
}
      
?>

