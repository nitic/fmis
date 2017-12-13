<div class="container-fluid">       
  <div class="row-fluid">
		<form id="fm" method="post" class="form-horizontal ">
	        <fieldset style="padding-top: 0">
		         <legend style="font-size: 11pt">ข้อมูลผู้ขออนุมัติ</legend>
				      <table border="1"  class="table-form span12">
				      	<tbody>
				      	<tr>
				      		<td>
							    <label class="control-label" style="width: 80px;">เลขที่เอกสาร</label>
								<input type="text" name="document_number" class="easyui-validatebox" style="font-size: 12px;width: 120px;" required="true">
				      		</td>
				      		<td>
				      			<label class="control-label" style="width: 80px;">ลำดับที่แฟ้ม</label>
								<input type="text" name="file_number" class="input-mini" style="font-size: 12px">
				      		</td>
				      		<td>
				      		     <label class="control-label" style="width: 80px;">คณะ</label>
				      	     	  <input id="ccfaculty" name="ccfaculty" class="easyui-combobox" style="height:30px;width:200px;"  
				                           data-options="url:'<?php echo base_url(); ?>faculty/combobox',
				                    	   valueField:'code',
				                           textField:'name',
				                           panelHeight:'auto',
				                           onSelect: function(rec){
									        var url = '<?php echo base_url(); ?>department/get_by/'+rec.code;  
											$('#ccdepartment').combobox('clear');
				                            $('#ccdepartment').combobox('reload', url);
									        }
				                           ">   
				      		</td>
				      	</tr>
				      	<tr>
				      	     <td colspan="2">
 				      	     	<label class="control-label" style="width: 80px;">วันที่อนุมัติ</label>
						          <input name="doc_date" class="easyui-datebox" required="true" style="height:30px;width: 133px;" data-options="formatter:myformatter,parser:myparser" >
							    
				      	     </td>
					     <td colspan="2">
 				      	     	  <label class="control-label" style="width: 80px;">ภาควิชา</label>
				      	     	  <input id="ccdepartment" name="ccdepartment" class="easyui-combobox" 
				     				       style="height:30px;width:200px;" 
				     				       data-options="valueField:'id',textField:'name',panelHeight:'auto',
				     				        onSelect: function(rec){
									        var url = '<?php echo base_url(); ?>division/get_by/'+rec.id;  
											$('#ccdivision').combobox('clear');
				                            $('#ccdivision').combobox('reload', url);
									       }
				     				       ">
							    
				      	     </td>	
				      	</tr>
				      	<tr>
				      	     <td colspan="2">
 				      	     	  <label class="control-label" style="width: 80px;">แหล่งเงิน</label>
					      		       	  <input id="ccbudget" name="ccbudget" class="easyui-combobox" required="true" 
				     				       style="height:30px;width:295px;" 
				     				       data-options="url:'<?php echo base_url(); ?>budget_main/combobox',
				     				                     valueField:'id',textField:'title',panelHeight:'auto',
                                                                         onSelect: function(rec){
											       $('#budget_amount').val(formatCurrency(rec.amount));
											             }
				     				                    ">
							    
				      	     </td>
                                             <td colspan="2">
 				      	     	  <label class="control-label" style="width: 80px;">หน่วยงาน</label>
				      	     	   <input id="ccdivision" name="ccdivision" class="easyui-combobox" style="height:30px;width:200px;" 
				     				       data-options="valueField:'id',textField:'name',panelHeight:'auto'" />
							    
				      	     </td>
				      	</tr>
				      
				      	
                        </tbody>
				     </table>

                     <legend style="font-size: 11pt">รายละเอียดการอนุมัติ</legend>
				     <table border="1"  class="table-form span12">
				     	<tbody>
				     	  <tr>
				      	     <td colspan="2">
 				      	     	  <label class="control-label" style="width: 80px;">เรื่อง</label>
				      	     	  <input type="text" name="subject" style="font-size: 12px;width:565px;">
							    
				      	     </td>
				      	   </tr>
					   <tr>
				     			<td colspan="2">
				     				<label class="control-label" style="width: 80px;">รายละเอียด</label>
								<textarea name="detail" rows="2" style="font-size: 12px;width:565px;"></textarea>
								
				     			</td>
				     		</tr>
				     		<tr>
				     			<td>
				     				<label class="control-label" style="width: 80px;">แผนงาน</label>
				     				<input id="ccplans" name="ccplans" class="easyui-combobox" style="height:30px;width:245px;" required="true"  
				                           data-options="url:'<?php echo base_url(); ?>plans/combobox',
				                    	   valueField:'id',
				                           textField:'name',
				                           panelHeight:'auto',
				                           onSelect: function(rec){
									        var url = '<?php echo base_url(); ?>product/get_by/'+rec.id;  
											$('#ccproduct').combobox('clear');
				                            $('#ccproduct').combobox('reload', url);
									        }
				                           ">  
				     			</td>
                                                  <td>
				     			<label class="control-label" style="width: 80px;">โครงการ</label>
				     			<input id="ccproject" name="ccproject" class="easyui-combobox" style="height:30px;width:245px;" 
				     			       data-options="valueField:'id',textField:'name',panelHeight:'auto'" />	
			                       
				     	          </td>
				     		</tr>
				     		<tr>
				     			<td>
				     				<label class="control-label" style="width: 80px;">ผลผลิต</label>
				     				<input id="ccproduct" name="ccproduct" class="easyui-combobox" 
				     				       style="height:30px;width:245px;" 
				     				       data-options="valueField:'id',textField:'name',panelHeight:'auto',
				     				        onSelect: function(rec){
									        var url = '<?php echo base_url(); ?>project/get_by/'+rec.id;  
											$('#ccproject').combobox('clear');
				                            $('#ccproject').combobox('reload', url);
									       }
				     				       ">
				     			</td>
                                                        <td>
				     			   <label class="control-label" style="width: 80px;">กิจกรรม</label>
				     				<input id="ccactivity" name="ccactivity" class="easyui-combobox" 
				     				       style="height:30px;width:245px;" 
				     				       data-options="url:'<?php echo base_url(); ?>activity/combobox',
				     				       valueField:'id',textField:'name',panelHeight:'auto'" />
				     			</td>
				     		</tr>
				     		
				     		<tr>
				     			<td colspan="2">
				     				<label class="control-label" style="width: 80px;">งบรายจ่าย</label>
				     				<input id="ccactivity" name="ccactivity" class="easyui-combobox" 
				     				       style="height:30px;width:470px;" 
				     				       data-options="url:'<?php echo base_url(); ?>activity/combobox',
				     				       valueField:'id',textField:'name',panelHeight:'auto'" />
								
                                                           <input type="text" name="costs_balance" class="easyui-numberbox input-small" style="font-size: 12px">
				     			</td>
				     		</tr>
				     		
				     		<tr>
				     			<td colspan="2">
				     				<label class="control-label" style="width: 80px;">จำนวนเงิน</label>
						            <input type="text" name="amount" required="true" class="easyui-numberbox input-medium" data-options="precision:2,groupSeparator:','"> บาท
								
				     			</td>
				     		</tr>
				     	</tbody>
				     </table>
		
						
		    </fieldset>
		   
		    <div id="dlg-buttons" class="form-actions">
			<button type="button" class="btn btn-primary" onclick="save()">Save changes</button>
			<button type="button" class="btn" onclick="window.history.back()">Cancel</button>
            
		    </div>
		    
		</form>
   </div>
