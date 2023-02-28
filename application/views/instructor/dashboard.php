<div class="row">
  <div class="col-lg-4 col-sm-6">
    <div class="card">
      <div class="card-statistic-4">
        <div class="info-box7-block">
          <h6 class="m-b-20 text-right">Subject / Course</h6>
          <h4 class="text-right"><i class="fas fa-file pull-left bg-indigo c-icon"></i><span><?php echo $subject_name; ?></span>
          </h4>
          <p class="mb-0 mt-3 text-muted">
            <span class="text-success font-weight-bold">
              <?php
                if ($class_cat_id === '1') {
                  echo "FOR JUNIOR CLASSES ";
                }else {
                  echo "FOR SENIOR CLASSES";
                }
               ?>
            </span>
          </p>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-4 col-sm-6">
    <div class="card">
      <div class="card-statistic-4">
        <div class="info-box7-block">
          <h6 class="m-b-20 text-right">Class / Department</h6>
          <h4 class="text-right"><i class="fas fa-graduation-cap pull-left bg-indigo c-icon"></i><span>
            <?php
              if ($class_cat_id === '1') {
                echo "FOR JUNIOR CLASSES ";
              }else {
              echo "FOR SENIOR CLASSES";
              }
             ?>
          </span>
          </h4>
          <p class="mb-0 mt-3 text-muted"><span
              class="text-success font-weight-bold">FOR ALL</span></p>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-4 col-sm-6">
    <div class="card">
      <div class="card-statistic-4">
        <div class="info-box7-block">
          <h6 class="m-b-20 text-right">Students</h6>
          <h4 class="text-right"><i class="fas fa-users pull-left bg-indigo c-icon"></i><span>
            <?php
              $class_cat_id = $this->db->get_where('courses', array('instructor_id' => $this->session->userdata('instructor_id')))->row()->class_cat_id;

              echo $this->db->where('class_cat_id', $class_cat_id)->get('enroll')->num_rows();
            ?>
         </span>
          </h4>
          <p class="mb-0 mt-3 text-muted"><i class="fas fa-arrow-circle-up col-green m-r-5"></i><span
              class="text-success font-weight-bold">Numbers</span> of Students Taking your Course</p>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
  <div class="card">
    <div class="card-statistic-4">
      <div class="align-items-center justify-content-between">
        <div class="row ">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
            <div class="card-content">
              <h5 class="font-15">Exam Questions</h5>
              <h2 class="mb-3 font-18"><?php echo $this->db->where('instructor_id', $this->session->userdata('instructor_id'))->get('question_bank')->num_rows(); ?></h2>
              <p class="mb-0"><span class="col-green">Added</span>
                by you</p>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
            <div class="banner-img">
              <img src="<?php echo base_url(); ?>assets/img/banner/3.png" alt="">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
