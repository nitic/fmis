<div class="box box-color box-bordered">
    <div class="box-title">
		<h3>
			<i class="icon-table"></i>
			แหล่งเงินงบประมาณ
		</h3>
	</div>
	<div class="box-content nopadding">
			<table id="tg" class="easyui-treegrid" style="width:auto;height:450px"
            toolbar="#toolbar" data-options=" 
				                url: '<?php echo base_url(); ?>report_planners/get',
				                rownumbers: false,
				                collapsible:true,
				                fitColumns:true,
				                idField: 'id',
				                treeField: 'name',
				                onLoadSuccess: function(){
							       collapseAll();
								 }
				            ">
	        <thead>
	            <tr>
	                <th data-options="field:'name'" width="300">แผนงาน / ผลผลิต / งบประมาณรายจ่าย</th>
	                <th data-options="field:'amount'" width="100" align="right" formatter="formatCurrency">จำนวนเงิน</th>
	                <th data-options="field:'balance'" width="100" align="right">คงเหลือ</th>
	            </tr>
	        </thead>
	       </table>
		       <div id="toolbar"> 
				<div style="float: left;width: 480px;background-color: transparent;border: none;"> 
		         <span>ปีงบประมาณ:
			    	  <input id="ccsource" name="ccsource" class="easyui-combobox"  style="width:200px" readonly="readonly" 
			             data-options="url:'<?php echo base_url(); ?>budget_main/combobox2',
			                    	   valueField:'id',
			                           textField:'title',
			                           panelHeight:'auto',
			                           onSelect: function(rec){
							              doFilter(rec.id);
								        }">  
					   <a href="#" class="easyui-linkbutton" iconCls="icons-add" plain="true" onclick="expandAll()">ขยายทั้งหมด</a>  
			           <a href="#" class="easyui-linkbutton" iconCls="icons-remove" plain="true" onclick="collapseAll()">ย่อทั้งหมด</a> 
		         </span> 
		         </div>		
		     </div>
			
	  </div>
</div>		    

<script type="text/javascript">
		var source_year = <?php echo $this->session->userdata('budget_year_id'); ?>;

		function collapseAll(){
            $('#tg').treegrid('collapseAll');
        }
        function expandAll(){
            $('#tg').treegrid('expandAll');
        }
        
        function doFilter(id){
		     $('#tg').treegrid('load',{
		        budget_main_id: id
		    });
		}

	
$(function(){

	        $('#ccsource').combobox({
				onLoadSuccess: function(){
					$('#ccsource').combobox('select', source_year);
				}
			});		
});	
</script>
