function validateForm(e) {
  
  var valid;
  
  valid = true;

  $('form .form-control').each(function() {
    $(this).next('.custom-help-block').hide();
    var name = $(this).attr('name');
    
    // Form value listeners
    if (name === "name") {
      $(this).next('.custom-help-block').hide();
      var inputVal = $(this).val();
      var characterReg = /^[a-zA-Z]+$/;
      if(!characterReg.test(inputVal)) {
        $(this).next('.custom-help-block').show();
        valid = false;
      }
    }
    else if (name === "email") {
      $(this).next('.custom-help-block').hide();
      var inputVal = $(this).val();
      var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
      if(!emailReg.test(inputVal)) {
        $(this).next('.custom-help-block').show();
        valid = false;
      }
    }
    else if (name === "phone") {
      $(this).next('.custom-help-block').hide();
      var inputVal = $(this).val();
      var characterReg = /\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/;
      if(!characterReg.test(inputVal)) {
        $(this).next('.custom-help-block').show();
        valid = false;
      }
    }
    else {
      var inputVal = $(this).val();
      if (!inputVal) {
        $(this).next('.custom-help-block').show();
        valid = false;
      }
    }

  });
  
  // Final check if valid is true
  if (valid != true) {
    return false;
  }
  else {
    return true; 
  }
  
}


$(document).ready(function() {
  
//  $('.form-control').keyup(function() {
//    validateForm();
//  });
  
  $('form button').click(function() {
    return validateForm();
  });
  
});

