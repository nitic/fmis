<div id="dlg" class="easyui-dialog" style="width:740px;height:540px"  
        closed="true" buttons="#dlg-buttons">  

<div class="container-fluid">       
  <div class="row-fluid">
		<form id="fm_popup" method="post" class="form-horizontal ">
	        <fieldset style="padding-top: 0">
		         <legend style="font-size: 11pt">ข้อมูลเอกสารอนุมัติ</legend>
				      <table border="0"  class="table-form span12">
				      	<tbody>
				      	<tr>
				      		<td>
                              
							    <label class="control-label" style="width: 80px;">เลขที่เอกสาร</label>
								<input type="text" name="doc_number" class="easyui-validatebox" style="font-size: 12px;width: 120px;" required="true">
				      		</td>
				      		<td>
				      			<label class="control-label" style="width: 80px;">ลำดับที่แฟ้ม</label>
								<input type="text" name="file_number" class="input-mini" style="font-size: 12px">
				      		</td>
				      		<td>
				      		     <label class="control-label" style="width: 80px;">คณะ</label>
				      	     	  <input id="ccfaculty" name="ccfaculty" class="easyui-combobox" style="height:30px;width:200px;" 
				                           data-options="url:'<?php echo base_url(); ?>faculty/combobox',
				                    	   valueField:'code',
				                           textField:'name',
				                           panelHeight:'auto',
				                           onSelect: function(rec){
										        var url = '<?php echo base_url(); ?>department/get_by/'+rec.code;  
												$('#ccdepartment').combobox('clear');
					                            $('#ccdepartment').combobox('reload', url);        
									        }
				                           ">   
				      		</td>
				      	</tr>
				      	<tr>
				      	     <td colspan="2">
 				      	     	<label class="control-label" style="width: 80px;">วันที่</label>
						          <input name="doc_date" class="easyui-datebox" style="height:30px;width: 133px;" data-options="formatter:myformatter,parser:myparser" >
							    
				      	     </td>
					     <td colspan="2">
 				      	     	  <label class="control-label" style="width: 80px;">ภาควิชา</label>
				      	     	  <input id="ccdepartment" name="ccdepartment" class="easyui-combobox"
				     				       style="height:30px;width:200px;" 
				     				       data-options="valueField:'id',textField:'name',panelHeight:'auto',
				     				        onSelect: function(rec){
				     				          if(isset(rec)){	
										        var url = '<?php echo base_url(); ?>division/get_by/'+rec.id;  
												$('#ccdivision').combobox('clear');
					                            $('#ccdivision').combobox('reload', url);
				                              }
									       }
				     				       ">
							    
				      	     </td>	
				      	</tr>
				      	<tr>
				      	   <td colspan="2">
 				      	     	  <label class="control-label" style="width: 80px;">เรื่อง</label>
				      	     	  <input type="text" name="subject" style="font-size: 12px;width:280px;">
							    
				      	     </td>
                            <td colspan="2">
 				      	     	  <label class="control-label" style="width: 80px;">หน่วยงาน</label>
				      	     	   <input id="ccdivision" name="ccdivision" class="easyui-combobox" style="height:30px;width:200px;" 
				     				       data-options="valueField:'id',textField:'name',panelHeight:'auto'" />
							    
				      	     </td>
				      	</tr>
                        <tr>
				     			<td colspan="3">
				     				<label class="control-label" style="width: 80px;">รายละเอียด</label>
								<textarea name="detail" rows="2" style="font-size: 12px;width:565px;"></textarea>
								
				     			</td>
				     	</tr>
                        <tr>
                            <td colspan="2">
				     				<label class="control-label" style="width: 80px;">แผนงาน</label>
				     				<input id="ccplans_mgt" name="ccplans_mgt" class="easyui-combobox" style="height:30px;width:290px"  
				                           data-options="url:'<?php echo base_url(); ?>mgt_plans/get_by/<?php echo $this->session->userdata('budget_year_id'); ?>',
                                           valueField:'id',textField:'name',panelHeight:'auto',
				                           onSelect: function(rec){
				                           	   if(isset(rec)){
									             var ccurl = '<?php echo base_url(); ?>mgt_product/get_by/'+rec.id;  
											     $('#ccproduct_mgt').combobox('clear');
				                                 $('#ccproduct_mgt').combobox('reload', ccurl);
				                               }
									        }
				                           ">  
				     	     </td>
                               <td>
				     			<label class="control-label" style="width: 80px;">งบรายจ่าย</label>
				     			<input id="ccgroup_popup" name="ccgroup_popup" class="easyui-combobox" style="height:30px;width:200px;" 
				     		                data-options="url:'<?php echo base_url(); ?>costs_group/combobox2',
		            	                                  valueField:'id',
		                                                  textField:'name',
		                                                  groupField:'type',
		                                                  panelHeight:'auto',
		                                                  onSelect: function(rec){        
		                                  	                if(isset(rec)){                         
                                                             $('#txtcosts_popup').val(rec.costs_id);
                                             
                                                             var url = '<?php echo base_url(); ?>costs_type/get_by/'+rec.id;  
											                 $('#cctype_popup').combobox('clear');
				                                             $('#cctype_popup').combobox('reload', url);
				                                            }
										                 }
				     		                "/>
				                     <input type="hidden" id="txtcosts_popup" name="txtcosts_popup" />	
				     	       </td>
                              
                        </tr> 
                        <tr>
                              <td colspan="2">
				     				<label class="control-label" style="width: 80px;">งาน</label>
				     				<input id="ccproduct_mgt" name="ccproduct_mgt" class="easyui-combobox"
				     				       style="height:30px;width:290px;" 
				     				       data-options="valueField:'id',textField:'name',panelHeight:'auto'">
				     			</td>
                                <td>
				     			<label class="control-label" style="width: 80px;">ประเภท</label>
				     			<input id="cctype_popup" name="cctype_popup" class="easyui-combobox"
				     				       style="height:30px;width:200px;" 
				     				       data-options="valueField:'id',textField:'name',panelHeight:'auto',
				     				        onSelect: function(rec){
				     				         if(isset(rec) && !empty($('#ccproduct_mgt').combobox('getValue'))){	
										         var url = '<?php echo base_url(); ?>mgt_costs/get_by_cost/'+$('#ccproduct_mgt').combobox('getValue')
                                                            +'/'+$('#txtcosts_popup').val()
                                                            +'/'+$('#ccgroup_popup').combobox('getValue')
                                                            +'/'+rec.id;
												$('#cccosts').combobox('clear');
					                            $('#cccosts').combobox('reload', url);
					                           }
									       }
				     				       ">	
			                       
				     	        </td>
                        </tr> 
                         <tr>
                              <td colspan="3">
                                <label class="control-label" style="width: 80px;">รายการรายจ่าย</label>	
			                       <input id="cccosts" name="cccosts" class="easyui-combobox" style="height:30px;width:582px;" 
				     				    data-options="valueField:'id',textField:'name',panelHeight:'auto'" />

				     			</td>
                        </tr> 
                        <tr>
				     		  <td colspan="2">
				     			  <label class="control-label" style="width: 80px;">วงเงินอนุมัติ</label>
				      	     	  <input type="text" id="amount" name="amount" class="easyui-numberbox" data-options="min:0,precision:2" style="font-size: 12px;"> บาท

				     		  </td>
                              <td>
                           
				     			  <label class="checkbox"><input type="checkbox" name="checkbox">ไม่ระบุจำนวนเงินอนุมัติ</label>
				      	     	
				     		  </td>
				     	</tr>
                        <tr>
				     		  <td colspan="3">
				     			  <label class="control-label" style="width: 80px;">สถานะ</label>
				      	     	  <select class="easyui-combobox" id="status" name="status" data-options="panelHeight:100" style="height:30px;width:200px;">
                                    <option value="1">1 : ยังไม่เบิกจ่าย</option>
                                    <option value="2">2 : เบิกจ่ายบางส่วน</option>
                                    <option value="3">3 : เบิกจ่ายเสร็จสิ้น</option>
                                  </select>
				     		  </td>
				     	</tr>
                        </tbody>
				     </table>

		    </fieldset>
		   
		    <div id="dlg-buttons">
			<button type="button" class="btn btn-primary" onclick="save_new_document()">บันทึกข้อมูล</button>
			<button type="button" class="btn" onclick="javascript:$('#dlg').dialog('close')">ยกเลิก</button>
		    </div>
		    
		</form>
   </div>
