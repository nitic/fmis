<div class="box box-color box-bordered">
    <div class="box-title">
		<h3>
			<i class="icon-th-list"></i>
			รายงานประจำเดือนส่งทางอีเมล์
		</h3>
	</div>

	<div class="box-content nopadding">
			 <form id="fm" method="post" class='form-horizontal form-bordered'> 
				<div class="control-group">
					<label for="textfield" class="control-label">อีเมล์ผู้รับ</label>
					<div class="controls">
						<input type="text" name="email" id="email" placeholder="E-Mail" class="input-xlarge">
					</div>
				</div>
				
                <div class="control-group">
					
						<div class="controls">
                            <button type="button" class="btn" onclick="window.open('mail/sendmail/1', '_blank');"><i class="icon-print"></i> ดูตัวอย่างรายงาน</button>
							<button type="button" class="btn btn-primary" onclick="send()">ส่งรายงาน</button>
						</div>
					</div>
				
			</form>
           
	  </div> 
</div>	

<div class="span4">
	<h6>รายงานประจำเดือนย้อนหลัง</h6>
	
		<ul class="nav nav-list">
			<li class="active"><a href="#">เดือน (ปีงบประมาณ <?php echo $this->session->userdata('budget_year_year')+543; ?>)</a></li>
			
			<?php
				// Start Budget Month = 10;
				// End Budget Month = 9;

				// Current Budget Year
				$budget_year = (date("m")<10)? date("Y") : date("Y") + 1 ;

				//User select Budget Year
				$select_year = $this->session->userdata('budget_year_year');
			    

			   if($select_year < $budget_year)
			   { //Old Budget Year

			   		$pdf_filename = base_url('assets/uploads/files').'/'.($select_year-1).'-';
					echo '<li><a href="'.$pdf_filename.'10.pdf" target="_blank">'.$th_month[10].' '.($select_year+543-1)."</a></li>";
					echo '<li><a href="'.$pdf_filename.'11.pdf" target="_blank">'.$th_month[11].' '.($select_year+543-1)."</a></li>";
					echo '<li><a href="'.$pdf_filename.'12.pdf" target="_blank">'.$th_month[12].' '.($select_year+543-1)."</a></li>";
					
					for($i=1; $i<=9; $i++){
						$pdf_filename = base_url('assets/uploads/files').'/'.($select_year).'-0'.$i.'.pdf';
						echo '<li><a href="'.$pdf_filename.'" target="_blank">'.$th_month[$i]." ".($select_year+543)."</a></li>";
					}
				}
				else{ // Current Budget Year
					
					//Current this Month
					$month = date("m");
					//$month = 10; // for debug

					if($month > 10){ // month 10-11-12
						for($i=$month-1; $i>=10; $i--){
							$pdf_filename = base_url('assets/uploads/files').'/'.($budget_year-1).'-'.$i.'.pdf';
							echo '<li><a href="'.$pdf_filename.'" target="_blank">'.$th_month[$i]." ".($budget_year+543-1)."</a></li>";
						}
					}
					else{ // month 10-12 and 1-9
						$pdf_filename = base_url('assets/uploads/files').'/'.($budget_year-1).'-';
						echo '<li><a href="'.$pdf_filename.'10.pdf" target="_blank">'.$th_month[10].' '.($budget_year+543-1)."</a></li>";
						echo '<li><a href="'.$pdf_filename.'11.pdf" target="_blank">'.$th_month[11].' '.($budget_year+543-1)."</a></li>";
						echo '<li><a href="'.$pdf_filename.'12.pdf" target="_blank">'.$th_month[12].' '.($budget_year+543-1)."</a></li>";

						for($i=1; $i<=$month-1; $i++){
							$pdf_filename = base_url('assets/uploads/files').'/'.($budget_year).'-0'.$i.'.pdf';
							echo '<li><a href="'.$pdf_filename.'" target="_blank">'.$th_month[$i].' '.($budget_year+543)."</a></li>";
						}
						
					}
				}
			
	     ?>
					
		</ul>
</div>	    

<script type="text/javascript">
		var url = '<?php echo base_url(); ?>mail/sendmail';
		
		function send(){
			$('#fm').form('submit',{
				url: url,
				onSubmit: function(){
					return $(this).form('validate');
				},
				success: function(result){
                   // console.log(result);
					var result = eval('('+result+')');
					if (result.success){
					   $.messager.alert('ผลการส่ง','ส่งรายงานไปยังผู้รับทางอีเมล์เรียบร้อยแล้ว');
					} else {
					   $.messager.alert('ผลการส่ง','ผิดพลาดไม่สามารถส่งอีเมล์ได้ กรุณาติดต่อผู้ดูแลระบบ','error');
					}
				}
			});
		}
		
</script>