<div class="box box-color box-bordered">
    <div class="box-title">
		<h3>
			<i class="icon-table"></i>
			รายการเอกสารต้นเรื่อง
		</h3>
	</div>
	<div class="box-content nopadding">
		<table id="dg" class="easyui-datagrid" 
					url="<?php echo base_url(); ?>approve/get"
					toolbar="#toolbar"  
		            rownumbers="true" fitColumns="true" singleSelect="true" pagination="true" data-options="onDblClickRow: onDblClickRow">
				<thead>
					<tr>
                        <th data-options="field:'doc_date',width:100" sortable="true">วันที่</th>
						<th data-options="field:'doc_number',width:100" sortable="true">เลขที่ มอ.</th>
						<th data-options="field:'file_number',width:70" sortable="true">ลำดับแฟ้ม</th>
						<th data-options="field:'subject',width:250" sortable="true">เรื่อง</th>
						<th data-options="field:'costs',width:100" sortable="true">ภาควิชา/หน่วยงาน</th>
						<th data-options="field:'amount',width:120,align:'right'" formatter="formatCurrency" sortable="true">จำนวนเงินอนุมัติ</th>
					
					</tr>
				</thead>	
			</table>
			<?php if($this->session->userdata('Role') == 'Administrator' || $this->session->userdata('Role') == 'Finance'): ?>
			<div id="toolbar">  
		    <a href="#" class="easyui-linkbutton" iconCls="icons-add" plain="true" onclick="add()">เพิ่ม</a>
		    <a href="#" class="easyui-linkbutton" iconCls="icons-ok" plain="true" onclick="disbursement()">เบิกจ่าย</a>
		    <a href="#" class="easyui-linkbutton" iconCls="icons-edit" plain="true" onclick="edit()">แก้ไข</a>  
		    <a href="#" class="easyui-linkbutton" iconCls="icons-remove" plain="true" onclick="del()">ลบ</a> 
		    </div>
		    <?php endif; ?>
	  </div>
	  
	  
</div>		    

<div id="dlg" class="easyui-dialog" style="width:740px;height:640px"  
        closed="true" buttons="#dlg-buttons">  

