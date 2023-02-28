<div class="row">
	<div class="col-md-12">
		<div class="card">
      <div class="card-body">
        <div class="table-responsive">
          
          <table class="table table-striped table-hover" id="tableExport" style="width:100%;">
            <thead>
              <tr>
                <th>Student Name</th>
                <th>Exam Expected</th>
                <th>Exam Taken</th>
                <th>Total Marks</th>
                <th>Total Marks Obtained</th>
                <th>Percentage</th>
                <th>Grade</th>
              </tr>
            </thead>
            <tbody>
                
                
                <?php 
                $students = $this->db->get_where('enroll', array('class_id'=> $class_id))->result_array();

                    foreach($students as $row):?>
                    <tr id="">
                      <td>
                          <?php
                        echo $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->name;
                           
                        ?>
                      </td>
                      
                      
                     <td>
                         <?php 
                        $class_cat_id = $this->db->get_where('enroll', array('student_id' => $row['student_id']))->row()->class_cat_id;
                        echo $this->db->get_where('courses', array('class_cat_id' => $class_cat_id))->num_rows();
                        ?>
                     </td>
                     
                     <td>
                         <?php
                        $query = $this->db->get_where('online_exam_result', array('student_id' => $row['student_id']))->num_rows();
                        echo $query;
                      
                      ?>
                     </td>
                     
                     
                    <td>
                        <?php 
                     
                        $totalmarks = $this->db->select_sum('total_marK')->get_where('online_exam_result', array('student_id' => $row['student_id']))->row();
                        echo $totalmarks->total_marK;
                        
                        ?>
                    </td>
                    
                    <td>
                        <?php 
                     
                        $obtainedmarks = $this->db->select_sum('obtained_mark')->get_where('online_exam_result', array('student_id' => $row['student_id']))->row();
                        echo $obtainedmarks->obtained_mark;
                        
                        ?>
                    </td>
                    
                    <td>
                        <?php
                        $totalmark = $totalmarks->total_marK;
                        $obtainedmark = $obtainedmarks->obtained_mark;
                        $percent = $obtainedmark / $totalmark * 100;
                        echo round($percent,1).'%';
                        ?>
                    </td>
                    
                    <td>
                        <?php
                        if($percent >= 70){
                            echo 'A';
                        }elseif($percent <= 69 && $percent >= 60){
                            echo 'B';
                        }elseif($percent <= 59 && $percent >= 50){
                            echo 'C';
                        }elseif($percent <= 49 && $percent >= 45){
                            echo 'D';
                        }elseif($percent <= 44 && $percent >= 40){
                            echo 'E';
                        }else{
                            echo 'F';
                        }
                        ?>
                    </td>
                      
                    </tr>
                  <?php endforeach;?>
                  
            </tbody>
          </table>
         </div>
      </div>
    </div>
	</div>
</div>