</div>

</div>

<div id="dlg2" class="easyui-dialog" title="รายละเอียด" style="width:350px;height:350px"  
        closed="true" buttons="#dlg-buttons2">  

  <div class="container-fluid" id="table-check-modal" style="padding:10px">
      <table class="table-check" border="1">
      </table>  
  </div>
  <div id="dlg-buttons2">
  	<button type="button" class="btn btn-primary" onclick="select_approve_document()">ตกลง</button>
  </div>

</div>


<div class="container-fluid">       
  <div class="row-fluid">
		<form id="fm" class="form-horizontal ">
	        <fieldset style="padding-top: 0">
		         <legend style="font-size: 11pt">1.ตรวจสอบเอกสารอนุมัติส่งเบิก</legend>
		         
		           <input type="hidden" id="approveid" name="approveid">
               <input type="hidden" id="check_status" name="check_status">
               <input type="hidden" id="search_type_status" name="search_type_status" value="1">

                    <table border="0"  class="table-form span12">
                        <tr>
                            <td style="width:250px">
                                 <select class="easyui-combobox" id="searchtype" name="searchtype" data-options="panelHeight:100" style="height:30px;width:100px;">
                                     <option value="1">เอกสารเลขที่</option>
                                     <option value="2">ลำดับแฟ้ม</option>
                                  </select>
                                  <input type="hidden" name="url_search_type" id="url_search_type" value="<?php echo base_url()."search/approve_docnumber/"; ?>" />
                                   &nbsp;
                                  <input type="text" name="approve_doc_number" id="approve_doc_number"  style="width:120px; "/>
                                  <input type="hidden" name="autocomplete-ajax-x" id="autocomplete-ajax-x" value="" />                     
                                   
				      	    </td>
                            <td> 
                                 <a href="#" class="easyui-linkbutton" data-options="iconCls:'icons-search'" onclick="checking()">ตรวจสอบ</a>
				      	    </td>
                            <td> 
                                 <label class="control-label" style="width: 120px;">หรือ <a href="#" onclick="add()">เพิ่มเอกสารใหม่</a></label>
                                 
				      	    </td>
                        </tr>
                        <tr>
				     			<td colspan="3">
				     			<label class="control-label" style="width: 80px;">เรื่อง</label>
				     			<input type="text"  name="approve_subject" style="font-size: 12px;width:280px;" disabled="disabled">
			                       
				     	        </td>
                                
				     	</tr>
                        <tr>
				     		  <td colspan="3">
				     			  <label class="control-label" style="width: 80px;">วงเงินอนุมัติ</label>
				      	     	  <input type="text" name="approve_amount" style="font-size: 12px;width:120px;" disabled="disabled"> บาท
				     		  </td>
				     	</tr>
                        <tr>
				     		  <td colspan="3">
				     			  <label class="control-label" style="width: 80px;">สถานะ</label>
				      	     	  <input type="text" name="current_status" style="font-size: 12px;width:120px;" disabled="disabled">
				     		  </td>
				     	</tr>
                    </table>
            
		
						<legend style="font-size: 11pt">2.เพิ่มข้อมูลเบิกจ่าย  <span id="check-payment" style="color:red"></span></legend>
						 <table id="pay-table" border="0"  class="table-form span12">
						 	<tbody>
                                <tr>
                                 <td colspan="3">
                                  <table border="0">
                                  		<tr>
                                          <td>
                                    		 <label class="control-label" style="width: 80px;">เลขที่เอกสาร</label>
						                         <input type="text" name="paydoc_number" class="input-medium" style="font-size: 12px">
                                    	  </td>
                                         <td>
				     			                  <label class="control-label" style="width: 160px;">ลำดับที่แฟ้ม</label>
							                      <input type="text" name="payfile_number" class="input-mini" style="font-size: 12px">
				     			          </td>
                                   </tr>
                                  	<tr>
                                          <td>
                                    		 <label class="control-label" style="width: 80px;">วันที่เบิกจ่าย</label>
						                         <input name="pay_date" class="easyui-datebox" style="height:30px;width: 150px;" data-options="formatter:myformatter,parser:myparser">
                                    	  </td>
                                         <td>
				     			                 <label class="control-label" style="width: 160px;">เลขที่ใบส่งของ / ใบเสร็จ</label>
							                     <input type="text" name="invoice_number" style="width: 153px;" style="font-size: 12px">
				     			          </td>
                                   </tr>
                                   </table>
                                  </td>
                         </tr>
                         
                          <tr>
				     			<td>
				     				<label class="control-label" style="width: 80px;">แผนงาน</label>
				     				<input id="ccplans" name="ccplans" class="easyui-combobox" style="height:30px;width:245px" required="true"  
				                           data-options="url:'<?php echo base_url(); ?>mgt_plans/get_by/<?php echo $this->session->userdata('budget_year_id'); ?>',
                                           valueField:'id',textField:'name',panelHeight:'auto',
				                           onSelect: function(rec){
				                           	   if(isset(rec)){
									             var ccurl = '<?php echo base_url(); ?>mgt_product/get_by/'+rec.id;  
											     $('#ccproduct').combobox('clear');
				                                 $('#ccproduct').combobox('reload', ccurl);
				                               }
									        }
				                           ">  
				     			</td>
                                <td>
				     			  <!-- <label class="control-label" style="width: 80px;">วงเงิน</label>
				     			   <div id="myprogress1"></div>-->
				     				
				     			</td>
				     		</tr>
                            <tr>
				     			<td>
				     				<label class="control-label" style="width: 80px;">งาน</label>
				     				<input id="ccproduct" name="ccproduct" class="easyui-combobox" required="true" 
				     				       style="height:30px;width:245px;" 
                                           data-options="valueField:'id',textField:'name',panelHeight:'auto'">
				     			</td>
                                <td>
				     			  <!-- <label class="control-label" style="width: 80px;">วงเงิน</label>
				     			   <div id="myprogress2"></div>-->
				     				
				     			</td>
				     		</tr>
                            <tr>
				     			<td>
				     			<label class="control-label" style="width: 80px;">งบรายจ่าย</label>
				     			<input id="ccgroup" name="ccgroup" class="easyui-combobox" required="true" style="height:30px;width:245px;" 
				     		                data-options="url:'<?php echo base_url(); ?>costs_group/combobox2',
		            	                                  valueField:'id',
		                                                  textField:'name',
		                                                  groupField:'type',
		                                                  panelHeight:'auto',
		                                                  onSelect: function(rec){        
		                                  	                if(isset(rec)){                         
                                                             $('#txtcosts').val(rec.costs_id);
                                             
                                                             var url = '<?php echo base_url(); ?>costs_type/get_by/'+rec.id;  
											                 $('#cctype').combobox('clear');
				                                             $('#cctype').combobox('reload', url);
				                                            }
										                 }
				     		                "/>
				                     <input type="hidden" id="txtcosts" name="txtcosts" />	
				     	        </td>
                                <td>
				     			  <!-- <label class="control-label" style="width: 80px;">วงเงิน</label>
				     			   <div id="myprogress3"></div>-->
				     				
				     			</td>
				     		</tr>
                            <tr>
				     			<td>
				     			<label class="control-label" style="width: 80px;">ประเภท</label>
				     			<input id="cctype" name="cctype" class="easyui-combobox" required="true"
				     				       style="height:30px;width:245px;" 
				     				       data-options="valueField:'id',textField:'name',panelHeight:'auto',
				     				        onSelect: function(rec){
				     				         if(isset(rec)){	
										        var url = '<?php echo base_url(); ?>costs_lists/get_by/'+rec.id;  
												$('#cclists').combobox('clear');
					                            $('#cclists').combobox('reload', url);
					                           }
									       }
				     				       ">	
			                       
				     	        </td>
                                <td>
				     			  <!-- <label class="control-label" style="width: 80px;">วงเงิน</label>
				     			   <div id="myprogress5"></div>-->
				     				
				     			</td>
				     		</tr>
                            <tr>
				     			<td colspan="2">
				     			<label class="control-label" style="width: 80px;">รายการ</label>
				     			<input id="cclists" name="cclists" class="easyui-combobox" required="true"
				     				       style="height:30px;width:425px;" 
				     				       data-options="valueField:'id',textField:'name',panelHeight:'auto',
				     				        onSelect: function(rec){
				     				        if(isset(rec)){	
										        var url = '<?php echo base_url(); ?>costs_sublist/get_by/'+rec.id;  
												$('#ccsublist').combobox('clear');
					                            $('#ccsublist').combobox('reload', url);
					                         }
									       }
				     				       ">	
			                       
				     	        </td>
                                
				     		</tr>
                            <tr>
				     			<td colspan="2">
				     			<label class="control-label" style="width: 80px;">รายการย่อย</label>	
			                       <input id="ccsublist" name="ccsublist" class="easyui-combobox" style="height:30px;width:425px;" 
				     				       data-options="valueField:'id',textField:'name',panelHeight:'auto'" />
				     	        </td>
				     		</tr>
                            <tr>
				     		  <td colspan="2">
				     			  <label class="control-label" style="width: 80px;">สถานะเบิกจ่าย</label>
				      	     	  <select class="easyui-combobox" id="approve_status" name="approve_status" data-options="panelHeight:60" style="height:30px;width:210px;">
                                    <option value="2">เบิกจ่ายบางส่วน</option>
                                    <option value="3">เบิกจ่ายเสร็จสิ้น</option>
                                  </select>
				     		  </td>
				     	   </tr>
                            <tr>
				     		  <td valign="top">
				     			  <label class="control-label" style="width: 80px;">หมายเหตุ</label>
                                  <textarea id="paynote" name="paynote"  style="font-size: 12px;width:230px;" rows="2"></textarea>
                                 
				     		  </td>
                              <td valign="top">
                                   (ถ้ามี) เช่น คำสั่ง 1432/5
                              </td>
				     	   </tr>
						 	<tr>
						 			<td style="width: 330px;">
						 			   <input type="hidden" name="payerid[1]">	
						 			   <label class="control-label" style="width: 80px;">ผู้รับเงิน 1</label>
					                   <input id="ccpayer1" name="ccpayer[1]" class="easyui-combobox" style="height:30px;width:245px;" required="true"
		                                 data-options="url:'<?php echo base_url(); ?>payer/combobox',
		            	                  valueField:'payer_code',
		                                  textField:'name',
		                                  groupField:'type',
		                                  panelHeight:'auto'
		                                 ">
						 			</td>
						 			<td>
						 				<label class="control-label" style="width: 68px;">จำนวน</label>
						 				<input type="text" name="sum[1]" onkeyup="plus()"  class="input-small" style="text-align:right;" required="true"> บาท
						 			    &nbsp; <button class="btn" type="button" onclick="add_pay();" title="เพิ่มผู้รับเงิน"><i class="icon-plus"></i> เพิ่มจำนวนผู้รับเงิน</button>
                                     </td>
                                     
						 			
						 	</tr>
						 	</tbody>
						 </table>
						 <table border="0" class="table-form span12">
                                  <tr>
                                          <td style="width: 330px;">
                                    	
                                    	  </td>
                                         <td>
				     			               <label class="control-label" style="width: 70px;">รวมเป็นเงิน</label>
							                   <input type="text" id="total_amount" name="total_amount" class="input-small" style="text-align:right;" disabled="disabled"> บาท
				     			          </td>
                                   </tr>
                          </table>
                         
		    </fieldset>
		   
		    <div id="dlg-buttons" class="form-actions">
			<button type="button" class="btn btn-primary" onclick="save()">บันทึกข้อมูล</button>
			<button id="cancelButton" type="button" class="btn" onclick="cancel()">ยกเลิก</button>
		    </div>
		    
		</form>
   </div>
