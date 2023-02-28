<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crud_model extends CI_Model {

  function get_total_mark($exam_id){
      $added_question_info = $this->db->get_where('question_bank', array('exam_id' => $exam_id))->result_array();
      $total_mark = 0;
      if (sizeof($added_question_info) > 0){
          foreach ($added_question_info as $single_question) {
              $total_mark = $total_mark + $single_question['mark'];
          }
      }
      return $total_mark;
  }


  function update_multiple_choice_question($question_id){
    $output = array('error' => false);

      if (sizeof($this->input->post('options')) != $this->input->post('number_of_options')) {
        $output['error'] = true;
        $output['message'] = 'No Options can be blank';
          return;
      }
      foreach ($this->input->post('options') as $option) {
          if ($option == "") {
            $output['error'] = true;
            $output['message'] = 'No Options can be blank';
              return;
          }
      }

      if (sizeof($this->input->post('correct_answers')) == 0) {
          $correct_answers = [""];
      }
      else{
          $correct_answers = $this->input->post('correct_answers');
      }

      $data['question_title']     = html_escape($this->input->post('question_title'));
      $data['instructor_id']     = $this->session->userdata('instructor_id');
      $data['mark']               = html_escape($this->input->post('mark'));
      $data['number_of_options']  = html_escape($this->input->post('number_of_options'));
      $data['options']            = json_encode($this->input->post('options'));
      $data['correct_answers']    = json_encode($correct_answers);
      $this->db->where('question_bank_id', $question_id);
      $this->db->update('question_bank', $data);
      $output['message'] = 'Question Updated Successfully';

      echo json_encode($output);


  }
  
  function update_multiple_choice_question_admin($question_id){
    $output = array('error' => false);

      if (sizeof($this->input->post('options')) != $this->input->post('number_of_options')) {
        $output['error'] = true;
        $output['message'] = 'No Options can be blank';
          return;
      }
      foreach ($this->input->post('options') as $option) {
          if ($option == "") {
            $output['error'] = true;
            $output['message'] = 'No Options can be blank';
              return;
          }
      }

      if (sizeof($this->input->post('correct_answers')) == 0) {
          $correct_answers = [""];
      }
      else{
          $correct_answers = $this->input->post('correct_answers');
      }

      $data['question_title']     = html_escape($this->input->post('question_title'));
      $data['mark']               = html_escape($this->input->post('mark'));
      $data['number_of_options']  = html_escape($this->input->post('number_of_options'));
      $data['options']            = json_encode($this->input->post('options'));
      $data['correct_answers']    = json_encode($correct_answers);
      $this->db->where('question_bank_id', $question_id);
      $this->db->update('question_bank', $data);
      $output['message'] = 'Question Updated Successfully';

      echo json_encode($output);


  }

  function update_true_false_question($question_id){
    $output = array('error' => false);

      $data['question_title']     = html_escape($this->input->post('question_title'));
      $data['instructor_id']     = $this->session->userdata('instructor_id');
      $data['mark']               = html_escape($this->input->post('mark'));
      $data['correct_answers']    = html_escape($this->input->post('true_false_answer'));

      $this->db->where('question_bank_id', $question_id);
      $this->db->update('question_bank', $data);
      $output['message'] = 'Question Updated Successfully';

      echo json_encode($output);

  }
  
  
  function update_true_false_question_admin($question_id){
    $output = array('error' => false);

      $data['question_title']     = html_escape($this->input->post('question_title'));
      $data['mark']               = html_escape($this->input->post('mark'));
      $data['correct_answers']    = html_escape($this->input->post('true_false_answer'));

      $this->db->where('question_bank_id', $question_id);
      $this->db->update('question_bank', $data);
      $output['message'] = 'Question Updated Successfully';

      echo json_encode($output);

  }

  function update_fill_in_the_blanks_question($question_id){
			$output = array('error' => false);

			$suitable_words_array = explode(',', html_escape($this->input->post('suitable_words')));
			$suitable_words = array();
			foreach ($suitable_words_array as $row) {
				array_push($suitable_words, strtolower($row));
			}
			$data['question_title']     = html_escape($this->input->post('question_title'));
      $data['instructor_id']     = $this->session->userdata('instructor_id');

			$data['mark']               = html_escape($this->input->post('mark'));
			$data['correct_answers']    = json_encode(array_map('trim',$suitable_words));

			$this->db->where('question_bank_id', $question_id);
			$this->db->update('question_bank', $data);
			$output['message'] = 'Question Updated Successfully';

			echo json_encode($output);

	}
	
	
	function update_fill_in_the_blanks_question_admin($question_id){
			$output = array('error' => false);

			$suitable_words_array = explode(',', html_escape($this->input->post('suitable_words')));
			$suitable_words = array();
			foreach ($suitable_words_array as $row) {
				array_push($suitable_words, strtolower($row));
			}
			$data['question_title']     = html_escape($this->input->post('question_title'));

			$data['mark']               = html_escape($this->input->post('mark'));
			$data['correct_answers']    = json_encode(array_map('trim',$suitable_words));

			$this->db->where('question_bank_id', $question_id);
			$this->db->update('question_bank', $data);
			$output['message'] = 'Question Updated Successfully';

			echo json_encode($output);

	}

  function delete_question_from_online_exam($question_id){
      $this->db->where('question_bank_id', $question_id);
      $this->db->delete('question_bank');
  }

  function change_online_exam_status_to_attended_for_student($exam_id = ""){

      $checker = array(
          'exam_id' => $exam_id,
          'student_id' => $this->session->userdata('login_user_id')
      );

      if($this->db->get_where('online_exam_result', $checker)->num_rows() == 0){
          $inserted_array = array(
              'status' => 'attended',
              'exam_id' => $exam_id,
              'student_id' => $this->session->userdata('login_user_id'),
              'exam_started_timestamp' => strtotime("now")
          );
          $this->db->insert('online_exam_result', $inserted_array);
      }
  }

  function check_availability_for_student($exam_id){

      $result = $this->db->get_where('online_exam_result', array('exam_id' => $exam_id, 'student_id' => $this->session->userdata('login_user_id')))->row_array();

      return $result['status'];
  }

  function get_correct_answer($question_bank_id = ""){

      $question_details = $this->db->get_where('question_bank', array('question_bank_id' => $question_bank_id))->row_array();
      return $question_details['correct_answers'];
  }

  function submit_online_exam($exam_id = "", $answer_script = ""){

      $checker = array(
          'exam_id' => $exam_id,
          'student_id' => $this->session->userdata('login_user_id')
      );
      $updated_array = array(
          'status' => 'submitted',
          'answer_script' => $answer_script
      );

      $this->db->where($checker);
      $this->db->update('online_exam_result', $updated_array);

      $this->calculate_exam_mark($exam_id);
  }

  function calculate_exam_mark($exam_id) {

      $checker = array(
          'exam_id' => $exam_id,
          'student_id' => $this->session->userdata('login_user_id')
      );


      $obtained_marks = 0;
      $online_exam_result = $this->db->get_where('online_exam_result', $checker);
      if ($online_exam_result->num_rows() == 0) {

          $data['obtained_mark'] = 0;
          $data['percentage_mark_obtained'] = 0;
      }
      else{
          $results = $online_exam_result->row_array();
          $answer_script = json_decode($results['answer_script'], true);
          foreach ($answer_script as $row) {

              if ($row['submitted_answer'] == $row['correct_answers']) {

                  $obtained_marks = $obtained_marks + $this->get_question_details_by_id($row['question_bank_id'], 'mark');

              }
          }
          $data['obtained_mark'] = $obtained_marks;
      }

      $total_mark = $this->get_total_mark($exam_id);
      $query = $this->db->get_where('exam', array('exam_id' => $exam_id))->row_array();
      $minimum_percentage = $query['minimum_percentage'];

      $minumum_required_marks = ($total_mark * $minimum_percentage) / 100;
      $percentage_mark_obtained = ($obtained_marks / $total_mark) * 100;
      if ($minumum_required_marks > $obtained_marks) {
          $data['result'] = 'fail';
          $data['total_mark'] = $total_mark;
          $data['percentage_mark_obtained'] = $percentage_mark_obtained;
      }
      else {
          $data['result'] = 'pass';
          $data['total_mark'] = $total_mark;
          $data['percentage_mark_obtained'] = $percentage_mark_obtained;
      }
      $this->db->where($checker);
      $this->db->update('online_exam_result', $data);
  }

  function get_question_details_by_id($question_bank_id, $column_name = "") {

      return $this->db->get_where('question_bank', array('question_bank_id' => $question_bank_id))->row()->$column_name;
  }


}
