<div class="box box-color box-bordered">
    <div class="box-title">
		<h3>
			<i class="icon-table"></i>
			แหล่งงบประมาณหลัก
		</h3>
	</div>
    <div class="box-content nopadding">
		<table id="dg" class="easyui-datagrid" style="width:auto;height:auto"
			url="<?php echo base_url(); ?>budget_main/get"
			toolbar="#toolbar"  
            rownumbers="true" fitColumns="true" singleSelect="true" pagination="true" >
			<thead>
				<tr>
					<th data-options="field:'title',width:180">แหล่งเงิน</th>
					<th data-options="field:'year',width:150" sortable="true">ปีงบประมาณ</th>
					<th data-options="field:'start_date',width:150">วันเริ่มใช้</th>
					<th data-options="field:'end_date',width:150">วันสิ้นสุด</th>
					<th data-options="field:'amount',width:120,align:'right'" formatter="formatCurrency" sortable="true">จำนวนเงิน</th>
					<th data-options="field:'status',width:200" sortable="true">สถานะ</th>
				</tr>
			</thead>	
	   </table>
	   <?php if($this->session->userdata('Role') == 'Administrator' || $this->session->userdata('Role') == 'Planners'): ?>
		<div id="toolbar">  
	    <a href="#" class="easyui-linkbutton" iconCls="icons-add" plain="true" onclick="add()">เพิ่ม</a>  
	    <a href="#" class="easyui-linkbutton" iconCls="icons-edit" plain="true" onclick="edit()">แก้ไข</a>  
	    <a href="#" class="easyui-linkbutton" iconCls="icons-remove" plain="true" onclick="del()">ลบ</a>  
	    </div>
	    <?php endif; ?>
    </div>
</div>

<div id="dlg" class="easyui-dialog" style="width:600px;height:500px;padding:10px 20px"  
        closed="true" buttons="#dlg-buttons">   
    
    <div class="box-title">
		<h3><i class="icon-edit"></i> ข้อมูลแหล่งเงินงบประมาณ</h3>
	</div>
	<div class="box-content nopadding">
    <form id="fm" method="post" class='form-horizontal form-bordered'> 
    	    <div class="control-group">
			  <label for="title" class="control-label">ชื่อรายการ</label>
				<div class="controls">
					<input id="cc" name="title" required="true" class="easyui-combobox" style="height:30px;"  
                           data-options="url:'<?php echo base_url(); ?>budget/combobox',
                    	   valueField:'id',
                           textField:'title',
                           panelHeight:'auto'
                           ">  
				</div>
			</div>
    	    <div class="control-group">
			  <label for="year" class="control-label">ปีงบประมาณ</label>
				<div class="controls">
					<input type="text" name="year" class="easyui-numberbox input-small" required="true">
				</div>
			</div>
			<div class="control-group">
			  <label for="start_date" class="control-label">วันเริ่มต้น</label>
				<div class="controls">
					<input name="start_date" class="easyui-datebox" style="height:30px;" data-options="formatter:myformatter,parser:myparser" >
				</div>
			</div>
    	   <div class="control-group">
			  <label for="end_date" class="control-label">วันสิ้นสุด</label>
				<div class="controls">
					<input name="end_date" class="easyui-datebox" style="height:30px;" data-options="formatter:myformatter,parser:myparser">
				</div>
			</div>
			<div class="control-group">
			  <label for="amount" class="control-label">จำนวนเงิน</label>
				<div class="controls">
					<input type="text" name="amount" class="easyui-numberbox" data-options="precision:2,groupSeparator:','">
				</div>
			</div>
			<div class="control-group">
			  <label for="status" class="control-label">สถานะ</label>
				<div class="controls">
					<input id="cca" name="status" class="easyui-combobox" style="height:30px;"   
                           data-options="url:'<?php echo base_url(); ?>budget_status/combobox',
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
	url = '<?php echo base_url(); ?>budget_main/add';
}

function edit(){
	var row = $('#dg').datagrid('getSelected');
	if (row){
		$('#dlg').dialog('open').dialog('setTitle','แก้ไขข้อมูล');
		$('#fm').form('load',row);
		url = '<?php echo base_url(); ?>budget_main/update/'+row.id;
		
		$('#cc').combobox('select',row.budget_id); //select combobox
		$('#cca').combobox('select',row.status_id); 
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
				location.reload();
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
		$.messager.confirm('ยืนยัน','คุณต้องการลบข้อมูลที่ถูกเลือก ใช่หรือไม่?',function(r){
			if (r){
				$.post('<?php echo base_url(); ?>budget_main/delete',{id:row.id},function(result){
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