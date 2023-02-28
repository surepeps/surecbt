<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Instructor extends CI_Controller {

	function __construct() {
			parent::__construct();
			$this->load->database();

	}

	//Default function, redirects to logged in user area
	public function index() {

			if ($this->session->userdata('instructor_login') == 1)
					redirect(site_url('instructor/dashboard'), 'refresh');

			$this->load->view('instructor/login');
	}

	//Validating login from ajax request
	function validate_login() {
		$email = $this->input->post('email');
    $password = $this->input->post('password');
    $credential = array('email' => $email, 'password' => md5($password), 'status' => 'active');
    // Checking login credential for admin
    $query = $this->db->get_where('instructor', $credential);
    if ($query->num_rows() > 0) {
        $row = $query->row();
        $this->session->set_userdata('instructor_login', '1');
        $this->session->set_userdata('instructor_id', $row->instructor_id);
        $this->session->set_userdata('login_user_id', $row->instructor_id);
        $this->session->set_userdata('name', $row->name);
        $this->session->set_userdata('login_type', 'instructor');
        $this->session->set_flashdata('flash_message', 'Successfully Logged In');
        redirect(site_url('instructor/dashboard'), 'refresh');
    }

		$this->session->set_flashdata('error_message', 'Invalid Login Details');
		redirect(site_url('instructor'), 'refresh');

	}

	function reg(){
		if ($this->session->userdata('instructor_login') == 1)
				redirect(site_url('instructor/dashboard'), 'refresh');
				
    $page_data['courses'] = $this->db->get_where('courses', array('instructor_id' => 0))->result_array();

    $this->load->view('instructor/register', $page_data);
  }

	function register_validate(){

				$data['name'] = html_escape($this->input->post('name'));
				$data['sex'] = $this->input->post('sex');
				$data['code'] = substr(md5(rand(0, 1000000)), 0, 10);
				$data['course_id'] = $this->input->post('course_id');
				$data['password'] = md5($this->input->post('password'));
				$data['phone'] = html_escape($this->input->post('phone'));
				$data['status'] = 'active';
				$data['email'] = html_escape($this->input->post('email'));
				$data['date']     = strtotime(date("Y-m-d H:i:s"));

				if(!empty($data['course_id'])) {
						$this->db->insert('instructor', $data);
						$instructor_id = $this->db->insert_id();

						$data2['instructor_id'] = $instructor_id;
						$course_id = $this->input->post('course_id');

						$this->db->where('course_id', $course_id);
						$this->db->update('courses', $data2);

						$this->session->set_flashdata('flash_message', 'Successfully Registered Please Proceed To Login Below');
						redirect(site_url('instructor'), 'refresh');
				}
				else {
					$this->session->set_flashdata('error_message', 'Sorry Course Id has been selected already');
					redirect(site_url('instructor/reg'), 'refresh');
				}

	}

	function dashboard(){
		if ($this->session->userdata('instructor_login') != 1)
				redirect(site_url('instructor'), 'refresh');

		$page_data['subject_name'] = $this->db->get_where('courses', array('instructor_id' => $this->session->userdata('instructor_id')))->row()->name;
		$page_data['class_cat_id'] = $this->db->get_where('courses', array('instructor_id' => $this->session->userdata('instructor_id')))->row()->class_cat_id;

		$page_data['page_title'] = 'Dashboard';
		$page_data['page_name'] = 'dashboard';
		$this->load->view('index', $page_data);
	}

	function students(){
		if ($this->session->userdata('instructor_login') != 1)
				redirect(site_url('instructor'), 'refresh');

		$class_cat_id = $this->db->get_where('courses', array('instructor_id' => $this->session->userdata('instructor_id')))->row()->class_cat_id;

		$page_data['students'] = $this->db->get_where('enroll', array('class_cat_id' => $class_cat_id))->result_array();

		$page_data['page_title'] = 'Students';
		$page_data['page_name'] = 'students';
		$this->load->view('index', $page_data);
	}

	function exam(){
		if ($this->session->userdata('instructor_login') != 1)
			redirect(site_url('instructor'), 'refresh');

			$page_data['class_cat_id'] = $this->db->get_where('courses', array('instructor_id' => $this->session->userdata('instructor_id')))->row()->class_cat_id;
			$page_data['subject_name'] = $this->db->get_where('courses', array('instructor_id' => $this->session->userdata('instructor_id')))->row()->name;
			$page_data['subject_id'] = $this->db->get_where('courses', array('instructor_id' => $this->session->userdata('instructor_id')))->row()->course_id;

			$page_data['page_name'] = 'addexam';
			$page_data['page_jsname'] = 'examjs';
			$page_data['page_title'] = 'Add Exam';
			$this->load->view('index', $page_data);
	}


	function manage_exam($param1 = "", $param2 = ""){
		if ($this->session->userdata('instructor_login') != 1)
			redirect(site_url('instructor'), 'refresh');

					$output = array('error' => false);

			if ($param1 == 'create') {
					if (!empty($this->input->post('course_id')) &&  !empty($this->input->post('class_id'))) {
						$data['exam_code']  = substr(md5(uniqid(rand(), true)), 0, 7);
						$data['title'] = $this->input->post('title');
						$data['class_id'] = $this->input->post('class_id');
						$data['course_id'] = $this->input->post('course_id');
						$data['instructor_id'] = $this->session->userdata('instructor_id');
						$data['status'] = 'active';
						$data['state'] = 'pending';
						$data['minimum_percentage'] = $this->input->post('minimum_percentage');
						$data['instruction'] = $this->input->post('instruction');

						$this->db->insert('exam', $data);
						$output['message'] = 'Exam Added Successfully';
					}
					else {
						$output['error'] = true;
						$output['message'] = 'Make sure class id is valid and subject';
					}
			}
			if ($param1 == 'edit') {
					if (!empty($this->input->post('course_id')) &&  !empty($this->input->post('class_id'))) {
						$data['title'] = $this->input->post('title');
						$data['class_id'] = $this->input->post('class_id');
						$data['course_id'] = $this->input->post('course_id');
						$data['instructor_id'] = $this->session->userdata('instructor_id');
						$data['minimum_percentage'] = $this->input->post('minimum_percentage');
						$data['instruction'] = $this->input->post('instruction');

		        $this->db->where('exam_id', $this->input->post('exam_id'));
		        $this->db->update('exam', $data);

							$output['message'] = 'Exam Updated Successfully';
					}
					else{
						$output['error'] = true;
						$output['message'] = 'Make sure class id is valid and subject';
					}
			}
			if ($param1 == 'delete') {
					$this->db->where('exam_id', $param2);
					$this->db->delete('exam');
			}

			echo json_encode($output);


	}

	function exam_view($param1 = ''){
		if ($this->session->userdata('instructor_login') != 1)
			redirect(site_url('instructor'), 'refresh');

      $instructor_id = $this->session->userdata('instructor_id');

      if ($param1 == '') {
          $match = array('status !=' => 'expired', 'instructor_id' => $instructor_id);
          $page_data['status'] = 'active';
          $this->db->order_by("exam_date", "dsc");
          $page_data['online_exams'] = $this->db->where($match)->get('exam')->result_array();
      }

      if ($param1 == 'expired') {
          $match = array('status' => 'expired', 'instructor_id' => $instructor_id);
          $page_data['status'] = 'expired';
          $this->db->order_by("exam_date", "dsc");
          $page_data['online_exams'] = $this->db->where($match)->get('exam')->result_array();
      }


      $page_data['page_name'] = 'examlist';
      $page_data['page_title'] = 'Manage Online Exam';
      $this->load->view('index', $page_data);
  }

	function exam_question($exam_id = ''){
		if ($this->session->userdata('instructor_login') != 1)
			redirect(site_url('instructor'), 'refresh');

		$page_data['page_jsname'] = 'examjs';
		$page_data['exam_id'] = $exam_id;
		$page_data['page_name'] = 'manage_online_exam_question';
		$page_data['page_title'] = 'Exam Questions For '.$this->db->get_where('exam', array('exam_id'=>$exam_id))->row()->title;
		$this->load->view('index', $page_data);
	}


	function load_question_type($type, $exam_id) {
		if ($this->session->userdata('instructor_login') != 1)
			redirect(site_url('instructor'), 'refresh');

			$page_data['question_type'] = $type;
			$page_data['exam_id'] = $exam_id;
			$this->load->view('instructor/online_exam_add_'.$type, $page_data);
	}


	function manage_multiple_choices_options() {
		if ($this->session->userdata('instructor_login') != 1)
			redirect(site_url('instructor'), 'refresh');

      $page_data['number_of_options'] = $this->input->post('number_of_options');
      $this->load->view('instructor/manage_multiple_choices_options', $page_data);
  }


  function manage_online_exam_question($exam_id = "", $task = "", $type = ""){
		if ($this->session->userdata('instructor_login') != 1)
			redirect(site_url('instructor'), 'refresh');

      if ($task == 'add') {
          if ($type == 'multiple_choice') {
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
			        $data['exam_id']     = $exam_id;
			        $data['question_title']     = html_escape($this->input->post('question_title'));
							$data['instructor_id']     = $this->session->userdata('instructor_id');
			        $data['mark']               = html_escape($this->input->post('mark'));
			        $data['number_of_options']  = html_escape($this->input->post('number_of_options'));
			        $data['type']               = 'multiple_choice';
			        $data['options']            = json_encode($this->input->post('options'));
			        $data['correct_answers']    = json_encode($correct_answers);
			        $this->db->insert('question_bank', $data);
			        $output['message'] = 'Multiple Question Added Successfully';

			        echo json_encode($output);

          }
          elseif ($type == 'true_false') {
						$output = array('error' => false);

			        $data['exam_id']     = $exam_id;
			        $data['question_title']     = html_escape($this->input->post('question_title'));
							$data['instructor_id']     = $this->session->userdata('instructor_id');
			        $data['type']               = 'true_false';
			        $data['mark']               = html_escape($this->input->post('mark'));
			        $data['correct_answers']    = html_escape($this->input->post('true_false_answer'));
			        $this->db->insert('question_bank', $data);
			        $output['message'] = 'True Or False Question Added Successfully';

			        echo json_encode($output);

          }
          elseif ($type == 'fill_in_the_blanks') {
						$output = array('error' => false);

		        $suitable_words_array = explode(',', html_escape($this->input->post('suitable_words')));
		        $suitable_words = array();
		        foreach ($suitable_words_array as $row) {
		          array_push($suitable_words, strtolower($row));
		        }
		        $data['exam_id']     = $exam_id;
		        $data['question_title']     = html_escape($this->input->post('question_title'));
						$data['instructor_id']     = $this->session->userdata('instructor_id');
		        $data['type']               = 'fill_in_the_blanks';
		        $data['mark']               = html_escape($this->input->post('mark'));
		        $data['correct_answers']    = json_encode(array_map('trim',$suitable_words));
		        $this->db->insert('question_bank', $data);
		        $output['message'] = 'Fill in The Gap Question Added Successfully';

		        echo json_encode($output);

          }
      }


  }

	function manage_online_exam_status($exam_id = "", $status = ""){
		$output = array('error' => false);

			$checker = array(
					'exam_id' => $exam_id
			);
			$updater = array(
					'status' => $status
			);

			$this->db->where($checker);
			$this->db->update('exam', $updater);
			$output['message'] = 'Exam Status Changed';

			echo json_encode($output);
  }

	function update_exam($param1 = ""){
		if ($this->session->userdata('instructor_login') != 1)
			redirect(site_url('instructor'), 'refresh');

      $page_data['exam_id'] = $param1;

      $page_data['page_jsname'] = 'examjs';
      $page_data['page_name'] = 'edit_online_exam';
      $page_data['page_title'] = 'Update Online Exam';
      $this->load->view('index', $page_data);
  }

	function view_exam_result($exam_id){
		if ($this->session->userdata('instructor_login') != 1)
			redirect(site_url('instructor'), 'refresh');

      $page_data['page_name'] = 'view_online_exam_results';
      $page_data['page_title'] = 'Result';
      $page_data['exam_id'] = $exam_id;
      $this->load->view('index',$page_data);
  }


	function update_online_exam_question($question_id = "", $task = "", $exam_id = "") {

		if ($this->session->userdata('instructor_login') != 1)
			redirect(site_url('instructor'), 'refresh');

      $online_exam_id = $this->db->get_where('question_bank', array('question_bank_id' => $question_id))->row()->exam_id;
      $type = $this->db->get_where('question_bank', array('question_bank_id' => $question_id))->row()->type;

      if ($task == "update") {
          if ($type == 'multiple_choice') {
              $this->crud_model->update_multiple_choice_question($question_id);
          }
          elseif($type == 'true_false'){
              $this->crud_model->update_true_false_question($question_id);
          }
          elseif($type == 'fill_in_the_blanks'){
              $this->crud_model->update_fill_in_the_blanks_question($question_id);
          }
      }
  }

	function exam_questions_print($exam_id, $answers) {
		if ($this->session->userdata('instructor_login') != 1)
			redirect(site_url('instructor'), 'refresh');

			$page_data['exam_id'] = $exam_id;
			$page_data['answers'] = $answers;
			$page_data['page_title'] = 'Questions Print';
			$this->load->view('instructor/online_exam_questions_print_view', $page_data);
	}


	function delete_question_from_online_exam($question_id){
			$online_exam_id = $this->db->get_where('question_bank', array('question_bank_id' => $question_id))->row()->exam_id;
			$this->crud_model->delete_question_from_online_exam($question_id);
	}


	function show_script($exam_id, $student_id){
		if ($this->session->userdata('instructor_login') != 1)
			redirect(site_url('instructor'), 'refresh');

			$page_data['exam_id'] = $exam_id;
			$page_data['student_id'] = $student_id;
			$page_data['page_title'] = 'Answer Script Print';
			$this->load->view('instructor/answer_script_with_submitted_answers', $page_data);
	}





	function logout() {
      $this->session->sess_destroy();
      redirect(site_url('instructor'), 'refresh');
  }

}
