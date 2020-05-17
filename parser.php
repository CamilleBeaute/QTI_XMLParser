<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>QTI XML Parser</title>
  </head>
  <body>
<?php
  $filename = 'example_qti.xml';

  $xml = simplexml_load_file($filename) or die("Error: Cannot create object");
  //echo('<pre>');
  //print_r($xml);
  //echo('</pre>');

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

                  //question mattext
                  foreach($value as $key=>$value) {
                    echo($value);
                    echo("\n");
                  }

                }

                $optionKeysArr = ['a', 'b', 'c', 'd'];
                //$optionValuesArr = [];
                $optionValuesText = '';

                if($key == 'response_lid') {
                  //print_r($value);

                  //render_choice
                  foreach($value as $key=>$value) {
                    if($key == 'render_choice') {
                      //print_r($value);

                      foreach($value as $key=>$value) {
                        if($key == 'response_label') {
                          //echo '<pre>';
                          //print_r($value);
                          //echo '</pre>';

                          foreach($value as $options) {
                            //echo $options->mattext;

                            $optionValuesText .= $options->mattext . ",";
                            //$optionValuesArr[] = $options->mattext;

                          }

                          //echo $optionValuesText;

                        }

                      }

                    }

                  }

                }

              }

              $optionValuesArr = explode(',', $optionValuesText);
              array_pop($optionValuesArr);
              //echo '<pre>';
              //print_r($optionValuesArr);
              //echo '</pre>';

              $options = array_combine($optionKeysArr, $optionValuesArr);
              //echo '<pre>';
              //print_r($options);
              //echo '</pre>';

              //display options
              foreach($options as $key=>$value) {
                echo $key . '. ' . $value . "\n";
              }

              echo "\n";

            }

          }

        }

      }

    }

  }

?>
  </body>
</html>
