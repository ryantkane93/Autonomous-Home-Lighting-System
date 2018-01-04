
import datetime; #Import the datetime library so the ".now" function can be used
import on;
import off;



fileOpen = open("RPiEmails.txt", 'r'); #Open the file containing the time of events.
events = fileOpen.readlines(); #Retrieve each line in the file.
fileOpen.close(); #Close the file handler




now = datetime.datetime.now() #Retrieves the current time so that it can be compared to the times in the file.

now  = now.replace(second = 0, microsecond = 0); #Truncate the microseconds and seconds for easy comparison.

from datetime import datetime #Import the datetime library so that the strings in the file can be converted to a datetime object. This cancels out the original datetime import.

for event in events:

	times = event.split('|'); #Split each line at the pipe to extract the date and time.
	dateTimeTemp = times[1].split(','); #Remove the day of the week from the string
	dateTimeString = dateTimeTemp[1].split('+'); #Remove non-time/date elements from the rest of the string.
	date_object = datetime.strptime(dateTimeString[0], ' %d %b %Y %H:%M:%S '); #Store the event start time in a datetime object.
	
	date_object = date_object.replace(second =0, microsecond =0); #Truncate microseconds and seconds to compare to now
	
	if (date_object == now): #If the time in the file matches the current time (to the minute) 
		temp = times[0].split('::', 1); #Split the on or off value from the left side of the string.
		lightState = temp[1].split(' ', 1); #Split the on or off value from the right side of the string.
		if lightState[0].strip() == "on":		#Add on or off to the array.
			on.main();
		elif lightState[0].strip()=="off":
			off.main();
	





