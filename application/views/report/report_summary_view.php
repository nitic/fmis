<div class="box box-color box-bordered">
    <div class="box-title">
		<h3>
			<i class="icon-table"></i>
			ตารางสรุปภาพรวมการเบิกจ่ายงบประมาณ
		</h3>
	</div>

    <div class="box-content nopadding">
        
        
        
          <div id="toolsbar" style="background-color:#F4F4F4; border:1px solid #dedede;height:120px">

            <?php 
              $attributes = array('id' => 'fm');
              echo form_open('report_summary/',$attributes); 
             ?>   

                 <table border="0" style="width:100%">
                    
                     <tr style="height:10px;">
                         <td colspan="6">
                               <input type="hidden" id="plan_name" name="plan_name" />
                               <input type="hidden" id="product_name" name="product_name" />
                         </td>
                     </tr>
                      <tr style="height:30px;">
                          <td style="text-align:right;width:60px">
                              แผนงาน:
                          </td>
                          <td style="width:320px; border-right:1px solid #dedede">
                                <input id="ccplan" name="ccplan" class="easyui-combobox"   style="width:300px;"
                                    data-options="url:'<?php echo base_url(); ?>mgt_plans/combobox/<?php echo $this->session->userdata('budget_year_id') ?>',
                                        valueField:'id',textField:'name',panelHeight:'auto',
                                         onSelect: function(rec){
                                                 	if(isset(rec)){		  
                                                       var url = '<?php echo base_url(); ?>mgt_product/combobox/'+rec.id;  
        											   $('#ccproduct').combobox('clear');
        				                               $('#ccproduct').combobox('reload', url);
                                                       $('#plan_name').val(rec.name);
        				                             }  
        										 }
                                   ">
                          </td>
                           <td style="text-align:right;width:80px">
                             <span >ระหว่างวันที่:</span>
                           </td>
                          <td>
                              <input id="start_date" name="start_date" class="easyui-datebox" style="width: 133px;" data-options="formatter:myformatter,parser:myparser" >
                             &nbsp; ถึง &nbsp;
                              <input id="end_date" name="end_date" class="easyui-datebox" style="width: 133px;" data-options="formatter:myformatter,parser:myparser" >
                          </td>
                          
                          <td style="text-align:right">
                              <?php
                                // echo var_dump($_POST); 
                                   if (isset($_POST) && !empty($_POST)){
                                      
                                      $segments = array('report_summary', 'pdf', $_POST["ccplan"], $_POST["ccproduct"]); 
                                      $print_url = site_url($segments);
                                   } 
                                   else{
                                        $segments = array('report_summary', 'pdf', '0', '0'); 
                                        $print_url = site_url($segments);
                                   } 
                              ?>
                              <button type="button" class="btn" onclick="window.open('<?php echo $print_url; ?>', '_blank');"><i class="icon-print"></i> พิมพ์รายงาน</button>
                          </td>
                      </tr>
                      <tr style="height:30px;">
                           <td style="text-align:right;">
                              งาน:
                          </td>
                          <td colspan="5" style="width:200px">
                              <input id="ccproduct" name="ccproduct" class="easyui-combobox"  style="width:300px;"
        				     		data-options="valueField:'id',textField:'name',panelHeight:'auto',
                                        onSelect: function(rec){
                                                 	if(isset(rec)){		  
                                                        $('#product_name').val(rec.name);
        				                             }  
        										 }
                                  ">
                          </td>
                         
                      </tr>
                      <tr style="height:40px;">
                          <td >
                      
                          </td>
                          <td colspan="4" >
                              <button type="submit">แสดงผล</button>
                          </td>
                      </tr>
                      
                  </table> 
                   <?php echo form_close(); ?>
		    </div>
            <table style="width:100%"> 
					<tr class="datagrid-header datagrid-header-row" style="height:30px ;border: 1px solid #dedede;background-color:#989898">
                        <td style="width:45%;text-align:center;font-weight:900;color:#fff"><div class="datagrid-cell"><span>รายการ</span></div></td>
                        <td style="width:10%;text-align:center;font-weight:900;color:#fff"><div class="datagrid-cell"><span>ประมาณการ</span></div></td>      
						<td style="width:10%;text-align:center;font-weight:900;color:#fff"><div class="datagrid-cell"><span>จ่ายจริง</span></div></td>
						<td style="width:10%;text-align:center;font-weight:900;color:#fff"><div class="datagrid-cell"><span>คงเหลือ</span></div></td>
                        <td style="width:10%;text-align:center;font-weight:900;color:#fff"><div class="datagrid-cell"><span>ขออนุมัติแล้วรอส่งหลักฐานเบิกจ่าย</span></div></td>
						<td style="width:10%;text-align:center;font-weight:900;color:#fff"><div class="datagrid-cell"><span>คงเหลือ</span></div></td>
					</tr>
                   <?php
                       echo $table_data;   
                   ?>
			</table>
            
</div>		    


<script type="text/javascript">

$(document).ready(function () {
    
    <?php
       
        if (isset($_POST['ccplan']) && !empty($_POST['ccplan'])){
            echo "$('#ccplan').combobox('select', '".$_POST['ccplan']."');";
            echo "ccurl = '".base_url()."' + 'mgt_product/combobox/".$_POST['ccplan']."';";
            echo "$('#ccproduct').combobox('clear').combobox('reload', ccurl).combobox('select', '".$_POST['ccproduct']."');";
            
        }
        else{
             echo "$('#ccplan').combobox('select', '0');";
             echo "ccurl = '".base_url()."' + 'mgt_product/combobox/0';";
             echo "$('#ccproduct').combobox('clear').combobox('reload', ccurl).combobox('select', '0');";

        }
        
            echo "$('#start_date').datebox('setValue','".$_POST['start_date']."');";
            echo "$('#end_date').datebox('setValue','".$_POST['end_date']."');";
    ?>     
 });
</script>