//author:Harry
App.getData  = function() {
    $.ajax({
    type: "GET",
    url: "api/update_percentages.php",
    dataType: "json",
    success: function(data) {
      console.log(data[0]);
      $('#lastyear-val').text(data[0].last_year);
    }
  });
};