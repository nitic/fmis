<div class="box box-color box-bordered">
    <div class="box-title">
		<h3>
			<i class="icon-table"></i>
			รายการรายจ่าย
		</h3>
	</div>
 <div class="box-content nopadding">
		<table id="dg" class="easyui-datagrid" style="width:auto;height:auto"
			url="<?php echo base_url(); ?>costs_lists/get"
			toolbar="#toolbar"  
            rownumbers="true" fitColumns="true" singleSelect="true" pagination="true" >
		<thead>
			<tr>
				<th data-options="field:'id',width:20" formatter="padDigits3" sortable="true">รหัส</th>
				<th data-options="field:'name',width:100" sortable="true">ชื่อรายการ</th>
				<th data-options="field:'type',width:150" sortable="true">ประเภทรายจ่าย</th>
			</tr>
		</thead>	
		</table>
		<div id="toolbar"> 
			<div style="float: left;width: 450px;background-color: transparent;border: none;"> 
		     <?php if($this->session->userdata('Role') == 'Administrator'): ?>
		      <a href="#" class="easyui-linkbutton" iconCls="icons-add" plain="true" onclick="add()">เพิ่ม</a>  
		      <a href="#" class="easyui-linkbutton" iconCls="icons-edit" plain="true" onclick="edit()">แก้ไข</a>  
		      <a href="#" class="easyui-linkbutton" iconCls="icons-remove" plain="true" onclick="del()">ลบ</a>  
	         <?php endif; ?> 
	        
	         <span> เลือกประเภทรายจ่าย:
		    	  <input id="cctype" name="cctype" class="easyui-combobox"  style="width:150px" 
		             data-options="url:'<?php echo base_url(); ?>costs_type/combobox2',
		                    	   valueField:'id',
		                           textField:'name',
		                           panelHeight:'auto',
		                           onSelect: function(rec){
						              doFilter(rec.id);
							        }">  
	         </span> 
	         </div>		
	    </div>
    </div>
</div>



<div id="dlg" class="easyui-dialog" style="width:500px;height:300px;padding:10px 20px"  
        closed="true" buttons="#dlg-buttons">  
    
    <div class="box-title">
		<h3><i class="icon-edit"></i> ข้อมูลรายจ่าย</h3>
	</div>
	<div class="box-content nopadding">
    <form id="fm" method="post" class='form-horizontal form-bordered'> 
    	   <div class="control-group">
			  <label for="name" class="control-label">ชื่อรายจ่าย</label>
				<div class="controls">
					<input type="text" name="name" class="easyui-validatebox input-large" required="true">
				</div>
			</div>
    	    <div class="control-group">
			  <label for="plan" class="control-label">ประเภทรายจ่าย</label>
				<div class="controls">
					<input id="cc" name="type" required="true" class="easyui-combobox" style="height:30px;width:225px;"   
                           data-options="url:'<?php echo base_url(); ?>costs_type/combobox',
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
			url = '<?php echo base_url(); ?>costs_lists/add';
		}
		function edit(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','แก้ไขข้อมูล');
				$('#fm').form('load',row);
				url = '<?php echo base_url(); ?>costs_lists/update/'+row.id;
				
				$('#cc').combobox('select',row.costs_type_id); //select combobox
			}
		}
		function save(){
			$('#fm').form('submit',{
				url: url,
				onSubmit: function(){
					return $(this).form('validate');
				},
				success: function(result){
					//console.log(result);
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
						$.post('<?php echo base_url(); ?>costs_lists/delete',{id:row.id},function(result){
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
		
		function doFilter(id){
		     $('#dg').datagrid('load',{
		        costs_type_id: id
		    });
		}
	</script>