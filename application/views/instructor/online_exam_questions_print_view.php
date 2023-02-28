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
		// calculate total marks
		$total_marks = 0;
		foreach ($questions as $question)
			$total_marks += $question['mark'];
	?>
	<div style="text-align: center;">
		<img src="<?php echo base_url(); ?>uploads/sys_image/logo.png" width="80" height="80" alt="">
		<h3></h3>
		<b><?php echo $online_exam_info->title;?></b><br>
		<b><?php echo 'Class';?>: <?php echo $class;?></b><br>
		<b><?php echo 'Subject';?>: <?php echo $subject;?></b><br>
		<b><?php echo 'Total Marks';?>: <?php echo $total_marks;?></b><br>
		<b><?php echo 'Time';?>: <?php echo ($online_exam_info->duration / 60) . ' Minutes';?></b>
		<p><?php echo 'Instructions';?>: <?php echo $online_exam_info->instruction;?></p>
	</div>
	<div style="margin: 50px 20px 20px 20px;">
		<?php $count = 1; foreach ($questions as $row): ?>
		<div style="height: auto;">
			<div style="width: 95%; float: left;">
			    <?php echo $count++;?>. <?php echo $row['type'] == 'fill_in_the_blanks' ? str_replace('^', '__________', $row['question_title']) : $row['question_title'];?>
			    <p>
			    	<?php if ($row['type'] == 'true_false') { ?>
                        <ul>
                        	<li><?php echo 'True';?></li>
                        	<li><?php echo 'False';?></li>
                        </ul>
                        <?php if ($answers == 'answers'):?>
							<i><strong>[<?php echo 'Correct Answer';?> - <?php echo $row['correct_answers'];?>]</strong></i>
                        <?php endif;?>
			    	<?php } else if ($row['type'] == 'fill_in_the_blanks') { ?>
						<b><?php echo 'Answer';?>: </b>
						<?php if ($answers == 'answers'):
							$suitable_words = implode(',', json_decode($row['correct_answers']));
						?>
							<br><br>
							<i><strong>[<?php echo 'Correct Answers';?> - <?php echo $suitable_words;?>]</strong></i>
                        <?php endif;?>
			    	<?php } else {
			    		if ($row['options'] != '' || $row['options'] != null)
			    			$options = json_decode($row['options']);
			    		else
			    			$options = array();
			    		?>
						<ul>
							<?php
							$alpha = array('A','B','C','D','E','F','G','H','I','J','K', 'L','M','N','O','P','Q','R','S','T','U','V','W','X ','Y','Z');

							for ($i = 0; $i < $row['number_of_options']; $i++): ?>
								<li><?php echo $alpha[$i];?>. <?php echo $options[$i];?></li>
							<?php endfor; ?>
						</ul>
						<?php if ($answers == 'answers'):
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
							<i><strong>[<?php echo 'Correct Answer';?> - <?php echo rtrim(trim($r), ',');?>]</strong></i>
                        <?php endif;?>
			    	<?php } ?>
			    </p>
		    </div>
		    <div style="width: 5%; float: right; text-align: right;">
			    <b><?php echo $row['mark'];?></b>
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
