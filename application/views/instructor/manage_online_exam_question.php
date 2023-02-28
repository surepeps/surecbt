<?php
    $online_exam_details = $this->db->get_where('exam', array('exam_id' => $exam_id))->row_array();
    $added_question_info = $this->db->get_where('question_bank', array('exam_id' => $exam_id))->result_array();
?>
<div class="row">
  <div class="col-md-12" style="margin-bottom: 10px;" >
      <button type="button" class="btn btn-info pull-right" id="questions_print">
          <i class="fas fa-print"></i> &nbsp; Print
      </button>
      <div id="print_options">
          <a href="<?php echo site_url('instructor/exam_questions_print/'.$exam_id.'/answers');?>" class="btn btn-white pull-right" id="questions_print_with_answers">
              <i class="fas fa-print"></i> &nbsp; Print With Answers
          </a>
          <a href="<?php echo site_url('instructor/exam_questions_print/'.$exam_id.'/no_answers');?>" class="btn btn-white pull-right" id="questions_print_without_answers">
              <i class="fas fa-print"></i> &nbsp; Print Without Answers
          </a>
      </div>
  </div>
</div>
<div class="row">
  <div class="col-12 col-md-12 col-lg-12">
    <div class="card card-primary">
      <div class="card-header">
        <h4>Question List</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered">
              <thead>
                  <tr>
                      <th style="text-align: center;" width="5%"><div>#</div></th>
                      <th style="text-align: center;"><div>Type</div></th>
                      <th style="text-align: center;" width="60%"><div>Question</div></th>
                      <th style="text-align: center;" width="10%">Mark</th>
                      <th style="text-align: center;">Options</th>
                  </tr>
              </thead>
              <tbody>
                  <?php if (sizeof($added_question_info) == 0):?>
                      <tr>
                          <td style="text-align: center;" colspan="5"><?php echo 'No Question Has Been Added Yet'; ?></td>
                      </tr>

                      <?php
                      elseif (sizeof($added_question_info) > 0):
                      $i = 0;
                      foreach ($added_question_info as $added_question): ?>
                          <tr id="<?php echo $added_question['question_bank_id']; ?>">
                              <td style="text-align: center;"><?php echo ++$i; ?></td>
                              <td><?php echo ucfirst($added_question['type']);?></td>
                              <?php if ($added_question['type'] == 'fill_in_the_blanks'): ?>
                                  <td><?php echo str_replace('^', '____', $added_question['question_title']); ?></td>
                              <?php else: ?>
                                  <td><?php echo $added_question['question_title']; ?></td>
                              <?php endif; ?>
                              <td style="text-align: center;"><?php echo $added_question['mark']; ?></td>
                              <td style="text-align: center;">
                                <a href="#" onclick="getAjaxModal('<?php echo site_url('modal/popup/update_online_exam_question/'.$added_question['question_bank_id']);?>')" class="btn btn-primary btn-xs" data-toggle="tooltip" title="<?php echo 'Edit'; ?>"><i class="fas fa-edit"></i></a>
                                <a class="deleteQuestion btn btn-danger btn-xs"  data-toggle="tooltip" title="<?php echo 'Delete'; ?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
                              </td>
                          </tr>
                      <?php endforeach; ?>
                  <?php endif; ?>
              </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="col-12 col-md-6 col-lg-6">
    <div class="card card-secondary">
      <div class="card-header">
        <h4>Exam Information</h4>
      </div>
      <div class="card-body">
        <table  class="table table-bordered">
            <tbody>
                <tr>
                    <td><b><?php echo 'Exam Title';?></b></td>
                    <td><?php echo $online_exam_details['title']; ?></td>
                    <td><b><?php echo 'Date';?></b></td>
                    <td><?php echo date('M d, Y', $online_exam_details['exam_date']); ?></td>
                </tr>
                <tr>
                    <td><b><?php echo 'Class';?></b></td>
                    <td><?php echo $this->db->get_where('classes', array('class_id' => $online_exam_details['class_id']))->row()->name; ?></td>
                    <td><b><?php echo 'Time';?></b></td>
                    <td><?php echo $online_exam_details['time_start'].' - '.$online_exam_details['time_end']; ?></td>
                </tr>
                <tr>
                    <td><b><?php echo 'Category';?></b></td>
                    <td><?php $class_cat_id = $this->db->get_where('classes', array('class_id' => $online_exam_details['class_id']))->row()->class_cat_id;
                      echo $this->db->get_where('class_cat', array('class_cat_id' => $class_cat_id))->row()->name;
                    ?></td>
                    <td><b><?php echo 'Passing Percentage';?></b></td>
                    <td><?php echo $online_exam_details['minimum_percentage'].'%'; ?></td>
                </tr>
                <tr>
                    <td><b><?php echo 'Subject';?></b></td>
                    <td><?php echo $this->db->get_where('courses', array('course_id' => $online_exam_details['course_id']))->row()->name; ?></td>
                    <td><b><?php echo 'Total Marks';?></b></td>
                    <td>
                        <?php if (sizeof($added_question_info) == 0):?>
                            <?php echo 0; ?>
                        <?php elseif (sizeof($added_question_info) > 0):?>
                            <?php
                                $total_mark = 0;
                                foreach ($added_question_info as $single_question) {
                                    $total_mark = $total_mark + $single_question['mark'];
                                }
                                echo $total_mark;
                             ?>
                        <?php endif; ?>
                    </td>
                </tr>
            </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="col-12 col-md-6 col-lg-6">
    <div class="card card-danger">
      <div class="card-header">
        <h4><i class="fas fa-plus"></i>  Add New Question</h4>
      </div>
      <div class="card-body">
        <div class="form-group">
          <label>Question Type</label>
          <select class="form-control select2" name="question_type" style="width: 100%;" id="question_type">
              <option value=""><?php echo 'Select Question Type';?></option>
              <option value="multiple_choice"><?php echo 'Multiple Choice';?></option>
              <option value="true_false"><?php echo 'True Or False';?></option>
              
          </select>
        </div>
        <br/>
        <div id="question_holder"></div>
      </div>
    </div>
  </div>
</div>