</div>

<script type="text/javascript">
        var base_url = '<?php echo base_url(); ?>';
        var row_id = <?php echo $row_id; ?>;
		var url;
		
		function save(){
			 if(row_id > 0){
			    url = base_url + 'approve/update/'+row_id;
			 }else if(row_id == 0){
				url = base_url + 'approve/add';
			 }
			$('#fm').form('submit',{
				url: url,
				onSubmit: function(){
					return $(this).form('validate');
				},
				success: function(result){
					var result = eval('('+result+')');
					if (result.success){
			            window.location.href = base_url+'approve/';
					} else {
						alert(result.msg);
					}

				}
			});
		}
		
		function del(){
			if (row_id > 0){
				$.messager.confirm('ยืนยัน','คุณแน่ใจหรือว่าต้องการลบข้อมูลรายการนี้?',function(r){
					if (r){
						$.post('<?php echo base_url(); ?>approve/delete',{id:row_id},function(result){
							if (result.success){
								window.location.href = base_url+'approve/';
							} else {
								alert(result.msg);
							}
						},'json');
					}
				});
			}
		}
		
<?php 

if($row_id > 0):
?>
$(document).ready(function() {
	
var url_base = '<?=base_url();?>';
var jqsonurl = '<?=base_url('approve/get_by')."/".$row_id;?>';

	$.getJSON(jqsonurl, function(data) {
        $.each(data, function(index, val) {
            
            $('#fm').form('load',{
                 document_number:val.doc_number,
            	 file_number:val.file_number,
            	 doc_date:formatThaiDate(val.doc_date),
            	 subject:val.subject,
            	 detail:val.detail,
            	 amount:val.amount
            });
            
            // faculty combobox
            if(val.faculty_code > 0){
            $('#ccfaculty').combobox('select',val.faculty_code);
            }
            
            // department combobox
            if(val.department_id > 0){
            var ccurl = url_base + 'department/get_by/'+ val.faculty_code;
            $('#ccdepartment').combobox('clear').combobox('reload', ccurl).combobox('select',val.department_id);
            }
            
            // division combobox
            if(val.division_id > 0){
            ccurl = url_base + 'division/get_by/'+ val.department_id;
            $('#ccdivision').combobox('clear').combobox('reload', ccurl).combobox('select',val.division_id);
            }
            
            // plans combobox
            if(val.plan_id > 0){
            $('#ccplans').combobox('select',val.plan_id);
            }
            
            // product combobox
            if(val.product_id > 0){
            ccurl = url_base + 'product/get_by/'+ val.plan_id;
            $('#ccproduct').combobox('clear').combobox('reload', ccurl).combobox('select',val.product_id);
            }
            
            // project combobox
            if(val.project_id > 0){
            ccurl = url_base + 'project/get_by/'+ val.product_id;
            $('#ccproject').combobox('clear').combobox('reload', ccurl).combobox('select',val.project_id);
            }
            
            // activity combobox
            if(val.activity_id > 0){
            $('#ccactivity').combobox('select',val.activity_id);
            }
            
            // costs group combobox
            if(val.costs_group_id > 0){
            $('#ccgroup').combobox('select',val.costs_group_id);
            }
           
            // costs type combobox
            if(val.costs_type_id > 0){
         	ccurl = url_base + 'costs_type/get_by/'+ val.costs_group_id;
            $('#cctype').combobox('clear').combobox('reload', ccurl).combobox('select',val.costs_type_id);
            }
         	
         	// costs lists combobox
         	if(val.costs_lists_id > 0){
         	ccurl = url_base + 'costs_lists/get_by/'+ val.costs_type_id;
            $('#cclists').combobox('clear').combobox('reload', ccurl).combobox('select',val.costs_lists_id);
            }
           
            // costs sublist combobox
            if(val.costs_sublist_id > 0){
            ccurl = url_base + 'costs_sublist/get_by/'+ val.costs_lists_id;
            $('#ccsublist').combobox('clear').combobox('reload', ccurl).combobox('select',val.costs_sublist_id);
            }
            
            // budget combobox
            $('#ccbudget').combobox('select',val.budget_main_id);
            
        });
    });
});
<?php endif; ?>
</script>
