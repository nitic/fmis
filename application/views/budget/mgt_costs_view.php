<div style="margin:10px 0;"></div>
<div class="easyui-tabs" style="width:auto;height:500px;">
<div title="การจัดสรรเงิน" style="padding:10px">
<div class="box box-color box-bordered">
    <div class="box-title">
		<h3>
			<i class="icon-table"></i>
			 รายการงบรายจ่าย
		</h3>
	</div>	
 <div class="box-content nopadding">
		<table id="dg" class="easyui-datagrid" style="width:auto;height:auto"
			url="<?php echo base_url(); ?>mgt_costs/get"
			toolbar="#toolbar"  
            rownumbers="true" fitColumns="true" singleSelect="true" pagination="true" >
		<thead>
			<tr>
				<th data-options="field:'name',width:250" sortable="true">ชื่อรายจ่าย</th>
				<th data-options="field:'costs_type',width:100" sortable="true">ประเภทรายจ่าย</th>
				<th data-options="field:'product',width:150" sortable="true">ภายใต้ผลิตผล</th>
				<th data-options="field:'plan',width:150" sortable="true">แผนงาน</th>
				<th data-options="field:'year',width:80">แหล่งเงิน</th>
				<th data-options="field:'amount',width:100, align:'right'" formatter="formatCurrency" sortable="true">จำนวนเงิน</th>
			</tr>
		</thead>	
		</table>
		<div id="toolbar"> 
			<div style="float: left;width: 450px;background-color: transparent;border: none;"> 
			<?php if($this->session->userdata('Role') == 'Administrator' || $this->session->userdata('Role') == 'Planners'): ?>
		      <a href="#" class="easyui-linkbutton" iconCls="icons-add" plain="true" onclick="add()">เพิ่ม</a>  
		      <a href="#" class="easyui-linkbutton" iconCls="icons-edit" plain="true" onclick="edit()">แก้ไข</a>  
		      <a href="#" class="easyui-linkbutton" iconCls="icons-remove" plain="true" onclick="del()">ลบ</a>  
	         <?php endif; ?>
	         <span>แหล่งเงิน:
		    	  <input id="ccsource" name="ccsource" class="easyui-combobox"  style="width:200px" readonly="readonly"
		             data-options="url:'<?php echo base_url(); ?>budget_main/combobox2',
		                    	   valueField:'id',
		                           textField:'title',
		                           panelHeight:'auto',
		                           onSelect: function(rec){
						              doFilter(rec.id);
							        }">  
	         </span> 
	         </div>		
	    </div>
    </div>
   </div>
</div>
  <div title="สรุปภาพรวม" style="padding:10px">
           <div class="box box-color box-bordered">
			    <div class="box-title">
					<h3>
						<i class="icon-table"></i>
						สรุปภาพรวมการจัดสรรงบระดับรายจ่าย
					</h3>
				</div>
			   <div class="box-content nopadding">
					<table id="dg2" class="easyui-datagrid" style="width:auto;height:350px"
						url="<?php echo base_url(); ?>mgt_costs/get_summary"  
			            rownumbers="true" fitColumns="true" singleSelect="true" toolbar="#toolbar2"  >
						<thead>
							<tr>
								<th data-options="field:'product',width:150">ผลผลิต</th>
								<th data-options="field:'plans',width:180">แผนงาน</th>
								<th data-options="field:'budget',width:70">แหล่งเงิน</th>
								<th data-options="field:'amount',width:120,align:'right'" formatter="formatCurrency">จำนวนวงเงินทั้งหมด</th>
								<th data-options="field:'balance',width:120,align:'right'" formatter="formatCurrency">คงเหลือ</th>
								<th data-options="field:'total',width:120,align:'right'" formatter="formatCurrency">ใช้เงินจัดสรรไป</th>
							</tr>
						</thead>	
				   </table>
				   <div id="toolbar2"> 
						<div style="float: left;width: 450px;background-color: transparent;border: none;"> 
						          เลือกแหล่งเงิน:
					    	  <input id="ccsource2" name="ccsource2" class="easyui-combobox"  style="width:200px" readonly="readonly"
					             data-options="url:'<?php echo base_url(); ?>budget_main/combobox2',
					                    	   valueField:'id',
					                           textField:'title',
					                           panelHeight:'auto',
					                           onSelect: function(rec){
									              doFilter2(rec.id);
								               }
							  ">  
				         </div>		
				    </div>
			    </div> 
			</div>
        </div>
</div>


