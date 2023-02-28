<!DOCTYPE html>
<html>
<head>
	<title><?php echo $page_title;?></title>
</head>
<body>
  <?php
      $online_exam_info = $this->db->get_where('exam', array('exam_id' => $exam_id))->row();
      $class = $this->db->get_where('classes', array('class_id' => $online_exam_info->class_id))->row()->name;
      $subject = $this->db->get_where('courses', array('course_id' => $online_exam_info->course_id))->row()->name;
      $questions = $this->db->get_where('question_bank', array('exam_id' => $exam_id))->result_array();
      $answers = "answers";
      // calculate total marks
      $total_marks = 0;

      $student_name = $this->db->get_where('student', array('student_id' => $student_id ))->row()->name;
      $student_exam_code = $this->db->get_where('student', array('student_id' => $student_id ))->row()->exam_code;

      $student_result = $this->db->get_where('online_exam_result', array('student_id' => $student_id, 'exam_id' => $exam_id))->row_array();

      $submitted_answer_script_details = $this->db->get_where('online_exam_result', array('exam_id' => $exam_id, 'student_id' => $student_id))->row_array();
      $submitted_answer_script = json_decode($submitted_answer_script_details['answer_script'], true);
      foreach ($questions as $question)
          $total_marks += $question['mark'];
  ?>




  <div style="text-align: center;">
		<img src="<?php echo base_url(); ?>uploads/sys_image/logo.png" width="80" height="80" alt="">

      <h3><?php echo $student_name;?> {<?php echo $student_exam_code; ?>}</h3>
      <h4>Mark Obtained : <?php echo $student_result['obtained_mark']; ?></h4>
      <b><?php echo 'Exam Name: '.$online_exam_info->title;?></b><br>
      <b><?php echo 'Class';?>: <?php echo $class;?></b><br>
      <b><?php echo 'Subject';?>: <?php echo $subject;?></b><br>
      <b><?php echo 'Total Marks';?>: <?php echo $total_marks;?></b><br>
      <p><?php echo 'Instructions';?>: <?php echo $online_exam_info->instruction;?></p>
  </div>
  <div style="margin: 50px 20px 20px 20px;">
      <?php
          $count = 1; foreach ($submitted_answer_script as $row):
          $question_type = $this->crud_model->get_question_details_by_id($row['question_bank_id'], 'type');
          $question_title = $this->crud_model->get_question_details_by_id($row['question_bank_id'], 'question_title');
          $mark = $this->crud_model->get_question_details_by_id($row['question_bank_id'], 'mark');
          $submitted_answer = "";
      ?>
      <div style="height: auto;">
          <div style="width: 95%; float: left;">
               <br>
               <?php echo $count++;?>. <?php echo $question_type == 'fill_in_the_blanks' ? str_replace('^', '__________', $question_title) : $question_title;?>
               <br>
               <?php if ($question_type == 'multiple_choice'):
                   $options_json = $this->crud_model->get_question_details_by_id($row['question_bank_id'], 'options');
                   $number_of_options = $this->crud_model->get_question_details_by_id($row['question_bank_id'], 'number_of_options');
                   if ( $options_json != '' || $options_json != null)
                       $options = json_decode($options_json);
                   else
                       $options = array();
                   ?>
                   <ul>
                       <?php
                        $alpha = array('A','B','C','D','E','F','G','H','I','J','K', 'L','M','N','O','P','Q','R','S','T','U','V','W','X ','Y','Z');
                        for ($i = 0; $i < $number_of_options; $i++): ?>
                           <li><?php echo $alpha[$i];?>. <?php echo $options[$i];?></li>
                       <?php endfor; ?>
                   </ul>
                   <?php
                   if ($row['submitted_answer'] != "" || $row['submitted_answer'] != null) {
                       $submitted_answer = json_decode($row['submitted_answer']);
                       $correct_options = json_decode($row['correct_answers']);
                       if($submitted_answer == $correct_options){
                           $color = 'green';
                       }else{
                           $color = 'red';
                       }
                       $r = '';
                       for ($i = 0; $i < count($submitted_answer); $i++) {
                           $x = $submitted_answer[$i];
                           $r .= $options[$x-1].',';
                       }
                   } else {
                       $submitted_answer = array();
                       $color = 'red';
                       $r = 'Not Answered.';
                   }
                    ?>
                    <i style="color: <?php echo $color; ?>"><strong>[<?php echo 'Submitted Answers';?> - <?php echo rtrim(trim($r), ',');?>]</strong></i>
                    <br>
                   <?php
                   if ($row['correct_answers'] != "" || $row['correct_answers'] != null) {
                       $correct_options = json_decode($row['correct_answers']);
                       $r = '';
                       for ($i = 0; $i < count($correct_options); $i++) {
                           $x = $correct_options[$i];
                           $r .= $options[$x-1].',';
                       }
                   } else {
                       $correct_options = array();
                       $r = 'None Of Them.';
                   }
                    ?>
                    <i style="color:green;"><strong>[<?php echo 'Correct Answer';?> - <?php echo rtrim(trim($r), ',');?>]</strong></i>
                    <hr>

               <?php elseif($question_type == 'fill_in_the_blanks'):
                   if ($row['submitted_answer'] != "" || $row['submitted_answer'] != " ") {
                       $submitted_answer = json_decode($row['submitted_answer']);
                       $correct_options = json_decode($row['correct_answers']);
                       if($submitted_answer == $correct_options){
                           $color = 'green';
                       }else{
                           $color = 'red';
                       }
                   }
                   else{
                       $submitted_answer = 'Not Answered.';
                   }
                   $suitable_words   = implode(',', json_decode($row['correct_answers']));
                ?>
                <br>
                <i style="color: <?php echo $color; ?>"><strong>[<?php echo 'Submitted Answers';?> - <?php echo $submitted_answer;?>]</strong></i><br/>
                <i style="color: green;"><strong>[<?php echo 'Correct Answers';?> - <?php echo $suitable_words;?>]</strong></i>
                <hr>

            <?php elseif($question_type == 'true_false'):
                if ($row['submitted_answer'] != "") {
                    $submitted_answer = $row['submitted_answer'];
                    $correct_options = $row['correct_answers'];
                    if($submitted_answer == $correct_options){
                           $color = 'green';
                   }else{
                       $color = 'red';
                   }
                }
                else{
                    $submitted_answer = get_phrase('not_answered');
                }
                ?>

                <i style="color: <?php echo $color; ?>"><strong>[<?php echo 'Submitted Answer';?> - <?php echo $submitted_answer;?>]</strong></i><br>
                <i style="color: green;"><strong>[<?php echo 'Correct Answer';?> - <?php echo $row['correct_answers'];?>]</strong></i>
                <hr>
               <?php endif; ?>
          </div>
          <div style="width: 5%; float: right; text-align: right;">
              <b><?php echo $mark;?></b>
          </div>
      </div>
      <div style="height: 80px;"></div>
  <?php endforeach;?>
  </div>
</body>
<script src="<?php echo base_url(); ?>assets/js/app.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/scripts.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		window.print();
	});
</script>
</html>
