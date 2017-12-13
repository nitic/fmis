
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
			เอกสารอนุมัติเบิกจ่ายแล้ว 
		</h3>
	</div>
	<div class="box-content nopadding">
		<table id="dg" class="easyui-datagrid" 
					url="<?php echo base_url(); ?>report_approve/get_paymented"
                    toolbar="#toolbar"
		            rownumbers="true" fitColumns="true" singleSelect="true" pagination="true" pageSize="20">
				<thead>
					<tr>
						<th data-options="field:'doc_number',width:60" sortable="true">เลขที่ มอ.</th>
						<th data-options="field:'file_number',width:30" sortable="true">ลำดับ</th>
                        <th data-options="field:'doc_date',width:55" sortable="true">วันที่</th>
						<th data-options="field:'subject',width:230" sortable="true">เรื่อง</th>
                        <th data-options="field:'costs',width:180" sortable="true">ชื่อค่าใช้จ่าย</th>
                        <th data-options="field:'status',width:80" formatter="formatColor" sortable="true">สถานะ</th>
						<th data-options="field:'amount',width:80,align:'right'" formatter="formatCurrency" sortable="true">จำนวนเงินอนุมัติ</th>
                        <th data-options="field:'balance',width:80,align:'right'" formatter="formatPrice" sortable="true">จำนวนเงินคงเหลือ</th>
					</tr>
				</thead>	
			</table>
             <div id="toolbar">  
		    <a href="#" class="easyui-linkbutton" iconCls="icons-search" plain="true" onclick="show()">ดูรายละเอียด</a>  
		    </div>
	  </div>
      <div><br />สถานะ: <span style="color:green;"><b>สีเขียว</b></span> = เบิกจ่ายเสร็จสิ้นเต็มวงเงิน, <span style="color:#FFBF00;"><b>(สีเหลือง)</b></span> = เบิกจ่ายเสร็จสิ้นไม่เต็มวงเงินมีเงินเหลือ,
      <span style="color:blue;"><b>สีน้ำเงิน</b></span> = เบิกจ่ายบางส่วน </div>
      
  <div id="dlg" class="easyui-dialog" style="width:740px;height:430px;background-color:#eee"  
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
								<input type="text"  id="doc_number" name="doc_number"  style="font-size: 12px;width: 80px;">
				      		</td>
				      		<td>
				      			<label class="control-label" style="width: 70px;">ลำดับที่แฟ้ม</label>
								<input type="text" id="file_number" name="file_number" class="input-mini" style="font-size: 12px;">
				      		</td>
				      		<td>
				      		     <label class="control-label" style="width: 80px;">คณะ</label>
                                 <input type="text"  id="ccfaculty" name="ccfaculty"  style="font-size: 12px;width: 180px;">  
				      		</td>
				      	</tr>
				      	<tr>
				      	     <td colspan="2">
 				      	     	<label class="control-label" style="width: 64px;">วันที่</label>
                                 <input type="text"  id="doc_date" name="doc_date"  style="font-size: 12px;width: 90px;">
				      	     </td>
					     <td colspan="2">
 				      	     	  <label class="control-label" style="width: 80px;">ภาควิชา</label>
                                  <input type="text"  id="ccdepartment" name="ccdepartment"  style="font-size: 12px;width: 180px;">   
				      	     </td>	
				      	</tr>
				      	<tr>
				      	   <td colspan="2">
 				      	     	  <label class="control-label" style="width: 64px;">เรื่อง</label>
				      	     	  <input type="text" id="subject" name="subject" style="font-size: 12px;width:280px;">
							    
				      	     </td>
                            <td colspan="2">
 				      	     	  <label class="control-label" style="width: 80px;">หน่วยงาน</label>
                                 <input type="text"  id="ccdivision" name="ccdivision"  style="font-size: 12px;width: 180px;">     
							    
				      	     </td>
				      	</tr>
                        <tr>
				     			<td colspan="3">
				     				<label class="control-label" style="width: 64px;">รายละเอียด</label>
								<textarea id="detail" name="detail" rows="2" style="font-size: 12px;width:500px;"></textarea>
								
				     			</td>
				     	</tr>
                        <tr>
                            <td colspan="2">
				     				<label class="control-label" style="width: 64px;">แผนงาน</label>
                                 <input type="text"  id="ccplans" name="ccplans"  style="font-size: 12px;width: 290px;">     
				     	     </td>
                               <td>
				     			<label class="control-label" style="width: 80px;">งบรายจ่าย</label>
                                <input type="text"  id="ccgroup" name="ccgroup"  style="font-size: 12px;width: 200px;">
				     	       </td>
                              
                        </tr> 
                        <tr>
                              <td colspan="2">
				     				<label class="control-label" style="width: 64px;">งาน</label>
                                    <input type="text"  id="ccproduct" name="ccproduct"  style="font-size: 12px;width: 290px;">
				     		   </td>
                                <td>
				     			<label class="control-label" style="width: 80px;">ประเภท</label>
                                <input type="text"  id="cctype" name="cctype"  style="font-size: 12px;width: 200px;">
				     	       </td>
                        </tr> 
                         <tr>
                              <td colspan="3">
                                <label class="control-label" style="width: 64px;">ค่าใช้จ่าย</label>	
                                 <input type="text"  id="cccosts" name="cccosts"  style="font-size: 12px;width: 450px;">
				     			</td>
                        </tr> 
                         
                        <tr>
				     		  <td colspan="2">
				     			  <label class="control-label" style="width: 65px;">วงเงินอนุมัติ</label>
				      	     	  <input type="text" id="amount" name="amount" style="width: 150px;font-size: 12px;"> บาท

				     		  </td>
				     	</tr>
                         
                        </tbody>
				     </table>

		    </fieldset>
		    <div id="dlg-buttons">
			<button type="button" id="btn_disbursement" class="btn btn-primary" style="width:100px" onclick="disbursement()">เบิกจ่าย</button>
            <button type="button" class="btn btn-info" onclick="javascript:$('#dlg').dialog('close')">ปิดหน้าต่าง</button>
		    </div>
		</div>
   </div>