</div>

<script type="text/javascript">
    var base_url = '<?php echo base_url(); ?>';
    var approve_id = '<?php echo $approve_id; ?>';
    var disbursement_id = '<?php echo $disbursement_id; ?>';
    var num = 1;
    var url;
    var dataUrl;
    var searchUrl;

function checking() {
   
    clear_approve_box();

    var doc_number = $('#approve_doc_number').val().replace('/','_');
    
    if($('#search_type_status').val() == 1){
      var jqsonurl = base_url + 'approve/check_document/' + doc_number;
    }else{
      var jqsonurl = base_url + 'approve/check_document_by_filenumber/' + doc_number;
    }

    
    $.getJSON(jqsonurl, function (data) {  
      if(jQuery.isEmptyObject(data) === false){ 
             
                  // found  1 data 
                  if(data.length == 1){
                          var html = '<table class="table-check" border="1">';
                      
                      $.each(data, function (index, val) {       
                                                
                          html += '<tr><td class="table-check-title">เลขที่</td>';
                          html += '<td>'+ val.doc_number +'</td></tr>';
                          html += '<tr><td class="table-check-title">ลำดับแฟ้ม</td>';
                          html += '<td>'+ val.file_number +'</td></tr>';
                          html += '<tr><td class="table-check-title">วันที่</td>';
                          html += '<td>'+ val.doc_date +'</td></tr>';
                          html += '<tr><td class="table-check-title">เรื่อง</td>';
                          html += '<td>'+ val.subject +'</td></tr>';
                          html += '<tr><td class="table-check-title">เงินอนุมัติคงเหลือ</td>';
                          html += '<td>'+ val.amount +' บาท</td></tr>';
                          html += '<tr><td class="table-check-title">สถานะ</td>';
                          html += '<td>'+ val.status +'</td></tr>';
                          html += '</table>';
                              
                           $('#approveid').val(val.id);
                       });
                        
                         $('#check_status').val(1);
                         $('#table-check-modal').html(html);
                   }
                   else{  // found more data
                      var html = '<p><b>พบเอกสารอนุมัติจำนวน '+ data.length +' รายการ กรุณาเลือก:</b></p>';
                          html += '<table class="table-check" border="1">'; 
                         $.each(data, function (index, val) {
                             html += '<tr><td class="table-check-title" style="width:20px;padding:5px 5px 5px 10px">';
                             html += '<input type="radio" name="rdo_docnumber" value="'+val.id+'"></td>';
                             html += '<td>เลขที่: '+val.doc_number+'</td>';  
                             html += '<td>ลำดับแฟ้ม: '+val.file_number+'</td></tr>';    
                        });
                        html += '</table>'; 
                       
                       $('#check_status').val(2);
                       $('#table-check-modal').html(html);
                       
                    }
                   
           $('#dlg2').dialog('open');
      }   
      else
      { 
          $.messager.alert('ผลการค้นหา', 'ไม่พบเอกสาร กรุณาป้อนเลขเอกสารใหม่อีกครั้ง');
      }    
          
     
    });
 
}


