<?PHP
//Set the variables needed to connect to gmail via the imap_open function.

$user = 'raspberrypifsu@gmail.com'; //Username for the RPi's gmail account.
$pass = 'research123'; //Password for RPi's e-mail account.
$hostname = '{imap.gmail.com:993/imap/ssl}INBOX'; //Hostname that uses IMAP to connect to the RPi's inbox.

#Use imap_open to the RPi's e-mail account. Terminate the program and display the imap error message if a connection is unable to be made.
$inbox = imap_open($hostname,$user,$pass) or die('Unable to connect to RPi g-mail account! ' . imap_last_error());

$deleteDate = new DateTime(); //Declare a date object. It will automatically be given today's date and time.
$deleteDate->modify('-1 week'); //Subtract one week from the current date. Therefore the date value will represent one week prior to the current date.

$check = imap_check($inbox); //Gather an overview of information for each item in the inbox.

$messages = imap_fetch_overview($inbox,"1:{$check->Nmsgs}",0); //Fetch and store the overview information (an object) for each item in the inbox into an array.

foreach ($messages as $overview) { //Traverse the messages array to analyze each overview object.
    $date = $overview->date; //Extract the date attribute from the current overview object.
    $date = DateTime::createFromFormat('D, d M Y H:i:s O', $date);  //Format the date object into a DateTime object so that it can be compared to the threshold date.

    if($date<$deleteDate) { //If the message was received more than one week ago...
        imap_delete($inbox,$overview->msgno); //Mark the message for deletion.
    }
}

imap_expunge($inbox); //Delete all of the messages marked for deletion.
imap_close($inbox); //Close the imap connection.

?>