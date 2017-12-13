<div class="box box-color box-bordered">
    <div class="box-title">
		<h3>
			<i class="icon-table"></i>
			รายชื่อผู้รับเงิน
		</h3>
	</div>
	<div class="box-content nopadding">
		<table id="dg" class="easyui-datagrid" 
					url="<?php echo base_url(); ?>payer/get"
					toolbar="#toolbar"  
		            rownumbers="true" fitColumns="true" singleSelect="true" pagination="true" >
				<thead>
					<tr>
						<th data-options="field:'payer_code',width:80">รหัส</th>
						<th data-options="field:'ordering',width:50">ลำดับ</th>
						<th data-options="field:'name',width:200">ชื่อผู้รับเงิน</th>
						<th data-options="field:'type',width:400">ประเภท</th>
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


<div id="dlg" class="easyui-dialog" style="width:500px;height:350px;padding:5px 10px"  
        closed="true" buttons="#dlg-buttons">  
   
	<div class="box-title">
		<h3><i class="icon-edit"></i> ข้อมูลผู้รับเงิน</h3>
	</div>
	<div class="box-content nopadding">
	    <form id="fm" method="post" class='form-horizontal form-bordered'> 
	    	<div class="control-group">
			  <label for="code" class="control-label">ประเภท</label>
				<div class="controls">
					<input id="cctype" name="cctype" class="easyui-combobox" style="height:30px;" required="true"  data-options="
							valueField: 'id',
							textField: 'value',
							panelHeight:'60',
							data: [{
								id: 'บุคคลธรรมดา',
								value: 'บุคคลธรรมดา'
							},{
								id: 'นิติบุคคล',
								value: 'นิติบุคคล'
							}],
							onSelect: function(rec){
					            if(rec.id == 'บุคคลธรรมดา')
					              var url = '<?php echo base_url(); ?>personnel/combobox';
                                else
                                  var url = '<?php echo base_url(); ?>company/combobox';
                                  
                                $('#ccpayer').combobox('clear').combobox('reload', url);
					        }
						"/>
      
				</div>
			</div>
			<div class="control-group">
			  <label for="name" class="control-label">ชื่อผู้รับเงิน</label>
				<div class="controls">
					<input id="ccpayer" name="ccpayer" class="easyui-combobox" style="height:30px;" required="true" 
				     data-options="valueField:'name',
				     textField:'name',
				     panelHeight:'150',
				     onSelect: function(row){
				     	$('#payer_code').val(row.code);
				     }
				     
				     "/>
				</div>
			</div>
			<div class="control-group">
			  <label for="code" class="control-label">ลำดับที่</label>
				<div class="controls">
					<input type="text" name="ordering" class="easyui-numberbox input-small">
				</div>
			</div>
			<input type="hidden" id="payer_code" name="payer_code">
			
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
			url = '<?php echo base_url(); ?>payer/add';
		}
		function edit(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','แก้ไขข้อมูล');
				$('#fm').form('load',row);
				url = '<?php echo base_url(); ?>payer/update/'+row.id;
				
				$('#cctype').combobox('select',row.type);
				//alert(row.type);
				$('#ccpayer').combobox('select',row.name); //select combobox
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
						$.post('<?php echo base_url(); ?>payer/delete',{id:row.id},function(result){
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
