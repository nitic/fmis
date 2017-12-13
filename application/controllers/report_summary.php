<?php

class Report_Summary extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->helper('myfunction');
        $this->load->model('report_mgt_model');
        $this->load->model('mgt_product_model');
        $this->load->model('mgt_plans_model');
        $this->load->model('mgt_costs_model');
        $this->load->model('disbursement_model');
        $this->load->model('approve_model');
		$this->load->helper('general');
		$this->load->helper('menu');
        $this->load->library("mpdf");
        
        Accesscontrol_helper::is_logged_in();
	}
	
	public function index()
	{
		$data["title"] = "สรุปภาพรวมการเบิกจ่ายงบประมาณทั้งหมด";
		$data["path"] = array("งานการเงิน","รายงาน","สรุปภาพรวมการเบิกจ่ายงบประมาณทั้งหมด");
		$data["submenu"] = Finance_menu(3);
        
        $where_start_date = '';
        $where_end_date = '';
        
         if(!empty($_POST['start_date']) && !empty($_POST['end_date'])){
                $display_date = " (ระหว่างวันที่ ".$_POST['start_date']." - ".$_POST['end_date'].")";
                $where_start_date = formatDateToMySql($_POST['start_date']);
                $where_end_date = formatDateToMySql($_POST['end_date']);
                
                //pdf
                $this->session->set_userdata('pdf_start_date', $where_start_date);
                $this->session->set_userdata('pdf_end_date', $where_end_date);
                $this->session->set_userdata('pdf_date', $display_date);
            }
         else
            {
            	$display_date = "";
                
                //pdf
                $this->session->set_userdata('pdf_date', " (ทั้งปีงบประมาณ)");
                $this->session->set_userdata('pdf_start_date', '');
                $this->session->set_userdata('pdf_end_date', '');
            }
        
       

        $where_plans = isset($_POST['ccplan']) ? mysql_real_escape_string($_POST['ccplan']) : '0';
        $where_product = isset($_POST['ccproduct']) ? mysql_real_escape_string($_POST['ccproduct']) : '0';
        
        $html = $this->create_tabledata($where_plans, $where_product, $where_start_date, $where_end_date);
        $data["table_data"] = $html;
		$this->template->load('template', 'report/report_summary_view', $data);
         
	}
    
     public function get(){
      
        $budget_id = $this->session->userdata('budget_year_id');
       // $data = $this->report_mgt_model->plans_level($budget_id, '40' , '41');
        
         $start_date = '2015-01-01';
         $end_date = '2015-09-01';
        
      //  $data = $this->disbursement_model->costs_lists_paymented_level($budget_id, 49, 2, 5, 26, $start_date, $end_date);
      //  echo $data[0]["payment"];
        
      //  $data = $this->approve_model->costs_lists_approve_only_level($budget_id, 41, 2, 5, 22, $start_date, $end_date);
     //   $data = $this->approve_model->plans_approve_only_level($budget_id, 43, $start_date, $end_date);
      //  echo  $data->result_object()[0]->amount;
       
        dump($data);
	    $this->output->enable_profiler(TRUE);
       
    }
    
    public function debug(){
        $data = $this->disbursement_model->display_costs_lists_level('40', '41', '5');
        
      //  $data = $this->mgt_costs_model->mgt_costslists_budget('40', '5');
        
      //   $data = $this->approve_model->amount_approve_only(99);
       //   $data = $this->mgt_costs_model->mgt_costslists_budget('43', '4');
       // $data = $this->disbursement_model->display_plans_level('12', '', '');
        dump($data);
	    $this->output->enable_profiler(TRUE);
    }
    

    public function create_tabledata($mgt_plans_id, $mgt_product_id, $start_date, $end_date){
    
         $budget_id = $this->session->userdata('budget_year_id');
      
         $plans_data = $this->report_mgt_model->plans_level($budget_id, $mgt_plans_id);
         $product_data = $this->report_mgt_model->product_level($budget_id, $mgt_product_id);
         $costs_main_data = $this->report_mgt_model->costs_main_level($budget_id);
         $costs_type_data = $this->report_mgt_model->costs_type_level($budget_id);
         $costs_lists_data = $this->report_mgt_model->costs_lists_level($budget_id);

         $html = "";
         
         // level 1 Plans
         foreach ($plans_data as $level1) {
                 
                 //level 1 Plans disbursement
                 $plans_disbursement = $this->disbursement_model->plan_paymented_level($budget_id, $level1["plan_id"], $start_date, $end_date);
                 $plans_budget_disbursement_amount = $level1["plan_amount"] - $plans_disbursement[0]["payment"];
                 $loss_disbursement_color = ($plans_budget_disbursement_amount < 0)? "red":"black";
                 
                 //level 1 Plans approve
                 $plans_approve_only = $this->approve_model->plans_approve_only_level($budget_id, $level1["plan_id"], $start_date, $end_date);
                 $plans_budget_approve_amount = $plans_budget_disbursement_amount - $plans_approve_only->result_object()[0]->amount;
                 $loss_approve_color = ($plans_budget_approve_amount < 0)? "red":"black";
                 
                  //Display level 1 Plans
                 $html .= '<tr class="datagrid-body" style="height:30px;background-color:#D3D9DF">';
                 $html .= '<td class="plan-level"><div style="padding:0 5px 0 3px;overflow:hidden;line-height: 18px;font-weight:900;">'.$level1["plan_name"].'</div></td>';
                 $html .= '<td><div class="datagrid-cell" style="text-align:right;font-weight:700;">'.number_format($level1["plan_amount"],2).'</div></td>';
                 $html .= '<td><div class="datagrid-cell" style="text-align:right;font-weight:700;">'.number_format($plans_disbursement[0]["payment"],2).'</div></td>';
                 $html .= '<td><div class="datagrid-cell" style="text-align:right;font-weight:700;color:'.$loss_disbursement_color.'">'.number_format($plans_budget_disbursement_amount,2).'</div></td>';
                 $html .= '<td><div class="datagrid-cell" style="text-align:right;font-weight:700;">'.number_format($plans_approve_only->result_object()[0]->amount,2).'</div></td>';
                 $html .= '<td><div class="datagrid-cell" style="text-align:right;font-weight:700;;color:'.$loss_approve_color.'">'.number_format($plans_budget_approve_amount,2).'</div></td>';
                 $html .= "</tr>";
                 
                 
                 // level 2 Product
                 foreach ($product_data as $level2) {
                         if($level1["plan_id"] === $level2["mgt_plans_id"]){
                              
                             //level 2 Product disbursement
                             $product_disbursement = $this->disbursement_model->product_paymented_level($budget_id, $level2["product_id"], $start_date, $end_date);
                             $product_budget_disbursement_amount = $level2["product_amount"] - $product_disbursement[0]["payment"];
                             $loss_disbursement_color = ($product_budget_disbursement_amount < 0)? "red":"black";
                             
                             //level 2 Product approve
                             $product_approve_only = $this->approve_model->product_approve_only_level($budget_id, $level2["product_id"], $start_date, $end_date);
                             $product_budget_approve_amount = $product_budget_disbursement_amount - $product_approve_only->result_object()[0]->amount;
                             $loss_approve_color = ($product_budget_approve_amount < 0)? "red":"black";
                             
                             //Display level 2 Product
                             $html .= '<tr class="datagrid-body" style="height:30px;background-color:#E1E1D6">';
                             $html .= '<td class="product-level"><div style="padding:0 5px 0 20px;overflow:hidden;line-height: 18px;font-weight:900;">'.$level2["product_name"].'</div></td>';
                             $html .= '<td><div class="datagrid-cell" style="text-align:right">'.number_format($level2["product_amount"],2).'</div></td>';
                             $html .= '<td><div class="datagrid-cell" style="text-align:right">'.number_format($product_disbursement[0]["payment"],2).'</div></td>';
                             $html .= '<td><div class="datagrid-cell" style="text-align:right;color:'.$loss_disbursement_color.'">'.number_format($product_budget_disbursement_amount,2).'</div></td>';
                             $html .= '<td><div class="datagrid-cell" style="text-align:right">'.number_format($product_approve_only->result_object()[0]->amount,2).'</div></td>';
                             $html .= '<td><div class="datagrid-cell" style="text-align:right;color:'.$loss_approve_color.'">'.number_format($product_budget_approve_amount,2).'</div></td>';
                             $html .= "</tr>";
                             
                              
                              // level 3 CostsMain
                              foreach ($costs_main_data as $level3) { 
                                      if($level2["product_id"] === $level3["mgt_product_id"]){
                                          
                                            //level 3 CostsMain disbursement
                                            $CostsMain_disbursement = $this->disbursement_model->costs_main_paymented_level($budget_id, $level2["product_id"], $level3["costs_id"], $start_date, $end_date);
                                            $CostsMain_budget_disbursement_amount = $level3["cost_main_amount"] - $CostsMain_disbursement[0]["payment"];
                                            $loss_disbursement_color = ($CostsMain_budget_disbursement_amount < 0)? "red":"black";
                                            
                                            //level 3 CostsMain approve
                                            $CostsMain_approve_only = $this->approve_model->costs_main_approve_only_level($budget_id, $level2["product_id"], $level3["costs_id"], $start_date, $end_date);
                                            $CostsMain_budget_approve_amount = $CostsMain_budget_disbursement_amount - $CostsMain_approve_only->result_object()[0]->amount;
                                            $loss_approve_color = ($CostsMain_budget_approve_amount < 0)? "red":"black";
                                            
                                            //Display level 3 CostsMain
                                            $html .= '<tr class="datagrid-body" style="height:25px;background-color:#F1EFE2">';
                                            $html .= '<td class="cost-level"><div style="padding:0 5px 0 45px;overflow:hidden;line-height: 18px;font-weight:900;">'.$level3["cost_main_name"].'</div></td>';
                                            $html .= '<td><div class="datagrid-cell" style="text-align:right">'.number_format($level3["cost_main_amount"],2).'</div></td>';
                                            $html .= '<td><div class="datagrid-cell" style="text-align:right">'.number_format($CostsMain_disbursement[0]["payment"],2).'</div></td>';
                                            $html .= '<td><div class="datagrid-cell" style="text-align:right;color:'.$loss_disbursement_color.'">'.number_format($CostsMain_budget_disbursement_amount,2).'</div></td>';
                                            $html .= '<td><div class="datagrid-cell" style="text-align:right">'.number_format($CostsMain_approve_only->result_object()[0]->amount,2).'</div></td>';
                                            $html .= '<td><div class="datagrid-cell" style="text-align:right;color:'.$loss_approve_color.'">'.number_format($CostsMain_budget_approve_amount,2).'</div></td>';
                                            $html .= "</tr>";
                                             
                                            
                                              // level 4 CostsType
                                             foreach ($costs_type_data as $level4) { 
                                                    if($level3["mgt_product_id"] === $level4["mgt_product_id"] && $level3["costs_id"] === $level4["costs_main_id"]){
                                                            
                                                            //level 4 CostsType disbursement
                                                            $CostsType_disbursement = $this->disbursement_model->costs_type_paymented_level($budget_id, $level3["mgt_product_id"], $level3["costs_id"], $level4["costs_type_id"], $start_date, $end_date);
                                                            $CostsType_budget_disbursement_amount = $level4["cost_type_amount"] - $CostsType_disbursement[0]["payment"];
                                                            $loss_disbursement_color = ($CostsType_budget_disbursement_amount < 0)? "red":"black";
                                                            
                                                            //level 4 CostsType approve
                                                            $CostsType_approve_only = $this->approve_model->costs_type_approve_only_level($budget_id, $level3["mgt_product_id"], $level3["costs_id"], $level4["costs_type_id"], $start_date, $end_date);
                                                            $CostsType_budget_approve_amount = $CostsType_budget_disbursement_amount - $CostsType_approve_only->result_object()[0]->amount;
                                                            $loss_approve_color = ($CostsType_budget_approve_amount < 0)? "red":"black";
                                                            
                                                            //Display level 4 CostsType
                                                            $html .= '<tr class="datagrid-body" style="height:25px;background-color:#f5f5f5">';
                                                            $html .= '<td class="cost-type-level"><div style="padding:0 5px 0 60px;overflow:hidden;line-height: 18px;font-size: 12px;font-weight:700;">- '.$level4["cost_type_name"].'</div></td>';
                                                            $html .= '<td><div class="datagrid-cell" style="text-align:right">'.number_format($level4["cost_type_amount"],2).'</div></td>';
                                                            $html .= '<td><div class="datagrid-cell" style="text-align:right">'.number_format($CostsType_disbursement[0]["payment"],2).'</div></td>';
                                                            $html .= '<td><div class="datagrid-cell" style="text-align:right;color:'.$loss_disbursement_color.'">'.number_format($CostsType_budget_disbursement_amount,2).'</div></td>';
                                                            $html .= '<td><div class="datagrid-cell" style="text-align:right">'.number_format($CostsType_approve_only->result_object()[0]->amount,2).'</div></td>';
                                                            $html .= '<td><div class="datagrid-cell" style="text-align:right;color:'.$loss_approve_color.'">'.number_format($CostsType_budget_approve_amount,2).'</div></td>';
                                                            $html .= "</tr>";
                                                            
                                                            
                                                             // level 5 Costslists
                                                                foreach ($costs_lists_data as $level5) { 
                                                                        if($level4["mgt_product_id"] === $level5["mgt_product_id"] && $level4["costs_main_id"] === $level5["costs_main_id"] && $level4["costs_type_id"] === $level5["costs_type_id"]){
                                                                                
                                                                                //level 5 CostsLists disbursement
                                                                                $CostsLists_disbursement = $this->disbursement_model->costs_lists_paymented_level($budget_id, $level4["mgt_product_id"], $level4["costs_main_id"], $level4["costs_type_id"], $level5["costs_lists_id"], $start_date, $end_date);
                                                                                $CostsLists_budget_disbursement_amount = $level5["costs_lists_amount"] - $CostsLists_disbursement[0]["payment"];
                                                                                $loss_disbursement_color = ($CostsLists_budget_disbursement_amount < 0)? "red":"black";
                                                                                
                                                                                //level 5 CostsLists approve
                                                                                $CostsLists_approve_only = $this->approve_model->costs_lists_approve_only_level($budget_id, $level4["mgt_product_id"], $level4["costs_main_id"], $level4["costs_type_id"], $level5["costs_lists_id"], $start_date, $end_date);
                                                                                $CostsLists_budget_approve_amount = $CostsLists_budget_disbursement_amount - $CostsLists_approve_only->result_object()[0]->amount;
                                                                                $loss_approve_color = ($CostsLists_budget_approve_amount < 0)? "red":"black";
                                                                                
                                                                                //Display level 4 CostsType
                                                                                $html .= '<tr class="datagrid-body" style="height:25px;">';
                                                                                $html .= '<td class="cost-lists-level"><div style="padding:0 5px 0 80px;overflow:hidden;line-height: 18px;font-size: 12px;">- '.$level5["costs_lists_name"].'</div></td>';
                                                                                $html .= '<td><div class="datagrid-cell" style="text-align:right">'.number_format($level5["costs_lists_amount"],2).'</div></td>';
                                                                                $html .= '<td><div class="datagrid-cell" style="text-align:right">'.number_format($CostsLists_disbursement[0]["payment"],2).'</div></td>';
                                                                                $html .= '<td><div class="datagrid-cell" style="text-align:right;color:'.$loss_disbursement_color.'">'.number_format($CostsLists_budget_disbursement_amount,2).'</div></td>';
                                                                                $html .= '<td><div class="datagrid-cell" style="text-align:right">'.number_format($CostsLists_approve_only->result_object()[0]->amount,2).'</div></td>';
                                                                                $html .= '<td><div class="datagrid-cell" style="text-align:right;color:'.$loss_approve_color.'">'.number_format($CostsLists_budget_approve_amount,2).'</div></td>';
                                                                                $html .= "</tr>";
                                                                                

                                                                            }//end if 5
                                                                    }// end level 5
                                                            
                                                        }//end if 4
                                                }// end level 4
                                                
                                        }//end if 3
                                }// end level 3
                              
                         }//end if 2
                 } // end level 2
                  
         }// end level 1

       
        return $html;
        

    }
    
    
    public function pdf()
    {
        
        $where_plans = $this->uri->segment(3);
        $where_product = $this->uri->segment(4);
        $where_start_date = $this->session->userdata('pdf_start_date');
        $where_end_date = $this->session->userdata('pdf_end_date');
        
      //  echo $where_start_date;
        
     //   $html = $this->create_tabledata($where_plans, $where_product, $where_start_date, $where_end_date);
       
        $html = '<div style="text-align:center"><h3>สรุปภาพรวมการเบิกจ่ายงบประมาณโดยจำแนกตามแผนงาน '.$this->session->userdata('budget_year_title').'</3></div>';
        $html .= "<h5>ช่วงระยะวันเดือนปีการเบิกจ่าย : ".$this->session->userdata('pdf_date')."</h5>";
        $html .= "<table>";
        $html .= "<thead><tr>";
        $html .= "<th>รายการรายจ่าย</th>";
        $html .= "<th>ประมาณการ</th>";
        $html .= "<th>จ่ายจริง</th>";
        $html .= "<th>คงเหลือ</th>";
        $html .= "<th>ขออนุมัติแล้วรอส่งเบิกจ่าย</th>";
        $html .= "<th>คงเหลือ</th>";
        $html .= "</tr></thead>";
        $html .= "<tbody>";
        $html .= $this->create_tabledata($where_plans, $where_product, $where_start_date, $where_end_date);
        $html .= "</tbody>";
		$html .= "</table>";			
        
        $this->mpdf = new mPDF('utf-8', 'A4-L');
        $stylesheet = file_get_contents(base_url('assets/css/report_pdf.css'));
        $this->mpdf->SetAutoFont();

        $this->mpdf->mirrorMargins = 1;	// Use different Odd/Even headers and footers and mirror margins

        $this->mpdf->defaultheaderfontsize = 8;	/* in pts */
        $this->mpdf->defaultheaderfontstyle = '';	/* blank, B, I, or BI */
        $this->mpdf->defaultheaderline = 0; 	/* 1 to include line below header/above footer */

        $this->mpdf->defaultfooterfontsize = 8;	/* in pts */
        $this->mpdf->defaultfooterfontstyle = '';	/* blank, B, I, or BI */
        $this->mpdf->defaultfooterline = 0; 	/* 1 to include line below header/above footer */	


        $this->mpdf->SetHeader('{DATE j-m-Y}|{PAGENO}/{nb}| TTM-FMIS Report');
        $this->mpdf->SetFooter('{PAGENO}/{nb}');
        
        $this->mpdf->WriteHTML($stylesheet,1);
        $this->mpdf->WriteHTML($html);
        $this->mpdf->Output();
      
    }
    
    
}
