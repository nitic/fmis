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
			รายการเอกสารเบิกจ่าย
		</h3>
	</div>
	<div class="box-content nopadding">
		<table id="dg" class="easyui-datagrid"
					url="<?php echo base_url(); ?>disbursement/get"
					toolbar="#toolbar"  
		            rownumbers="true" fitColumns="true" singleSelect="true" pagination="true" pageSize="20">
				<thead>
					<tr>
                        <th data-options="field:'doc_number',width:90" sortable="true">เลขที่ มอ.</th>
                        <th data-options="field:'file_number',width:45" sortable="true">ลำดับ</th>
						<th data-options="field:'doc_date',width:80" sortable="true" formatter="formatThaiDate">วันที่เบิกจ่าย</th>	
                        <th data-options="field:'plan',width:170" sortable="true">แผนงาน</th>
                        <th data-options="field:'product',width:140" sortable="true">งาน</th>
						<th data-options="field:'costs',width:90" sortable="true">งบรายจ่าย</th>
						<th data-options="field:'coststype',width:90" sortable="true">ประเภท</th>
						<th data-options="field:'costsname',width:300" sortable="true">รายการจ่าย</th>
						<th data-options="field:'total_amount',width:120,align:'right'" formatter="formatCurrency" sortable="true">จำนวนเงิน</th>
					</tr>
				</thead>	
			</table>
			<?php if($this->session->userdata('Role') == 'Administrator' || $this->session->userdata('Role') == 'Finance'): ?>
			<div id="toolbar">
             <a href="#" class="easyui-linkbutton" iconCls="icons-add" plain="true" onclick="add()">เพิ่ม</a>
		     <a href="#" class="easyui-linkbutton" iconCls="icons-edit" plain="true" onclick="edit()">แก้ไข</a>  
		     <a href="#" class="easyui-linkbutton" iconCls="icons-remove" plain="true" onclick="del()">ลบ</a>  
             <a href="#" class="easyui-linkbutton" iconCls="icons-search" plain="true" onclick="show()">ดูรายละเอียด</a> 
		    </div>
		    <?php endif; ?>
	  </div>
</div>		    

 <div id="dlg" class="easyui-dialog" style="width:740px;height:400px;background-color:#eee"  
        closed="true" buttons="#dlg-buttons">  
  <div class="container-fluid">       
  <div class="row-fluid">
        <div class="form-horizontal">
	        <fieldset style="padding-top: 0">
                    
				      <table border="0"  class="table-form span12" style="background-color:#eee">
				      	<tbody>
				      	<tr>
				      		<td>
							    <label class="control-label" style="width: 64px;">เลขที่ มอ.</label>
								<input type="text"  id="paydoc_number" name="paydoc_number"  style="font-size: 12px;width: 80px;">
				      		</td>
				      		<td>
				      			<label class="control-label" style="width: 70px;">ลำดับที่แฟ้ม</label>
								<input type="text" id="pay_file_number" name="pay_file_number" class="input-mini" style="font-size: 12px;">
				      		</td>
                             <td style="text-align: right;">
				      			<label class="control-label" style="width: 170px;text-align: right;color:red">เอกสารอนุมัติเลขที่</label>
								<input type="text" id="approve_document_number" name="approve_document_number" style="font-size: 12px;width: 115px;color:red;background-color:#eee">
				      		</td>
				      	</tr>
				      	<tr>
				      	     <td>
 				      	     	<label class="control-label" style="width: 64px;">วันที่</label>
                                 <input type="text"  id="pay_date" name="pay_date"  style="font-size: 12px;width: 90px;">
				      	     </td>
                             <td colspan="3">
				      		     <label class="control-label" style="width: 128px;">เลขที่ใบส่งของ/ใบเสร็จ</label>
                                 <input type="text"  id="invoice_number" name="invoice_number"  style="font-size: 12px;width: 180px;">  
				      		</td>
				      	</tr>
                        <tr>
                            <td colspan="2">
				     				<label class="control-label" style="width: 64px;">แผนงาน</label>
                                 <input type="text"  id="pay_plans" name="pay_plans"  style="font-size: 12px;width: 290px;">     
				     	     </td>
                               <td>
				     			<label class="control-label" style="width: 80px;">งบรายจ่าย</label>
                                <input type="text"  id="pay_costs_group" name="pay_costs_group"  style="font-size: 12px;width: 200px;">
				     	       </td>
                              
                        </tr> 
                        <tr>
                              <td colspan="2">
				     				<label class="control-label" style="width: 64px;">งาน</label>
                                    <input type="text"  id="pay_product" name="pay_product"  style="font-size: 12px;width: 290px;">
				     		   </td>
                                <td>
				     			<label class="control-label" style="width: 80px;">ประเภท</label>
                                <input type="text"  id="pay_type" name="pay_type"  style="font-size: 12px;width: 200px;">
				     	       </td>
                        </tr> 
                         <tr>
                              <td colspan="3">
                                <label class="control-label" style="width: 64px;">ค่าใช้จ่าย</label>	
                                 <input type="text"  id="pay_lists" name="pay_lists"  style="font-size: 12px;width: 450px;">
				     			</td>
                        </tr> 
                         <tr>
				     			<td colspan="3">
				     				<label class="control-label" style="width: 64px;">ผู้รับเงิน</label>
								<textarea id="payer" name="payer" rows="2" style="font-size: 12px;width:500px;"></textarea>
								
				     			</td>
				     	</tr> 
                        <tr>
				     		  <td colspan="2">
				     			  <label class="control-label" style="width: 65px;">วงเงินอนุมัติ</label>
				      	     	  <input type="text" id="total_amount" name="total_amount" style="width: 150px;font-size: 12px;"> บาท
				     		  </td>
				     	</tr>
                         
                        </tbody>
				     </table>

		    </fieldset>
		    <div id="dlg-buttons">
            <button type="button" class="btn btn-primary" onclick="javascript:$('#dlg').dialog('close')">ปิดหน้าต่าง</button>
		    </div>
		</div>
   </div>
