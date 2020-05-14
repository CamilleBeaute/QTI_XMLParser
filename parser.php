<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>QTI XML Parser</title>
  </head>
  <body>
    <!--pre-->
      <?php
        $filename = 'example_qti.xml';

        $xml = simplexml_load_file($filename) or die("Error: Cannot create object");
        //print_r($xml);

        //assessment array
        foreach($xml as $assessment) {
          //print_r($assessment);

          //section array
          foreach($assessment as $section) {
            //print_r($section);

            //item array
            foreach($section as $key=>$value) {
              if($key == 'item') {
                //print_r($value);

                //presentation array
                foreach($value as $key=>$value) {
                  if($key == 'presentation') {

                    //material array
                    foreach ($value as $key=>$value) {
                      if($key == 'material') {
                        //print_r($value);

                        //mattext
                        foreach($value as $key=>$value) {
                          echo($value);
                          echo('<br>');
                        }

                      }

                    }

                  }
                }

              }
            }

          }
        }

      ?>
    <!--/pre-->
  </body>
</html>
