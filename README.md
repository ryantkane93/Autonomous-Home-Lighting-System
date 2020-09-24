# Autonomous-Home-Lighting-System
This autonomous home lighting system is a working prototype that harnesses the power of the Internet of Things in an attempt to conserve our planet's dwindling resources.
Rigorous testing of the prototype revealed that, when used properly, the system could reduce wasteful light emissions by 17%. Each of the scripts in this repository reside
on a Raspberry Pi (Model 2) running Raspbian (a Debian-based operating system) where there execution is controlled using Linux's native CRON scheduler. Produced using the
LAMP stack, the entirety of the software is written in PHP and Python. The system relies on being subscribed to a user's Google Calendar so that it has access to event alerts.
Each incoming alert is assessed to determine whether the user will no longer be home so that the lights can be turned off (if necessary). The following gives a brief summary
of the roles of each of the scripts in this process:

1. phpEmail.php: Obtains user's Google calendar alerts from the Raspberry Pi's e-mail inbox, determines which events may be at risk of wasteful light emissions,
and writes them to a text file.
2. deleteEmail.php: Extracts date infromation of the Raspberry Pi's e-mail inbox and deletes all messages that have already been processed.
3. processEmail.py: Checks the times of each Google Calendar event extracted by phpEmail and, if necessary, adjusts the state of the lights once the event has begun/ended.
4. on.py: Script responsible for powering on all lights connected to the Raspberry Pi when a user's event has finished.
5. off.py: Script responsible for powering off all lights connected to the Raspberry Pi when a user exits their home.
