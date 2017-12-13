<div style="margin:10px 0;"></div>
<div class="easyui-tabs" style="width:auto;height:500px;">
<div title="การจัดสรรเงิน" style="padding:10px">
<div class="box box-color box-bordered">
    <div class="box-title">
		<h3>
			<i class="icon-table"></i>
			 รายการแผนงาน
		</h3>
	</div>	
 <div class="box-content nopadding">
		<table id="dg" class="easyui-datagrid" style="width:auto;height:auto"
			url="<?php echo base_url(); ?>mgt_plans/get"
			toolbar="#toolbar"  
            rownumbers="true" fitColumns="true" singleSelect="true" pagination="true" >
		<thead>
			<tr>
				<th data-options="field:'name',width:150" sortable="true">ชื่อรายการ</th>
				<th data-options="field:'amount',width:100" formatter="formatCurrency" sortable="true">จำนวนเงิน</th>
				<th data-options="field:'title',width:200">แหล่งเงิน</th>
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
						สรุปภาพรวมการจัดสรรงบระดับแผนงาน
					</h3>
				</div>
			    <div class="box-content nopadding">
					<table id="dg2" class="easyui-datagrid" style="width:auto;height:350px"
						url="<?php echo base_url(); ?>mgt_plans/get_summary"  
			            rownumbers="true" fitColumns="true" singleSelect="true" >
						<thead>
							<tr>
								<th data-options="field:'title',width:180">แหล่งเงิน</th>
								<th data-options="field:'year',width:80">ปีงบประมาณ</th>
								<th data-options="field:'status',width:150">สถานะ</th>
								<th data-options="field:'amount',width:120,align:'right'" formatter="formatCurrency">จำนวนเงิน</th>
								<th data-options="field:'balance',width:120,align:'right'" formatter="formatCurrency">คงเหลือ</th>
								<th data-options="field:'total',width:120,align:'right'" formatter="formatCurrency">รวมเงินที่จัดสรรไป</th>
							</tr>
						</thead>	
				   </table>
			    </div>
			</div>
        </div>
</div>


<div id="dlg" class="easyui-dialog" style="width:700px;height:350px;padding:10px 20px"  
        closed="true" buttons="#dlg-buttons">  
    
    <div class="box-title">
		<h3><i class="icon-edit"></i> ข้อมูลงบแผนงาน</h3>
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
										 }
				    ">
					<input type="text" id="budget_amount" class="input-small" disabled="disabled"> บาท				
				</div>
			</div>
    	   
    	   <div class="control-group">
			  <label for="name" class="control-label">ชื่อแผนงาน</label>
				<div class="controls">
					<input id="ccplan" name="ccplan" required="true" class="easyui-combobox" style="height:30px;width:285px;"   
                           data-options="url:'<?php echo base_url(); ?>plans/combobox',
                    	   valueField:'id',
                           textField:'name',
                           panelHeight:'auto'
                           "> 
				</div>
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
		var total_balance;
		
		function add(){
			$('#dlg').dialog('open').dialog('setTitle','เพิ่มข้อมูลใหม่');
			$('#clear').hide();
			$('#amount').removeAttr("readonly");
			$('#fm').form('clear');
			$('#ccbudget').combobox('select', source_year);
			$('#ccbudget').combobox('disable');
			url = '<?php echo base_url(); ?>mgt_plans/add';
		}
		function edit(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','แก้ไขข้อมูล');
				$('#fm').form('load',row);
				url = '<?php echo base_url(); ?>mgt_plans/update/'+row.id;
				
				$('#ccbudget').combobox('select',row.budget_main_id); //select combobox
				calculatBudgetBalance(row.budget_main_id);
				
				$('#ccplan').combobox('select',row.plan_id); //select combobox
				
				$('#ccbudget').combobox('disable');
				$('#amount').attr("readonly", "readonly");
		        $('#clear').show();
			}
		}
		function save(){
			$('#fm').form('submit',{
				url: url,
				onSubmit: function(){
					var tmp_amount = parseFloat($('#budget_amount').val().replace(/[,]/g,''));
					if(tmp_amount < 0){
						$.messager.show({
							title: 'ผิดพลาด',
							msg: 'จำนวนเงินเกินงบประมาณ กรุณาป้อนใหม่'
						});
						return false;
					}
					return $(this).form('validate');
				},
				success: function(result){
					$('#amount').removeAttr("readonly");
					console.log(result);
					var result = eval('('+result+')');	
					if (result.success){
						$('#dlg').dialog('close');		// close the dialog
						$('#dg').datagrid('reload');	// reload the user data
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
						$.post('<?php echo base_url(); ?>mgt_plans/delete',{id:row.id},function(result){
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
			  
			           if(val.balance != null){
			           	   $('#budget_amount').val(formatCurrency(val.balance));
			           	   total_balance = val.balance;
			           }else{
			        	   $('#budget_amount').val(formatCurrency(val.amount));
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
			$('#budget_amount').val(formatCurrency(tmp_amount));
			$('#amount').val('');
			$('#amount').removeAttr("readonly");
			$('#clear').hide();
		}
		
		function doFilter(id){
		     $('#dg').datagrid('load',{
		        budget_main_id: id
		    });
		}
		
		function plus(){
			$("input[name^='amount']").sum({
			  bind: "keyup"
			, selector: "#budget_amount"
			, oncalc: function (value, settings){
				// you can use this callback to format values
				
				var e=window.event?window.event:event;
		        var keyCode=e.keyCode?e.keyCode:e.which?e.which:e.charCode;
				
				//0-9 (numpad,keyboard)
				if ((keyCode>=96 && keyCode<=105)||(keyCode>=48 && keyCode<=57)){
					if(value <= total_balance){
					    $('#budget_amount').val(formatCurrency(total_balance - value));
					    return true;
					 }
				}
				//backspace,delete,left,right,home,end,dot(numpad decimal)
			   if (',8,46,37,39,36,35,110,190,'.indexOf(','+keyCode+',')!=-1){
			      $('#budget_amount').val(formatCurrency(total_balance - value)); return true;
			   }
				else{ 
					 $(this).val('');
					 $('#budget_amount').val(formatCurrency(total_balance));
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
		   
            $('#dg2').datagrid({
                view: detailview,
                detailFormatter:function(index,row){
                    return '<div style="padding:2px"><table class="ddv"></table></div>';
                },
                onExpandRow: function(index,row){
                    var ddv = $(this).datagrid('getRowDetail',index).find('table.ddv');
                    ddv.datagrid({
                        url: '<?php echo base_url(); ?>mgt_plans/get_by/'+row.id,
                        fitColumns:true,
                        singleSelect:true,
                        rownumbers:true,
                        loadMsg:'',
                        height:'auto',
                        columns:[[
                            {field:'name',title:'ชื่อแผน',width:200},
                            {field:'amount',title:'จำนวนเงิน',width:200,align:'right',formatter:formatCurrency}
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