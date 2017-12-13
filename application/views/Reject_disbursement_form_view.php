<div class="container-fluid">       
  <div class="row-fluid">
		<form id="fm" class="form-horizontal ">
	        <fieldset style="padding-top: 0">
		         <legend style="font-size: 11pt">ข้อมูลเอกสารอนุมัติส่งเบิก</legend>
		         
		              <input type="hidden" id="id" name="id">
				      <table border="0"  class="table-form span12">
				      	<tbody>
				      	<tr>
				      		   <td colspan="2">
                                   <table>
                                   	<tr>
                                         <td>
										    <label class="control-label" style="width: 80px;">เลขที่อนุมัติ</label>
											<input type="text" name="doc_number" class="input-medium" disabled="disabled">
							      		</td>
							      		<td>
							      			<label class="control-label" style="width: 80px;">ลำดับที่แฟ้ม</label>
											<input type="text" name="file_number" class="input-mini" disabled="disabled">
							      		</td>
							      		<td>
										    <label class="control-label" style="width: 80px;">วันที่อนุมัติ</label>
											<input type="text" name="doc_date" class="input-medium" disabled="disabled">
							      		</td>
                                    </tr>
                                    </table>
                                </td>
				      	</tr>
				      	<tr>
				      	  <td colspan="2">
                                   <table>
                                   	<tr>
							      		<td>
			 				      	     	  <label class="control-label" style="width: 80px;">คณะ</label>
							      	     	  <input type="text" name="faculty" class="input-medium" disabled="disabled">
							      	     </td>
							      	      <td>
										    <label class="control-label" style="width: 80px;">ภาควิชา</label>
				      	                    <input type="text" name="department" class="input-medium" disabled="disabled">
							      		</td>
							      		<td>
			 				      	     	    <label class="control-label" style="width: 80px;">หน่วยงาน</label>
							                    <input type="text" name="division" class="input-medium" disabled="disabled">
							      	     </td>
                                    </tr>
                                    </table>
                                </td>
				      	</tr>
				      	 <tr>
				      	     <td colspan="2">
 				      	     	  <label class="control-label" style="width: 80px;">เรื่อง</label>
				      	     	  <input type="text" name="subject" class="input-xxlarge" disabled="disabled">
				      	     </td>
				      	   </tr>
				      	  <tr>
				     			<td>
				     				<label class="control-label" style="width: 80px;">แผนงาน</label>
				     				<input type="text" name="plans" class="input-xlarge" disabled="disabled">
				     			</td>
				     			<td>
				     				<label class="control-label" style="width: 120px;">หมวด</label>
				     				<input type="text" name="costs_group" class="input-xlarge" disabled="disabled">
				     			</td>
				     		</tr>
				     		<tr>
				     			<td>
				     				<label class="control-label" style="width: 80px;">ผลผลิต</label>
				     				<input type="text" name="product" class="input-xlarge" disabled="disabled">
				     			</td>
				     			<td>
				     				<label class="control-label" style="width: 120px;">ประเภท</label>
				     				<input type="text" name="costs_type" class="input-xlarge" disabled="disabled">
				     			</td>
				     		</tr>
				     		<tr>
				     			<td>
				     				<label class="control-label" style="width: 80px;">โครงการ</label>
				     				<input type="text" name="project" class="input-xlarge" disabled="disabled">
				     			</td>
				     			<td>
				     				<label class="control-label" style="width: 120px;">รายการ</label>
				     				<input type="text" name="costs_lists" class="input-xlarge" disabled="disabled">
				     			</td>
				     		</tr>
				     		<tr>
				     			<td>
				     				<label class="control-label" style="width: 80px;">กิจกรรม</label>
				     				<input type="text" name="activity" class="input-xlarge" disabled="disabled">
				     			</td>
				     			<td>
				     				<label class="control-label" style="width: 120px;">รายการย่อย</label>
				     				<input type="text" name="costs_sublist" class="input-xlarge" disabled="disabled">
				     			</td>
				     		</tr>
				     		<tr>
				     			<td colspan="2">
				     				<label class="control-label" style="width: 80px;">รายละเอียด</label>
									<textarea name="detail" class="input-xxlarge" rows="3" disabled="disabled"></textarea>
				     			</td>
				     		</tr>
				     		<tr>
				     			<td>
				     				<label class="control-label" style="width: 80px;">วงเงินอนุมัติ</label>
						            <input type="text" id="amount" name="amount" class="input-medium" disabled="disabled"> บาท
				     			</td>
				     			<td>
				     				<label class="control-label" style="width: 120px;">แหล่งเงิน</label>
						            <input type="text" name="budget_amount" class="input-xlarge" disabled="disabled"> บาท
				     			</td>
				     		</tr>
                        </tbody>
				     </table>

		
						<legend style="font-size: 11pt">ข้อมูลเบิกจ่าย</legend>
						 <table id="pay-table" border="0"  class="table-form span12">
						 	<tbody>
                                <tr>
                                 <td colspan="2">
                                  <table>
                                  		<tr>
                                          <td>
                                    		 <label class="control-label" style="width: 80px;">เลขที่เอกสาร</label>
						                         <input type="text" name="paydoc_number" class="input-medium" style="font-size: 12px">
                                    	  </td>
                                         <td>
				     			                  <label class="control-label" style="width: 90px;">ลำดับที่แฟ้ม</label>
							                      <input type="text" name="payfile_number" class="input-mini" style="font-size: 12px">
				     			          </td>
                                   </tr>
                                  	<tr>
                                          <td>
                                    		 <label class="control-label" style="width: 80px;">วันที่เบิกจ่าย</label>
						                         <input name="pay_date" class="easyui-datebox" style="height:30px;width: 150px;" data-options="formatter:myformatter,parser:myparser" required="true">
                                    	  </td>
                                         <td>
				     			                 <label class="control-label" style="width: 160px;">เลขที่ใบส่งของ / ใบเสร็จ</label>
							                     <input type="text" name="invoice_number" class="input-large" style="font-size: 12px">
				     			          </td>
                                   </tr>
                                   </table>
                                  </td>
                                 <td rowspan="2" style="width:200px;border:1px solid #ccc;text-align: right;padding:5px;">
						 				
						      		       	 <div>
						      		       	  <label>รวมเป็นเงิน</label>
						      		       	    <input type="text" id="total_amount" name="total_amount" class="input-medium" style="text-align:right;" readonly= "readonly"> บาท
											 </div>
											 <div style="margin-top:5px">
											  <label>ยอดเงินคงเหลือ</label>
											     <input type="text" id="total_balance" name="total_balance" class="input-medium" style="text-align:right;" disabled="disabled"> บาท
											</div>
						 		</td>
                 
                         </tr>
                          <tr>
				     			<td colspan="2">
				     				<label class="control-label" style="width: 80px;">รายละเอียด</label>
									<textarea name="paydetail" class="input-xxlarge" rows="5"></textarea>
								
				     			</td>
				     		</tr>
						 	<tr>
						 			<td>
						 			   <input type="hidden" name="payerid[1]">	
						 			   <label class="control-label" style="width: 80px;">ผู้รับเงิน 1</label>
					                   <input id="ccpayer1" name="ccpayer[1]" class="easyui-combobox" style="height:30px;" required="true"
		                                 data-options="url:'<?php echo base_url(); ?>payer/combobox',
		            	                  valueField:'payer_code',
		                                  textField:'name',
		                                  groupField:'type',
		                                  panelHeight:'auto'
		                                 ">
						 			</td>
						 			<td>
						 				<label class="control-label" style="width: 40px;">จำนวน</label>
						 				<input type="text" name="sum[1]" onkeyup="plus()"  class="input-medium" style="text-align:right;" required="true"> บาท
						 			</td>
						 			
						 	</tr>
						 	</tbody>
						 </table>
                         <button class="btn" type="button" onclick="add_pay();"><i class="icon-plus"></i></button>
		    </fieldset>
		   
		    <div id="dlg-buttons" class="form-actions">
			<button type="button" class="btn btn-primary" onclick="save()">Save changes</button>
			<button id="cancelButton" type="button" class="btn" onclick="window.history.back()">Cancel</button>
		    </div>
		    
		</form>
   </div>
