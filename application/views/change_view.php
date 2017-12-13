<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sample codeigniter template</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<!-- Apple devices fullscreen -->
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<!-- Apple devices fullscreen -->
	<meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />
	
	<!-- Favicon -->
	<link rel="shortcut icon" href="<?php echo base_url('assets/img/favicon.ico');?>" />

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
 
	<!-- jQuery -->
	<script src="<?php echo base_url('assets/js/jquery.min.js');?>"></script>
	
	
	<!-- MyFunction -->
	<script src="<?php echo base_url('assets/js/MyFunction.js');?>"></script>
	<!-- slimScroll remove by kengi -->
	
	<!-- Bootstrap -->
	<script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>

	
</head>

<body class='locked'>
	<div class="wrapper">
		<div class="pull-left">
			<img src="<?php echo base_url('assets/img/logo-big.png');?>" style="margin-left: 100px;" 
			  alt="" width="59" height="49">
			
		</div>
		<div class="right">
			<div class="upper">
				<h2><?php echo $this->session->userdata('UserName'); ?></h2>
				<span><?php echo $this->session->userdata('Role'); ?></span>
			</div>
			<?php echo form_open('welcome/comeback'); ?>
				<select name="budget_year">
					<?php foreach ($budget as $key => $value): ?>	
					   <option value="<?php echo $value["id"]; ?>"><?php echo $value["title"]; ?></option>
					<?php endforeach; ?>   
				</select>
				<div>
					<input type="submit" value="Save changes" class='btn btn-inverse'>
				</div>
			</form>
		</div>
	</div>

</body>

</html>