$(document).ready(function(){



  $(".chat").click(function(){
    window.location = 'chat_room.php?chat_id=' + $(this).attr("value");
  });

  $('#messages').on('load', showNewMessages());
  $("#submitmsg").submit(function(e){
  e.preventDefault();
      $.post('handlers/chat_handler.php'), "post",$('#msg').serializeArray(), function(data){
        	$("#usermsg").attr("value", "");
          $('#chatbox').append(data);
      };

      return false;

  });

  $("#add_chat").click(function(){
    $(".this_chat").toggle();
    if($(".this_chat").is(":visible")){
      $("#add_chat").text("Close Chat");
    }else{
      $("#add_chat").text("New Chat");
    }
  });

function showNewMessages(){
  $.ajax({
      url: 'handlers/chat_handler.php',
      success: function(data) {
          $('#chatbox').append(data);


      }
    });
    setTimeout(showNewMessages, 5000); // you could choose not to continue on failure...
}

});
