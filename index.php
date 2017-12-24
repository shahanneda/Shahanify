<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="viewport" content="width=device-width, user-scalable=no" />
<link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet">
<link rel="apple-touch-icon" href="http://listenfree.gq/apple-touch-icon.png">

<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<title>Shahanify </title>

</head>
<body>
<style>
.delete{
        display:none !important;
}
</style>
<script>
 
////////////////////////////COPY PASTED TO SOLVE IOS FIXED DIV BUG///////////////////////////////////////////
// Let's assume the fixed top navbar has id="navbar"
// Cache the fixed element
var $navbar = $('#searchInput');

function fixFixedPosition() {
  $navbar.css({
    position: 'absolute',
    top: document.body.scrollTop + 'px'
  });
}
function resetFixedPosition() {
  $navbar.css({
    position: 'fixed',
    top: ''
  });
  $(document).off('scroll', updateScrollTop);
}
function updateScrollTop() {
  $navbar.css('top', document.body.scrollTop + 'px');
}
/////////////////////////////////////////////////////

$('input, textarea, [contenteditable=true]').on({
  focus: function() {
    // NOTE: The delay is required.
    setTimeout(fixFixedPosition, 100);
    // Keep the fixed element absolutely positioned at the top
    // when the keyboard is visible
    $(document).scroll(updateScrollTop);
  },
  blur: resetFixedPosition
});

$(document).ready(function(){
        $('#searchInput').keyup(function(){
                
                var search = $('#searchInput').val();
                if(search != ""){
                        $('.songs').hide();
                        $.ajax({
                               type: "POST",
                               url: "SearchSongs.php",
                               data: { name: search,},
                               success: function(data){ 
                                    $('#SearchResults').html(data);
                               }
                        });
                
                }else{
                        $('.songs').show();
                
                }
                
        });

});

</script>
<div id="SearchContainer">
        <div id= "searchBoxContainer">
                <input id="searchInput" type="text" name="search" placeholder="Search for a song or an artist">
        </div>
        <div id="SearchResults"></div>
</div>
<?php 

$currentTrackURL = "mp3/TaioCruzDynamite.mp3";

        $servername = "";
        $username = "";
        $password = "";
        $dbname = "";
        
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
            echo "<div class='songs'>";
            while($row = $result->fetch_assoc()) {
                echo "<div class='songListing'> <span class='name'>" . $row["Name"]. "</span><div class='selectCircle'> </div><br> <span class='aname'>" . $row["Author"]. "</span><span class='URL'>" . $row["URL"]. "</span> <span class='delete'> DELETE </span> </div> <br>";
            }
        } else {
            echo "0 results";
        }
        echo "</div>";
        $conn->close();  
      
    
?>






<script>
var nextTracksURLs = [];
var currentIndexInPlaylist = 0;
var isPlayingPlaylist = false;
var isLoaded = false;
var currentTrackUrl;
function Play(){
        $('#PLAYER').get(0).play();
        if(isLoaded){
                $('.pauseButton').show();
                $('.playButton').hide();
        }
}

function Pause(){
        $('#PLAYER').get(0).pause();
        $('.pauseButton').hide();
        $('.playButton').show();
}
function PlayTrack( url){
         
        audio_core=$('#PLAYER');
        audio_core.attr('src', url);
        $('.LoadingGif').show();
        $('.playButton').hide();
        $('.pauseButton').hide();
        Play();
        
}
function ScrubToPrecent( precent){
        audio_core=$('#PLAYER');
        $('#ProgressBar').css('width',precent+'%');
        var audioDuration = audio_core[0].duration;
        audio_core[0].currentTime = (precent/100)*audioDuration;
}
function UpdateProgressBar(){
        audio_core=$('#PLAYER');
        var audioDuration = (audio_core[0].duration ? audio_core[0].duration: '0:00');
        var precentWidth = (audio_core[0].currentTime/audioDuration)*100;
        $('#ProgressBar').css('width',precentWidth+'%');
        if(audioDuration != "0:00"){
                $('#TimePast').text(convertMinToSecond(audio_core[0].currentTime));
                $('#TimeLeft').text(convertMinToSecond(audioDuration));
        
        }

        
}

function convertMinToSecond(value) {
   var isLessThan10; 
   if(Math.round(value % 60 ? value % 60 : '00') >= 10){
           return Math.floor(value / 60) + ":" + Math.round(value % 60 ? value % 60 : '00')
   }
   
    return Math.floor(value / 60) + ":0" + Math.round(value % 60 ? value % 60 : '00')
}

