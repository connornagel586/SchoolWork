$("document").ready(function(){
  var i = 1;
  $("#add_class").click(function(){
    i++;
    var str =		   "<div class=\"class\">\
    <input type=\"text\" placeholder=\"Class Name\" class=\"className\" name=\"class" + i + "\">\
    <input type=\"text\" placeholder=\"Class Number\" class=\"classNum\"name=\"classNum" + i + "\"><br>\
    <input type=\"text\" placeholder=\"Professor\" class=\"professor\"name=\"professor" + i + "\">\
    <input type=\"text\" placeholder=\"Credits\" class=\"credits\" name=\"credits" + i + "\"><br>\
    <input type=\"text\" placeholder=\"Grade\" class=\"grade\" name=\"grade" + i + "\"><br>\
    </div>"

    $(".form").append(str);

  });

  $("#remove_class").click(function(){

    if(!(i == 1)){
      $(".form div:last").remove();
      i--;
    }
  });

});
