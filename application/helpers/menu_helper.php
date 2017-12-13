<?php

function Main_menu($id)
{
	switch ($id) {
		case '1': $submenu = array("dashboard" => "1.กราฟสรุปผลรวม","report_summary" => "2.สรุปผลภาพรวมการเบิกจ่าย");
		//case '1': $submenu = array("dashboard" => "สรุปผลภาพรวมการเบิกจ่าย","report_x" => "รายงานเจำแนกตามแผน", "report_xx" => "รายงานจำแนกตามงบรายจ่าย", "report_xxx" => "รายงานจำแนกตามค่าใช้จ่าย");
		   break;
	}
	
	return $submenu;
}


function Plans_menu($id)
{
	switch ($id) {
		case '1': $submenu = array("budget_status" => "1.เปิด-ปิดแหล่งงบประมาณ", "budget_main" => "2.จัดการแหล่งงบประมาณ");
		   break;
		case '2': $submenu = array("mgt_plans" => "1.จัดสรรงบประมาณระดับแผนงาน", "mgt_product" => "2.จัดสรรงบประมาณระดับผลผลิต", "mgt_costs" => "3.จัดสรรงบประมาณระดับรายจ่าย");
		   break;
		case '3': $submenu = array("report_planners" => "สรุปข้อมูลการจัดสรรงบประมาณ");
		   break;
	}
	
	return $submenu;
}

function Finance_menu($id)
{
	switch ($id) {
		case '1': $submenu = array("approve" => "1.เอกสารอนุมัติทั้งหมด", "report_approve/nopayment" => "2.เอกสารอนุมัติยังไม่เบิกจ่าย" ,"report_approve/paymented" => "3.ประวัติเอกสารอนุมัติเบิกจ่ายแล้ว");
		   break;
		case '2': $submenu = array("disbursement/form" => "1.เพิ่มข้อมูลเบิกจ่าย","disbursement" => "2.ประวัติการเบิกจ่ายทั้งหมด");
		   break;
		case '3': $submenu = array("report_summary" => "1.สรุปภาพรวมการเบิกจ่ายทั้งหมด", "report_plans_costs" => "2.รายละเอียดเบิกจ่ายแยกตามแผน", "mail" => "3.รายงานประจำเดือนทางอีเมล์");
		   break;
	}
	
	return $submenu;
}

function Mananger_menu($id)
{
	switch ($id) {
		case '1': $submenu = array("budget_status" => "1.ขออนุมัติใช้งบประมาณ","report_summary" => "2.สรุปภาพรวมการเบิกจ่ายงบประมาณ");
		   break;
	}
	
	return $submenu;
}


function Admin_menu($id)
{
	switch ($id) {
		case '1': $submenu = array("budget" => "แหล่งงบประมาณ","budget_main" => "ปีงบประมาณ");
		   break;
		case '2': $submenu = array("plans" => "ข้อมูลรายการแผนงาน","product" => "ข้อมูลรายการผลผลิต","project" => "ข้อมูลรายการโครงการ","activity" => "ข้อมูลรายการกิจกรรม");
		   break;
		case '3': $submenu = array("costs" => "ข้อมูลงบรายจ่าย","costs_group" => "ข้อมูลหมวดรายจ่าย","costs_type" => "ข้อมูลประเภทรายจ่าย","costs_lists" => "ข้อมูลรายการรายจ่าย","costs_sublist" => "ข้อมูลรายการรายจ่ายย่อย");
		   break;
		case '4': $submenu = array("faculty" => "ข้อมูลคณะ","department" => "ข้อมูลภาควิชา","division" => "ข้อมูลหน่วยงาน");
		   break;
		case '5': $submenu = array("payer" => "ข้อมูลผู้รับเงิน");
		   break;
		default: $submenu = array("budget" => "แหล่งงบประมาณ","budget_main" => "ปีงบประมาณ");
		   break;
	}
	
	return $submenu;
}


