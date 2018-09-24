<?php 
    include ('header.php'); 
?>
   
<?php
if(isset($_POST['email'])) {
 
 
    $email_to = "calinte2002@yahoo.co.uk";
 
    $email_subject = "Blog contact request";
 

    function died($error) {
 
        // your error code can go here
 
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
 
        echo "These errors appear below.<br /><br />";
 
        echo $error."<br /><br />";
 
        echo "Please go back and fix these errors.<br /><br />";
 
        die();
 
    }
 
    // validation expected data exists
 
    if(!isset($_POST['name']) ||

        !isset($_POST['email']) ||
 
        !isset($_POST['phone']) ||
 
        !isset($_POST['message'])) {
 
        died('We are sorry, but there appears to be a problem with the form you submitted.');       
 
    }
 
 
    $first_name = $_POST['name']; // required

    $email_from = $_POST['email']; // required
 
    $telephone = $_POST['phone']; // not required
 
    $comments = $_POST['message']; // required
 
     
    $error_message = "";
 
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
 
   if(!preg_match($email_exp,$email_from)) {
 
    $error_message .= 'The email address you entered does not appear to be valid.<br />';
 
  }
 
    $string_exp = "/^[A-Za-z .'-]+$/";
 
   if(!preg_match($string_exp,$first_name)) {
 
    $error_message .= 'The name you entered does not appear to be valid.<br />';
 
  }

   if(strlen($comments) < 2) {
 
    $error_message .= 'The message you entered do not appear to be valid.<br />';
 
  }
 
   if(strlen($error_message) > 0) {
 
    died($error_message);
 
  }
 
    $email_message = "Form details below.\n\n";
 
     
 
  function clean_string($string) {
 
      $bad = array("content-type","bcc:","to:","cc:","href");
 
      return str_replace($bad,"",$string);
 
  }
 
     
 
    $email_message .= "Name: ".clean_string($first_name)."\n";
 
    $email_message .= "Email: ".clean_string($email_from)."\n";
 
    $email_message .= "Phone: ".clean_string($telephone)."\n";
 
    $email_message .= "Message: ".clean_string($comments)."\n";
 
     
 
// create email headers
 
$headers = 'From: '.$email_from."\r\n".
 
'Reply-To: '.$email_from."\r\n" .
 
'X-Mailer: PHP/' . phpversion();
 
@mail($email_to, $email_subject, $email_message, $headers);  
 
?>
 
 
 
<!-- include your own success html here -->
 
 
 
Thank you for contacting us. We will be in touch with you very soon.
 
 
 
<?php
 
}
 
?>

<body>
  <!--MAIN-->
  <div class="main">
        <div class="contact text">
         <div class="row">
              <div class="col-md-6">
                  <div class="contact-left">
                       <h1>Drop me a line!</h1>
                  </div>
                  <img src="assets/images/pic4.png">
              </div>
              <div class="col-md-6">
                  <form name="contactform" method="post" action="contact.php">
                    <div class="form-group">
                      <label>Name</label>
                      <input type="text" name="first-name" class="form-control" placeholder="Your name" />
                      <div class="custom-help-block">Name is not valid.</div>
                    </div>  
                    <div class="form-group">
                      <label>Email</label>
                      <input type="email" name="email" class="form-control" placeholder="Your email" />
                      <div class="custom-help-block">Email is not valid.</div>
                    </div>
                    <div class="form-group">
                      <label>Phone Nr.</label>
                      <input type="text" name="phone" class="form-control" placeholder="Your phone number" />
                      <div class="custom-help-block">PhoneNr. is not valid.</div>
                    </div>
                    <div class="form-group">
                      <label>Message</label>
                      <textarea name="message" class="form-control" placeholder="Your message"></textarea>
                      <div class="custom-help-block">Message is not valid.</div>
                    </div>
                    <button type="submit">send</button>
                  </form>
              </div>
          </div>
        </div>
  </div>
</body>

<?php 
  include ('footer.php'); 
?>