function select_approve_document() {

      // console.log($('#approveid').val());
      // console.log($('#check_status').val());
       
         if($('#check_status').val() == 2){
            $('#approveid').val($("input[name^='rdo_docnumber']:checked").val());
         }
               
        var jqsonurl = base_url + 'approve/check_document_by_id/' + $('#approveid').val();
                $.getJSON(jqsonurl, function (data) {
                    $.each(data, function (index, val) {
                        $("input[name='approve_subject']").val(val.subject);
                        $("input[name='approve_amount']").val(val.amount);
                        $("input[name='current_status']").val(val.status);
                        show_mgt_costs(val.mgt_costs_id);
                    });
                });
                
       check_payment($('#approveid').val(), function(result){
           if(result > 0){
               $('#check-payment').show();
               $('#check-payment').html(' (มีการเบิกจ่ายแล้ว จำนวน '+ result + ' ครั้ง)');
            }
       });
       
      $('#dlg2').dialog('close');
}


function check_payment(aprove_id, callback) {
    var jqsonurl = base_url + 'disbursement/check_payment/' + aprove_id; 
     $.ajax({
        url: jqsonurl,
        type: "POST",
        dataType: "text",
        success: function (result) {
            callback(result);
        }
    });
}


function clear_approve_box() {
    $("input[name='approve_subject']").val('');
    $("input[name='approve_amount']").val('');
    $("input[name='current_status']").val('');
    $('#check-payment').hide();
}


