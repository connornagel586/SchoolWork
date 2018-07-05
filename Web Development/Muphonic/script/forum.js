$("document").ready(function(){



  $(".topic").click(function(){
    window.location = 'forum_page.php?topic_id=' + $(this).attr("value");
  });

  $("#add_topic").click(function(){
    $(".this_topic").toggle();
    if($(".this_topic").is(":visible")){
      $("#add_topic").text("Close Topic");
    }else{
      $("#add_topic").text("New Topic");
    }
  });
  $("#add_comment").click(function(){
    $(".this_comment").toggle();
    if($(".this_comment").is(":visible")){
      $("#add_comment").text("Close Comment");
    }else{
      $("#add_comment").text("New Comment");
    }
  });

  $("#idForm").submit(function(e) {

      var url = "../topic.php"; // the script where you handle the form input.

      $.ajax({
             type: "POST",
             url: url,
             data: $("#idForm").serialize(), // serializes the form's elements.
             success: function(data)
             {
                 alert(data); // show response from the php script.
             }
           });

      e.preventDefault(); // avoid to execute the actual submit of the form.
  });












});
