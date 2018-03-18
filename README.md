# IRC Drawing Bot
An IRC bot that can paint pixels on a canvas.

This is the IRC bot responsible for the canvas at https://www.jamieweb.net/projects/irc-drawing-bot/. The bot is not designed to be robust or user friendly, but it should be easy to modify for your own needs given some basic programming/PHP knowledge.

One of the main features of this bot is heavy user input sanitization and verification, meaning that actual user input is never used to construct the pixel array. This will need to be adjusted manually depending on what you are using it for.

If you have a password for identifying with NickServ, simply put it in the file "identify.txt".

Make sure to run this as a separate user to your web server. Create a hard link between the grid.txt configuration file and the file on your web server that is used by render.php.

**Note that the bot file in this repository contains hard-coded connection and configuration information. As I described above, this program is not designed to be robust so you'll have to change the values manually for your own use.**
