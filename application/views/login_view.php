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

     <!-- Icons -->
     <link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.min.css');?>">
     <link rel="stylesheet" href="<?php echo base_url('assets/css/simple-line-icons.css');?>">

    <!-- Main styles for this application -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/login_style.css');?>">




</head>

<body class="app flex-row align-items-center">
<div class="container">

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card-group mb-0">
            <div class="card p-4">
                <div class="card-body">
                    <h1>Login</h1>
                    <p class="text-muted">Sign In with PSU Passport</p>
                    <?php echo form_open('welcome/login'); ?>
                        <div class="input-group mb-3">
                                    <span class="input-group-addon"><i class="icon-user"></i>
                                    </span>
                            <input type="text" name='usr' class="form-control" placeholder="Username">
                        </div>
                        <div class="input-group mb-3">
                                    <span class="input-group-addon"><i class="icon-lock"></i>
                                    </span>
                            <input type="password" name="pwd" class="form-control" placeholder="Password">
                        </div>
                        <div class="input-group mb-4">
                                    <span class="input-group-addon"><i class="icon-pie-chart"></i>
                                    </span>
                                <select name="budget_year" style="width:100%" >
                                <?php foreach ($budget as $key => $value): ?>
                                <option value="<?php echo $value["id"]; ?>"><?php echo $value["title"]; ?></option>
                                <?php endforeach; ?>
                                </select>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <button type="submit" class="btn btn-primary px-4">Login</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
                <div class="card-body text-center">
                    <div>
                        <img class="mb-3" src="<?php echo base_url('assets/img/logo-psu.png');?>" style="width:70px"  >
                        <h5>ระบบบริหารเงินงบประมาณ</h5>
                        <p>คณะการแพทย์แผนไทย มหาวิทยาลัยสงขลานครินทร์  &copy; ลิขสิทธิ์ 2013-2017 งานเทคโนโลยีสารสนเทศ TTM-FMIS</p>
                        <a href="<?php echo base_url('assets/update_log.txt');?>" target="_blank">
                        <button type="button" class="btn btn-primary active mt-3">Version 1.3.2</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</body>

</html>
