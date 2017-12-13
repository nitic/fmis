<div class="box span9">
     <div class="box-title">
			<h3>
				<i class="icon-table"></i>
				 ตารางสถานะ
			</h3>
		</div>
        <div class="box-content nopadding">
            <form id="fm" method="post">	
            <table class="table table-nomargin">
                <thead>
                    <tr>
                        <th>แหล่งงบประมาณ</th>
                        <th class="text-center">จำนวนเงินทั้งหมด</th>
                         <th class="text-center">จำนวนเงินอนุมัติ</th>
                        <th class="text-center">คงเหลือ</th>
                        <th> </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($rows as $value): ?>
                    <?php
                    		if($value["balance"] <= 0){
                    		    $useable = 100;
								$balance = number_format($value["amount"],2);
							} else {
								$useable = number_format(($value["balance"]/$value["amount"])*100,2);
								$balance = number_format($value["balance"],2);
							}
							
							if($value["status_id"] == 2)
								$checked = 'checked';
							else
								$checked = '';
                    ?>
                    <tr>
                        <td>
                        <div class="media">
                            <div class="media-body">
                                <h4 class="media-heading"><?php echo $value["title"]; ?></h4>
                                <h6 class="media-heading">ระยะเวลา<a href="#"> <?php echo $value["start_date"]." - ".$value["end_date"]; ?></a></h6>
                                 <span>จำนวนเงินคงเหลือ (<?php echo $useable; ?> %)</span>
								  <div class="progress progress-info active">
								      <div class="bar" style="width: <?php echo $useable; ?>%;"></div>
								  </div>
                            </div>
                        </div></td>
                        <td class="text-center"><strong><?php echo number_format($value["amount"],2); ?></strong></td>
                        <td class="text-center"><strong><?php echo number_format($value["approve"],2); ?></strong></td>
                        <td class="text-center"><strong><?php echo $balance; ?></strong></td>
                        <?php if($this->session->userdata('Role') == 'Administrator' || $this->session->userdata('Role') == 'Planners' || $this->session->userdata('Role') == 'Manager'): ?>
                        <td>
	                        <span class="button-checkbox">
						        <button type="button" class="btn" data-color="success" data-id="<?php echo $value["id"]; ?>">เปิดใช้งาน</button>
						        <input type="checkbox" class="hidden" <?php echo $checked; ?> />
						        <h6 class="media-heading">สถานะ: <span style="font-weight: 100; font-style:italic"><?php echo $value["status"]; ?></span></h6>
						    </span>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; ?>
                    
                 </tbody>
           </table>
           </form>
     </div>
</div>




<script type="text/javascript">
		var url;
		
		function edit(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','แก้ไขข้อมูล');
				$('#fm').form('load',row);
				url = '<?php echo base_url(); ?>budget_status/update/'+row.id;
			}
		}
		function save(){
			$('#fm').form('submit',{
				url: url,
				success: function(result){
					var result = eval('('+result+')');
					if (result.success){
						location.reload();
					} else {
						$.messager.show({
							title: 'Error',
							msg: result.msg
						});
					}
				}
			});
		}
	
$(function () {
    $('.button-checkbox').each(function () {

        // Settings
        var $widget = $(this),
            $button = $widget.find('button'),
            $checkbox = $widget.find('input:checkbox'),
            color = $button.data('color'),
            settings = {
                on: {
                    icon: 'glyphicon icon-check'
                },
                off: {
                    icon: 'glyphicon icon-check-empty'
                }
            };

        // Event Handlers
        $button.on('click', function () {
            $checkbox.prop('checked', !$checkbox.is(':checked'));
            $checkbox.triggerHandler('change');
            updateDisplay();
            
            var id = $(this).data("id");
			if (id){
				url = '<?php echo base_url(); ?>budget_status/update/'+ id + '/' + $(this).data("state");
				save();
			}
        });
        $checkbox.on('change', function () {
            updateDisplay();
        });

        // Actions
        function updateDisplay() {
            var isChecked = $checkbox.is(':checked');

            // Set the button's state
            $button.data('state', (isChecked) ? "on" : "off");

            // Set the button's icon
            $button.find('.state-icon')
                .removeClass()
                .addClass('state-icon ' + settings[$button.data('state')].icon);

            // Update the button's color
            if (isChecked) {
                $button
                    .removeClass('btn-default')
                    .addClass('btn-' + color + ' active');
              //  alert('ON');
            }
            else {
                $button
                    .removeClass('btn-' + color + ' active')
                    .addClass('btn-default');
               //  alert('OFF');
            }
        }

        // Initialization
        function init() {

            updateDisplay();

            // Inject the icon if applicable
            if ($button.find('.state-icon').length == 0) {
                $button.prepend('<i class="state-icon ' + settings[$button.data('state')].icon + '"></i> ');
            }
        }
        init();
    });
});	
	
	
	</script>