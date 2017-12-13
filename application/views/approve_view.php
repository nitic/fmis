
<div style="background-color:#ECF0F1;margin-top:2px;padding:1px 0 0.2px 5px">
    <h5 style="color:#666">ค้นหาเลขที่ มอ.</h5>
    <form id="form1" name="form1" method="post" action="" class="form-horizontal">
        <input name="show_arti_topic" type="text" id="show_arti_topic" size="50" />
        <input name="h_arti_id" type="hidden" id="h_arti_id" value="" />
        
        <button type="button" class="btn btn-primary" onclick="search_results()">ค้นหา</button>
    </form>
    
</div>


<div class="box box-color box-bordered">
    <div class="box-title">
		<h3>
			<i class="icon-table"></i>
			รายการเอกสารอนุมัติ
		</h3>
	</div>
	<div class="box-content nopadding">
		<table id="dg" class="easyui-datagrid" 
					url="<?php echo base_url(); ?>approve/get"
					toolbar="#toolbar"  
		            rownumbers="true" fitColumns="true" singleSelect="true" pagination="true" pageSize="20">
				<thead>
					<tr>
						<th data-options="field:'doc_number',width:55" sortable="true">เลขที่ มอ.</th>
						<th data-options="field:'file_number',width:30" sortable="true">ลำดับ</th>
                         <th data-options="field:'doc_date',width:45" sortable="true">วันที่</th>
						<th data-options="field:'subject',width:150" sortable="true">เรื่อง</th>
                        <th data-options="field:'costs_list',width:150" sortable="true">รายการรายจ่าย</th>
						<th data-options="field:'status',width:70" formatter="formatColor" sortable="true">สถานะ</th>
						<th data-options="field:'amount',width:60,align:'right'" formatter="formatCurrency" sortable="true">จำนวนเงินอนุมัติ</th>
                        <th data-options="field:'payment',width:60,align:'right'" formatter="formatCurrency" sortable="true">จำนวนเงินเบิกจ่าย</th>
                        <th data-options="field:'balance',width:60,align:'right'" formatter="formatPrice" sortable="true">คงเหลือ</th>
					
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
	  <div><br />สถานะ: <span style="color:black;"><b>สีดำ</b></span> = ยังไม่เบิกจ่าย, <span style="color:green;"><b>สีเขียว</b></span> = เบิกจ่ายเสร็จสิ้น, 
      <span style="color:#FFBF00;"><b>(สีเหลือง)</b></span> = เบิกจ่ายเสร็จสิ้น(มีเงินเหลือ), <span style="color:blue;"><b>สีน้ำเงิน</b></span> = เบิกจ่ายบางส่วน, <span style="color:red;"><b>สีแดง</b></span> = เงินติดลบ</div>
	  
</div>		    


