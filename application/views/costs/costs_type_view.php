<div class="box box-color box-bordered">
    <div class="box-title">
		<h3>
			<i class="icon-table"></i>
			ประเภทรายจ่าย
		</h3>
	</div>
    <div class="box-content nopadding">
		<table id="dg" class="easyui-datagrid" style="width:auto;height:auto"
			url="<?php echo base_url(); ?>costs_type/get"
			toolbar="#toolbar"  
            rownumbers="true" fitColumns="true" singleSelect="true" pagination="true" >
		<thead>
			<tr>
				<th data-options="field:'id',width:30" formatter="padDigits2" sortable="true">รหัส</th>
				<th data-options="field:'name',width:60">ชื่อประเภท</th>
				<th data-options="field:'costs_group',width:200" sortable="true">หมวดรายจ่าย</th>
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

<div id="dlg" class="easyui-dialog" style="width:500px;height:300px;padding:10px 20px"  
        closed="true" buttons="#dlg-buttons">  
    
    <div class="box-title">
		<h3><i class="icon-edit"></i> ข้อมูลประเภทรายจ่าย</h3>
	</div>
	<div class="box-content nopadding" class='form-horizontal form-bordered'>
    <form id="fm" method="post" class='form-horizontal form-bordered'> 
    	   <div class="control-group">
			  <label for="name" class="control-label">ชื่อประเภท</label>
				<div class="controls">
					<input type="text" name="name" class="easyui-validatebox input-large" required="true">
				</div>
			</div>
			 <div class="control-group">
			  <label for="plan" class="control-label">หมวดรายจ่าย</label>
				<div class="controls">
					<input id="cc" name="group" required="true" class="easyui-combobox" style="height:30px;width:225px;"  
                           data-options="url:'<?php echo base_url(); ?>costs_group/combobox',
                    	   valueField:'id',
                           textField:'name',
                           panelHeight:'auto'
                           ">
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
			url = '<?php echo base_url(); ?>costs_type/add';
		}
		function edit(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','แก้ไขข้อมูล');
				$('#fm').form('load',row);
				url = '<?php echo base_url(); ?>costs_type/update/'+row.id;
				
				$('#cc').combobox('select',row.costs_group_id); //select combobox
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
						$.post('<?php echo base_url(); ?>costs_type/delete',{id:row.id},function(result){
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