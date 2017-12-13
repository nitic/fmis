<div id="navigation">
		<div class="container-fluid">
			<a href="#" id="brand">TTM-FMIS</a>
			<a href="#" class="toggle-nav" rel="tooltip" data-placement="bottom" title="Toggle navigation"><i class="icon-reorder"></i></a>
			<ul class='main-nav'>
				<li>
					<a href="<?php echo base_url();?>dashboard">
						<i class="icon-home"></i>
						<span>Dashboard</span>
					</a>
				</li>
				<li>
					<a href="#" data-toggle="dropdown" class='dropdown-toggle'>
						<i class="icon-edit"></i>
						<span>งานแผน</span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li>
							<a href="<?php echo base_url();?>budget_status">จัดการแหล่งเงินงบประมาณ</a>
						</li>
						<li>
							<a href="<?php echo base_url();?>mgt_plans">จัดสรรงบประมาณประจำปี</a>
						</li>
						<li>
							<a href="<?php echo base_url();?>report_planners">รายงาน</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="#" data-toggle="dropdown" class='dropdown-toggle'>
						<i class="icon-th-large"></i>
						<span>งานการเงิน</span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li>
							<a href="<?php echo base_url();?>approve">จัดการเอกสารอนุมัติ</a>
						</li>
						<li>
							<a href="<?php echo base_url();?>disbursement/form">เบิกจ่ายงบประมาณ</a>
						</li>
						<li>
							<a href="<?php echo base_url();?>report_summary">รายงาน</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="#" data-toggle="dropdown" class='dropdown-toggle'>
						<i class="icon-table"></i>
						<span>ผู้บริหาร</span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li>
							<a href="<?php echo base_url();?>budget_status">อนุมัติใช้งบประมาณ</a>
						</li>
						<li>
							<a href="<?php echo base_url();?>report_summary">รายงาน</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="#" data-toggle="dropdown" class='dropdown-toggle'>
						<i class="icon-th-large"></i>
						<span>ผู้ดูแลระบบ</span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li>
							<a href="<?php echo base_url();?>budget">ข้อมูลพื้นฐานแหล่งงบประมาณ</a>
						</li>
						<li>
							<a href="<?php echo base_url();?>plans">ข้อมูลพื้นฐานแผนงบประมาณ</a>
						</li>
						<li>
							<a href="<?php echo base_url();?>costs">ข้อมูลพื้นฐานงบประมาณรายจ่าย</a>
						</li>
						<li>
							<a href="<?php echo base_url();?>faculty">ข้อมูลพื้นฐานหน่วยงาน</a>
						</li>
						<li>
							<a href="<?php echo base_url();?>payer">ข้อมูลพื้นฐานผู้รับเงิน</a>
						</li>
					</ul>
				</li>
			</ul>
			<div class="user">
				<ul class="icon-nav">
					<li class="dropdown sett">
						<a href="#" class='dropdown-toggle' data-toggle="dropdown"><i class="icon-cog"></i></a>
						<ul class="dropdown-menu pull-right theme-settings">
							<li>
								<span>ผู้ใช้งาน</span>
								<div class="topbar-toggle">
									<a href="#" class='set-topbar-fixed'>จัดการผู้ใช้</a>
									<a href="#" class="set-topbar-default">สิทธิการใช้งาน</a>
								</div>
							</li>
							<li>
								<span>เกี่ยวกับระบบ</span>
								<div class="version-toggle">
									<a href="#" class='set-fixed'>ประวัติการเข้าใช้</a>
									<a href="#" class="set-fluid">สำรองข้อมูล</a>
								</div>
							</li>
							<!--
							<li>
								<span>Topbar</span>
								<div class="topbar-toggle">
									<a href="#" class='set-topbar-fixed'>Fixed</a>
									<a href="#" class="active set-topbar-default">Default</a>
								</div>
							</li>
							<li>
								<span>Sidebar</span>
								<div class="sidebar-toggle">
									<a href="#" class='set-sidebar-fixed'>Fixed</a>
									<a href="#" class="active set-sidebar-default">Default</a>
								</div>
							</li>
							-->
						</ul>
					</li>
				<!--	<li class='dropdown colo'>
						<a href="#" class='dropdown-toggle' data-toggle="dropdown"><i class="icon-tint"></i></a>
						<ul class="dropdown-menu pull-right theme-colors">
							<li class="subtitle">
								Predefined colors
							</li>
							<li>
								<span class='red'></span>
								<span class='orange'></span>
								<span class='green'></span>
								<span class="brown"></span>
								<span class="blue"></span>
								<span class='lime'></span>
								<span class="teal"></span>
								<span class="purple"></span>
								<span class="pink"></span>
								<span class="magenta"></span>
								<span class="grey"></span>
								<span class="darkblue"></span>
								<span class="lightred"></span>
								<span class="lightgrey"></span>
								<span class="satblue"></span>
								<span class="satgreen"></span>
							</li>
						</ul>
				</li>   -->
					<li>
						<a href="<?php echo base_url();?>welcome/change" class='lock-screen' rel='tooltip' title="เปลี่ยนปีงบประมาณ" data-placement="bottom"><i class="icon-signout"></i></a>
					</li> 
				</ul>
				<div class="dropdown">
					<a href="#" class='dropdown-toggle' data-toggle="dropdown">
						  <?php echo $this->session->userdata('UserName')." (".$this->session->userdata('Role').")"; ?>
						<!--  <img src="<?php echo base_url('assets/img/demo/user-avatar.jpg');?>" alt=""> -->
						  </a>
					<ul class="dropdown-menu pull-right">
						<li>
							<a href="#">แก้ไขข้อมูลส่วนตัว</a>
						</li>
						<li>
							<a href="#">ตั้งค่าบัญชีผู้ใช้</a>
						</li>
						<li>
							<a href="<?php echo base_url();?>welcome/logout">ออกจากระบบ</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
</div>

<script type="text/javascript">


$(document).ready(function(){
   
   $(".toggle-subnav").click(function (e) {
        e.preventDefault();
        var t = $(this);
        t.parents(".subnav").toggleClass("subnav-hidden").find(".subnav-menu").slideToggle("fast");
        t.find("i").toggleClass("icon-angle-down").toggleClass("icon-angle-right")
    });
   
   $(".toggle-nav").click(function (e) {
        e.preventDefault();
        $("#left").toggle().toggleClass("forced-hide");
        $("#left").is(":visible") ? $("#main").css("margin-left", $("#left").width()) : $("#main").css("margin-left", 0)
    });
    
});
</script>