</div>

<script type="text/javascript">
   var base_url = '<?php echo base_url(); ?>';
   var approve_id = <?php echo $app_id; ?>;
   var disbursement_id = <?php echo $dis_id; ?>;
   var num = 1;
   var url;
   
function add_pay(){

	num = num + 1;
    var html = '<tr id="tr'+num+'"><td><input type="hidden" name="payerid['+num+']"><label class="control-label" style="width: 80px;">ผู้รับเงิน '+num+'</label><input id="ccpayer'+num+'" name="ccpayer['+num+']" class="easyui-combobox" style="height:30px;" required="true"></td><td><label class="control-label" style="width: 40px;">จำนวน </label><input type="text" name="sum['+num+']" onkeyup="plus()" class="input-medium" style="text-align:right;" required="true"> บาท &nbsp; <button class="btn" type="button" onclick="delete_pay()"><i class="icon-remove"></i></button></td></tr>'
    $('#pay-table').append(html);
  
    var ccurl = base_url + 'payer/combobox';
    $("input[name^='ccpayer']").combobox({
	    url: ccurl,
	    valueField:'payer_code',
	    textField:'name',
	    groupField:'type',
		panelHeight:'auto'
    });
    
}

function delete_pay(){
	var oldsum = parseFloat($("input[name='sum["+num+"]']").val().replace(/[,]/g,''));
	
	var amount = parseFloat($('#total_amount').val().replace(/[,]/g,''));
	var balance = parseFloat($('#total_balance').val().replace(/[,]/g,''));
	
	if(oldsum){
	$('#total_amount').val(amount - oldsum);
	$('#total_balance').val(balance + oldsum);
	}
	
	if($("input[name='payerid["+num+"]']").val()){
		var rowid = $("input[name='payerid["+num+"]']").val();
			if (rowid){
				console.log(rowid);
				$.messager.confirm('ยืนยัน','คุณแน่ใจหรือว่าต้องการลบข้อมูลรายการนี้?',function(r){
					if (r){
						$.post('<?php echo base_url(); ?>payment/delete_by/'+rowid,function(result){
							if (result.success){
								$("#tr"+num).remove();
								num = num - 1;
								 $('#cancelButton').attr("disabled", true);
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
	else{
		$("#tr"+num).remove();
		num = num - 1;
	}
}

function plus(){
	var balance = parseFloat($('#amount').val().replace(/[,]/g,''));
	$("input[name^='sum']").sum({
	  bind: "keyup"
	, selector: "#total_amount"
	, oncalc: function (value, settings){
		// you can use this callback to format values
		
		var e=window.event?window.event:event;
        var keyCode=e.keyCode?e.keyCode:e.which?e.which:e.charCode;
		
		//0-9 (numpad,keyboard)
		if ((keyCode>=96 && keyCode<=105)||(keyCode>=48 && keyCode<=57)){
			if(value <= balance){
			    $('#total_balance').val(balance - value);
			    return true;
			 }
		}
		//backspace,delete,left,right,home,end
	   if (',8,46,37,39,36,35,110,190,'.indexOf(','+keyCode+',')!=-1){
	      $('#total_balance').val(balance - value); return true;
	   }
		else  $(this).val(''); return false;
	}
	
   });
}


		
function save(){
			 if(disbursement_id > 0){
			    url = base_url + 'disbursement/update/'+disbursement_id;
			 }else if(disbursement_id == 0){
				url = base_url + 'disbursement/add';
			 }

			$('#fm').form('submit',{
				url: url,
				onSubmit: function(){
					return $(this).form('validate');
				},
				success: function(result){
					var result = eval('('+result+')');
					if (result.success){
			            window.location.href = base_url+'disbursement/';
					} else {
						alert(result.msg);
					}
				}
			});
}

$(document).ready(function() {
	
var jqsonurl = base_url +'approve/get_detail/'+ approve_id;

	$.getJSON(jqsonurl, function(data) {
        $.each(data, function(index, val) {
        
           $('#fm').form('load',val);
           $("input[name='paydoc_number']").val(val.doc_number);
           $("input[name='payfile_number']").val(val.file_number);
           $('#total_balance').val(val.amount);
        });
    });
    
    
    // Case: updata Disbursement and payment data
    
    if(disbursement_id > 0)
    {
    	var jqsonurl = base_url +'disbursement/get_by/' + disbursement_id;
	    	$.getJSON(jqsonurl, function(data) {
	        $.each(data, function(index, val) {
	        
	           $('#fm').form('load',{
	           	paydoc_number:val.doc_number,
	           	payfile_number:val.file_number,
	           	pay_date:formatThaiDate(val.doc_date),
	           	invoice_number:val.invoice_number,
	           	paydetail:val.detail,
	           	total_amount:val.total_amount
	           	});
	          
	        });
	    });
	    
	    
	    var jqsonurl = base_url +'payment/get_by/' + disbursement_id;
	    	$.getJSON(jqsonurl, function(data) {
	    	
	    	var count = data.length;
	        $.each(data, function(index, val) {
	              if(count == data.length){
	              		$("input[name='payerid[1]']").val(val.id);
	              		$("#ccpayer1").combobox('select',val.payer_code);
	              		$("input[name='sum[1]']").val(val.amount);
	              		count--;
	              }
	              else{
	              		add_pay();
	              		$("input[name='payerid["+num+"]']").val(val.id);
	              		$("#ccpayer"+num).combobox('select',val.payer_code);
	              		$("input[name='sum["+num+"]']").val(val.amount);
	              		count--;
	              }

	        });
	    });
    }
    
});
	
</script>
