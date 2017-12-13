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
		            rownumbers="true" fitColumns="true" singleSelect="true" pagination="true">
				<thead>
					<tr>
						<th data-options="field:'doc_number',width:120">เลขที่เอกสาร</th>
						<th data-options="field:'file_number',width:70" sortable="true">ลำดับแฟ้ม</th>
						<th data-options="field:'doc_date',width:100" sortable="true">วันที่อนุมัติ</th>
						<th data-options="field:'subject',width:300">เรื่อง</th>
						<th data-options="field:'department',width:200" sortable="true">ภาควิชา</th>
						<th data-options="field:'costs',width:120">ประเภทรายจ่าย</th>
						<th data-options="field:'costsgroup',width:220">หมวดรายจ่าย</th>
						<th data-options="field:'amount',width:150,align:'right'" formatter="formatCurrency" sortable="true">จำนวนเงิน</th>
					
					</tr>
				</thead>	
			</table>
			<div id="toolbar">  
		    <a href="#" class="easyui-linkbutton" iconCls="icons-add" plain="true" onclick="add()">เพิ่ม</a>
		    <a href="#" class="easyui-linkbutton" iconCls="icons-ok" plain="true" onclick="disbursement()">เบิกจ่าย</a>
		    <a href="#" class="easyui-linkbutton" iconCls="icons-edit" plain="true" onclick="edit()">แก้ไข</a>  
		    <a href="#" class="easyui-linkbutton" iconCls="icons-remove" plain="true" onclick="del()">ลบ</a> 
		    </div>
	  </div>
</div>		    



<script type="text/javascript">
	    var base_url = '<?php echo base_url(); ?>';
		var url;
		function add(){
			url = base_url+'approve/form';
			window.location.href = url;
		}
		function disbursement(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				url = '<?php echo base_url(); ?>disbursement/form/'+row.id;
				window.location.href = url;  
			}
		}
		
		function edit(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				url = '<?php echo base_url(); ?>approve/form/'+row.id;
				window.location.href = url;  
			}
		}
		
		function del(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
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
		}
		
	</script>