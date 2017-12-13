<div class="box box-color box-bordered">
    <div class="box-title">
		<h3>
			<i class="icon-table"></i>
			ข้อมูลรายจ่าย<?php echo $budget_name[0]["title"]; ?>
		</h3>
	</div>
	<div class="box-content nopadding">
			   <table class="tree table table-nomargin table-bordered">
			        <thead>
						<tr>
							<th style="width: 550px">แผนงาน / ผลผลิต / งบประมาณรายจ่าย / ประเภทรายจ่าย / รายการรายจ่าย</th>
							<th style="text-align: center">เงินจัดสรร</th>
							<th style="text-align: center">เงินอนุมัติ</th>
							<th style="text-align: center">เงินเบิกจ่าย</th>
							<th style="text-align: center">คงเหลือสุทธิ</th>
						</tr>
					</thead>
			        <tbody>
					       <?php
					           echo $treegrid;
					       ?>
						  
			        </tbody>
		      </table>	 
	  </div>
</div>		    

<script type="text/javascript">
		
$(function(){
	   $('.tree').teegrid({
          'initialState': 'collapsed'
        });
});	
</script>
