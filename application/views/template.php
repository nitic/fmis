<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ระบบบริหารงบประมาณเงินรายได้ คณะการแพทย์แผนไทย มอ.</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<!-- Apple devices fullscreen -->
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<!-- Apple devices fullscreen -->
	<meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />
	
	<!-- Favicon -->
	<link rel="shortcut icon" href="<?php echo base_url('assets/img/favicon.ico');?>" />

    <!-- === CSS === -->
    
	<!-- Bootstrap -->
	<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css');?>">
	<!-- Bootstrap responsive -->
	<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap-responsive.min.css');?>">
	
	<!-- jQuery UI remove by kengi -->
	
	<!-- Theme CSS -->
	<link rel="stylesheet" href="<?php echo base_url('assets/css/style.css');?>">
	
	<!-- Color CSS -->
	<link rel="stylesheet" href="<?php echo base_url('assets/css/themes.css');?>">
    
    <!-- MyStyle CSS -->
	<link rel="stylesheet" href="<?php echo base_url('assets/css/MyStyle.css');?>">
    
    <!-- jquery treegrid CSS -->
	<link rel="stylesheet" href="<?php echo base_url('assets/css/jquery.treegrid.css');?>">
 
   <!--Autocomplete Js By ThaiCreate.com -->
   <link rel="stylesheet" href="<?php echo base_url('assets/css/autocomplete.css');?>">
	
	
     <!-- === JS === -->
 
	<!-- jQuery -->
	<script src="<?php echo base_url('assets/js/jquery.min.js');?>"></script>
	
	<!-- jQuery UI remove by kengi-->
	
	<!-- jQuery calculation -->
	<script src="<?php echo base_url('assets/js/jquery.calculation.min.js');?>"></script>
	
	<!-- jQuery treegrid -->
	<script src="<?php echo base_url('assets/js/jquery.treegrid.js');?>"></script>
	
	<!-- jQuery easybar -->
	<script src="<?php echo base_url('assets/js/jquery.progressbar.js');?>"></script>

    <!--javascript Number Format -->
	<script src="<?php echo base_url('assets/js/numeral.min.js');?>"></script>
	
	<!-- MyFunction -->
	<script src="<?php echo base_url('assets/js/MyFunction.js');?>"></script>
		
	<!-- Bootstrap -->
	<script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
	
	<!--Autocomplete Js By ThaiCreate.com -->
	<script src="<?php echo base_url('assets/js/autocomplete.js');?>"></script>
		
	<!-- Flot (Chart) -->
	<script src="<?php echo base_url('assets/js/plugins/flot/jquery.flot.min.js');?>"></script>
	<script src="<?php echo base_url('assets/js/plugins/flot/jquery.flot.bar.order.min.js');?>"></script>
	<script src="<?php echo base_url('assets/js/plugins/flot/jquery.flot.pie.min.js');?>"></script>
	<script src="<?php echo base_url('assets/js/plugins/flot/jquery.flot.resize.min.js');?>"></script>
	<script src="<?php echo base_url('assets/js/plugins/flot/jquery.flot.stack.js');?>"></script>
	

	
	
	<!-- Remove file list -->
	<!-- slimScroll remove by kengi -->	
	<!-- Bootbox remove by kengi -->
	<!-- Jquery forms remove by kengi -->	
	<!-- Validation remove by kengi -->	
	<!-- Theme framework eakroko remove by kengi-->
	<!-- Theme scripts remove by kengi
	<script src="<?php echo base_url('assets/js/application.min.js');?>></script> -->
	

    <!-- juery-easyui-->
	<script src="<?php echo base_url('assets/jquery-easyui/jquery.easyui.min.js');?>"></script>
	<script src="<?php echo base_url('assets/jquery-easyui/locale/easyui-lang-th.js');?>"></script>
	<link href="<?php echo base_url('assets/jquery-easyui/themes/metro-blue/easyui.css');?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url('assets/jquery-easyui/themes/icon.css');?>" rel="stylesheet" type="text/css" />
	
    <script type="text/javascript">

        function check_balance() {
            var total
            var jqsonurl = '<?php echo base_url(); ?>' + 'dashboard/get_balance/' + <?php echo $this->session->userdata('budget_year_id') ?>;
            $.getJSON(jqsonurl, function (data) {
                $.each(data, function (index, val) {
                        total = numeral(val.budget-val.payment).format('0,0.00');
                        $('#status_balance').html(total);
                    });
                });
        }
    </script>

</head>
<body onload="check_balance();">
	
<?php
//print_r($path);

?>

<?php echo $this->load->view('template/menu'); ?>

<div class="container-fluid" id="content">
	  <?php echo $this->load->view('template/left'); ?>	
		
		<div id="main">
			<div class="container-fluid">
				<div class="page-header">
					<div class="pull-left">
						<h1><?php echo $title;  ?></h1>
					</div>
					<div class="pull-right">
					 
					  <!--	<ul class="minitiles">
							<li class='teal'>
								<a href="#"><i class="icon-inbox"></i></a>
							</li>
							<li class='red'>
								<a href="#"><i class="icon-cogs"></i></a>
							</li>
							<li class='lime'>
								<a href="#"><i class="icon-globe"></i></a>
							</li>
						</ul> -->
						<ul class="stats">
						 <!--	<li class='orange'>
								<i class="icon-shopping-cart"></i>
								<div class="details">
									<span class="big">175</span>
									<span>เรื่องขออนุมัติ</span>
								</div>
							</li> -->
							<li class='green'>
								<i class="icon-money"></i>
								<div class="details" style="width:300px;">
									<span class="big">เงินคงเหลือสุทธิ <a href="#" style="color:#fff;" id="status_balance"></a> บาท</span>
                                    
									<span>แหล่งงบ: <?php echo $this->session->userdata('budget_year_title')." (".number_format($this->session->userdata('budget_year_amount'),2)." บ.)"; ?></span>
								</div>
							</li>
							<?php
							  $days = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
							  $colors = array('red', 'orange', 'pink' , 'lime', 'lightred', 'teal' , 'magenta');
							?>
							<li class='<?php echo $colors[date("w")]; ?>'>
								<i class="icon-calendar"></i>
								<div class="details">
									<span class="big"><?php echo date("F j,  Y"); ?></span>
									<span><?php echo $days[date("w")].date(', H:i:s A');?></span>
								</div>
							</li>
						</ul>
					</div>
				</div>
				<div class="breadcrumbs">
					<ul>
						<?php foreach($path as $key => $value): ?>
						<li>
							<?php
							   if($key == (sizeof($path)-1)){
							   	   echo '<a href="#">'.$value.'</a>';
							   }
							   else{
							   	   echo '<a href="#">'.$value.'</a>';
								   echo '<i class="icon-angle-right"></i>';
							   }
							?>
						</li>	
						<?php endforeach; ?>
						
					</ul>
					<div class="close-bread">
						<a href="#"><i class="icon-remove"></i></a>
					</div>
				</div>
				<div class="row-fluid">
					<div id="contents" class="span12">
							<?php echo $contents; ?>
					</div>
				</div>
			</div>
		</div>

</div>

</body>
</html>
