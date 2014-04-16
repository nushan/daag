<?php

    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields and remove whitespace.
		$name = str_replace(array("\r","\n"),array(" "," "), strip_tags(trim($_POST["name"])));
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $message = trim($_POST["msg"]);

        // Check that data was sent to the mailer.
        if ( empty($name) OR empty($message) OR empty($email)) {
            // Set a 400 (bad request) response code and exit.
            // http_response_code(400);
            
            echo json_encode(array('status'=>false, 'msg'=>'Oops! You can not submit a blank from. Please complete the form and try again.'));
            exit;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(array('status'=>false, 'msg'=>'Oops! You are trying to submit wrong email address. Please type a correct email address and try again.'));
            exit;
        }

        // Set the recipient email address.
        // FIXME: Update this to your desired email address.
        $recipient = "janis@daagcom.com";

        // Set the email subject.
        $subject = "From DAAG Website: $name has submit a Contact";

        // Build the email content.
        $email_content = "Name: $name\n";
        $email_content .= "Email: $email\n\n";
        $email_content .= "Message:\n$message\n";

        // To send HTML mail, the Content-type header must be set
        $email_headers  = 'MIME-Version: 1.0' . "\r\n";
        $email_headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        // Additional headers
        $email_headers .= "To: Daag <info@daagcom.com>, 'Janis Mahmun' <$recipient>" . "\r\n";
        $email_headers .= "From: $name <$email>" . "\r\n";
        $email_headers .= 'Cc: janismahmun@gmail.com' . "\r\n";
        
        $email_headers .= 'X-Mailer: PHP/' . phpversion();

        // Send the email.
        if (mail($recipient, $subject, $email_content, $email_headers)) {
            // Set a 200 (okay) response code.
            echo json_encode(array('status'=>true, 'msg'=>'Thank You! Your message has been sent. We will get back to you soon.'));
            exit;
        } else {
            // Set a 500 (internal server error) response code.
            echo json_encode(array('status'=>false, 'msg'=>'Oops! Something went wrong and we couldn\'t send your message.'));
            exit;
        }

    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        // http_response_code(403);
        echo json_encode(array('status'=>false, 'msg'=>'There was a problem with your submission, please try again.'));
        exit;
    }

?>