<div class="container-fluid">       
  <div class="row-fluid">
		<form id="fm" method="post" class="form-horizontal ">
	        <fieldset style="padding-top: 0">
		         <legend style="font-size: 11pt">ข้อมูลเอกสารต้นเรื่อง</legend>
				      <table border="0"  class="table-form span12">
				      	<tbody>
				      	<tr>
				      		<td>
							    <label class="control-label" style="width: 80px;">เลขที่เอกสาร</label>
								<input type="text" name="doc_number" class="easyui-validatebox" style="font-size: 12px;width: 120px;" required="true">
				      		</td>
				      		<td>
				      			<label class="control-label" style="width: 80px;">ลำดับที่แฟ้ม</label>
								<input type="text" name="file_number" class="input-mini" style="font-size: 12px">
				      		</td>
				      		<td>
				      		     <label class="control-label" style="width: 80px;">คณะ</label>
				      	     	  <input id="ccfaculty" name="ccfaculty" class="easyui-combobox" style="height:30px;width:200px;"  required="true"
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
 				      	     	<label class="control-label" style="width: 80px;">วันที่</label>
						          <input name="doc_date" class="easyui-datebox" required="true" style="height:30px;width: 133px;" data-options="formatter:myformatter,parser:myparser" >
							    
				      	     </td>
					     <td colspan="2">
 				      	     	  <label class="control-label" style="width: 80px;">ภาควิชา</label>
				      	     	  <input id="ccdepartment" name="ccdepartment" class="easyui-combobox" required="true"
				     				       style="height:30px;width:200px;" 
				     				       data-options="valueField:'id',textField:'name',panelHeight:'auto',
				     				        onSelect: function(rec){
				     				          if(isset(rec)){	
										        var url = '<?php echo base_url(); ?>division/get_by/'+rec.id;  
												$('#ccdivision').combobox('clear');
					                            $('#ccdivision').combobox('reload', url);
				                              }
									       }
				     				       ">
							    
				      	     </td>	
				      	</tr>
				      	<tr>
				      	   <td colspan="2">
 				      	     	  <label class="control-label" style="width: 80px;">เรื่อง</label>
				      	     	  <input type="text" name="subject" style="font-size: 12px;width:280px;">
							    
				      	     </td>
                            <td colspan="2">
 				      	     	  <label class="control-label" style="width: 80px;">หน่วยงาน</label>
				      	     	   <input id="ccdivision" name="ccdivision" class="easyui-combobox" style="height:30px;width:200px;" 
				     				       data-options="valueField:'id',textField:'name',panelHeight:'auto'" />
							    
				      	     </td>
				      	</tr>
                        <tr>
				     			<td colspan="3">
				     				<label class="control-label" style="width: 80px;">รายละเอียด</label>
								<textarea name="detail" rows="2" style="font-size: 12px;width:565px;"></textarea>
								
				     			</td>
				     		</tr>
				      


				      	
                        </tbody>
				     </table>

                     <legend style="font-size: 11pt">การเบิกจ่าย</legend>
				     <table border="0"  class="table-form span12">
				     	<tbody>
				     	 
				     		<tr>
				     			<td>
				     				<label class="control-label" style="width: 80px;">แผนงาน</label>
				     				<input id="ccplans" name="ccplans" class="easyui-combobox" style="height:30px;width:245px" required="true"  
				                           data-options="valueField:'id',textField:'name',panelHeight:'auto',
				                           onSelect: function(rec){
				                           	   if(isset(rec)){
									             var ccurl = '<?php echo base_url(); ?>mgt_product/get_by/'+rec.id;  
											     $('#ccproduct').combobox('clear');
				                                 $('#ccproduct').combobox('reload', ccurl);
				                               }
									        }
				                           ">  
				     			</td>
                                <td>
				     			  
				     			   <div id="myprogress"></div>
				     				
				     			</td>
                                
                                
				     		</tr>
                             <tr>
				     			
                                <td>
				     				<label class="control-label" style="width: 80px;">งาน</label>
				     				<input id="ccproduct" name="ccproduct" class="easyui-combobox" required="true" 
				     				       style="height:30px;width:245px;" 
				     				       data-options="valueField:'id',textField:'name',panelHeight:'auto',
				     				        onSelect: function(rec){
				     				        	if(isset(rec)){
											        var url = '<?php echo base_url(); ?>project/get_by/'+rec.product_id;  
													$('#ccproject').combobox('clear');
						                            $('#ccproject').combobox('reload', url);
						                            
						                            var ccurl = '<?php echo base_url(); ?>mgt_costs/get_by/'+rec.id;  
													$('#cccosts').combogrid('clear');
						                            $('#cccosts').combogrid('grid').datagrid({url:ccurl});
						                            $('#cccosts').combogrid('grid').datagrid('reload');
					                           }
									       }
				     				       ">
				     			</td>
                                <td>
				     			   <label class="control-label" style="width: 80px;">วงเงิน</label>
				     			   <div id="myprogress"></div>
				     				
				     			</td>
				     		</tr>
				     		<tr>
				     			<td>
				     			<label class="control-label" style="width: 80px;">งบรายจ่าย</label>
				     			<input id="ccproject" name="ccproject" class="easyui-combobox" style="height:30px;width:245px;" 
				     			       data-options="valueField:'id',textField:'name',panelHeight:'auto'" />	
			                       
				     	        </td>
                                <td>
				     			   <label class="control-label" style="width: 80px;">วงเงิน</label>
				     			   <div id="myprogress"></div>
				     				
				     			</td>
				     		</tr>
				     		
                            <tr>
				     		
                                <td>
				     			   <label class="control-label" style="width: 80px;">ประเภท</label>
				     				<input id="ccactivity" name="ccactivity" class="easyui-combobox" 
				     				       style="height:30px;width:245px;" 
				     				       data-options="url:'<?php echo base_url(); ?>activity/combobox',
				     				       valueField:'id',textField:'name',panelHeight:'auto'" />
				     			</td>
				     		</tr>

				     		<tr>
				     			<td colspan="2">
				     				<label class="control-label" style="width: 80px;">รายการ</label>
				     				<input id="cccosts" name="cccosts" class="easyui-combogrid" 
				     				       style="height:30px;width:445px;" 
				     				       data-options="
				     				       idField:'id',
                                           textField:'name',
								           mode:'remote',
								           fitColumns: true,
										    columns: [[
										    {field:'costs',title:'งบรายจ่าย',width:100},
                                            {field:'costs_type',title:'ประเภท',width:90},
                                            {field:'name',title:'รายการ / รายการย่อย',width:320}
										    ]],
										    onSelect: function(rowIndex,rowData){					
												calculatCostsBalance(rowData.id);
											}
										    
								"/>
								   
                                         <input type="text" id="real_amount" class="input-small" style="background-color: #FAFAFA; border: none; text-align: right" disabled="disabled"> บาท
				     			</td>
				     		</tr>
				     		
				     		<tr>
				     			<td>
				     				<label class="control-label" style="width: 80px;">จำนวนเงิน</label>
						            <input type="text" id="amount" name="amount" onkeyup="plus()" class="input-medium" style="text-align:right;" required="true">  บาท
					                <button id="clear" class="btn" type="button" onclick="clear_budget()"><i class="icon-remove"></i></button>
					                
				     			</td>
				     			
				     		</tr>
				     	</tbody>
				     </table>
		
						
		    </fieldset>
		   
		    <div id="dlg-buttons">
			<button type="button" class="btn btn-primary" onclick="save()">Save changes</button>
			<button type="button" class="btn" onclick="javascript:$('#dlg').dialog('close')">Cancel</button>
		    </div>
		    
		</form>
   </div>