</div>

</div>	
        
 <div id="dlg2" class="easyui-dialog" style="width:740px;height:400px;background-color:#eee"  
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
            <button type="button" class="btn btn-primary" onclick="javascript:$('#dlg2').dialog('close')">ปิดหน้าต่าง</button>
		    </div>
		</div>
   </div>
</div>

</div>			

<script src="<?php echo base_url('assets/jquery-easyui/extension/datagrid-detailview.js');?>"></script>
<script type="text/javascript">
    var base_url = '<?php echo base_url(); ?>';

    $('#dg').datagrid({
	    onDblClickRow: function(rowIndex, rowData){
		    get_approve_detail(rowData.id);
	    }
    });
    
     $('#dg2').datagrid({
	    onDblClickRow: function(rowIndex, rowData){
		    get_disbursement_detail(rowData.id);
	    }
    });
        
function show(){
			var row = $('#dg').datagrid('getSelected');
            get_approve_detail(row.id);
}

function get_approve_detail(approve_id){
        $('#dlg').dialog('open').dialog('setTitle', 'รายละเอียดเอกสารอนุมัติ');
        
        var jqsonurl = base_url +'report_approve/get_deatil/' + approve_id;
    	    $.getJSON(jqsonurl, function(data) {
                $.each(data, function(index, val) {
                     $('#doc_number').val(val.doc_number);
                     $('#file_number').val(val.file_number);
                     $('#doc_date').val(val.doc_date);
                     $('#ccfaculty').val(val.faculty);
                     $('#ccdepartment').val(val.department);
                     $('#ccdivision').val(val.division);
                     $('#subject').val(val.subject);
                     $('#detail').val(val.detail);   
                     $('#ccplans').val(val.plans);
                     $('#ccproduct').val( val.product);
                     $('#ccgroup').val(val.costs_group);
                     $('#cctype').val(val.costs_type);
                     $('#cccosts').val(val.costs_lists);
                     $('#amount').val(formatCurrency(val.amount,1));
                  
                     if(val.status_id == 2){
                        $('#btn_disbursement').show();
                     }
                     else{
                        $('#btn_disbursement').hide();
                     }
                     
                });
            });    
                    
}


function get_disbursement_detail(disbursement_id){
           $('#dlg2').dialog('open').dialog('setTitle', 'รายละเอียดการเบิกจ่าย');

           var jqsonurl = base_url +'report_approve/get_disbursement_deatil/' + disbursement_id;
	    	    $.getJSON(jqsonurl, function(data) {
	                $.each(data, function(index, val) {
                        
                         $('#paydoc_number').val(val.doc_number);
                         $('#pay_file_number').val(val.file_number);
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

function disbursement() {
            var row = $('#dg').datagrid('getSelected');
            if (row) {
                url = '<?php echo base_url(); ?>disbursement/form/' + row.id;
                window.location.href = url;
            }
}
function formatColor(val,row){
           
        if(row.status_id == 2){
            return '<span style="color:blue;">'+val+'</span>';
        }
        else{
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
   
   var url_data = base_url + 'report_approve/get_paymented/' + keyword;
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
		var  searchUrl = base_url + 'search/approve_docnumber_paymented/';
			
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
                    return '<div style="padding:2px"><table id="dg2" class="ddv"></table></div>';
                },
                onExpandRow: function(index,row){
                    var ddv = $(this).datagrid('getRowDetail',index).find('table.ddv');
                    ddv.datagrid({
                        url: base_url+'report_approve/get_disbursement_lists/'+row.id,
                        fitColumns:true,
                        singleSelect:true,
                        rownumbers:true,
                        showFooter:true,
                        loadMsg:'',
                        height:'auto',
                        columns:[[
                            {field:'doc_number',title:'เลขที่ มอ.',width:70},
                            {field:'file_number',title:'ลำดับแฟ้ม',width:50},
                            {field:'doc_date',title:'วันที่เบิกจ่าย',width:55},
                            {field:'plan_product',title:'แผนงาน / งาน',width:220},
                            {field:'costs',title:'งบรายจ่าย / ประเภทรายจ่าย / ชื่อรายจ่าย',width:280},
                            {field:'total_payment',title:'จำนวนเงินที่เบิกจ่าย',width:110,align:'right',formatter:formatCurrency}
                        ]],
                        onResize:function(){
                            $('#dg').datagrid('fixDetailRowHeight',index);
                        },
                        onLoadSuccess:function(){
                            setTimeout(function(){
                                $('#dg').datagrid('fixDetailRowHeight',index);
                            },0);
                        },
                        onClickRow: function(rowIndex, rowData){
                            get_disbursement_detail(rowData.id);
                        },
                    });
                    $('#dg').datagrid('fixDetailRowHeight',index);
                }
            });
        });
	

});

        
</script>
