<div class="box box-color box-bordered">
    <div class="box-title">
		<h3>
			<i class="icon-table"></i>
			รายจ่ายจำแนกตามแผนงาน
		</h3>
	</div>

	<div class="box-content nopadding">
         <div style="padding:5px 5px 0 5px;">
         <?php 
         
          $attributes = array('id' => 'fm');
          echo form_open('report_disbursement_plan/',$attributes); 
         
         ?>
             <input type="hidden" id="plan_name" name="plan_name" />
             <input type="hidden" id="product_name" name="product_name" />
          <table border="0" style="width:100%">
              <tr>
                  <td style="padding-right:5px; width:80px;">
                      เลือกแผนงาน:
                  </td>
                  <td style="width:200px;">
                        <input id="ccplan" name="ccplan" class="easyui-combobox" style="height:30px;"   
                            data-options="url:'<?php echo base_url(); ?>mgt_plans/get_by/<?php echo $this->session->userdata('budget_year_id') ?>',
                                valueField:'id',textField:'name',panelHeight:'auto',
                                 onSelect: function(rec){
                                         	if(isset(rec)){		  
                                               var url = '<?php echo base_url(); ?>mgt_product/get_by/'+rec.id;  
											   $('#ccproduct').combobox('clear');
				                               $('#ccproduct').combobox('reload', url);
                                               $('#plan_name').val(rec.name);
				                             }  
										 }
                           ">
                  </td>
                  <td style="width:30px; text-align:right;padding-right:5px;">
                      งาน:
                  </td>
                  <td style="width:200px;">
                      <input id="ccproduct" name="ccproduct" class="easyui-combobox" style="height:30px;" 
				     		data-options="valueField:'id',textField:'name',panelHeight:'auto',
                                onSelect: function(rec){
                                         	if(isset(rec)){		  
                                                $('#product_name').val(rec.name);
				                             }  
										 }
                          ">
                  </td>
                  <td style="width:80px; text-align:right;">
                      <button type="submit">แสดงผล</button>
                  </td>
                  <td style="padding-left:5px">
                      <a href="#" class="show_hide">ระบุวันที่...</a>
                  </td>
                  <td style="text-align:right">
                      <button type="button" class="btn" onclick="window.open('report_disbursement_plan/pdf/', '_blank');"><i class="icon-print"></i> พิมพ์รายงาน</button>
                  </td>
              </tr>
              <tr class="slidingTR">
                  <td>
                      ระหว่างวันที่:
                  </td>
                  <td colspan="3">
                      <input name="start_date" class="easyui-datebox" style="height:30px;width: 133px;" data-options="formatter:myformatter,parser:myparser" >
                      ถึง
                      <input name="end_date" class="easyui-datebox" style="height:30px;width: 133px;" data-options="formatter:myformatter,parser:myparser" >
                  </td>
                 
              </tr>
          </table>
         <?php echo form_close(); ?>
         </div>

			   <table class="tree table table-nomargin table-bordered">
			        <thead>
						<tr>
							<th style="width: 550px">รายการรายจ่าย</th>
							<th style="text-align: center">ประมาณการ</th>
							<th style="text-align: center">จ่ายจริง</th>
							<th style="text-align: center">คงเหลือ</th>
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

        $(".slidingTR").hide();

        $('.show_hide').click(function () {
            $(".slidingTR").toggle();
        });


        $('.tree').teegrid({
            'initialState': 'collapsed'
        });

</script>
