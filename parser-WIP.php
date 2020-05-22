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

  //Interpret XML file into an object
  $xml = simplexml_load_file($qtiXML) or die("Error: Cannot create object");

  //Define question arrays
  $questions = [];
  $question = [];
  $question_text = [];
  $optionKeysArr = ['a', 'b', 'c', 'd'];
  $optionValuesAllArr = [];
  $multiple_choice_options = [];
  $correct_answer = [];

  //assessment array
  foreach($xml as $assessment) {

    //section array
    foreach($assessment as $section) {

      //item array
      foreach($section as $key=>$value) {

        if($key == 'item') {

          //presentation array
          foreach($value as $key=>$value) {
            if($key == 'presentation') {

              //material array
              foreach ($value as $key=>$value) {
                if($key == 'material') {

                  foreach($value as $key=>$value) {
                    $question_text[] = html_entity_decode($value, ENT_QUOTES | ENT_HTML5);
                  }
                  //file_put_contents($testTXT, $questions, FILE_APPEND);
                }

                if($key == 'response_lid') {

                  //render_choice
                  foreach($value as $key=>$value) {
                    if($key == 'render_choice') {

                      //Declare array for collecting choices for a single question
                      $optionValuesSingleArr = [];

                      foreach($value as $key=>$value) {
                        if($key == 'response_label') {

                          foreach($value as $options) {
                            //convert object value to string
                            $optionStringVal = (string) $options->mattext;
                            //add multiple choice values to empty array
                            $optionValuesSingleArr[] = $optionStringVal;
                          }

                        }

                      }

                    }

                    $optionValuesAllArr[] = $optionValuesSingleArr;

                  }

                }

              }

            }

          }

        }

      }

    }

  }

  //echo '<pre>';
  //print_r($question_text);
  //echo '</pre>';

  //associate letter values with multiple choice values
  $letterOptions = [];
  foreach($optionValuesAllArr as $optionGroup) {
    $letterOptions[] = array_combine($optionKeysArr, $optionGroup);
  }

  //echo '<pre>';
  //print_r($letterOptions);
  //echo '</pre>';


  //Check to make sure each question has answer choices
  if(count($question_text) != count($optionValuesAllArr)) {
    echo 'The number of question and answer pairings do not match.';
    return;
  }

  //$c = array_combine($question_text, $optionValuesAllArr);

  foreach($question_text as $key=>$value) {

    foreach($letterOptions as $o=>$options) {
      $question['question_text'] = $value;
      $question['multiple_choice'] = $letterOptions[$key];

    }

    $questions[] = $question;

  }

  //echo '<pre>';
  //print_r($questions);
  //echo '</pre>';

  //output test cpntent to txt file
  $testContent = '';
  foreach($questions as $question) {

    $testContent .= "\n" . $question['question_text'] . "\n";

    foreach($question['multiple_choice'] as $key=>$value) {
      $testContent .= $key . '. ' . $value . "\n";
    }

  }

  file_put_contents($testTXT, $testContent, FILE_APPEND);
  //echo $testContent;


?>
  <p>View <a href="test.txt">test.txt</a> for printed questions and answers.</p>
  </body>
</html>
