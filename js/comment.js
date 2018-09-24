$(document).ready(function() {
  
  // Chats open
  $('.js-add-comment').click(function() {
    console.log(this);
    var comment = $(this).parent().parent().find('input').val();
    console.log(comment);
    	
    $( "<li>" + comment + "</li>" ).appendTo($(this).parent().parent().prev());
  });
});







