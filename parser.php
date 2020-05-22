<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>QTI XML Parser</title>
  </head>
  <body>
<?php
  $qtiXML = 'example_qti.xml';
  $testTXT = 'test.txt';
  //clear file contents before adding new content
  file_put_contents('test.txt','');

  $xml = simplexml_load_file($qtiXML) or die("Error: Cannot create object");
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
                  $questions = '';
                  foreach($value as $key=>$value) {
                    //echo($value);
                    //echo("\n");

                    $questions .= "\n" . html_entity_decode($value, ENT_QUOTES | ENT_HTML5) . "\n";
                  }
                  file_put_contents($testTXT, $questions, FILE_APPEND);

                }

                $optionKeysArr = ['a', 'b', 'c', 'd'];
                $optionValuesArr = [];
                //$optionValuesText = '';

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
                            //convert options object to an array
                            $options = (array) $options;
                            //add multiple choice values to empty array
                            $optionValuesArr[] = $options['mattext'];
                          }

                        }

                      }

                    }

                  }

                }

              }

              $options = array_combine($optionKeysArr, $optionValuesArr);
              //echo '<pre>';
              //print_r($options);
              //echo '</pre>';

              //display formatted multiple choice options
              $multiple_choices = '';
              foreach($options as $key=>$value) {
                $multiple_choices .= $key . '. ' . $value . "\n";
              }

              file_put_contents($testTXT, $multiple_choices, FILE_APPEND);

            }

          }

        }

      }

    }

  }

?>
  <p>View <a href="test.txt">test.text</a> for printed questions and answers.</p>
  </body>
</html>
