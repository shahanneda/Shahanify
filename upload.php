<?php
   if(isset($_FILES['mp3'])){
      $errors= array();
      $file_name = $_FILES['mp3']['name'];
      $file_size =$_FILES['mp3']['size'];
      $file_tmp =$_FILES['mp3']['tmp_name'];
      $file_type=$_FILES['mp3']['type'];
      $file_ext=strtolower(end(explode('.',$_FILES['mp3']['name'])));
      $fileUrl = str_replace(' ', '', "mp3/".$file_name);
      
      $expensions= array("jpeg","mp3","png");
      
      if(in_array($file_ext,$expensions)=== false){
         $errors[]="extension not allowed, please choose a JPEG or PNG file.";
      }
      
      if($file_size > 31457280){
         $errors[]='File size must be excately 2 MB';
      }
      
      if(empty($errors)==true){
      
         move_uploaded_file($file_tmp, $fileUrl);
         echo "Success";
         
         
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
        
        $sql = "INSERT INTO SongsTable (Name, Author, URL) VALUES ('" . $_POST["name"] . "', '".$_POST["aname"]." ', '".  $fileUrl . "')";
        
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();  
      ;
      }else{
         print_r($errors);
      }
      
      
      
   }
?>
<button type="button" id="UploadButton">Upload</button>
<div class="Upload">
      <link rel="stylesheet" href="styles.css">
      <form action="" method="POST" enctype="multipart/form-data">
         <input type="file" name="mp3" /> <br><br>
         Name: <input type="text" name="name"><br><br>
         Author Name: <input type="text" name="aname"><br><br>
         <input type="submit"/>
      </form>
      
</div>