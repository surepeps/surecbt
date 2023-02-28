<div class="main-sidebar sidebar-style-2">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="index-2.html"> <img src="<?php echo base_url(); ?>uploads/sys_image/logo.png" class="header-logo" alt="">  <span
          class="logo-name"><?php echo $this->db->get_where('settings' , array('type'=>'system_name'))->row()->description; ?></span>
      </a>
    </div>
    <div class="sidebar-user">
      <div class="sidebar-user-picture">
        <img src="<?php echo base_url(); ?>uploads/sys_image/logo.png" width="" height="" class="header-logo" alt="">
      </div>
      <div class="sidebar-user-details">
        <div class="user-name">
          <?php
						$name = $this->db->get_where($this->session->userdata('login_type'), array($this->session->userdata('login_type').'_id' => $this->session->userdata('login_user_id')))->row()->name;
						echo $name;
					?>
        </div>
        <div class="user-role">Administrator</div>
      </div>
    </div>
    <ul class="sidebar-menu">
      <li class="menu-header">Main</li>
      <li class="<?php if ($page_name == 'dashboard') echo 'active'; ?>">
        <a href="<?php echo base_url(); ?>admin" class="nav-link"><i
            data-feather="monitor"></i><span>Dashboard</span></a>
      </li>
      <li class="<?php if ($page_name == 'addstudent') echo 'active'; ?>">
        <a href="<?php echo base_url(); ?>admin/addstudent" class="nav-link"><i
            data-feather="user-plus"></i><span>Add Student</span></a>
      </li>
      <li class="<?php if ($page_name == 'addclasses') echo 'active'; ?>">
        <a href="<?php echo base_url(); ?>admin/addclasses" class="nav-link"><i
            data-feather="folder-plus"></i><span>Add Classes</span></a>
      </li>
      <li class="<?php if ($page_name == 'addcourses') echo 'active'; ?>">
        <a href="<?php echo base_url(); ?>admin/addcourses" class="nav-link"><i
            data-feather="book-open"></i><span>Add Courses</span></a>
      </li>
      <li class="<?php if ($page_name == 'students') echo 'active'; ?>">
        <a href="<?php echo base_url(); ?>admin/students" class="nav-link"><i
            data-feather="users"></i><span>Students</span></a>
      </li>
      <li class="<?php if ($page_name == 'teachers') echo 'active'; ?>">
        <a href="<?php echo base_url(); ?>admin/teachers" class="nav-link"><i
            data-feather="clipboard"></i><span>Teachers</span></a>
      </li>
      <li class="dropdown <?php if ($page_name == 'examlist' || $page_name == 'addexam' || $page_name == 'edit_online_exam') echo 'active';?>">
        <a href="#" class="menu-toggle nav-link has-dropdown"><i
            data-feather="airplay"></i><span>Online Exam</span></a>
        <ul class="dropdown-menu">
          <li class="<?php if ($page_name == 'addexam') echo 'active';?>"><a class="nav-link" href="<?php echo site_url('admin/exam'); ?>">Add Exam</a></li>
          <li class="<?php if ($page_name == 'examlist' || $page_name == 'addexam' || $page_name == 'edit_online_exam') echo 'active';?>"><a class="nav-link" href="<?php echo site_url('admin/exam_view'); ?>">Manage Exam</a></li>

        </ul>
      </li>
      <li class="dropdown <?php if ($page_name == 'examlist' || $page_name == 'addexam' || $page_name == 'edit_online_exam') echo 'active';?>">
        <a href="#" class="menu-toggle nav-link has-dropdown"><i
            data-feather="settings"></i><span>Settings</span></a>
        <ul class="dropdown-menu">
          <li class="<?php if ($page_name == 'addadmin') echo 'active';?>"><a class="nav-link" href="<?php echo site_url('admin/addusers'); ?>">Add Admin</a></li>
          <li class="<?php if ($page_name == 'systemsettings') echo 'active';?>"><a class="nav-link" href="<?php echo site_url('admin/systemsettings'); ?>">System Settings</a></li>

        </ul>
      </li>

    </ul>
  </aside>
</div>
