<?php
header("Content-Type: application/json", true);
/*
 *  CONFIGURE EVERYTHING HERE
 */

include ('../../lib/swift_required.php');
// Create the Transport
$transport = Swift_SmtpTransport::newInstance('localhost', 25);
// Create the Mailer using your created Transport
$mailer = Swift_Mailer::newInstance($transport);
/*
 *  LET'S DO THE SENDING
 */
// subject of the email
$subject = 'New message from contact form';

// form field names and their translations.
// array variable name => Text to appear in the email
$fields = array('name' => 'Name', 'surname' => 'Surname', 'phone' => 'Phone', 'email' => 'Email', 'message' => 'Message', 'survey' => 'Survey', 'reply' => 'Reply'); 

// message that will be displayed when everything is OK :)
$okMessage = 'Contact form successfully submitted. Thank you, I will get back to you soon!';

// If something goes wrong, we will display this message.
$errorMessage = 'There was an error while submitting the form. Please try again later';

error_reporting(E_ALL & ~E_NOTICE);

try
{          
    if(count($_POST) == 0) throw new \Exception('Form is empty');
    
    $emailTextHtml = "<h1>You have a new message from your contact form</h1><hr>";
    $emailTextHtml .= "<table>";
    $i=0;
    foreach ($_POST as $key => $value) {
        // If the field exists in the $fields array, include it in the email
        if (isset($fields[$key])) {
            $emailTextHtml .= "<tr><th style='text-align: right; margin-right:15px;'>$fields[$key]</th><td>$value</td></tr>";
           // $i++;
        }
        
    }
    $emailTextHtml .= "</table>";
    
    //$emailTextHtml = $i;
     
    $message = Swift_Message::newInstance('Contact Form Query')
    ->setFrom(array('noreply@epsilonproject.org' => 'Charter Yachts','x17161533@student.ncirl.ie' => 'Charter Yachts'))
    ->setTo(array('x17164966@student.ncirl.ie','x17161533@student.ncirl.ie' => 'Charter Yachts'))
    ->setBody($emailTextHtml,'text/html');

   $mailer->send($message); // send message
   $responseArray = array('type' => 'success', 'message' => $okMessage);
}
catch (\Exception $e)
{
    $responseArray = array('type' => 'danger', 'message' => $errorMessage);
}
// if requested by AJAX request return JSON response
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);

    header('Content-Type: application/json');

    echo $encoded;
}
// else just display the message
else {
    echo $responseArray['message'];
}
?>