</div>
</div>	


<script src="<?php echo base_url('assets/jquery-easyui/extension/datagrid-detailview.js');?>"></script>
<script type="text/javascript">
	    var base_url = '<?php echo base_url(); ?>';
		var url;
        
        $('#dg').datagrid({
	        onDblClickRow: function(rowIndex, rowData){
		        get_disbursement_detail(rowData.id);
	        }
       });
        
		function add(){
		    url = base_url + 'disbursement/form';
			window.location.href = url;
		}
		function edit(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				url = base_url+'disbursement/form/'+row.approve_id+'/'+row.id;
				window.location.href = url;
			}
		}
		function del(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$.messager.confirm('ยืนยัน','คุณแน่ใจหรือว่าต้องการลบข้อมูลรายการนี้?',function(r){
					if (r){
						$.post('<?php echo base_url(); ?>disbursement/delete',{id:row.id, app_id:row.approve_id},function(result){
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
        
       function show(){
			var row = $('#dg').datagrid('getSelected');
            get_disbursement_detail(row.id);
      }
      
      function get_disbursement_detail(disbursement_id){
           $('#dlg').dialog('open').dialog('setTitle', 'รายละเอียดการเบิกจ่าย');

           var jqsonurl = base_url +'report_approve/get_disbursement_deatil/' + disbursement_id;
	    	    $.getJSON(jqsonurl, function(data) {
	                $.each(data, function(index, val) {
                        
                         $('#paydoc_number').val(val.doc_number);
                         $('#pay_file_number').val(val.file_number);
                         $('#approve_document_number').val(val.approve_doc_number);
                         $('#pay_date').val(val.doc_date); 
                         $('#invoice_number').val(val.invoice_number);   
                         $('#pay_plans').val(val.plan);
                         $('#pay_product').val( val.product);
                         $('#pay_costs_group').val(val.costs_group);
                         $('#pay_type').val(val.costs_type);
                         $('#pay_lists').val(val.costs_lists);
                         $('#total_amount').val(formatCurrency(val.total_payment,1));
                         
                            var jqsonurl2 = base_url +'payment/get_detail/' + val.id;
                            var num = 1;
                            var text = "";
	    	                $.getJSON(jqsonurl2, function(data2) {
	                            $.each(data2, function(index, val2) {
                                   text += num + '. ' + val2.name + ' จำนวนเงิน ' + formatCurrency(val2.amount,1) + '\r\n';
                                   $('#payer').val(text);
                                   num++;
	                            });
                            });  
                         
	                });
                });  
      }


// Show search result 
function search_results(){

   var value = $('#show_arti_topic').val();
   var keyword = value.replace("/", "_");
   
   var url_data = base_url + 'disbursement/get/' + keyword;
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
		var  searchUrl = base_url + 'search/disbursement_docnumber/';
			
		return searchUrl +encodeURIComponent(keyword);
    });	
}	

// run Search Tools
make_autocom("show_arti_topic","h_arti_id");


$(document).ready(function() {
	 $(function(){
            $('#dg').datagrid({
                view: detailview,
                detailFormatter:function(index,row){
                    return '<div style="padding:2px"><table class="ddv"></table></div>';
                },
                onExpandRow: function(index,row){
                    var ddv = $(this).datagrid('getRowDetail',index).find('table.ddv');
                    ddv.datagrid({
                        url: base_url+'payment/get_detail/'+row.id,
                        fitColumns:true,
                        singleSelect:true,
                        rownumbers:true,
                        loadMsg:'',
                        height:'auto',
                        columns:[[
                            {field:'code',title:'รหัส',width:150},
                            {field:'name',title:'ชื่อผู้รับเงิน',width:200},
                            {field:'amount',title:'จำนวนเงิน',width:200,align:'right',formatter:formatCurrency}
                        ]],
                        onResize:function(){
                            $('#dg').datagrid('fixDetailRowHeight',index);
                        },
                        onLoadSuccess:function(){
                            setTimeout(function(){
                                $('#dg').datagrid('fixDetailRowHeight',index);
                            },0);
                        }
                    });
                    $('#dg').datagrid('fixDetailRowHeight',index);
                }
            });
        });
	
	
	
});

	</script>