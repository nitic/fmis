<?php

class Report_Manager extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->helper('myfunction');
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
		$data["title"] = "รายงานการเบิกรายจ่าย จำแนกตามแผนงาน";
		$data["path"] = array("งานการเงิน","รายงาน","รายงานการเบิกรายจ่ายจำแนกตามแผนงาน");
		$data["submenu"] = Finance_menu(3);
        
       
         if(!empty($_POST['start_date']) && !empty($_POST['end_date'])){
                $display_date = " (ระหว่างวันที่ ".$_POST['start_date']." - ".$_POST['end_date'].")";
                $start_date = formatDateToMySql($_POST['start_date']);
                $end_date = formatDateToMySql($_POST['end_date']);
                
                //pdf
                $this->session->set_userdata('pdf_start_date', $start_date);
                $this->session->set_userdata('pdf_end_date', $end_date);
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
        
        
        
        $html = $this->get_mgt_plan_level($start_date, $end_date);
        $data["treegrid"] = $html;
		$this->template->load('template', 'report/report_manager_view', $data);

	}
    
     public function get(){
      /*
        $budget_id = $this->session->userdata('budget_year_id');
        $data = $this->disbursement_model->display_plans_level($budget_id, '2014-10-01', '2014-10-30');
        dump($data);
	    $this->output->enable_profiler(TRUE);
        */
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
    
    //Level 1 Plans
    public function get_mgt_plan_level($start_date = '', $end_date = ''){
    
        $budget_id = $this->session->userdata('budget_year_id');
        
        $data = $this->disbursement_model->display_plans_level($budget_id, $start_date, $end_date);
        $html = "";
        foreach ($data as $key => $value) {
             $html .= '<tr class="teegrid-'.$value["id"].'">';
             $html .= '<td class="plan-level">'.$value["name"].'</td>';
             $html .= '<td class="plan-level">&nbsp;</td>';
             $html .= '<td class="plan-level">&nbsp;</td>';
             $html .= '<td class="plan-level">&nbsp;</td>';
             $html .= '<td class="plan-level">&nbsp;</td>';
             $html .= '<td class="plan-level">&nbsp;</td>';
             $html .= '</tr>';
             $html .= $this->get_mgt_product_level($value["id"]);
         }
        return $html;
    }
    
     //Level 2 Product
     public function get_mgt_product_level($mgt_plans_ID){
    
        $data = $this->disbursement_model->display_product_level($mgt_plans_ID);
        $html = "";
        foreach ($data as $key => $value) {
             $node_ID = $mgt_plans_ID.$value["id"];
             $html .= '<tr class="teegrid-'.$node_ID.' teegrid-parent-'.$mgt_plans_ID.'">';
             $html .= '<td class="product-level">'.$value["name"].'</td>';
             $html .= '<td class="product-level">&nbsp;</td>';
             $html .= '<td class="product-level">&nbsp;</td>';
             $html .= '<td class="product-level">&nbsp;</td>';
             $html .= '<td class="product-level">&nbsp;</td>';
             $html .= '<td class="product-level">&nbsp;</td>';
             $html .= '</tr>';
             $html .= $this->get_costs_level($mgt_plans_ID, $value["id"], $node_ID);
         }
        return $html;
    }
    
     //Level 3 costs
     public function get_costs_level($mgt_plans_ID, $mgt_product_ID, $parent_ID){
    
        $data = $this->disbursement_model->display_costs_level($mgt_plans_ID, $mgt_product_ID);
        $html = "";
        foreach ($data as $key => $value) {
             $node_ID = $parent_ID.$value["costs_id"];
             $html .= '<tr class="teegrid-'.$node_ID.' teegrid-parent-'.$parent_ID.'">';
             $html .= '<td class="cost-level">'.$value["name"].'</td>';
             $html .= '<td class="cost-level">&nbsp;</td>';
             $html .= '<td class="cost-level">&nbsp;</td>';
             $html .= '<td class="cost-level">&nbsp;</td>';
             $html .= '<td class="cost-level">&nbsp;</td>';
             $html .= '<td class="cost-level">&nbsp;</td>';
             $html .= '</tr>';
             $html .= $this->get_costsgroup_level($mgt_plans_ID, $mgt_product_ID, $value["costs_id"], $node_ID);
         }
        return $html;
    }
    
    //Level 4 costs group
    public function get_costsgroup_level($mgt_plans_ID, $mgt_product_ID, $costs_ID, $parent_ID){
    
        $data = $this->disbursement_model->display_costs_group_level($mgt_plans_ID, $mgt_product_ID, $costs_ID);
        $html = "";
        foreach ($data as $key => $value) {
             $node_ID = $parent_ID.$value["costs_group_id"];
             $html .= '<tr class="teegrid-'.$node_ID.' teegrid-parent-'.$parent_ID.'">';
             $html .= '<td class="cost-group-level">'.$value["name"].'</td>';
             $html .= '<td class="cost-group-level">&nbsp;</td>';
             $html .= '<td class="cost-group-level">&nbsp;</td>';
             $html .= '<td class="cost-group-level">&nbsp;</td>';
             $html .= '<td class="cost-group-level">&nbsp;</td>';
             $html .= '<td class="cost-group-level">&nbsp;</td>';
             $html .= '</tr>';
             $html .= $this->get_coststype_level($mgt_plans_ID, $mgt_product_ID, $value["costs_group_id"], $node_ID);
         }
        return $html;
    }
    
     //Level 5 costs type
     public function get_coststype_level($mgt_plans_ID, $mgt_product_ID, $costs_group_ID, $parent_ID){
     
        $data = $this->disbursement_model->display_costs_type_level($mgt_plans_ID, $mgt_product_ID, $costs_group_ID);
        $html = "";
        foreach ($data as $key => $value) {
             $node_ID = $parent_ID.$value["costs_type_id"];
             $html .= '<tr class="teegrid-'.$node_ID.' teegrid-parent-'.$parent_ID.'">';
             $html .= '<td class="cost-type-level">* ประเภท'.$value["name"].'</td>';
             $html .= '<td class="cost-type-level">&nbsp;</td>';
             $html .= '<td class="cost-type-level">&nbsp;</td>';
             $html .= '<td class="cost-type-level">&nbsp;</td>';
             $html .= '<td class="cost-type-level">&nbsp;</td>';
             $html .= '<td class="cost-type-level">&nbsp;</td>';
             $html .= '</tr>';
             $html .= $this->get_costslists_level($mgt_plans_ID, $mgt_product_ID, $value["costs_type_id"], $node_ID);
         }
        return $html;
    }
    
    //Level 6 costs lists and sublists
    public function get_costslists_level($mgt_plans_ID, $mgt_product_ID, $costs_type_ID, $parent_ID){
     
        $arr = array();
        $data = $this->disbursement_model->display_costs_lists_level($mgt_plans_ID, $mgt_product_ID, $costs_type_ID);
        foreach ($data as $key => $value) {
            $arr[$value["costs_lists_id"]]["node_ID"] = $parent_ID.$value["costs_lists_id"];
            $arr[$value["costs_lists_id"]]["name"] = $value["name"];
            $arr[$value["costs_lists_id"]]["payment"] = $value["payment"];
            $arr[$value["costs_lists_id"]]["mgt"] = 0.00;
            $arr[$value["costs_lists_id"]]["approve"] = 0.00;
        }
        
        $data = $this->mgt_costs_model->mgt_costslists_budget($mgt_product_ID, $costs_type_ID);
        foreach ($data as $key => $value) {
            if(array_key_exists($value["costs_lists_id"], $arr)){
                $arr[$value["costs_lists_id"]]["mgt"] = $value["amount"];
                
                    // get approve amount not disbrusement
                    $result = $this->approve_model->amount_approve_only($value["id"]);
                    if(count($result)){
                          foreach ($result as $row) {
                                $arr[$value["costs_lists_id"]]["approve"] += $row["balance"];
                          }
                    }
            }
        }
        
        $sum_mgt = 0;
        $sum_payment = 0;
        $sum_total_payment = 0;
        $sum_approve = 0;
        $sum_total_amount = 0;
        
        $html = "";
        foreach ($arr as $key => $value) {
            $html .= '<tr class="teegrid-'.$value["node_ID"].' teegrid-parent-'.$parent_ID.'">';
            $html .= '<td class="cost-lists-level">'."- ".$value["name"].'</td>';
            $html .= '<td style="text-align: right">'.number_format($value["mgt"],2).'</td>';
            $html .= '<td style="text-align: right">'.number_format($value["payment"],2).'</td>';	 
            $html .= '<td style="text-align: right">'.number_format($value["mgt"]-$value["payment"],2).'</td>';
            $html .= '<td style="text-align: right">'.number_format($value["approve"],2).'</td>';
            $html .= '<td style="text-align: right">'.number_format($value["mgt"]-$value["payment"]-$value["approve"],2).'</td>';
            $html .= '</tr>';
            
            $sum_mgt += $value["mgt"];
            $sum_payment += $value["payment"];
            $sum_total_payment += ($value["mgt"]-$value["payment"]);
            $sum_approve += $value["approve"];
            $sum_total_amount += ($value["mgt"]-$value["payment"]-$value["approve"]); 
         }
         
            $html .= '<tr style="background-color:#eee;" class="teegrid-sum teegrid-parent-'.$parent_ID.'">';
            $html .= '<td style="text-align: right;"><strong>รวมเงินทั้งหมด</strong></td>';
            $html .= '<td style="text-align: right">'.number_format($sum_mgt,2).'</td>';
            $html .= '<td style="text-align: right">'.number_format($sum_payment,2).'</td>';	 
            $html .= '<td style="text-align: right">'.number_format($sum_total_payment,2).'</td>';
            $html .= '<td style="text-align: right">'.number_format($sum_approve,2).'</td>';
            $html .= '<td style="text-align: right">'.number_format($sum_total_amount,2).'</td>';
            $html .= '</tr>';
            
        return $html;
       
    }
    
    
     public function pdf()
    {
        ini_set('memory_limit', '1024M');
    
        $html = "<h3>เงินรายได้คณะการแพทย์แผนไทย จำแนกตามแผน".$this->session->userdata('budget_year_title')."</3>";
        $html .= "<h5>".$this->session->userdata('pdf_date')."</h5>";
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
        $html .= $this->get_mgt_plan_level($this->session->userdata('pdf_start_date'), $this->session->userdata('pdf_end_date'));
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