<div id="dlg" class="easyui-dialog" style="width:680px;height:590px;padding:10px 20px"  
        closed="true" buttons="#dlg-buttons">  
    
    <div class="box-title">
		<h3><i class="icon-edit"></i> ข้อมูลงบรายจ่าย</h3>
	</div>
	<div class="box-content nopadding">
    <form id="fm" method="post" class='form-horizontal form-bordered'> 
    	   <div class="control-group">
			  <label for="plan" class="control-label">แหล่งเงิน</label>
				<div class="controls">
					<input id="ccbudget" name="ccbudget" class="easyui-combobox" required="true" style="height:30px;width:285px;" 
				     	   data-options="url:'<?php echo base_url(); ?>budget_main/combobox',
				     				     valueField:'id',textField:'title',panelHeight:'auto',
                                         onSelect: function(rec){
                                         		  
                                         		  calculatBudgetBalance(rec.id);
                                         		  $('#plans_amount').val('');
                                         		  
                                         		  var url = '<?php echo base_url(); ?>mgt_plans/get_by/'+rec.id;  
											      $('#ccplan').combobox('clear');
				                                  $('#ccplan').combobox('reload', url);

										 }
				    ">
					<input type="text" id="budget_amount" style="background-color: #fff; border: none; text-align: right" class="input-small" disabled="disabled"> บาท				
				</div>
			</div>
    	   
    	   <div class="control-group">
			  <label for="name" class="control-label">แผนงาน</label>
				<div class="controls">
					<input id="ccplan" name="ccplan" required="true" class="easyui-combobox" style="height:30px;width:285px;"   
                           data-options="valueField:'id',textField:'name',panelHeight:'auto',
                                 onSelect: function(rec){
                                 	          
                                         	if(isset(rec)){	  
                                              calculatPlansBalance(rec.id);
                                              var url = '<?php echo base_url(); ?>mgt_product/get_by/'+rec.id;  
											  $('#ccproduct').combobox('clear');
				                              $('#ccproduct').combobox('reload', url);
				                             }
										 }
                           
                           ">
                     <input type="text" id="plans_amount" style="background-color: #fff; border: none; text-align: right" class="input-small" disabled="disabled"> บาท
				</div>
			</div>
			
			<div class="control-group">
			  <label for="name" class="control-label">ผลผลิต</label>
				<div class="controls">
					<input id="ccproduct" name="ccproduct" required="true" class="easyui-combobox" style="height:30px;width:285px;"   
                           data-options="valueField:'id',textField:'name',panelHeight:'auto',
                                 onSelect: function(rec){  
                                 	         if(isset(rec)){                               
                                               calculatProductBalance(rec.id);
                                             }   
										 }
                           
                           ">
                     <input type="text" id="product_amount" class="input-small" disabled="disabled"> บาท
				</div>
			</div>
			
			<div class="control-group">
			  <label for="name" class="control-label">หมวดงบ</label>
				<div class="controls">
					<input id="ccgroup" name="ccgroup" class="easyui-combobox" required="true" style="height:30px;width:285px;" 
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
				</div>
			</div>
			
			<div class="control-group">
			  <label for="name" class="control-label">ประเภท</label>
				<div class="controls">
					<input id="cctype" name="cctype" class="easyui-combobox" required="true"
				     				       style="height:30px;width:285px;" 
				     				       data-options="valueField:'id',textField:'name',panelHeight:'auto',
				     				        onSelect: function(rec){
				     				         if(isset(rec)){	
										        var url = '<?php echo base_url(); ?>costs_lists/get_by/'+rec.id;  
												$('#cclists').combobox('clear');
					                            $('#cclists').combobox('reload', url);
					                           }
									       }
				     				       ">
				</div>
			</div>
			
			<div class="control-group">
			  <label for="name" class="control-label">รายการ</label>
				<div class="controls">
					<input id="cclists" name="cclists" class="easyui-combobox" required="true"
				     				       style="height:30px;width:285px;" 
				     				       data-options="valueField:'id',textField:'name',panelHeight:'auto',
				     				        onSelect: function(rec){
				     				        if(isset(rec)){	
										        var url = '<?php echo base_url(); ?>costs_sublist/get_by/'+rec.id;  
												$('#ccsublist').combobox('clear');
					                            $('#ccsublist').combobox('reload', url);
					                         }
									       }
				     				       ">
				</div>
			</div>
			
			<div class="control-group">
			  <label for="name" class="control-label">รายการย่อย</label>
				<div class="controls">
					<input id="ccsublist" name="ccsublist" class="easyui-combobox" style="height:30px;width:285px;" 
				     				       data-options="valueField:'id',textField:'name',panelHeight:'auto'" />
				(*ไม่จำเป็น ถ้ามี)</div>
			</div>
			
			<div class="control-group">
			  <label for="amount" class="control-label">จำนวนเงิน</label>
				<div class="controls">
					<input type="text" id="amount" name="amount" onkeyup="plus()"  class="input-medium" style="text-align:right;" required="true">  บาท
					<button id="clear" class="btn" type="button" onclick="clear_budget()"><i class="icon-remove"></i></button>
				</div>
			</div>
    	    
			<div id="dlg-buttons">  
			    <button type="button" class="btn btn-primary" onclick="save()">Save changes</button>
			    <button type="button" class="btn" onclick="javascript:$('#dlg').dialog('close')">Cancel</button>  
			</div>
     </form>  
