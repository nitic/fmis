<div class="box box-color box-bordered">
    <div class="box-title">
		<h3>
			<i class="icon-table"></i>
			สรุปภาพรวมรายจ่าย จำแนกตามแผนงาน
		</h3>
	</div>

	<div class="box-content nopadding">
         <div style="padding:5px 5px 0 5px;height:40px;background-color:#eee">
         <?php 
         
          $attributes = array('id' => 'fm');
          echo form_open('report_manager/',$attributes); 
         
         ?>
          <table border="0" style="width:100%">
              <tr>
                  <td width="70px">
                      ระหว่างวันที่:
                  </td>
                  <td>
                      <input name="start_date" class="easyui-datebox" style="height:30px;width: 133px;" data-options="formatter:myformatter,parser:myparser" >
                      ถึง
                      <input name="end_date" class="easyui-datebox" style="height:30px;width: 133px;" data-options="formatter:myformatter,parser:myparser" >
                  <button type="submit">แสดงผล</button>
                  </td>
                 
                  <td style="text-align:right">
                      <button type="button" class="btn" onclick="window.open('report_manager/pdf/', '_blank');"><i class="icon-print"></i> พิมพ์รายงาน</button>
                  </td>
              </tr>
          </table>
         <?php echo form_close(); ?>
         </div>        
    
    
			   <table class="tree table table-nomargin table-bordered">
			        <thead>
						<tr>
							<th style="width: 550px">รายการรายจ่าย <?php echo $this->session->userdata('pdf_date'); ?></th>
							<th style="text-align: center">ประมาณการ</th>
							<th style="text-align: center">จ่ายจริง</th>
							<th style="text-align: center">คงเหลือ</th>
                            <th style="text-align: center">ขออนุมัติแล้วรอส่งเบิกจ่าย</th>
                            <th style="text-align: center">คงเหลือ</th>
						</tr>
					</thead>
			        <tbody>
					    <?php
                           if(!empty($treegrid))
                             echo $treegrid;
                           else
                             echo '<tr><td colspan="6">ไม่มีข้อมูล</td></tr>';
                         ?>
			        </tbody>
		      </table>	 
	  </div>
</div>		    

<script type="text/javascript">

        $(".slidingTR").hide();

        $('.show_hide').click(function () {
            $(".slidingTR").toggle();
        });


        $('.tree').teegrid({
            'initialState': 'collapsed'
        });

</script>