<div id="dlg" class="easyui-dialog" style="width:740px;height:540px"  
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
						          <input name="doc_date" class="easyui-datebox" style="height:30px;width: 133px;" data-options="formatter:myformatter,parser:myparser" >
							    
				      	     </td>
					     <td colspan="2">
 				      	     	  <label class="control-label" style="width: 80px;">ภาควิชา</label>
				      	     	  <input id="ccdepartment" name="ccdepartment" class="easyui-combobox"
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
                        <tr>
                            <td colspan="2">
				     				<label class="control-label" style="width: 80px;">แผนงาน</label>
				     				<input id="ccplans_mgt" name="ccplans_mgt" class="easyui-combobox" style="height:30px;width:290px"  
				                           data-options="url:'<?php echo base_url(); ?>mgt_plans/get_by/<?php echo $this->session->userdata('budget_year_id'); ?>',
                                           valueField:'id',textField:'name',panelHeight:'auto',
				                           onSelect: function(rec){
				                           	   if(isset(rec)){
									             var ccurl = '<?php echo base_url(); ?>mgt_product/get_by/'+rec.id;  
											     $('#ccproduct_mgt').combobox('clear');
				                                 $('#ccproduct_mgt').combobox('reload', ccurl);
				                               }
									        }
				                           ">  
				     	     </td>
                               <td>
				     			<label class="control-label" style="width: 80px;">งบรายจ่าย</label>
				     			<input id="ccgroup" name="ccgroup" class="easyui-combobox" style="height:30px;width:200px;" 
				     		                data-options="url:'<?php echo base_url(); ?>costs_group/combobox2',
		            	                                  valueField:'id',
		                                                  textField:'name',
		                                                  groupField:'type',
		                                                  panelHeight:'auto',
		                                                  onSelect: function(rec){        
		                                  	                if(isset(rec)){                         
                                                             $('#txtcosts').val(rec.costs_id);
                                             
                                                             var url = '<?php echo base_url(); ?>costs_type/get_by/'+rec.id;  
											                 $('#cctype').combobox('clear');
				                                             $('#cctype').combobox('reload', url);
				                                            }
										                 }
				     		                "/>
				                     <input type="hidden" id="txtcosts" name="txtcosts" />	
				     	       </td>
                              
                        </tr> 
                        <tr>
                              <td colspan="2">
				     				<label class="control-label" style="width: 80px;">งาน</label>
				     				<input id="ccproduct_mgt" name="ccproduct_mgt" class="easyui-combobox"
				     				       style="height:30px;width:290px;" 
				     				       data-options="valueField:'id',textField:'name',panelHeight:'auto'">
				     			</td>
                                <td>
				     			<label class="control-label" style="width: 80px;">ประเภท</label>
				     			<input id="cctype" name="cctype" class="easyui-combobox"
				     				       style="height:30px;width:200px;" 
				     				       data-options="valueField:'id',textField:'name',panelHeight:'auto',
				     				        onSelect: function(rec){
				     				         if(isset(rec) && !empty($('#ccproduct_mgt').combobox('getValue'))){	
										         var url = '<?php echo base_url(); ?>mgt_costs/get_by_cost/'+$('#ccproduct_mgt').combobox('getValue')
                                                            +'/'+$('#txtcosts').val()
                                                            +'/'+$('#ccgroup').combobox('getValue')
                                                            +'/'+rec.id;
												$('#cccosts').combobox('clear');
					                            $('#cccosts').combobox('reload', url);
					                           }
									       }
				     				       ">	
			                       
				     	        </td>
                        </tr> 
                         <tr>
                              <td colspan="3">
                                <label class="control-label" style="width: 80px;">รายการรายจ่าย</label>	
			                       <input id="cccosts" name="cccosts" class="easyui-combobox" style="height:30px;width:582px;" 
				     				    data-options="valueField:'id',textField:'name',panelHeight:'auto'" />

				     			</td>
                        </tr> 
                         
                        <tr>
				     		  <td colspan="2">
				     			  <label class="control-label" style="width: 80px;">วงเงินอนุมัติ</label>
				      	     	  <input type="text" id="amount" name="amount" class="easyui-numberbox" data-options="min:0,precision:2" style="font-size: 12px;"> บาท

				     		  </td>
                              <td>
                           
				     			  <label class="checkbox"><input type="checkbox" name="checkbox">ไม่ระบุจำนวนเงินอนุมัติ</label>
				      	     	
				     		  </td>
				     	</tr>
                         <tr>
				     		  <td colspan="3">
				     			  <label class="control-label" style="width: 80px;">สถานะ</label>
				      	     	  <select class="easyui-combobox" id="status" name="status" data-options="panelHeight:100" style="height:30px;width:200px;">
                                    <option value="1">1 : ยังไม่เบิกจ่าย</option>
                                    <option value="2">2 : เบิกจ่ายบางส่วน</option>
                                    <option value="3">3 : เบิกจ่ายเสร็จสิ้น</option>
                                  </select>
				     		  </td>
				     	</tr>
                        </tbody>
				     </table>

		    </fieldset>
		   
		    <div id="dlg-buttons">
			<button type="button" class="btn btn-primary" onclick="save()">บันทึกข้อมูล</button>
			<button type="button" class="btn" onclick="javascript:$('#dlg').dialog('close')">ยกเลิก</button>
		    </div>
		    
		</form>
   </div>
</div>

</div>




