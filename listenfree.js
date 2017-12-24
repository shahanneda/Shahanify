  audiojs.events.ready(function() {
    var as = audiojs.createAll();
  });
  console.log('hi');


//get all songs as a json from a php file 
/*
  $.getJSON('songs.php', function(data) {
      $.each(data, function(SongName, SongAuthor, SongUrl) {
          });

*/

var data = $.parseJSON({
  "Songs": {
    "Dynomyte": {
      "SongName": "ty",
      "SongAuthor": "helli",
      "SongUrl": "ty.mp3"
    },
    "IDK": {
      "SongName": "tggy",
      "SongAuthor": "hegffslli",
      "SongUrl": "tyfg.mp3"
    }
  }
});

 $.each(data, function(SongName, SongAuthor, SongUrl) {
 	console.log(SongName + " " + SongAuthor + " " + SongUrl);
 });
 //display the songs out using jquery
