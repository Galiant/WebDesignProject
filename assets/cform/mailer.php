<?php
             
include ('../../lib/swift_required.php');
// echo "<div class='errorMessage'><div class='oops os_3 span_2'>OK :)</div>"; 

// Create the Transport
$transport = Swift_SmtpTransport::newInstance('localhost', 25);

 //echo "Does it reach here?";

// Create the Mailer using your created Transport
$mailer = Swift_Mailer::newInstance($transport);

 //echo "And here?";

// Create a message

$message = Swift_Message::newInstance('Contact Form Query')
  ->setFrom(array('noreply@epsilonproject.org' => 'Charter Yachts'))
  ->setTo(array('gerry.taylor@hotmail.com', 'gerry_taylor_@hotmail.com' => 'Charter'))
  ->setBody('<html>'.'<body>'.'<h2>Contact Form Details:</h2><h3>Query:</h3>'.$query.'<h3>Name:</h3>'.$title.'<h3>Email:</h3>'.$email.'<h3>Message:</h3>'.$comment.'</body>'.'</html>','text/html');


// echo "Or here?";
// Send the message
$numSent = $mailer->send($message);

echo "After mailer";
printf("Sent %d messages\n", $numSent);
echo "You're message has been sent. You should hear back from us soon. Thanks for your query.";
// Note that often that only the boolean equivalent of the
//  return value is of concern (zero indicates FALSE)

if ($mailer->send($message))
{
  echo "Sent\n";
}
else
{
  echo "Failed\n";
}
  
?>