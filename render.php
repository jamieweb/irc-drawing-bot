<html>
  <head>
    <style>
      table.irc tr td {
        height: 40px;
        width: 40px;
        padding: 0px;
      }
    </style
  </head>
  <body>
    <table class="irc">
<?php set_time_limit(1); echo "<tr><td bgcolor=\"" . str_replace(":", "\"></td></tr>\n<tr><td bgcolor=\"", str_replace(" ", "\"></td><td bgcolor=\"", str_replace("\n", "", preg_replace("/[^A-Za-z0-9: ]/", "", file_get_contents("config.txt"))))) . "\"></td></tr>\n"; ?>
    </table>
  </body>
</html>