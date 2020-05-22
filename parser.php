<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>QTI XML Parser</title>
  </head>
  <body>
<?php
  $qtiXML = 'example_qti_HumanSystemsTest.xml';
  $testTXT = 'test.txt';

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
                            //Convert object value to string
                            $optionStringVal = (string) $options->mattext;
                            //Add multiple choice values to empty array
                            $optionValuesSingleArr[] = $optionStringVal;
                          }

                        }

                      }

                    }

                    //Add each group of 4 multiple choice options (arrays) to 1
                    //array containing each question's array of choices
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

  //Associate letter values with multiple choice values
  $letterOptions = [];

  //Ensure the program only runs if each question has exactly 4 multiple choice options
  foreach($optionValuesAllArr as $optionGroup) {
    if (count($optionGroup) < 4) {
      echo 'Please provide at least 4 multiple choice options for each question.';
      return;
    } elseif (count($optionGroup) > 4) {
      echo 'Please provide no more than 4 multiple choice options for each question.';
      return;
    } else {
      $letterOptions[] = array_combine($optionKeysArr, $optionGroup);
    }
  }

  //Check to make sure each question has a set of answer choices
  if(count($question_text) != count($optionValuesAllArr)) {
    echo 'The number of question and answer pairings do not match.';
    return;
  }

  foreach($question_text as $key=>$value) {

    foreach($letterOptions as $o=>$options) {
      //Create & set the 'question_text' key in the question array (defined at top)
      //to the corresponding question
      $question['question_text'] = $value;
      //Create & set the 'multiple choice' key in the question array (defined at top)
      //to the corresponding array of options, per each each question key
      $question['multiple_choice'] = $letterOptions[$key];

    }
    //Add the question array data formed above to the questions array
    //(defined at top)
    $questions[] = $question;

  }

  //output test content to txt file
  $testContent = '';
  foreach($questions as $question) {

    $testContent .= "\n" . $question['question_text'] . "\n";

    foreach($question['multiple_choice'] as $key=>$value) {
      $testContent .= $key . '. ' . $value . "\n";
    }

  }

  file_put_contents($testTXT, $testContent);
  //echo $testContent;

?>
  <p>View <a href="test.txt">test.txt</a> for printed questions and answers.</p>
  </body>
</html>
