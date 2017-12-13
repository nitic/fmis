<div class="box box-color box-bordered">
    <div class="box-title">
		<h3>
			<i class="icon-table"></i>
			รายจ่ายจำแนกตามประเภทงบรายจ่าย
		</h3>
	</div>

    <div class="box-content nopadding">
        
        
        
          <div id="toolsbar" style="background-color:#F4F4F4; border:1px solid #dedede;height:120px">

            <?php 
              $attributes = array('id' => 'fm');
              echo form_open('report_plans_costs/',$attributes); 
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
                                   if (isset($post) && !empty($post)){
                                       if(!empty($post['start_date']) && !empty($post['end_date'])){
                                           $start_data = str_replace('/','-',$post['start_date']);
                                           $end_date = str_replace('/','-',$post['end_date']);
                                       }
                                       
                                      $segments = array('report_plans_costs', 'pdf', $post["ccplan"], $post["ccproduct"], $start_data, $end_date); 
                                      $print_url = site_url($segments);
                                   } 
                                   else{
                                       $print_url = "#";
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
					<tr class="datagrid-header datagrid-header-row" style="height:30px ;border: 1px solid #dedede">
                        <td style="width:500px"><div class="datagrid-cell"><span>ชื่อค่าใช้จ่าย</span></div></td>
                        <td style="width:70px"><div class="datagrid-cell"><span>ขออนุมัติเบิก</span></div></td>      
						<td style="width:90px"><div class="datagrid-cell"><span>หนังสือที่ มอ.</span></div></td>
						<td style="width:80px"><div class="datagrid-cell"><span>วันที่เบิกจ่าย</span></div></td>
                        <td style="width:110px"><div class="datagrid-cell"><span>ประเภท</span></div></td>
						<td style="width:100px"><div class="datagrid-cell"><span>จำนวนเงิน</span></div></td>
					</tr>
               
                     <?php
   
                    if (isset($groupview) && !empty($groupview)){
                        
                        $arr_costs_type = array();
                        $sum_amount_total = 0.0;
                        
                        foreach ($groupview as $value) {
                                   
                                   // show costs group header
                                   echo '<tr class="datagrid-body" style="height:25px;overflow:hidden;border-bottom:1px solid #ccc;"><td colspan = "6"><div class="datagrid-cell"><strong>'.$value["group_name"].'</strong> - ('.count($value["group_items"]).' รายการ)</div></td></tr>';                    
                                   
                                   foreach ($value["group_items"] as $item) {
                                       
                                       // costs type summary
                                        $arr_costs_type[$item["costs_type_id"]]["name"] = $item["costs_type_name"];
                                        
                                        if(!isset($arr_costs_type[$item["costs_type_id"]]["sumtotal"]))
                                          $arr_costs_type[$item["costs_type_id"]]["sumtotal"] = floatval($item["payment"]);
                                        else                               
                                          $arr_costs_type[$item["costs_type_id"]]["sumtotal"] += floatval($item["payment"]);
                                       
                                        // show group_items
                                        echo '<tr class="datagrid-body" style="height:25px;">';
                                        echo '<td><div style="padding:0 5px 0 40px;overflow:hidden;line-height: 18px;font-size: 12px;">'.$item["name"].'</div></td>';
                                        echo '<td><div class="datagrid-cell">'.$item["file_number"].'</div></td>';
                                        echo '<td><div class="datagrid-cell">'.$item["doc_number"].'</div></td>';
                                        echo '<td><div class="datagrid-cell">'.formatThaiDate($item["doc_date"]).'</div></td>';
                                        echo '<td><div class="datagrid-cell">'.$item["costs_type_name"].'</div></td>';
                                        echo '<td><div class="datagrid-cell" style="text-align:right">'.number_format($item["payment"],2).'</div></td>';
                                        echo '</tr>';
                                   }
                                    
                                    // show costs type summary
                                    foreach ($arr_costs_type as $item2){
                                        echo '<tr class="datagrid-body" style="height:25px;background-color:#F1EFE2;overflow:hidden"><td colspan = "5" style="padding-left:15px"><div class="datagrid-cell" style="font-weight:900;">'.$item2["name"].'</div></td><td><div class="datagrid-cell" style="text-align:right;font-weight:700;">'.number_format($item2["sumtotal"],2).'</div></td></tr>'; 
                                    }
                                    unset($arr_costs_type);
                                    
                                    // show costs amount summary
                                    echo '<tr class="datagrid-body" style="height:25px;background-color:#E1E1D6;overflow:hidden;border-bottom:1px solid #ccc;"><td colspan = "5"><div class="datagrid-cell" style="text-align:center;font-weight:900;">รวมเงิน</div></td><td><div class="datagrid-cell" style="text-align:right;font-weight:800;">'.number_format($value["group_amount"],2).'</div></td></tr>';  
                                    $sum_amount_total += floatval($value["group_amount"]);
                             
                         }
                         
                                   // show sum amount all total
                                   echo '<tr class="datagrid-body" style="height:25px;overflow:hidden;border-bottom:1px solid #ccc;background-color:#D3D9DF"><td colspan = "5"><div class="datagrid-cell" style="text-align:center;font-weight:900;">รวมเงินทั้งหมด</div></td><td><div class="datagrid-cell" style="text-align:right;font-weight:900;">'.number_format($sum_amount_total,2).'</div></td></tr>'; 
                  
                    }
                    
                    else{
                        echo '<tr class="datagrid-body" style="height:80px"><td colspan = "6" style="text-align:center"><div class="datagrid-cell" style="text-align:center;padding: 10px;"><strong>กรุณาเลือกแผนงานและงาน เพื่อเรียกดูข้อมูล !</strong></div></td></tr>';
                        
                    }     
                  ?>
			</table>
</div>		    


<script type="text/javascript">

$(document).ready(function () {
    
    <?php
        if (isset($post) && !empty($post))
		{
            echo "$('#ccplan').combobox('select', '".$post['ccplan']."');";
            echo "ccurl = '".base_url()."' + 'mgt_product/get_by/".$post['ccplan']."';";
		    echo "$('#ccproduct').combobox('clear').combobox('reload', ccurl).combobox('select', '".$post['ccproduct']."');";
            
            echo "$('#start_date').datebox('setValue','".$post['start_date']."');";
            echo "$('#end_date').datebox('setValue','".$post['end_date']."');";
        }  
    ?>     
 });
</script>