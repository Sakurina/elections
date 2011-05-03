var TOTAL_SEATS = 308;
var PARTIES = ["bloc", "libs", "ndp", "tories", "other"];

function updateResults() {
  $.getJSON("http://r-ch.net/elections/results.php", function(dict) {
    for (var i=0; i < PARTIES.length; i++) {
      var p = PARTIES[i];
      seat_width = dict[p] / TOTAL_SEATS * 100;
      pop_width = dict[p+"-pop"];
      $("#"+p).css('width', seat_width+"%");
      $("#"+p).html(dict[p]);
      $("#"+p+"-pop").css('width', pop_width+"%");
      $("#"+p+"-pop").html(dict[p+"-pop"]+"%");
    }
  });
}

$(document).ready(function() {
  updateResults();
  setInterval("updateResults()", 30000);
});