</div>  
</div>  

<script src="<?php echo base_url('assets/jquery-easyui/extension/datagrid-detailview.js');?>"></script>
<script type="text/javascript">
		var base_url = '<?php echo base_url(); ?>';
		var source_year = <?php echo $this->session->userdata('budget_year_id'); ?>;
		var url;
		var ccurl;
		var total_balance;
		
		function add(){
			$('#dlg').dialog('open').dialog('setTitle','เพิ่มข้อมูลใหม่');
			$('#clear').hide();
			$('#ccproduct').combobox('enable');
			$('#amount').removeAttr("disabled");
			$('#fm').form('clear');
			
			$('#ccbudget').combobox('select', source_year);
			$('#ccbudget').combobox('disable');
			url = '<?php echo base_url(); ?>mgt_costs/add';
		}
		function edit(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','แก้ไขข้อมูล');
				$('#fm').form('load',row);
				url = '<?php echo base_url(); ?>mgt_costs/update/'+row.id;
				
				//ccbudget combobox
				$('#ccbudget').combobox('select',row.budget_main_id); 
				
				//ccplan combobox
				ccurl = base_url + 'mgt_plans/get_by/'+ row.budget_main_id;
                $('#ccplan').combobox('clear').combobox('reload', ccurl).combobox('select',row.mgt_plans_id);
				calculatPlansBalance(row.mgt_plans_id);
				
				//ccproduct combobox
				ccurl = base_url + 'mgt_product/get_by/'+ row.mgt_plans_id;
                $('#ccproduct').combobox('clear').combobox('reload', ccurl).combobox('select',row.mgt_product_id);
		        calculatProductBalance(row.mgt_product_id);
		        
		        //hidden textbox costs
		        $('#txtcosts').val(row.costs_id);
		        
		        //ccgroup combobox
		        $('#ccgroup').combobox('select',row.costs_group_id);
		        
		         //cctype combobox
		        ccurl = base_url + 'costs_type/get_by/'+ row.costs_group_id;
                $('#cctype').combobox('clear').combobox('reload', ccurl).combobox('select',row.costs_type_id);;
		        
		         //cclists combobox
		        ccurl = base_url + 'costs_lists/get_by/'+ row.costs_type_id;
                $('#cclists').combobox('clear').combobox('reload', ccurl).combobox('select',row.costs_lists_id);
		       
		         //ccsublist combobox
		        if(row.costs_sublist_id > 0){
                ccurl = base_url + 'costs_sublist/get_by/'+ row.costs_lists_id;
                $('#ccsublist').combobox('clear').combobox('reload', ccurl).combobox('select',row.costs_sublist_id);
                }
		        
		        $('#ccproduct').combobox('disable');
		        $('#amount').attr("disabled", "disabled");
		        $('#clear').show();
			}
		}
		function save(){
			$('#fm').form('submit',{
				url: url,
				onSubmit: function(){
					$('#amount').removeAttr("disabled");
					var tmp_amount = parseFloat($('#product_amount').val().replace(/[,]/g,''));
					if(tmp_amount < 0){
						$.messager.show({
							title: 'ผิดพลาด',
							msg: 'จำนวนเงินเกินงบประมาณ ('+$('#product_amount').val()+' บ.) กรุณาป้อนใหม่'
						});
						return false;
					}
					return $(this).form('validate');
				},
				success: function(result){
					//console.log(result);
					var result = eval('('+result+')');	
					if (result.success){
						$('#dlg').dialog('close');		// close the dialog
						$('#dg').datagrid('reload');	// reload the user datagrid
						$('#dg2').datagrid('reload');	
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
						$.post('<?php echo base_url(); ?>mgt_costs/delete',{id:row.id},function(result){
							if (result.success){
								$('#dg').datagrid('reload');	// reload the user data
								$('#dg2').datagrid('reload');
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
		
		// calculat balance from budget_main - mgt_plans
		function calculatBudgetBalance(budget_id){
		   var jqsonurl = base_url +'mgt_plans/get_balance/'+ budget_id;
				$.getJSON(jqsonurl, function(data) {
			        $.each(data, function(index, val) {       
                        $('#budget_amount').val(formatCurrency(val.amount));
			        });
			    });
		}
		
		// calculat balance from  mgt_plans - mgt_product 
		function calculatPlansBalance(plans_id){
		   var jqsonurl = base_url +'mgt_product/get_balance/'+ plans_id;
				$.getJSON(jqsonurl, function(data) {
			        $.each(data, function(index, val) {
			        	   $('#plans_amount').val(formatCurrency(val.amount));
			        });
		   });
		}
		
		// calculat balance from  mgt_product - mgt_costs 
		function calculatProductBalance(product_id){
		   var jqsonurl = base_url +'mgt_costs/get_balance/'+ product_id;
				$.getJSON(jqsonurl, function(data) {
			        $.each(data, function(index, val) {
			        
			           if(val.balance != null){
			           	   $('#product_amount').val(formatCurrency(val.balance));
			           	   total_balance = val.balance;
			           }else{
			        	   $('#product_amount').val(formatCurrency(val.amount));
			        	   total_balance = val.amount;
			           }
			        });
		   });
		}
		
		
		function clear_budget()
		{
			var tmp_amount = parseFloat($('#amount').val().replace(/[,]/g,''));
			    tmp_amount = parseFloat(total_balance) + tmp_amount;
			
			total_balance = tmp_amount;
			$('#product_amount').val(formatCurrency(tmp_amount));
			$('#amount').val('');
			$('#ccproduct').combobox('enable');
			$('#amount').removeAttr("disabled");
			$('#clear').hide();
		}
		
		function doFilter(id){
		     $('#dg').datagrid('load',{
		        budget_main_id: id
		    });
		}
		
		function doFilter2(id){
		     $('#dg2').datagrid('load',{
		        budget_main_id: id
		    });
		}
		
		function plus(){
			$("input[name^='amount']").sum({
			  bind: "keyup"
			, selector: "#product_amount"
			, oncalc: function (value, settings){
				// you can use this callback to format values
				
				var e=window.event?window.event:event;
		        var keyCode=e.keyCode?e.keyCode:e.which?e.which:e.charCode;
				
				//0-9 (numpad,keyboard)
				if ((keyCode>=96 && keyCode<=105)||(keyCode>=48 && keyCode<=57)){
					if(value <= total_balance){
					    $('#product_amount').val(formatCurrency(total_balance - value));
					    return true;
					 }
				}
				//backspace,delete,left,right,home,end,dot(numpad decimal)
			   if (',8,46,37,39,36,35,110,190,'.indexOf(','+keyCode+',')!=-1){
			      $('#product_amount').val(formatCurrency(total_balance - value)); return true;
			   }
				else{ 
					 $(this).val('');
					 $('#product_amount').val(formatCurrency(total_balance));
					 return false;
				}
			}
			
		   });
		}


$(function(){
            
	        $('#ccsource').combobox({
				onLoadSuccess: function(){
					$('#ccsource').combobox('select', source_year);
				}
			});		
			
			$('#ccsource2').combobox({
				onLoadSuccess: function(){
					$('#ccsource2').combobox('select', source_year);
				}
			});
            
            $('#dg2').datagrid({
                view: detailview,
                detailFormatter:function(index,row){
                    return '<div style="padding:2px"><table class="ddv"></table></div>';
                },
                onExpandRow: function(index,row){
                    var ddv = $(this).datagrid('getRowDetail',index).find('table.ddv');
                    ddv.datagrid({
                        url: '<?php echo base_url(); ?>mgt_costs/get_by/'+row.mgt_product_id,
                        fitColumns:true,
                        singleSelect:true,
                        rownumbers:true,
                        loadMsg:'',
                        height:'auto',
                        columns:[[
                            {field:'name',title:'ชื่อรายจ่าย / รายจ่ายย่อย',width:320},
                            {field:'costs_type',title:'ประเภท',width:100},
                            {field:'costs_group',title:'หมวดงบรายจ่าย',width:200},
                             {field:'costs',title:'งบรายจ่าย',width:120},
                            {field:'amount',title:'จำนวนเงิน',width:150,align:'right',formatter:formatCurrency}
                        ]],
                        onResize:function(){
                            $('#dg2').datagrid('fixDetailRowHeight',index);
                        },
                        onLoadSuccess:function(){
                            setTimeout(function(){
                                $('#dg2').datagrid('fixDetailRowHeight',index);
                            },0);
                        }
                    });
                    $('#dg').datagrid('fixDetailRowHeight',index);
                }
            });
});

	</script>