function add(){
       $('#dlg').dialog('open').dialog('setTitle','เพิ่มข้อมูลใหม่');
       $('#fm_popup').form('clear');
       $('#ccfaculty').combobox('select', '53');
       url = base_url+'approve/add';
}

function add_pay(){

	num = num + 1;
    var html = '<tr id="tr'+num+'"><td><input type="hidden" name="payerid['+num+']"><label class="control-label" style="width: 80px;">ผู้รับเงิน '+num+'</label><input id="ccpayer'+num+'" name="ccpayer['+num+']" class="easyui-combobox" style="height:30px;width:245px;" required="true"></td><td><label class="control-label" style="width: 68px;">จำนวน </label><input type="text" name="sum['+num+']" onkeyup="plus()" class="input-small" style="text-align:right;" required="true"> บาท &nbsp; <button class="btn" type="button" onclick="delete_pay()"><i class="icon-remove"></i> ลบ</button></td></tr>'
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
	
	if(oldsum){
	$('#total_amount').val(amount - oldsum);
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

	$("input[name^='sum']").sum({
	  bind: "keyup"
	, selector: "#total_amount"
	, oncalc: function (value, settings){
		// you can use this callback to format values
		
		var e=window.event?window.event:event;
        var keyCode=e.keyCode?e.keyCode:e.which?e.which:e.charCode;
		
		//0-9 (numpad,keyboard)
		if ((keyCode>=96 && keyCode<=105)||(keyCode>=48 && keyCode<=57)){
			/*if(value <= balance){
			    $('#total_balance').val(balance - value);
			    return true;
			 }*/
		    return true;
		}
		//backspace,delete,left,right,home,end
	   if (',8,46,37,39,36,35,110,190,'.indexOf(','+keyCode+',')!=-1){
	       // $('#total_balance').val(balance - value); return true;
	       return true;
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
					console.log(result);
					var result = eval('('+result+')');
					if (result.success){
					    
                        // Case: When if update
					    if (disbursement_id > 0) {
					        $.messager.alert('ผลการบันทึก', 'บันทึกข้อมูลเบิกจ่ายเรียบร้อย');
					        window.location.href = base_url + 'disbursement/';
					    }
					    else {
					        $.messager.alert('ผลการบันทึก', 'บันทึกข้อมูลเบิกจ่ายเรียบร้อย');
					        $('#fm').form('clear');
					        $('#approve_doc_number').focus();
                            $('#searchtype').combobox('select', 1);
                            //window.location.href = base_url + 'approve/';
					    }


					} else {
						alert(result.msg);
					}
				}
			});
}

function save_new_document() {
    $('#fm_popup').form('submit', {
        url: url,
        onSubmit: function () {
            return $(this).form('validate');
        },
        success: function (result) {
            var result = eval('(' + result + ')');

            if (result.success) {
                $('#dlg').dialog('close');		// close the dialog
                $('#approveid').val(result.row_id);

                var jqsonurl = base_url + 'approve/check_document_by_id/' + result.row_id;
                $.getJSON(jqsonurl, function (data) {
                    $.each(data, function (index, val) {
                        $('#approve_doc_number').val(val.doc_number);
                        $("input[name='approve_subject']").val(val.subject);
                        $("input[name='approve_amount']").val(val.amount);
                        $("input[name='current_status']").val(val.status);
                        show_mgt_costs(val.mgt_costs_id);
                    });
                });
               
            } else {
                $.messager.show({
                    title: 'Error',
                    msg: result.msg
                });
            }
        }
    });
}


function cancel(){
    $('#fm').form('clear');
    $('#approve_doc_number').focus();
    $('#searchtype').combobox('select', 1);
    
}


function show_mgt_costs(mgt_costs_id){
 
    if(mgt_costs_id > 0 && mgt_costs_id != null && disbursement_id <= 0){
                var jqsonurl = base_url +'mgt_costs/get_all_id/' + mgt_costs_id;
		    	$.getJSON(jqsonurl, function(data) {
		            $.each(data, function(index, val) {
                            //plans combobox
		                    $('#ccplans').combobox('select', val.mgt_plans_id);

		                    //hidden textbox costs
		                    $('#txtcosts').val(val.costs_id);

		                    //ccgroup combobox
		                    $('#ccgroup').combobox('select', val.costs_group_id);

		                    //product combobox
		                    ccurl = base_url + 'mgt_product/get_by/' + val.mgt_plans_id;
		                    $('#ccproduct').combobox('clear').combobox('reload', ccurl).combobox('select', val.mgt_product_id);

		                    //cctype combobox
		                    ccurl = base_url + 'costs_type/get_by/' + val.costs_group_id;
		                    $('#cctype').combobox('clear').combobox('reload', ccurl).combobox('select', val.costs_type_id);;

		                    //cclists combobox
		                    ccurl = base_url + 'costs_lists/get_by/' + val.costs_type_id;
		                    $('#cclists').combobox('clear').combobox('reload', ccurl).combobox('select', val.costs_lists_id);

		                    //ccsublist combobox
		                    if (val.costs_sublist_id > 0) {
		                        ccurl = base_url + 'costs_sublist/get_by/' + val.costs_lists_id;
		                        $('#ccsublist').combobox('clear').combobox('reload', ccurl).combobox('select', val.costs_sublist_id);
		                    }
		            });
                });  
                
         } // end if
         else{
            $('#txtcosts').val('');
            $('#ccplans').combobox('clear');
            $('#ccproduct').combobox('clear');
            $('#ccgroup').combobox('clear');
            $('#cctype').combobox('clear');
            $('#cclists').combobox('clear');
            $('#ccsublist').combobox('clear');
        }    
}



function load_disbursement_data()
{
    var jqsonurl = base_url +'disbursement/get_by/' + disbursement_id;
		    	$.getJSON(jqsonurl, function(data) {
		        $.each(data, function(index, val) {
		        
		           $('#fm').form('load',{
		           	paydoc_number:val.doc_number,
		           	payfile_number:val.file_number,
		           	pay_date:formatThaiDate(val.doc_date),
		           	invoice_number:val.invoice_number,
                    paynote:val.note
		           });
                   
                   ccurl = base_url + 'mgt_plans/get_by/' + val.budget_main_id;
                   $('#ccplans').combobox('clear').combobox('reload', ccurl).combobox('select', val.mgt_plans_id);
                   
                   //product combobox
		           ccurl = base_url + 'mgt_product/get_by/' + val.mgt_plans_id;
		           $('#ccproduct').combobox('clear').combobox('reload', ccurl).combobox('select', val.mgt_product_id);

		            //hidden textbox costs
		           $('#txtcosts').val(val.costs_id);

		            //ccgroup combobox
		           $('#ccgroup').combobox('select', val.costs_group_id);

		            //cctype combobox
		           ccurl = base_url + 'costs_type/get_by/' + val.costs_group_id;
		           $('#cctype').combobox('clear').combobox('reload', ccurl).combobox('select', val.costs_type_id);;

		            //cclists combobox
		           ccurl = base_url + 'costs_lists/get_by/' + val.costs_type_id;
		           $('#cclists').combobox('clear').combobox('reload', ccurl).combobox('select', val.costs_lists_id);

		            //ccsublist combobox
		           if (val.costs_sublist_id > 0) {
		               ccurl = base_url + 'costs_sublist/get_by/' + val.costs_lists_id;
		               $('#ccsublist').combobox('clear').combobox('reload', ccurl).combobox('select', val.costs_sublist_id);
		           }

		        });

		        
		    });
            
            // ดึงข้อมูลผู้รับเงิน
		    var jqsonurl = base_url +'payment/get_by/' + disbursement_id;
		    	$.getJSON(jqsonurl, function(data) {
		    	
		    	var count = data.length;
		    	var total_payment = 0.00;
		    	
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
	                total_payment = total_payment + parseFloat(val.amount);
		        });
		        
		        $('#total_balance').val(parseFloat($('#amount').val().replace(/[,]/g,'')) - total_payment);
		        $('#total_amount').val(total_payment);
		    });

}   


