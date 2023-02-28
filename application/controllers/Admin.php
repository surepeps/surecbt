<?php
defined('BASEPATH') OR exit('No direct script access allowed');

  class Admin extends CI_Controller {

	function __construct() {
			parent::__construct();
			$this->load->database();

	}

	//Default function, redirects to logged in user area
	public function index() {

			if ($this->session->userdata('admin_login') == 1)
					redirect(site_url('admin/dashboard'), 'refresh');

			$this->load->view('admin/login');
	}

	//Validating login from ajax request
	function validate_login() {
		$email = $this->input->post('email');
    $password = $this->input->post('password');
    $credential = array('email' => $email, 'password' => md5($password), 'status' => 'active');
    // Checking login credential for admin
    $query = $this->db->get_where('admin', $credential);
    if ($query->num_rows() > 0) {
        $row = $query->row();
        $this->session->set_userdata('admin_login', '1');
        $this->session->set_userdata('admin_id', $row->admin_id);
        $this->session->set_userdata('login_user_id', $row->admin_id);
        $this->session->set_userdata('name', $row->name);
        $this->session->set_userdata('login_type', 'admin');
        $this->session->set_flashdata('flash_message', 'Successfully Logged In');
        redirect(site_url('admin/dashboard'), 'refresh');
    }

		$this->session->set_flashdata('error_message', 'Invalid Login Details');
		redirect(site_url('admin'), 'refresh');

	}


	function dashboard(){
		if ($this->session->userdata('admin_login') != 1)
				redirect(site_url('admin'), 'refresh');

		$page_data['page_title'] = 'Dashboard';
		$page_data['page_name'] = 'dashboard';
		$this->load->view('index', $page_data);
	}

	function students(){
    if ($this->session->userdata('admin_login') != 1)
        redirect(site_url('admin'), 'refresh');

		$page_data['students'] = $this->db->get('enroll')->result_array();

		$page_data['page_title'] = 'Students';
		$page_data['page_jsname'] = 'examjs';
		$page_data['page_name'] = 'students';
		$this->load->view('index', $page_data);
	}

  function results($student_id = ''){
    if ($this->session->userdata('admin_login') != 1)
        redirect(site_url('admin'), 'refresh');

        $page_data['data'] = 'result';
        $page_data['student_id'] = $student_id;

        $page_data['student_name'] = $this->db->get_where('student', array('student_id' => $student_id ))->row()->name;
        $page_data['exam_id'] = $this->db->get_where('student', array('student_id' => $student_id ))->row()->exam_code;

        $page_data['page_name'] = 'online_exam_result';
        $page_data['page_title'] = 'All Examination Results For '. $page_data['student_name'];
        $this->load->view('index', $page_data);
  }

  function teachers(){
    if ($this->session->userdata('admin_login') != 1)
        redirect(site_url('admin'), 'refresh');

		$page_data['teachers'] = $this->db->get('instructor')->result_array();

		$page_data['page_title'] = 'Teachers';
    $page_data['page_jsname'] = 'adminjs';
		$page_data['page_name'] = 'teachers';
		$this->load->view('index', $page_data);
	}

  function systemsettings(){
    if ($this->session->userdata('admin_login') != 1)
        redirect(site_url('admin'), 'refresh');

      $page_data['page_name'] = 'systemsettings';
      $page_data['page_jsname'] = 'adminjs';
      $page_data['page_title'] = 'System Settings';
      $this->load->view('index', $page_data);
  }

  function system_settings($param1 = '', $param2 = '', $param3 = '')
  {
      if ($this->session->userdata('admin_login') != 1)
          redirect(site_url('admin'), 'refresh');

          $output = array('error' => false);

      if ($param1 == 'do_update') {

          $data['description'] = html_escape($this->input->post('system_name'));
          $this->db->where('type' , 'system_name');
          $this->db->update('settings' , $data);

          $data['description'] = html_escape($this->input->post('system_abbrv'));
          $this->db->where('type' , 'system_abbrv');
          $this->db->update('settings' , $data);

          $data['description'] = html_escape($this->input->post('system_footer'));
          $this->db->where('type' , 'system_footer');
          $this->db->update('settings' , $data);

          move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/sys_image/logo.png');

          $output['message'] = 'Settings Updated Successfully';
      }

      if ($param1 == 'page_settings') {
          $data['description'] = html_escape($this->input->post('student_reg'));
          $this->db->where('type' , 'student_reg');
          $this->db->update('settings' , $data);

          $data['description'] = html_escape($this->input->post('student_reg_note'));
          $this->db->where('type' , 'student_reg_note');
          $this->db->update('settings' , $data);

          $data['description'] = html_escape($this->input->post('instructor_reg'));
          $this->db->where('type' , 'instructor_reg');
          $this->db->update('settings' , $data);

          $data['description'] = html_escape($this->input->post('instructor_reg_note'));
          $this->db->where('type' , 'instructor_reg_note');
          $this->db->update('settings' , $data);

          $data['description'] = html_escape($this->input->post('show_result_now'));
          $this->db->where('type' , 'show_result_now');
          $this->db->update('settings' , $data);

          $output['message'] = 'Page Settings Updated Successfully';
      }

      echo json_encode($output);

  }

	function exam(){
    if ($this->session->userdata('admin_login') != 1)
        redirect(site_url('admin'), 'refresh');

			$page_data['page_name'] = 'addexam';
			$page_data['page_jsname'] = 'examjs';
			$page_data['page_title'] = 'Add Exam';
			$this->load->view('index', $page_data);
	}

  function addusers(){
    if ($this->session->userdata('admin_login') != 1)
        redirect(site_url('admin'), 'refresh');

      $page_data['adminlist'] = $this->db->get('admin')->result_array();
      $page_data['page_name'] = 'addadmin';
      $page_data['page_jsname'] = 'adminjs';
      $page_data['page_title'] = 'Add Administrator';
      $this->load->view('index', $page_data);
  }

  function manage_admin($param1 = "", $param2 = ""){
    if ($this->session->userdata('admin_login') != 1)
        redirect(site_url('admin'), 'refresh');

					$output = array('error' => false);

			if ($param1 == 'create') {
					if (!empty($this->input->post('name'))) {
						$data['name'] = $this->input->post('name');
						$data['email'] = $this->input->post('email');
            $data['password'] = md5($this->input->post('password'));
            $data['date']     = strtotime(date("Y-m-d H:i:s"));
            $data['status'] = 'active';

						$this->db->insert('admin', $data);
						$output['message'] = 'Admin Added Successfully';
					}
					else {
						$output['error'] = true;
						$output['message'] = 'Make sure Name is filled well';
					}
			}
			if ($param1 == 'update') {
					if (!empty($this->input->post('name'))) {
            $name = $this->input->post('name');
						$email = $this->input->post('email');
            $status = $this->input->post('status');
            $password = $this->input->post('password');

            if($password != ''){
                $data['password'] = md5($password);
                $data['name'] = $name;
                $data['email'] = $email;
                $data['status'] = $status;

                $this->db->where('admin_id', $param2);
	            $this->db->update('admin', $data);

            }else{
                $data2['name'] = $name;
                $data2['email'] = $email;
                $data2['status'] = $status;

                $this->db->where('admin_id', $param2);
              $this->db->update('admin', $data2);

            }

							$output['message'] = 'Admin Updated Successfully';
					}
					else{
						$output['error'] = true;
						$output['message'] = 'Make sure class Category is valid';
					}
			}
			if ($param1 == 'delete') {
					$this->db->where('admin_id', $param2);
					$this->db->delete('admin');
			}

			echo json_encode($output);


	}

  function addclasses(){
    if ($this->session->userdata('admin_login') != 1)
        redirect(site_url('admin'), 'refresh');

      $page_data['classeslist'] = $this->db->get('classes')->result_array();
      $page_data['page_name'] = 'addclasses';
      $page_data['page_jsname'] = 'examjs';
      $page_data['page_title'] = 'Add Class';
      $this->load->view('index', $page_data);
  }

  function addcourses(){
    if ($this->session->userdata('admin_login') != 1)
        redirect(site_url('admin'), 'refresh');

      $page_data['courseslist'] = $this->db->get('courses')->result_array();
      $page_data['page_name'] = 'addcourses';
      $page_data['page_jsname'] = 'examjs';
      $page_data['page_title'] = 'Add Course';
      $this->load->view('index', $page_data);
  }

  function manage_class($param1 = "", $param2 = ""){
    if ($this->session->userdata('admin_login') != 1)
        redirect(site_url('admin'), 'refresh');

					$output = array('error' => false);

			if ($param1 == 'create') {
					if (!empty($this->input->post('class_cat_id'))) {
						$data['name'] = $this->input->post('name');
						$data['class_cat_id'] = $this->input->post('class_cat_id');

						$this->db->insert('classes', $data);
						$output['message'] = 'Class Added Successfully';
					}
					else {
						$output['error'] = true;
						$output['message'] = 'Make sure class Category is valid';
					}
			}
			if ($param1 == 'update') {
					if (!empty($this->input->post('class_cat_id'))) {
            $data['name'] = $this->input->post('name');
						$data['class_cat_id'] = $this->input->post('class_cat_id');

		        $this->db->where('class_id', $param2);
		        $this->db->update('classes', $data);

							$output['message'] = 'Class Updated Successfully';
					}
					else{
						$output['error'] = true;
						$output['message'] = 'Make sure class Category is valid';
					}
			}
			if ($param1 == 'delete') {
					$this->db->where('class_id', $param2);
					$this->db->delete('classes');
			}

			echo json_encode($output);


	}



  function manage_course($param1 = "", $param2 = ""){
    if ($this->session->userdata('admin_login') != 1)
        redirect(site_url('admin'), 'refresh');

					$output = array('error' => false);

			if ($param1 == 'create') {
					if (!empty($this->input->post('class_cat_id'))) {
						$data['name'] = $this->input->post('name');
						$data['class_cat_id'] = $this->input->post('class_cat_id');
            $data['instructor_id'] = $this->input->post('instructor_id');

						$this->db->insert('courses', $data);
						$output['message'] = 'Course Added Successfully';
					}
					else {
						$output['error'] = true;
						$output['message'] = 'Make sure class Category is valid';
					}
			}
			if ($param1 == 'update') {
					if (!empty($this->input->post('class_cat_id'))) {
            $data['name'] = $this->input->post('name');
						$data['class_cat_id'] = $this->input->post('class_cat_id');
            $data['instructor_id'] = $this->input->post('instructor_id');

		        $this->db->where('course_id', $param2);
		        $this->db->update('courses', $data);

							$output['message'] = 'Course Updated Successfully';
					}
					else{
						$output['error'] = true;
						$output['message'] = 'Make sure class Category is valid';
					}
			}
			if ($param1 == 'delete') {
					$this->db->where('course_id', $param2);
					$this->db->delete('courses');
			}

			echo json_encode($output);


	}


	function manage_exam($param1 = "", $param2 = ""){
    if ($this->session->userdata('admin_login') != 1)
        redirect(site_url('admin'), 'refresh');

					$output = array('error' => false);

			if ($param1 == 'create') {
					if (!empty($this->input->post('course_id')) &&  !empty($this->input->post('class_id'))) {
						$data['exam_code']  = substr(md5(uniqid(rand(), true)), 0, 7);
						$data['title'] = $this->input->post('title');
						$data['class_id'] = $this->input->post('class_id');
						$data['course_id'] = $this->input->post('course_id');
						$data['instructor_id'] = $this->input->post('instructor_id');
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
						$data['minimum_percentage'] = $this->input->post('minimum_percentage');
						$data['instruction'] = $this->input->post('instruction');
            $data['state'] = $this->input->post('state');
            $data['exam_date'] = strtotime(html_escape($this->input->post('exam_date')));
            $data['time_start'] = html_escape($this->input->post('time_start'));
            $data['time_end'] = html_escape($this->input->post('time_end'));
            $data['duration'] = strtotime(date('Y-m-d', $data['exam_date']).' '.$data['time_end']) - strtotime(date('Y-m-d', $data['exam_date']).' '.$data['time_start']);

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


	function deleteStudent($param2 = ''){
	    $this->db->where('student_id', $param2);
		$this->db->delete(array('enroll','student'));
	}

  function deleteTeacher($param2 = ''){
      $this->db->where('instructor_id', $param2);
      $this->db->delete('instructor');
  }

	function exam_view($param1 = ''){
    if ($this->session->userdata('admin_login') != 1)
        redirect(site_url('admin'), 'refresh');

      if ($param1 == '') {
          $match = array('status !=' => 'expired');
          $page_data['status'] = 'active';
          $this->db->order_by("exam_date", "dsc");
          $page_data['online_exams'] = $this->db->where($match)->get('exam')->result_array();
      }

      if ($param1 == 'expired') {
          $match = array('status' => 'expired');
          $page_data['status'] = 'expired';
          $this->db->order_by("exam_date", "dsc");
          $page_data['online_exams'] = $this->db->where($match)->get('exam')->result_array();
      }


      $page_data['page_name'] = 'examlist';
      $page_data['page_jsname'] = 'examjs';
      $page_data['page_title'] = 'Manage Online Exam';
      $this->load->view('index', $page_data);
  }

	function exam_question($exam_id = ''){
    if ($this->session->userdata('admin_login') != 1)
        redirect(site_url('admin'), 'refresh');

		$page_data['page_jsname'] = 'examjs';
		$page_data['exam_id'] = $exam_id;
		$page_data['page_name'] = 'manage_online_exam_question';
		$page_data['page_title'] = 'Exam Questions For '.$this->db->get_where('exam', array('exam_id'=>$exam_id))->row()->title;
		$this->load->view('index', $page_data);
	}


	function load_question_type($type, $exam_id) {
    if ($this->session->userdata('admin_login') != 1)
        redirect(site_url('admin'), 'refresh');

			$page_data['question_type'] = $type;
			$page_data['exam_id'] = $exam_id;
			$this->load->view('admin/online_exam_add_'.$type, $page_data);
	}


	function manage_multiple_choices_options() {
    if ($this->session->userdata('admin_login') != 1)
        redirect(site_url('admin'), 'refresh');

      $page_data['number_of_options'] = $this->input->post('number_of_options');
      $this->load->view('admin/manage_multiple_choices_options', $page_data);
  }


  function manage_online_exam_question($exam_id = "", $task = "", $type = ""){
    if ($this->session->userdata('admin_login') != 1)
        redirect(site_url('admin'), 'refresh');

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
    if ($this->session->userdata('admin_login') != 1)
        redirect(site_url('admin'), 'refresh');

      $page_data['exam_id'] = $param1;

      $page_data['page_jsname'] = 'examjs';
      $page_data['page_name'] = 'edit_online_exam';
      $page_data['page_title'] = 'Update Online Exam';
      $this->load->view('index', $page_data);
  }

	function view_exam_result($exam_id){
    if ($this->session->userdata('admin_login') != 1)
        redirect(site_url('admin'), 'refresh');

      // $page_data['page_jsname'] = 'examjs';
      $subject_id = $this->db->get_where('exam', array('exam_id' => $exam_id))->row()->course_id;
      $class_id = $this->db->get_where('exam', array('exam_id' => $exam_id))->row()->class_id;

      $subject_name = $this->db->get_where('courses', array('course_id' => $subject_id))->row()->name;
      $class_name = $this->db->get_where('classes', array('class_id' => $class_id))->row()->name;
      $page_data['page_name'] = 'view_online_exam_results';
      $page_data['page_title'] = $class_name. ' '. $subject_name .' Result';
      $page_data['exam_id'] = $exam_id;
      $this->load->view('index',$page_data);
  }


	function update_online_exam_question($question_id = "", $task = "", $exam_id = "") {

    if ($this->session->userdata('admin_login') != 1)
        redirect(site_url('admin'), 'refresh');

      $online_exam_id = $this->db->get_where('question_bank', array('question_bank_id' => $question_id))->row()->exam_id;
      $type = $this->db->get_where('question_bank', array('question_bank_id' => $question_id))->row()->type;

      if ($task == "update") {
          if ($type == 'multiple_choice') {
              $this->crud_model->update_multiple_choice_question_admin($question_id);
          }
          elseif($type == 'true_false'){
              $this->crud_model->update_true_false_question_admin($question_id);
          }
          elseif($type == 'fill_in_the_blanks'){
              $this->crud_model->update_fill_in_the_blanks_question_admin($question_id);
          }
      }
  }


  function update_teacher_account($instructor_id = ''){

      if ($this->session->userdata('admin_login') != 1)
        redirect(site_url('admin'), 'refresh');

        $output = array('error' => false);

        $password = $this->input->post('password');
        $email = html_escape($this->input->post('email'));
        $name = html_escape($this->input->post('name'));
        $phone = html_escape($this->input->post('phone'));


            if($password != ''){
                $data['password'] = md5($password);
                $data['name'] = $name;
                $data['email'] = $email;
                $data['phone'] = $phone;

                $this->db->where('instructor_id', $instructor_id);
	            $this->db->update('instructor', $data);

            }else{
                $data2['name'] = $name;
                $data2['email'] = $email;
                $data2['phone'] = $phone;

                $this->db->where('instructor_id', $instructor_id);
	            $this->db->update('instructor', $data2);

            }


	    $output['message'] = 'Account Updated Successfully';

	    echo json_encode($output);

  }

	function exam_questions_print($exam_id, $answers) {
    if ($this->session->userdata('admin_login') != 1)
        redirect(site_url('admin'), 'refresh');

			$page_data['exam_id'] = $exam_id;
			$page_data['answers'] = $answers;
			$page_data['page_title'] = 'Questions Print';
			$this->load->view('admin/online_exam_questions_print_view', $page_data);
	}

  function show_script($exam_id, $student_id){
    if ($this->session->userdata('admin_login') != 1)
        redirect(site_url('admin'), 'refresh');

      $page_data['exam_id'] = $exam_id;
      $page_data['student_id'] = $student_id;
      $page_data['page_title'] = 'Answer Script Print';
      $this->load->view('admin/answer_script_with_submitted_answers', $page_data);
  }


	function delete_question_from_online_exam($question_id){
			$online_exam_id = $this->db->get_where('question_bank', array('question_bank_id' => $question_id))->row()->exam_id;
			$this->crud_model->delete_question_from_online_exam($question_id);
	}

	function addstudent(){
	   if ($this->session->userdata('admin_login') != 1)
        redirect(site_url('admin'), 'refresh');

    $page_data['classes'] = $this->db->get('classes')->result_array();
    $page_data['page_name'] = 'addstudent';
    $page_data['page_title'] = 'Add New Student';

    $this->load->view('index', $page_data);
	}


   function grades($class_id){
    if ($this->session->userdata('admin_login') != 1)
        redirect(site_url('admin'), 'refresh');

      $page_data['class_id'] = $class_id;
      $classname = $this->db->get_where('classes', array('class_id'=>$class_id))->row()->name;
      $page_data['page_title'] = $classname. ' Students Gradesheet';
      $page_data['page_name'] = 'gradesheet';
      $this->load->view('index', $page_data);
  }


	function broadsheet($class_id){
    if ($this->session->userdata('admin_login') != 1)
        redirect(site_url('admin'), 'refresh');

      $page_data['class_id'] = $class_id;
      $page_data['page_title'] = 'Students Broadsheet';
      $this->load->view('admin/broadsheet', $page_data);
  }


	 function add_student(){
	     if ($this->session->userdata('admin_login') != 1)
        redirect(site_url('admin'), 'refresh');
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
            $this->session->set_flashdata('flash_message', 'Successfully Registered Student Exam id Is: <h2>'.$combocode. '</h2>');
            redirect(site_url('admin/addstudent'), 'refresh');
        }
        else {
          $this->session->set_flashdata('error_message', 'Sorry Exam Id could not generate Try later or contact the Support Center');
      		redirect(site_url('admin/addstudent'), 'refresh');
        }

  }


	function logout() {
      $this->session->sess_destroy();
      redirect(site_url('admin'), 'refresh');
  }

}
