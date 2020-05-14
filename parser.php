<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>QTI XML Parser</title>
  </head>
  <body>
    <pre>
      <?php
        $filename = 'example_qti.xml';

        $xml = simplexml_load_file($filename) or die("Error: Cannot create object");
        print_r($xml);

      ?>
    </pre>
  </body>
</html>
