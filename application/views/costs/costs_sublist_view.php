<div class="box box-color box-bordered">
    <div class="box-title">
		<h3>
			<i class="icon-table"></i>
			 รายการรายจ่ายย่อย
		</h3>
	</div>
    <div class="box-content nopadding">
		<table id="dg" class="easyui-datagrid" style="width:auto;height:auto"
			url="<?php echo base_url(); ?>costs_sublist/get"
			toolbar="#toolbar"  
            rownumbers="true" fitColumns="true" singleSelect="true" pagination="true" >
		<thead>
			<tr>
				<th data-options="field:'id',width:50" formatter="padDigits4" sortable="true">รหัส</th>
				<th data-options="field:'name',width:350">ชื่อรายการย่อย</th>
				<th data-options="field:'lists',width:280" sortable="true">ชื่อรายการหลัก</th>
				<th data-options="field:'type',width:150" sortable="true">ประเภทรายจ่าย</th>
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

<div id="dlg" class="easyui-dialog" style="width:610px;height:350px;padding:10px 20px"  
        closed="true" buttons="#dlg-buttons">  
    <div class="box-title">
		<h3><i class="icon-edit"></i> ข้อมูลรายจ่ายย่อย</h3>
	</div>
	<div class="box-content nopadding">
    <form id="fm" method="post" class='form-horizontal form-bordered'> 
    	    <div class="control-group">
			  <label for="name" class="control-label">ชื่อรายจ่ายย่อย</label>
				<div class="controls">
					<input type="text" name="name" class="easyui-validatebox input-xlarge" required="true">
				</div>
			</div>
    	    <div class="control-group">
			  <label for="type" class="control-label">ประเภทรายจ่าย</label>
				<div class="controls">
					<input id="cc1" name="type" required="true" class="easyui-combobox" style="height:30px;width:285px;"  
                           data-options="url:'<?php echo base_url(); ?>costs_type/combobox',
                    	   valueField:'id',
                           textField:'name',
                           panelHeight:'auto',
                           onSelect: function(rec){
					        var url = '<?php echo base_url(); ?>costs_lists/get_by/'+rec.id;  
							$('#cc2').combobox('clear');
                            $('#cc2').combobox('reload', url);
					        }
                           ">  
				</div>
			</div>
    	    <div class="control-group">
			  <label for="cclist" class="control-label">สังกัดรายการหลัก</label>
				<div class="controls">
					<input id="cc2" name="cclist" required="true" class="easyui-combobox" style="height:30px;width:285px;" data-options="valueField:'id',textField:'name',panelHeight:'auto'" />
				</div>
			</div>
    	    <div id="dlg-buttons">  
			    <button type="button" class="btn btn-primary" onclick="save()">Save changes</button>
			    <button type="button" class="btn" onclick="javascript:$('#dlg').dialog('close')">Cancel</button>  
			</div>
    	
    </form>  
</div>  
</div>  


<script sublist="text/javascript">
		var url;
		function add(){
			$('#dlg').dialog('open').dialog('setTitle','เพิ่มข้อมูลใหม่');
			$('#fm').form('clear');
			url = '<?php echo base_url(); ?>costs_sublist/add';
		}
		function edit(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','แก้ไขข้อมูล');
				$('#fm').form('load',row);
				url = '<?php echo base_url(); ?>costs_sublist/update/'+row.id;
				
				$('#cc1').combobox('select',row.costs_type_id); //select combobox
				
				var ccurl = '<?php echo base_url(); ?>costs_lists/get_by/'+row.costs_type_id;  
				$('#cc2').combobox('clear');
                $('#cc2').combobox('reload', ccurl);
                $('#cc2').combobox('select',row.costs_lists_id); //select combobox
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
						$.post('<?php echo base_url(); ?>costs_sublist/delete',{id:row.id},function(result){
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