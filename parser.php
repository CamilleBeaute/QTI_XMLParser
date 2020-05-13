<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>PHP Tutorial</title>
  </head>
  <body>

      <?php
        echo("Hello World!");
        echo("<br>");
        echo("<br>");

        $myXMLData =
          "<?xml version='1.0' encoding='UTF-8'?>
          <note>
          <to>Tove</to>
          <from>Jani</from>
          <heading>Reminder</heading>
          <body>Don't forget me this weekend!</body>
          </note>";

          $xml = simplexml_load_string($myXMLData) or die("Error: Cannot create object");
          print_r($xml);
      ?>

  </body>
</html>