<script type="text/javascript">
        var base_url = '<?php echo base_url(); ?>';
        var url;

     $('#dg').datagrid({
	    onDblClickRow: function(rowIndex, rowData){
		     edit();
	    }
    });


        function add() {
            $('#dlg').dialog('open').dialog('setTitle', 'เพิ่มข้อมูลใหม่');
            $('#fm').form('clear');
            $('#amount').numberbox('clear');
            $('#amount').numberbox('enable');
            $('#ccfaculty').combobox('select', '53');
            $('#status').combobox('select', '1');
            url = base_url + 'approve/add';
        }

        function disbursement() {
            var row = $('#dg').datagrid('getSelected');
            if (row) {
             // alert(row.status);
               if(row.status_id != 3){
                   url = '<?php echo base_url(); ?>disbursement/form/' + row.id;
                   window.location.href = url;
                }
            }
        }

        function edit() {
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','แก้ไขข้อมูล');
				$('#fm').form('load',row);
                
               
				url = '<?php echo base_url(); ?>approve/update/' + row.id;
              
                if(row.mgt_costs_id > 0){
                    var jqsonurl = base_url +'mgt_costs/get_all_id/' + row.mgt_costs_id;
		    	    $.getJSON(jqsonurl, function(data) {
		                $.each(data, function(index, val) {
                            $('#ccplans_mgt').combobox('select', val.mgt_plans_id);
                            $('#ccproduct_mgt').combobox('select', val.mgt_product_id);
                            $('#ccgroup').combobox('select', val.costs_group_id);
                            $('#txtcosts').val(val.costs_id);
                            $('#cctype').combobox('select', val.costs_type_id);
                          
                            ccurl = base_url + 'mgt_costs/get_by_cost/' + val.mgt_product_id + '/' + val.costs_id  + '/' + val.costs_group_id + '/' + val.costs_type_id;
		                    $('#cccosts').combobox('clear').combobox('reload', ccurl).combobox('select',row.mgt_costs_id);    
                         
		                });
                    });                   
                }
                else{
                    $('#ccplans_mgt').combobox('clear');
                    $('#ccproduct_mgt').combobox('clear');
                    $('#ccgroup').combobox('clear');
                    $('#cctype').combobox('clear');
                    $('#cccosts').combobox('clear');
                    
                    $('#txtcosts').val('');                 
                }
                
                //select combobox
				$('#ccfaculty').combobox('select','53');
				$('#ccdepartment').combobox('select',row.department_id); 
                $('#status').combobox('select',row.status_id);
			}
		}

       function save() {
			$('#fm').form('submit',{
				url: url,
				onSubmit: function(){
					return $(this).form('validate');
				},
				success: function(result){
				  //  console.log(result);
				   
				    var result = eval('(' + result + ')');
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
				$.messager.confirm('ยืนยัน','คุณแน่ใจหรือว่าต้องการลบข้อมูลรายการนี้?',function(r){
					if (r){
					    $.post('<?php echo base_url(); ?>approve/delete', { id: row.id }, function (result) {
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
		}

    function formatColor(val,row){ 
        if(row.status_id == 1){
                 return '<span style="color:black;">'+val+'</span>';
        }
        else if(row.status_id == 2){
            return '<span style="color:blue;">'+val+'</span>';
        }
        else if(row.status_id == 3){
                 if(row.balance > 0.00){
                      return '<span style="color:#FFBF00;">'+val+'</span>';
                 }
                 else{
                      return '<span style="color:green;">'+val+'</span>';
                 }
        }
  
    }  
        
        
       function formatPrice(val,row){
           
           if(row.status_id == 3){
              if(val > 0.00){
                 return '<span style="color:#FFBF00;">('+formatCurrency(val)+')</span>';
              }
              else if(val < 0.00){
                 return '<span style="color:red;">'+formatCurrency(val)+'</span>';
              }
              else{
                 return '<span style="color:green;">'+formatCurrency(val)+'</span>';
              }
           }
           else if(row.status_id == 2){
                if(val < 0.00){
                    return '<span style="color:red;">'+formatCurrency(val)+'</span>';
                }
                else{
                    return '<span style="color:blue;">'+formatCurrency(val)+'</span>';
                }
           }
            else if(row.status_id == 1){
                return formatCurrency(val);
           }
 
       }


// Show search result 
function search_results(){

   var value = $('#show_arti_topic').val();
   var keyword = value.replace("/", "_");
   
   var url_data = base_url + 'approve/get/' + keyword;
   $('#dg').datagrid({url:url_data});
   $('#dg').datagrid('reload');	// reload the user data
}

// Search Tools
function make_autocom(autoObj,showObj){
	
	var mkAutoObj=autoObj; 
	var mkSerValObj=showObj; 
	new Autocomplete(mkAutoObj, function() {
		this.setValue = function(id) {		
			document.getElementById(mkSerValObj).value = id;
		}
		if ( this.isModified )
			this.setValue("");
		if ( this.value.length < 1 && this.isNotClick ) 
			return ;	
		
		
		var keyword = this.value.replace("%2F", "_");
		var  searchUrl = base_url + 'search/approve_docnumber/';
			
		return searchUrl +encodeURIComponent(keyword);
    });	
}	

// run Search Tools
make_autocom("show_arti_topic","h_arti_id");


$(document).ready(function () {

        $('input[type="checkbox"][name="checkbox"]').change(function () {
            if (this.checked) {
                $('#amount').numberbox('setValue', 0.00);
                $('#amount').numberbox('disable');

            }
            else {
                $('#amount').numberbox('clear');
                $('#amount').numberbox('enable');
            }

        });
        
 });
</script>
