//author:Harry
/*App.getData  = function() {
    $.ajax({
    type: "GET",
    url: "api/update_percentages.php",
    dataType: "json",
    success: function(data) {
      console.log(data[0]);
      $('#lastyear-val').text(data[0].last_year);
    }
  });
};*/

(function(){
	
var App = function(){

}

App.bindBtn = function(){
	var t = this;
	$('#perc').on("change keyup", function(e){
		t.getData(e.target.name, e.target.text) 
	})
}

App.getData  = function(name, value) {
	$.ajax({
    type: "GET",
    url: "api/update_percentages.php",
    data: {
    	"name": name,
    	"percentage": value
    },
    dataType: "json",
    success: function(data) {
      console.log(data);
      // $('#'+name).text(data[0].last_year);
    }
  });
};

App.init = function(){
	var t = this;
	t.bindBtn();
}

App = new App();
App.init();
}())