<div class="box box-color box-bordered">
    <div class="box-title">
		<h3>
			<i class="icon-table"></i>
		     เอกสารอนุมัติแต่ยังไม่เบิกจ่าย
		</h3>
	</div>
	<div class="box-content nopadding">
		<table id="dg" class="easyui-datagrid" 
                    toolbar="#toolbar"
					url="<?php echo base_url(); ?>report_approve/get_nopayment"
		            rownumbers="true" fitColumns="true" singleSelect="true" pagination="true" pageSize="20">
				<thead>
					<tr>
						<th data-options="field:'doc_number',width:60" sortable="true">เลขที่ มอ.</th>
						<th data-options="field:'file_number',width:30" sortable="true">ลำดับ</th>
                        <th data-options="field:'doc_date',width:55" sortable="true">วันที่</th>
						<th data-options="field:'subject',width:210" sortable="true">เรื่อง</th>
                        <th data-options="field:'costs',width:200" sortable="true">ชื่อค่าใช้จ่าย</th>
                        <th data-options="field:'status',width:70" formatter="formatColor" sortable="true">สถานะ</th>
						<th data-options="field:'real_amount',width:100,align:'right'" formatter="formatPrice" sortable="true">จำนวนเงินอนุมัติและคงเหลือ</th>
					</tr>
				</thead>	
			</table>
            <div id="toolbar">  
		    <a href="#" class="easyui-linkbutton" iconCls="icons-search" plain="true" onclick="show()">ดูรายละเอียด</a>  
		    </div>
  </div>    
  <div><br />สถานะ: <span style="color:black;"><b>สีดำ</b></span> = ยังไม่เบิกจ่าย, <span style="color:blue;"><b>สีน้ำเงิน</b></span> = เบิกจ่ายบางส่วน</div>	  </div>
      
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
			<button type="button" class="btn btn-primary" style="width:100px" onclick="disbursement()">เบิกจ่าย</button>
            <button type="button" class="btn btn-info" onclick="javascript:$('#dlg').dialog('close')">ยกเลิก</button>
		    </div>
		</div>
   </div>
</div>

</div>		    

<script type="text/javascript">
    var base_url = '<?php echo base_url(); ?>';
    
    $('#dg').datagrid({
	    onDblClickRow: function(rowIndex, rowData){
		     getdetail(rowData.id);
	    }
    });
    
    function show(){
			var row = $('#dg').datagrid('getSelected');
            getdetail(row.id);
    }
    
    function getdetail(approve_id){
                $('#dlg').dialog('open').dialog('setTitle', 'รายละเอียด');
                
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
</script>