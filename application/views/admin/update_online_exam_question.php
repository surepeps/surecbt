<?php
    $question_details = $this->db->get_where('question_bank', array('question_bank_id' => $param2))->row_array();
    if ($question_details['options'] != "" || $question_details['options'] != null) {
        $options = json_decode($question_details['options']);
    } else {
        $options = array();
    }
    if ($question_details['correct_answers'] != "" || $question_details['correct_answers'] != null) {
        $correct_answers= json_decode($question_details['correct_answers']);
    } else {
        $correct_answers = array();
    }

    $online_exam_details = $this->db->get_where('exam', array('exam_id' => $question_details['exam_id']))->row_array();

    $added_question_info = $this->db->get_where('question_bank', array('exam_id' => $online_exam_details['exam_id']))->result_array();
    if($question_details['type'] == 'fill_in_the_blanks') {
        $suitable_words = implode(',', json_decode($question_details['correct_answers']));
    }
?>

<style media="screen">
.red {
    color: #f44336;
}
</style>
<div class="row">
  <div class="col-12 col-md-12 col-lg-12">
    <div class="card-header">
      <h4>Edit Exam Question</h4>
    </div>
    <div class="card-body">
      <form id="editquestionForm">

        <div class="form-group">
          <label>Mark</label>
          <input type="number" class="form-control" name="mark" required min="0" value="<?php echo $question_details['mark']; ?>"/>
        </div>

        <div class="form-group">
          <label><?php echo 'Question Title';?></label>
          <textarea name="question_title" class="form-control" id="question_title" rows="8" cols="80" required <?php if($question_details['type'] == 'fill_in_the_blanks') echo "onkeyup='changeTheBlankColor()'"; ?>>
            <?php echo $question_details['question_title']; ?>
          </textarea>
        </div>

        <!-- Multiple choice question portion -->
          <?php if ($question_details['type'] == 'multiple_choice'): ?>
            <div class="form-group" id='multiple_choice_question'>
                <label>Number of options</label>
                <div class="input-group">
                  <input type="number" class="form-control" name="number_of_options" id="number_of_options" required min="0" value="<?php echo $question_details['number_of_options']; ?>"/>
                  <div class="input-group-append">
                    <button type="button" name="button" onclick="showOptions(jQuery('#number_of_options').val())" class="input-group-text">
                      <i class="fa fa-check"></i>
                    </button>
                  </div>
                </div>
            </div>
            <?php for ($i = 0; $i < $question_details['number_of_options']; $i++):?>
              <div class="form-group options">
                <label><?php echo 'Option '.($i+1);?></label>
                <div class="input-group">
                  <input type="text" class="form-control" name = "options[]" id="option_<?php echo $i+1; ?>" placeholder="<?php echo 'Option '.($i+1); ?>" required value="<?php echo $options[$i]; ?>">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <input type = 'checkbox' name = "correct_answers[]" value = <?php echo ($i+1); ?> <?php if(in_array(($i+1), $correct_answers)) echo 'checked'; ?>>
                    </div>
                  </div>
                </div>
              </div>
            <?php endfor;?>
          <?php endif; ?>


          <!-- True False question portion -->
          <?php if ($question_details['type'] == 'true_false'): ?>
            <div class="row"  style="margin-top: 10px; text-align: left;">
                <div class="col-sm-12 col-sm-offset-3">
                    <p>
                        <input type="radio" id="true" name="true_false_answer" value="true" <?php if($question_details['correct_answers'] == 'true') echo 'checked';  ?>>
                        <label for="true">True</label>
                    </p>
                </div>
                <div class="col-sm-12 col-sm-offset-3">
                    <p>
                        <input type="radio" id="false" name="true_false_answer" value="false" <?php if($question_details['correct_answers'] == 'false') echo 'checked';  ?>>
                        <label for="false">False</label>
                    </p>
                </div>

            </div>
          <?php endif; ?>


          <!-- Fill In The Blanks question portion -->
          <?php if ($question_details['type'] == 'fill_in_the_blanks'): ?>
              <div class="form-group">
                <label>Preview</label>
                <div class="" id = "preview"></div>
              </div>

              <div class="form-group">
                <label>Suitable Words</label>
                <textarea name="suitable_words" class = "form-control" rows="8" cols="80" required placeholder="<?php echo 'This Area Will Contain Suitable Words For The Blanks Please Write Down The Suitable Words Side By Side With A Comma Delimiter......'; ?>" ><?php echo $suitable_words; ?></textarea>
              </div>
          <?php endif; ?>

          <div class="form-group">
            <button type="submit" class="btn btn-info btn-block" id="editquestionText"></button>
          </div>

      </form>
    </div>
  </div>
</div>


<!-- EDIT QUESTIONS JS START -->
<script type="text/javascript">
  $(document).ready(function(){
    $('#editquestionText').html('Update Question');
    $('#editquestionForm').submit(function(e){
      e.preventDefault();
      $("#editquestionText").addClass('btn-progress disabled');
      var url = '<?php echo base_url(); ?>';
      var user = $('#editquestionForm').serialize();
      var question_id = '<?php echo $param2;?>';
      var online_exam_id = '<?php echo $question_details['exam_id']; ?>';
      var editquestion = function(){
          $.ajax({
            type: 'POST',
            url: url + 'admin/update_online_exam_question/' + question_id + '/update/' + online_exam_id,
            dataType: 'json',
            data: user,
          success:function(response){
          $("#editquestionText").removeClass('btn-progress disabled');
              if(response.error){
                iziToast.error({
                  title: 'Error!',
                  message: response.message,
                  position: 'topRight'
                });
              }
              else{
                iziToast.success({
                  title: 'Success!',
                  message: response.message,
                  position: 'topRight'
                });
                setTimeout(function(){
                  location.reload();
                }, 4000);
              }
            }
          });
        };
        setTimeout(editquestion, 2000);
      });

    });
</script>
<!-- EDIT QUESTIONS JS END -->

<script type="text/javascript">

    jQuery(document).ready(function($) {
        changeTheBlankColor();
    });

    function showOptions(number_of_options){
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('admin/manage_multiple_choices_options'); ?>",
            data: {number_of_options : number_of_options},
            success: function(response){
                console.log(response);
                jQuery('.options').remove();
                jQuery('#multiple_choice_question').after(response);
            }
        });
    }

    function changeTheBlankColor(){
        var alpha = ["^"];
        var res = "", cls = "";
        var t = jQuery("#question_title").val();

        for (i=0; i<t.length; i++) {
            for (j=0; j<alpha.length; j++) {
                if (t[i] == alpha[j])
                {
                    cls = "red";
                }
            }
            if (t[i] === "^") {
                res += "<span class='"+cls+"'>"+'__'+"</span>";
            }
            else{
                res += "<span class='"+cls+"'>"+t[i]+"</span>";
            }
            cls="";
        }
        jQuery("#preview").html(res);
    }
</script>