</div>

</div>


<script type="text/javascript">
	    var base_url = '<?php echo base_url(); ?>';
	    var source_year = '<?php echo $this->session->userdata('budget_year_id'); ?>';
	    var role = '<?php echo $this->session->userdata('Role'); ?>';
		var url;
		var ccurl;
		var total_approve;
		var realpay_amount;
		var costsplan_amount;
		var bar1 = $("#myprogress").progress3bar({width:'200px',color:'#368EE0',border:'1px solid #C3D9E0',padding:'2px'});
		
		function add(){
			$('#dlg').dialog('open').dialog('setTitle','เพิ่มข้อมูลใหม่');
			$('#fm').form('clear');
			$('#clear').hide();
			$('#cccosts').combogrid('enable');
			$('#amount').removeAttr("disabled");
			$('.btn-primary').show();
			
			$('#ccbudget').combobox('select', source_year);
			
			bar1.progress3(0);
			
            url = base_url+'approve/add';
		}
		function disbursement(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				if(row.status == 1){
				    url = '<?php echo base_url(); ?>disbursement/form/'+row.id;
				 }  
				 else{
				 	url = '<?php echo base_url(); ?>disbursement/';
				 }
				 window.location.href = url;
			}
		}
		
		function edit(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','แก้ไขข้อมูล');
				$('#fm').form('load',row);
				url = '<?php echo base_url(); ?>approve/update/'+row.id;
				
				//budget combobox
				$('#ccbudget').combobox('select',row.budget_main_id); 
				
				//faculty combobox
				$('#ccfaculty').combobox('select',row.faculty_code);
				
				//department combobox
				if(row.department_id > 0)
					$('#ccdepartment').combobox('select',row.department_id);									
				else
					$('#ccdepartment').combobox('clear');
				
				//division combobox	
				if(row.division_id > 0){
					ccurl = base_url + 'division/get_by/'+ row.department_id;
					$('#ccdivision').combobox('clear').combobox('reload', ccurl).combobox('select',row.division_id);									
				}else
					$('#ccdivision').combobox('clear');
				
				//plans combobox
				$('#ccplans').combobox('select',row.mgt_plans_id); 
				
				//product combobox
				ccurl = base_url + 'mgt_product/get_by/'+ row.mgt_plans_id;
                $('#ccproduct').combobox('clear').combobox('reload', ccurl).combobox('select',row.mgt_product_id);
				
				//costs combobox
				ccurl = '<?php echo base_url(); ?>mgt_costs/get_by/'+row.mgt_product_id;  
				$('#cccosts').combogrid('clear');
				$('#cccosts').combogrid('grid').datagrid({url:ccurl});
				$('#cccosts').combogrid('grid').datagrid('reload');		
				$('#cccosts').combogrid('setValue', row.mgt_costs_id);
				calculatCostsBalance(row.mgt_costs_id);
				
				//project combobox
				if(row.project_id > 0){
					ccurl = base_url + 'project/get_by/'+ row.product_id;
					$('#ccproject').combobox('clear').combobox('reload', ccurl).combobox('select',row.project_id);									
				}
				
				//activity combobox
				if(row.activity_id > 0)
					$('#ccactivity').combobox('select',row.activity_id);									
				else
					$('#ccactivity').combobox('clear');
				
		
				//check status hide/show save button
				if(row.status == 2 || role != "Finance" || role != "Administrator"){
				   $('.btn-primary').hide();
				   $('#clear').hide();
				}
				else if(role == "Finance" || role == "Administrator"){
				   $('.btn-primary').show();
				   $('#clear').show();
				}
				
				$('#cccosts').combogrid('disable');
				$('#amount').attr("disabled", "disabled");
			}
		}
		function save(){
			$('#fm').form('submit',{
				url: url,
				onSubmit: function(){
					$('#amount').removeAttr("disabled");
					var tmp_amount = parseFloat($('#amount').val().replace(/[,]/g,''));
					console.log(tmp_amount);
					if(tmp_amount < 0){
						$.messager.show({
							title: 'ผิดพลาด',
							msg: 'จำนวนเงินเกินงบประมาณหรือไม่ได้ระบุจำนวนเงิน กรุณาป้อนใหม่'
						});
						return false;
					}
					return $(this).form('validate');
				},
				success: function(result){
					console.log(result);
				
					var result = eval('('+result+')');	
					if (result.success){
						$('#dlg').dialog('close');		// close the dialog
						$('#dg').datagrid('reload');	// reload the user data
					
					} else {
						$.messager.show({
							title: 'Error',
							msg: result.msg
						});
					}
				}
			});
		}
		function del(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				if(row.status == 1){
					 $.messager.confirm('ยืนยัน','คุณแน่ใจหรือว่าต้องการลบข้อมูลรายการนี้?',function(r){
						if (r){
							$.post('<?php echo base_url(); ?>approve/delete',{id:row.id},function(result){
								if (result.success){
									$('#dg').datagrid('reload');	// reload the user data
								} else {
									$.messager.show({	// show error message
										title: 'Error',
										msg: result.msg
									});
								}
							},'json');
						}
					});
				}
				else{
					$.messager.alert('แจ้งเตือน','ไม่สามารถลบเอกสารฉบับนี้ได้ เนื่องจากเอกสารฉบับนี้ทำการเบิกจ่ายเรียบร้อยแล้ว กรุณาติดต่อผู้ดูแลระบบ','info');
				}
			}
		}
		
		// calculat balance from mgt_costs - approve (Real Payment)
		function calculatCostsBalance(mgt_costs_id){
		    var jqsonurl = base_url +'approve/get_real/'+ mgt_costs_id;
				$.getJSON(jqsonurl, function(data) {
			        $.each(data, function(index, val) {
			            $('#real_amount').val(formatCurrency(val.amount));
			            realpay_amount = parseFloat(val.amount);
			        });
			    });
			
			// calculat balance from mgt_costs - approve (Total Apporve)    
			var jqsonurl = base_url +'approve/get_total/'+ mgt_costs_id;
				$.getJSON(jqsonurl, function(data) {
			        $.each(data, function(index, val) {
			           if(val.total != null){
			           	   total_approve = parseFloat(val.total);
			           }else{ 
			        	   total_approve = 0.00;
			           }
			   
			            costsplan_amount = parseFloat(val.amount);
			            
			            var total = (total_approve/costsplan_amount)*100
			            total =  parseFloat(Math.round(total * 100) / 100).toFixed(0);
			            
			            bar1.progress3(total);
			           
			            if(total_approve >= costsplan_amount)
			              $('#amount').attr("disabled", "disabled");
					    else
					      $('#amount').removeAttr("disabled");
					    
			        });
			    });    
		  
		}
		
		
		function clear_budget()
		{
			var tmp_amount = parseFloat($('#amount').val().replace(/[,]/g,''));
			    tmp_amount = parseFloat(total_approve) - tmp_amount;
			
			total_approve = tmp_amount;

			$('#amount').val('');
			$('#amount').removeAttr("disabled");
			$('#cccosts').combogrid('enable');
			$('#clear').hide();
		}
		
		function plus(){
			$("#amount").sum({
			  bind: "keyup"
			, selector: "#real_amount"
			, oncalc: function (value, settings){
				// you can use this callback to format values
				
				var e=window.event?window.event:event;
		        var keyCode=e.keyCode?e.keyCode:e.which?e.which:e.charCode;
				
				//0-9 (numpad,keyboard)
				if ((keyCode>=96 && keyCode<=105)||(keyCode>=48 && keyCode<=57)){
					if(value <= realpay_amount && (total_approve + value) <=  costsplan_amount){
					    $('#real_amount').val(formatCurrency(realpay_amount - value));
					   
					    var total = ((total_approve + value)/costsplan_amount)*100;
					    total =  parseFloat(Math.round(total * 100) / 100).toFixed(0);
					    bar1.progress3(total); 
					    
					    
					    return true;
					 }
				}
				//backspace,delete,left,right,home,end,dot(numpad decimal)
			   if (',8,46,37,39,36,35,110,190,'.indexOf(','+keyCode+',')!=-1){
			      $('#real_amount').val(formatCurrency(realpay_amount - value)); 
			     
			      var total = ((total_approve + value)/costsplan_amount)*100;
			      total =  parseFloat(Math.round(total * 100) / 100).toFixed(0);
				  bar1.progress3(total); 
			      
			      return true;
			   }
				else{ 
					 $(this).val('');
					 $('#real_amount').val(formatCurrency(realpay_amount));
					 
					 return false;
				}
			}
			
		   });
		}
		
		function onDblClickRow(rowIndex, row){
		   edit();
        }
		
		function formatStatus(val,row){
            if (val == 1){
                return '<span class="label label-warning">ยังไม่เบิกจ่าย</span>';
            } else {
                return '<span class="label label-success">เบิกจ่ายแล้ว</span>';
            }
        }
		

$(function(){
     bar1.progress3(0); 
});
	  
</script>
