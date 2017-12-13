<div class="box box-color box-bordered">
    <div class="box-title">
		<h3>
			<i class="icon-table"></i>
			สรุปภาพรวมการอนุมัติ
		</h3>
	</div>
	<div class="box-content nopadding">
		<table id="dg" class="easyui-datagrid" style="height:500px"
					url="<?php echo base_url(); ?>report_approve/get"
					toolbar="#toolbar"  
		            rownumbers="true" fitColumns="true" singleSelect="true" pagination="true">
				<thead>
					<tr>
						<th data-options="field:'name',width:120" sortable="true">แผนงาน</th>
						<th data-options="field:'year',width:80">แหล่งเงินงบประมาณ</th>
						<th data-options="field:'total',width:150,align:'right'" formatter="formatCurrency" sortable="true">ยอดรวมเงินอนุมัติ</th>
					</tr>
				</thead>	
			</table>
			<div id="toolbar">
			 	<div style="float: left;width: 480px;background-color: transparent;border: none;"> 
		         <span style="float: left;"> ปีงบประมาณ:
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

<script src="<?php echo base_url('assets/jquery-easyui/extension/datagrid-detailview.js');?>"></script>
<script type="text/javascript">
	    var base_url = '<?php echo base_url(); ?>';
	    var source_year = '<?php echo $this->session->userdata('budget_year_id'); ?>';
		var url;

		function doFilter(id){
		     $('#dg').datagrid('load',{
		        budget_main_id: id
		    });
		}
		
$(document).ready(function() {
	 $(function(){
	 	   $('#ccsource').combobox({
				onLoadSuccess: function(){
					$('#ccsource').combobox('select', source_year);
				}
		   });
	 	
            $('#dg').datagrid({
                view: detailview,
                detailFormatter:function(index,row){
                    return '<div style="padding:2px"><table class="ddv"></table></div>';
                },
                onExpandRow: function(index,row){
                    var ddv = $(this).datagrid('getRowDetail',index).find('table.ddv');
                    ddv.datagrid({
                        url: base_url+'report_approve/get_detail/'+row.budget_main_id+'/'+row.mgt_plans_id,
                        fitColumns:true,
                        singleSelect:true,
                        rownumbers:true,
                        loadMsg:'',
                        height:'auto',
                        columns:[[
                            {field:'costs',title:'งบประมาณรายจ่าย',width:400},
                            {field:'doc_date',title:'วันที่อนุมัติ',width:80},
                            {field:'total',title:'จำนวนเงินอนุมัติ',width:100,align:'right',formatter:formatCurrency}
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