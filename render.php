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
<?php set_time_limit(1); echo "<tr><td bgcolor=\"" . str_replace(":", "\"></td></tr>\n<tr><td bgcolor=\"", str_replace(" ", "\"></td><td bgcolor=\"", str_replace("\n", "", preg_replace("/[^a-eghiklnoprtuwy: ]/", "", filter_var(strtolower(rtrim(substr(file_get_contents("grid.txt"), 0, 1536))), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH))))) . "\"></td></tr>\n"; ?>
    </table>
  </body>
</html>
