<div class="box box-color box-bordered">
    <div class="box-title">
		<h3>
			<i class="icon-table"></i>
			รายชื่อหน่วยงาน
		</h3>
	</div>
	<div class="box-content nopadding">
		<table id="dg" class="easyui-datagrid" 
					url="<?php echo base_url(); ?>division/get"
					toolbar="#toolbar"  
		            rownumbers="true" fitColumns="true" singleSelect="true" pagination="true" >
				<thead>
					<tr>
						<th data-options="field:'id',width:30,align:'left'" formatter="padDigits2">รหัส</th>
                                                <th data-options="field:'name',width:150">ชื่อหน่วยงาน</th>
						<th data-options="field:'department',width:100">ภาควิชา</th>
						<th data-options="field:'faculty',width:250">สังกัดคณะ</th>
					</tr>
				</thead>	
			</table>
			<?php if($this->session->userdata('Role') == 'Administrator'): ?>
			<div id="toolbar">  
		    <a href="#" class="easyui-linkbutton" iconCls="icons-add" plain="true" onclick="add()">เพิ่ม</a>  
		    <a href="#" class="easyui-linkbutton" iconCls="icons-edit" plain="true" onclick="edit()">แก้ไข</a>  
		    <a href="#" class="easyui-linkbutton" iconCls="icons-remove" plain="true" onclick="del()">ลบ</a>  
		    </div>
		    <?php endif; ?>
	  </div>
</div>		    


<div id="dlg" class="easyui-dialog" style="width:550px;height:350px;padding:5px 10px"  
        closed="true" buttons="#dlg-buttons">  
   
	<div class="box-title">
		<h3><i class="icon-edit"></i> ข้อมูลหน่วยงาน</h3>
	</div>
	<div class="box-content nopadding">
	    <form id="fm" method="post" class='form-horizontal form-bordered'> 
			<div class="control-group">
			  <label for="ccfaculty" class="control-label">สังกัดคณะ</label>
			  <div class="controls">
					
			   <input id="ccfaculty" name="ccfaculty" class="easyui-combobox" style="height:30px;"  disabled="disabled"
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
		          </div>
			</div>
	    	        <div class="control-group">
			  <label for="name" class="control-label">ชื่อหน่วยงาน</label>
				<div class="controls">
			          <input type="text" name="name" class="easyui-validatebox" required="true">
				</div>
			</div>
			<div class="control-group">
			  <label for="ccfaculty" class="control-label">ภาควิชา</label>
			  <div class="controls">		
			  <input id="ccdepartment" name="ccdepartment" class="easyui-combobox" style="height:30px;" 
				     data-options="valueField:'id',textField:'name',panelHeight:'auto'" required="true" />
		          </div>
			</div>
			
	    	<div id="dlg-buttons">
			<button type="button" class="btn btn-primary" onclick="save()">Save changes</button>
			<button type="button" class="btn" onclick="javascript:$('#dlg').dialog('close')">Cancel</button>
		    </div>
	    </form>  
   </div>
 </div>  




<script type="text/javascript">
		var url;
		function add(){
			$('#dlg').dialog('open').dialog('setTitle','เพิ่มข้อมูลใหม่');
			$('#fm').form('clear');
			$('#ccfaculty').combobox('select','53');
			url = '<?php echo base_url(); ?>division/add';
		}
		function edit(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','แก้ไขข้อมูล');
				$('#fm').form('load',row);
				url = '<?php echo base_url(); ?>division/update/'+row.id;

				$('#ccfaculty').combobox('select','53');
				$('#ccdepartment').combobox('select',row.department_id); //select combobox

			}
		}
		function save(){
			$('#fm').form('submit',{
				url: url,
				onSubmit: function(){
					return $(this).form('validate');
				},
				success: function(result){
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
				$.messager.confirm('ยืนยัน','คุณแน่ใจหรือว่าต้องการลบข้อมูลรายการนี้?',function(r){
					if (r){
						$.post('<?php echo base_url(); ?>division/delete',{id:row.id},function(result){
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
	</script>
