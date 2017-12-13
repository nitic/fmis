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

 <style type="text/css">
      body {
        padding-top: 80px;
		    height:360px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }

      @media (max-width: 980px) {
        /* Enable use of floated navbar text */
        .navbar-text.pull-right {
          float: none;
          padding-left: 5px;
          padding-right: 5px;
        }
      }
    </style>	
</head>

<body>
	 <div class="navbar-fixed-top">
        <div class="container-fluid" style="background:#368ee0;padding:5px 0 5px 10px">
          <table border="0">
            <tr>
                <td>
                    <img src="<?php echo base_url('assets/img/logo-big.png');?>" alt="" class='retina-ready' >
                </td>
                <td style="padding-left:10px">
                    <span style="font-size:14pt;color:#fff">ระบบบริหารงบประมาณเงินรายได้ คณะการแพทย์แผนไทย</span>
                    <br />
                    <span style="font-size:10pt;color:#fff">Version 1.3.2</span>
                </td>
            </tr>
          </table>
         
          </div><!--/.nav-collapse -->
      </div>	

     <div  class="container-fluid span12">
      <div class="row-fluid">
        
		<div class="span3">
          <div class="sidebar-nav">
            
			<div class="login-body">
			    <h4 style="text-align:center"><i class="icon-signin"></i> Login with <i style="font-size:10pt"> PSU Passport</i></h4>
				<?php echo form_open('welcome/login'); ?>
					<div class="email">
						<input type="text" name='usr' placeholder="Username" class='input-block-level'>
					</div>
					<div class="pw">
						<input type="password" name="pwd" placeholder="Password" class='input-block-level'>
					</div>
					<div class="submit">
						<select name="budget_year" >
						<?php foreach ($budget as $key => $value): ?>	
						   <option value="<?php echo $value["id"]; ?>"><?php echo $value["title"]; ?></option>
						<?php endforeach; ?>   
						</select>
						
					</div>
					
				<div class="forget" style="text-align: left">
					<input type="submit" value="เข้าสู่ระบบ" class='btn btn-large btn-primary'>
				</div>
				</form>
                  
				
		   </div>

          </div><!--/nav -->
        </div><!--/span3-->
		
        <div class="span6">
          <div class="well" style="height:350px">
            <h4><i class="icon-comments"> </i>ประกาศ</h4>
            <p>
				<ul>
				  <li>[22/12/2016] สามารถดูรายงานประจำเดือนย้อนหลังได้ <img src="<?php echo base_url('assets/img/new.gif');?>"></li>
          <li>[12/02/2016] สามารถใส่หมายเหตุในเอกสารเบิกจ่ายได้ เช่น คำสั่ง 1432/5 </li>
          <li>[11/02/2016] สามารถค้นหาเลขที่ มอ. ในเอกสารเบิกจ่าย</li>
					<li>[07/10/2015] สามารถค้นหาเลขที่ มอ. ในเอกสารอนุมัติ</li>
					<li>[14/09/2015] ปรับปรุงหน้ารายงานใหม่ "สรุปภาพรวมการเบิกจ่ายงบประมาณแยกตามแผน"</li>
					<li>[04/09/2015] ปรับปรุงระบบค้นหาใหม่</li>
				</ul>
		    </p>
			
			 <h4><i class="icon-edit"> </i>รายการที่กำลังดำเนินการ Coming Soon...</h4>
            <p>
				<ul>
				  <li>ปรับปรุงระบบให้สามารถนำเข้าข้อมูลสู่ระบบการเงิน fmisbudget.psu.ac.th ของมหาวิทยาลัยได้</li>
					<li>ระบบสามารถจัดการเงินประมาณแผ่นดินได้</li>
					<li>ระบบสามารถจัดการเงินในส่วนที่เป็นรายได้ได้</li>
					<li>แสดงยอดคงเหลือทั้งหมด แสดงยอดยกมา ในรายงานการเบิกจ่ายแสดงตามแผน</li>
          <li>งานแผน->มีหน้าทำงานสามารถโยกเงินงบประมาณที่จัดสรรได้</li>
					<li>รายงานแบบไตรมาส รายปี</li>
				</ul>
		    </p>
			
        </div>
		<div >
			    <span>
				 &copy; ลิขสิทธิ์ 2013-2017 งานเทคโนโลยีสารสนเทศ คณะการแพทย์แผนไทย ม.อ.
				  <a href="<?php echo base_url('assets/update_log.txt');?>" target="_blank"> [Change logs]
					</a>
					<br/>&nbsp;&nbsp;&nbsp; ระบบนี้จะสามารถแสดงผลได้ดีที่ความละเอียดหน้าจอ 1280 x 800 พิกเซล ขึ้นไป
				</div>
				</span>
      </div><!--/span9-->
	  
  </div>
  </div>
</body>

</html>