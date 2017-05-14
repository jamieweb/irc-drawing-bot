<?php set_time_limit(0);

$ircSocket = fsockopen("ssl://chat.freenode.net", "7000", $errno, $errstr, 1);

if ($ircSocket) {

    fwrite($ircSocket, "USER ircbot jamieweb.net Freenode :JamieWebBot\n");
    fwrite($ircSocket, "NICK JamieWebBot\n");
    fwrite($ircSocket, "JOIN ##jamieweb\n");
    fwrite($ircSocket, "PRIVMSG NickServ :IDENTIFY JamieWebBot " . file_get_contents("identify.txt") . "\n");

    $currentColour = "red";
    $currentX = "0";
    $currentY = "0";

    $grid = preg_replace("/[^a-z\n: ]/", '', file_get_contents("grid.txt"));
    $grid = explode("\n", $grid);
    $confArray = array();
    foreach($grid AS $row){
        $confArray[] = explode(' ', $row);
    }

    function updateConf() {
        global $confArray;
        $grid = array_merge(...$confArray);
        $grid = implode(' ', $grid);
        $grid = str_replace(": ", ":\n", $grid);
        $grid = rtrim($grid);
        //echo $grid;

        file_put_contents("grid.txt", preg_replace("/[^a-z\n: ]/", '', $grid));
    }

    while(1) {
        while($data = preg_replace("/[^A-Za-z0-9! ]/", '', fgets($ircSocket, 128))) {
            //echo $data;
            if((trim(explode(' ', $data)[0]) == "PING") && (preg_match("/freenodenet$/", trim(explode(' ', $data)[1])))) {
                fwrite($ircSocket, "PONG\n");
            } elseif(trim(explode(' ', $data)[3]) == "!hello") {
                fwrite($ircSocket, "PRIVMSG ##jamieweb :Hello!\n");
            } elseif(trim(explode(' ', $data)[3]) == "!draw") {
                if($currentX == "19") {
                    if($currentY == "9") {
                        $confArray[$currentY][$currentX] = $currentColour;
                        updateConf();
                        fwrite($ircSocket, "PRIVMSG ##jamieweb :Drawing colour '" . $currentColour . "' at: " . ($currentX + 1) . ", " . ($currentY + 1) . ".\n");
                    } else {
                        $confArray[$currentY][$currentX] = $currentColour . ":";
                        updateConf();
                        fwrite($ircSocket, "PRIVMSG ##jamieweb :Drawing colour '" . $currentColour . "' at: " . ($currentX + 1) . ", " . ($currentY + 1) . ".\n");
                    }
                } else {
                    $confArray[$currentY][$currentX] = $currentColour;
                    updateConf();
                    fwrite($ircSocket, "PRIVMSG ##jamieweb :Drawing colour '" . $currentColour . "' at: " . ($currentX + 1) . ", " . ($currentY + 1) . ".\n");
                }
            } elseif(trim(explode(' ', $data)[3]) == "!colour") {
                $data = trim(stripslashes(htmlspecialchars(preg_replace("/[^a-z ]/", '', $data))));
                if(preg_match("/^(red|yellow|green|blue|lightblue|white|black|orange|pink|brown)$/", trim(explode(' ', $data)[4]))) {
                    //Deliberately inefficient code below - to allow for using colour codes instead of names in the future (also prevents sanitized user input from been directly used)
                    if(trim(explode(' ', $data)[4]) == "red") {
                        $currentColour = "red";
                        fwrite($ircSocket, "PRIVMSG ##jamieweb :Colour set to: " . $currentColour . ".\n");
                    } elseif(trim(explode(' ', $data)[4]) == "yellow") {
                        $currentColour = "yellow";
                        fwrite($ircSocket, "PRIVMSG ##jamieweb :Colour set to: " . $currentColour . ".\n");
                    } elseif(trim(explode(' ', $data)[4]) == "green") {
                        $currentColour = "green";
                        fwrite($ircSocket, "PRIVMSG ##jamieweb :Colour set to: " . $currentColour . ".\n");
                    } elseif(trim(explode(' ', $data)[4]) == "blue") {
                        $currentColour = "blue";
                        fwrite($ircSocket, "PRIVMSG ##jamieweb :Colour set to: " . $currentColour . ".\n");
                    } elseif(trim(explode(' ', $data)[4]) == "lightblue") {
                        $currentColour = "lightblue";
                        fwrite($ircSocket, "PRIVMSG ##jamieweb :Colour set to: " . $currentColour . ".\n");
                    } elseif(trim(explode(' ', $data)[4]) == "white") {
                        $currentColour = "white";
                        fwrite($ircSocket, "PRIVMSG ##jamieweb :Colour set to: " . $currentColour . ".\n");
                    } elseif(trim(explode(' ', $data)[4]) == "black") {
                        $currentColour = "black";
                        fwrite($ircSocket, "PRIVMSG ##jamieweb :Colour set to: " . $currentColour . ".\n");
                    } elseif(trim(explode(' ', $data)[4]) == "orange") {
                        $currentColour = "orange";
                        fwrite($ircSocket, "PRIVMSG ##jamieweb :Colour set to: " . $currentColour . ".\n");
                    } elseif(trim(explode(' ', $data)[4]) == "pink") {
                        $currentColour = "pink";
                        fwrite($ircSocket, "PRIVMSG ##jamieweb :Colour set to: " . $currentColour . ".\n");
                    } elseif(trim(explode(' ', $data)[4]) == "brown") {
                        $currentColour = "brown";
                        fwrite($ircSocket, "PRIVMSG ##jamieweb :Colour set to: " . $currentColour . ".\n");
                    }
                } else {
                    fwrite($ircSocket, "PRIVMSG ##jamieweb :Invalid colour. Use '!colours' to view a list of supported colours.\n");
                }
            } elseif(trim(explode(' ', $data)[3]) == "!move") {
                $data = trim(stripslashes(htmlspecialchars(preg_replace("/[^a-z0-9 ]/", '', $data))));
                if((preg_match("/^([1-9]|10|[1][1-9]|20)$/", trim(explode(' ', $data)[4]))) && (preg_match("/^([1-9]|10)$/", trim(explode(' ', $data)[5])))) {
                    $currentX = intval(trim(explode(' ', $data)[4]) - 1, 10);
                    $currentY = intval(trim(explode(' ', $data)[5]) - 1, 10);
                    fwrite($ircSocket, "PRIVMSG ##jamieweb :Moving pen to: " . ($currentX + 1) . ", " . ($currentY + 1) . ".\n");
                } else {
                    fwrite($ircSocket, "PRIVMSG ##jamieweb :Invalid input. Must be integers 1-20 for x (across) and 1-10 for y (down).\n");
                }
            } elseif(trim(explode(' ', $data)[3]) == "!colours") {
                fwrite($ircSocket, "PRIVMSG ##jamieweb :Allowed colours: red, yellow, green, blue, lightblue, white, black, orange, pink, brown.\n");
            } elseif(trim(explode(' ', $data)[3]) == "!help") {
                fwrite($ircSocket, "PRIVMSG ##jamieweb :For help using the bot, please see https://www.jamieweb.net/projects/irc-drawing-bot/. For technical information, see https://www.jamieweb.net/blog/irc-drawing-bot/.\n");
            }
            sleep(1);
        }
    }
} else {
    echo "Could not extablish a connection to the IRC server.";
}

?>