/* search autocomplete */
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
    var searchURL = $('#url_search_type').val();
			
		return searchURL +encodeURIComponent(keyword);
    });	
}	

// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า"); 
make_autocom("approve_doc_number","autocomplete-ajax-x");


$(document).ready(function () {

    $('input[type="checkbox"][name="checkbox"]').change(function () {
        if (this.checked) {
            $('#amount').numberbox('setValue', 0.00);
            $('#amount').numberbox('disable');

        }
        else {
            $('#amount').numberbox('clear');
            $('#amount').numberbox('enable');
        }
    });
    
    // search autocomplete
    $('#searchtype').combobox({
    	onSelect: function(param){
            if(param.value == 1){
               searchUrl = base_url + 'search/approve_docnumber/';
               $('#search_type_status').val(1);
               $('#url_search_type').val(searchUrl);
            }
            else{
               searchUrl = base_url + 'search/approve_filenumber/';
               $('#search_type_status').val(2);
               $('#url_search_type').val(searchUrl);
            }
           $('#approve_doc_number').val('');
           clear_approve_box();      
    	}
    });
    

    // Case: Auto load approve document
    if (approve_id > 0) {
        $('#approveid').val(approve_id);
        var jqsonurl = base_url + 'approve/check_document_by_id/' + approve_id;
        $.getJSON(jqsonurl, function (data) {
            $.each(data, function (index, val) {
               
                $('#approve_doc_number').val(val.doc_number);
                $("input[name='approve_subject']").val(val.subject);
                $("input[name='approve_amount']").val(val.amount);
                $("input[name='current_status']").val(val.status);
                
                //approve status
                if(val.status_id == 1){
		          $('#approve_status').combobox('select', 2);
                }
                else{
                   $('#approve_status').combobox('select', val.status_id);
                }
                 
                show_mgt_costs(val.mgt_costs_id); 
            });
        });
    }

    // Case: updata Disbursement and payment data
    if(disbursement_id > 0)
    {
	    	setTimeout(load_disbursement_data, 300);
    }


// end document.ready
});
	
    
 
</script>
