<?PHP
//Set the variables needed to connect to gmail via the imap_open function.

$user = 'raspberrypifsu@gmail.com'; //Username for the RPi's gmail account.
$pass = 'HIDDEN'; //Password for RPi's e-mail account.
$hostname = '{imap.gmail.com:993/imap/ssl}INBOX'; //Hostname that uses IMAP to connect to the RPi's inbox.

#Use imap_open to the RPi's e-mail account. Terminate the program and display the imap error message if a connection is unable to be made.
$inbox = imap_open($hostname,$user,$pass) or die('Unable to connect to RPi g-mail account! ' . imap_last_error());

/*Use the imap search function to retrieve all of the e-mails and store them in a variable. 
imap_search returns an array, argument #1 takes an imap_open()variable. The second argument is a string specifying which e-mails to retrieve from the subject line.
This will use REGEX to only take e-mails containing RPi in the subject*/
$mail = imap_search($inbox,'SUBJECT "RPi::"'); //Retrieve emails that contains "RPi:: in the subject line"

//If the e-mails were successfully retrieved from the inbox...
if($mail) {
		
	//Use reverse sort to order the e-mails from newest to oldest. This will allow any newer alerts to be processed first.
	rsort($mail);
	
	$messageInfo=''; //Make a blank string so that messageInfo can be continuously appended to hold all of the message information as a single string.
	
	/*Use a foreach loop to extract the date and subject line of each e-mail and stores it in a file using the output buffer stream. */
	foreach($mail as $numMail) {
		//Use imap_fetch_overview to retrieve the subject line and date/time of the message.
		$overview = imap_fetch_overview($inbox,$numMail,0);
				
		//Store the subject line and the date/time of the e-mail in a string. Separate the two sets of data by a pipe.
		$messageInfo.= $overview[0]->subject." | ";
		$messageInfo.= $overview[0]->date.PHP_EOL; //PHP_EOL identifies the newline character native to the systm.
		
	}
	
	$fileName = "C:\\RPiEmails.txt"; /*Open the file that will store the message information. w in the second paramter
	will create the file if does not exist.*/
	
	/*Write the string containing each of the messages to the file. file_put_contents acts as a file handler as well.
	It opens the file, overwrites it and then closes it when finished.*/
	file_put_contents($fileName, $messageInfo); 
	
	
}
else{
	die('Unable to extract e-mail messages!'. imap_last_error()); //Kill the script and display an error message if the IMAP retreival fails.
} 

// Close the IMAP connection
imap_close($inbox);
?>