function myOnLoadedData()  {
        isLoaded=true;
        console.log("Loaded");
        $('.pauseButton').show();
        $('.playButton').hide();
         $('.LoadingGif').hide();

Play(); Pause(); Play(); 

}
$(document).ready(function() {
        $(document).on('touchstart', function() {
            detectTap = true; //detects all touch events
        });
        $(document).on('touchmove', function() {
            detectTap = false; 
        });
        //When the proggress bar is fucking clicked this figures out where it was clicked and convert it to a width.
        setInterval(UpdateProgressBar,50)
        $('#ProgressBarBackground').click(function(){
                var windowWidth = $( window ).width();
                var progressBarWidth = $( '#ProgressBarBackground' ).width();
                console.log("progressBarWidth = " + progressBarWidth);
                console.log("windows width ="  +windowWidth);
                
                var curserXPos = event.clientX;
                var precentDecimal = Math.round((((curserXPos/(progressBarWidth)))*100)-12);
                console.log(precentDecimal + "%");    
                ScrubToPrecent(precentDecimal);
        });

        var isDragging = false;

        $("body")
            .on("mousedown touchstart",".songListing",function (evt) {
                isDragging = false;
                
                console.log("MOUSE DOWN BITCHES");
            })
            .on("mousemove touchmove",".songListing",function (evt) {
       
                isDragging = true;
            })
            .on("mouseup touchend",".songListing",function () {
                if (isDragging) {
                    console.log("Drag");
                } else {
                    console.log("Click");
                                    if($(this).children('.URL').text() ==currentTrackUrl){return;}
                isLoaded = false;
                console.log('U CLICKED SOME SHITE RIGHT?');
                $('.songListing').each(function() {
                    $(this).css("background-color", "rgba(46, 46, 46, 0.18)");
                });
                PlayTrack($(this).children('.URL').text())
                
                //
                $(this).css("background-color", "rgba(184, 184, 184, 0.17);");
                console.log($(this).children('.URL').text());
                currentTrackUrl=$(this).children('.URL').text();
               
                }
                isDragging = false;
                startingPos = [];
            });
        $('body').on('touchend click',".songListing",function(){
                //

                
                
                
        });
        $('#UploadButton').on('click', function(){
        console.log('clicked');
        $('.Upload').fadeToggle();
        
        });
        
        $('.delete').on('click', function(){
               $('.deleteForm').toggle(); 
        
        });
         $('.playButton').on('click', function(){
               Play();
        
        });
        $('.pauseButton').on('click', function(){
              Pause();
        });
        $('#PLAYER').on('ended', function(){
            console.log('FUCKING');
            if(nextTracksURLs.length > 0){
                    currentIndexInPlaylist = nextTracksURLs.indexOf($('#PLAYER').attr('src'));
                    currentIndexInPlaylist++;
                    if(currentIndexInPlaylist >= nextTracksURLs.length){
                    currentIndexInPlaylist = 0;
                    
                    }
                    PlayTrack(nextTracksURLs[currentIndexInPlaylist]);
                     
            }else{
                      Play();
            }
                    
        });
        $('.selectCircle').on('click', function(){
                //
                
                
                
                //
                if($(this).css("background-color") == "rgb(0, 0, 0)"){
                        $(this).css("background-color", "beige");
                        var index = nextTracksURLs.indexOf($(this).siblings('.URL').text());
                        if (index > -1) {
                            nextTracksURLs.splice(index, 1);
                        }
                        console.log(nextTracksURLs);
                
                }else{
                        $(this).css("background-color", "black");
                        nextTracksURLs.push($(this).siblings('.URL').text());
                        console.log(nextTracksURLs);
                }
                
                
                
        });
        
        $('.playPlaylist').on('click', function(){
             isPlayingPlaylist = true;
             PlayTrack(nextTracksURLs[0]);
        });
        
});

</script>

<?php include("upload.php"); ?>
<div id="PlayerContainer">
        <div id="PlayerButtons">
                <image class='playButton'src="images/Play.png">
                <image class='PauseButton'src="images/Pause.png">
                <image class='LoadingGif' src = "images/loading.gif";
        </div>
         
        <div id="ProgressContainer">
          
          <div id="ProgressBarContainer">
                  <div id="ProgressBarBackground">                   
                          <div id="ProgressBar"> </div>
                          <div id="TimePast"> 0.00 </div>
                          <div id="TimeLeft"> 0.00 </div>
                          
                  </div>
                  
          </div>
          
          
        </div>
        <div id='playerDiv'>
               
                 
                 <audio onloadeddata="myOnLoadedData()" id='PLAYER' >              
                 <source   src="<?php echo($currentTrackURL); ?>" type="audio/mpeg">

        </audio>
        </div>
</div>
<div class="deleteForm">
        <form action="delete.php" method="POST" >
                
                 <input type="text" name="name"><br><br>
                 
                 <input type="submit"/>
        </form>
</div>

</body>
</html>