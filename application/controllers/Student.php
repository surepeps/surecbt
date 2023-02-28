<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class Student extends CI_Controller
{

    function __construct() {
		parent::__construct();
		$this->load->database();

	}


  //Default function, redirects to logged in user area
	public function index() {

			if ($this->session->userdata('student_login') == 1)
					redirect(site_url('student/dashboard'), 'refresh');

			$this->load->view('student/login');
	}


  //Validating login from ajax request
  function validate_login() {
    $exam_code = $this->input->post('exam_code');
    $credential = array('exam_code' => $exam_code, 'status' => 'active');
    // Checking login credential for admin
    $query = $this->db->get_where('student', $credential);
    if ($query->num_rows() > 0) {
        $row = $query->row();
        $this->session->set_userdata('student_login', '1');
        $this->session->set_userdata('student_id', $row->student_id);
        $this->session->set_userdata('login_user_id', $row->student_id);
        $this->session->set_userdata('name', $row->name);
        $this->session->set_userdata('login_type', 'student');
        $this->session->set_flashdata('flash_message', 'Successfully Logged In');
        redirect(site_url('student/dashboard'), 'refresh');
    }

    $this->session->set_flashdata('error_message', 'Invalid Login Details');
    redirect(site_url('student'), 'refresh');

  }


  function dashboard(){
    if ($this->session->userdata('student_login') != 1)
        redirect(site_url('student'), 'refresh');

    $page_data['page_title'] = 'Dashboard';
    $page_data['page_name'] = 'dashboard';
    $this->load->view('index', $page_data);
  }


  function reg(){
    if ($this->session->userdata('student_login') == 1)
        redirect(site_url('student/dashboard'), 'refresh');

    $page_data['classes'] = $this->db->get('classes')->result_array();

    $this->load->view('student/register', $page_data);
  }


  function register_validate(){
        $system_abbrv = $this->db->get_where('settings' , array('type'=>'system_abbrv'))->row()->description;
        $code = substr(md5(rand(0, 1000000)), 0, 7);
        $combocode = $system_abbrv.'-'.$code;
        $data['name'] = html_escape($this->input->post('name'));
        $data['sex'] = $this->input->post('sex');
        $data['phone'] = html_escape($this->input->post('phone'));
        $data['status'] = 'active';
        $data['exam_code'] = $combocode;


        if(!empty($data['exam_code'])) {
            $this->db->insert('student', $data);
            $student_id = $this->db->insert_id();

            $data2['student_id'] = $student_id;
            $data2['enroll_code'] = substr(md5(rand(0, 1000000)), 0, 7);
            $classid = $this->input->post('class_id');
            $data2['class_cat_id'] = $this->db->get_where('classes', array('class_id' => $classid))->row()->class_cat_id;
            $data2['class_id'] = $this->input->post('class_id');
            $data2['date_added']     = strtotime(date("Y-m-d H:i:s"));
            $this->db->insert('enroll', $data2);
            $this->session->set_flashdata('flash_message', 'Successfully Registered Your Exam id Is: <h2>'.$combocode. '</h2> Always enter your exam id below to attend exams');
            redirect(site_url('student'), 'refresh');
        }
        else {
          $this->session->set_flashdata('error_message', 'Sorry Exam Id could not generate Try later or contact the Support Center');
      		redirect(site_url('student/reg'), 'refresh');
        }

  }

      function take_exam($exam_code) {
          if ($this->session->userdata('student_login') != 1)
              redirect(site_url('student'), 'refresh');

          $exam_id = $this->db->get_where('exam', array('exam_code' => $exam_code))->row()->exam_id;
          $student_id = $this->session->userdata('login_user_id');
          // check if the student has already taken the exam
          $check = array('student_id' => $student_id, 'exam_id' => $exam_id);
          $taken = $this->db->where($check)->get('online_exam_result')->num_rows();

          $this->crud_model->change_online_exam_status_to_attended_for_student($exam_id);

          $status = $this->crud_model->check_availability_for_student($exam_id);

          if ($status == 'submitted') {
              $page_data['page_name']  = 'exam_done';
          }
          else{
              $page_data['page_name']  = 'online_exam_take';
          }
          $page_data['page_jsname'] = 'examjs';
          $page_data['page_title'] = 'Online Exam';
          $page_data['exam_id'] = $exam_id;
          $page_data['exam_info'] = $this->db->get_where('exam', array('exam_id' => $exam_id));
          $this->load->view('index', $page_data);
      }



      function submit_exam($exam_id = ""){

          $answer_script = array();
          $question_bank = $this->db->get_where('question_bank', array('exam_id' => $exam_id))->result_array();

          foreach ($question_bank as $question) {

            $correct_answers  = $this->crud_model->get_correct_answer($question['question_bank_id']);
            $container_2 = array();
            if (isset($_POST[$question['question_bank_id']])) {

                foreach ($this->input->post($question['question_bank_id']) as $row) {
                    $submitted_answer = "";
                    if ($question['type'] == 'true_false') {
                        $submitted_answer = $row;
                    }
                    elseif($question['type'] == 'fill_in_the_blanks'){
                      $suitable_words = array();
                      $suitable_words_array = explode(',', $row);
                      foreach ($suitable_words_array as $key) {
                        array_push($suitable_words, strtolower($key));
                      }
                      $submitted_answer = json_encode(array_map('trim',$suitable_words));
                    }
                    else{
                        array_push($container_2, strtolower($row));
                        $submitted_answer = json_encode($container_2);
                    }
                    $container = array(
                        "question_bank_id" => $question['question_bank_id'],
                        "submitted_answer" => $submitted_answer,
                        "correct_answers"  => $correct_answers
                    );
                }
            }
            else {
                $container = array(
                    "question_bank_id" => $question['question_bank_id'],
                    "submitted_answer" => "",
                    "correct_answers"  => $correct_answers
                );
            }

            array_push($answer_script, $container);
          }
          $this->crud_model->submit_online_exam($exam_id, json_encode($answer_script));
          $this->session->set_flashdata('flash_message', 'Exam Successfully Submitted');
          redirect(site_url('student/dashboard'), 'refresh');
      }


  function results($param1 = '', $param2 = ''){
    if ($this->session->userdata('student_login') != 1)
        redirect(site_url('student'), 'refresh');
        if ($param1 == '') {
            $page_data['data'] = 'result';
            $page_data['student_id'] = $this->session->userdata('login_user_id');
            $page_data['student_name'] = $this->db->get_where('student', array('student_id' => $this->session->userdata('login_user_id')))->row()->name;
            $page_data['exam_id'] = $this->db->get_where('student', array('student_id' => $this->session->userdata('login_user_id')))->row()->exam_code;
        }

        $page_data['page_jsname'] = 'examjs';
        $page_data['page_name'] = 'online_exam_result';
        $page_data['page_title'] = 'All Your Examination Results';
        $this->load->view('index', $page_data);
  }

 function show_script($exam_id, $student_id){
    if ($this->session->userdata('student_login') != 1)
        redirect(site_url('student'), 'refresh');

      $page_data['exam_id'] = $exam_id;
      $page_data['student_id'] = $student_id;
      $page_data['page_title'] = 'My Answer Script Print';
      $this->load->view('student/answer_script_with_submitted_answers', $page_data);
  }
  function logout() {
      $this->session->sess_destroy();
      redirect(site_url('student'), 'refresh');
  }



}
