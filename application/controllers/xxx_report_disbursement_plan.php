<?php
class Report_Disbursement_Plan extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('disbursement_model');
        $this->load->model('mgt_costs_model');
		$this->load->helper('myfunction');
		$this->load->helper('general');
		$this->load->helper('menu');
		$this->load->library("mpdf");
        
		Accesscontrol_helper::is_logged_in();
	}
	
	public function index()
	{
		$data["title"] = "รายละเอียดการเบิกจ่ายตามแผน";
		$data["path"] = array("งานการเงิน","รายงาน","รายละเอียดการเบิกจ่ายตามแผน");
		$data["submenu"] = Finance_menu(3);
      
        if (isset($_POST['ccplan']) && !empty($_POST["ccplan"]))
        {
        	$budget_id = $this->session->userdata('budget_year_id');
            $plans_id = $_POST["ccplan"];
            $product_id = $_POST["ccproduct"];
            
            // Pdf
            $this->session->set_userdata('pdf_plan_id', $_POST["ccplan"]);
            $this->session->set_userdata('pdf_plan_name', $_POST["plan_name"]);
            $this->session->set_userdata('pdf_product_id', $_POST["ccproduct"]);
            $this->session->set_userdata('pdf_product_name', $_POST["product_name"]);
            
            
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
                $this->session->set_userdata('pdf_date', "ระหว่างวันที่ (ทั้งปีงบประมาณ)");
                $this->session->set_userdata('pdf_start_date', '');
                $this->session->set_userdata('pdf_end_date', '');
            }
            
            $html  = '<tr>';
            $html .= '<td class="plan-level"  colspan="4"><strong>'.$_POST["plan_name"].$display_date.'</strong></td>';
            $html .= '</tr>';
            $html .= '<tr>';
            $html .= '<td class="product-level" colspan="4" style="padding-left:10mm;"><strong>'.$_POST["product_name"].'</strong></td>';
            $html .= '</tr>';
            $html .=  $this->get_costs_level($budget_id, $plans_id, $product_id, $start_date, $end_date);
            
            $data["treegrid"] = $html;
        }
     
		$this->template->load('template', 'report/report_disbursement_by_plan_view', $data);
	}
    
	
	public function get_costs_level($budget_main_ID, $plans_ID, $product_ID, $start_date = '', $end_date = '')
	{
        
        $html = "";
        $arr = array();
        
       $data = $this->disbursement_model->costs_level($budget_main_ID, $plans_ID, $product_ID, $start_date, $end_date);
       foreach ($data as $key => $value) {
            $arr[$value["costs_id"]]["nodeID"] = $value["id"];
            $arr[$value["costs_id"]]["name"] = $value["name"];
            $arr[$value["costs_id"]]["payment"] = $value["payment"];
            $arr[$value["costs_id"]]["mgt"] = 0.00;
        }
    
        $data = $this->mgt_costs_model->mgt_costs_level($product_ID);
        foreach ($data as $key => $value) {
            if(array_key_exists($value["costs_id"], $arr)){
                $arr[$value["costs_id"]]["mgt"] = $value["amount"];
            }
        }
       
        $sum_mgt = 0;
        $sum_payment = 0;
        $sum_total_amount = 0;
        
        foreach ($arr as $key => $value) {
             
             $html .= '<tr class="teegrid-'.$value["nodeID"].'">';
             $html .= '<td class="cost-level" style="padding-left:15mm;">'.$value["name"].'</td>';
             $html .= '<td style="text-align: right">'.number_format($value["mgt"],2).'</td>';
             $html .= '<td style="text-align: right">'.number_format($value["payment"],2).'</td>';	 
             $html .= '<td style="text-align: right">'.number_format($value["mgt"]-$value["payment"],2).'</td>';
             $html .= '</tr>';
             $html .= $this->get_costs_group_level($budget_main_ID, $plans_ID, $product_ID, $key, $value["nodeID"], $start_date, $end_date);
             
             $sum_mgt += $value["mgt"];
             $sum_payment += $value["payment"];
             $sum_total_amount += $value["mgt"]-$value["payment"];
         }
        
        // sum footer 
            $html .= '<tfoot>';
            $html .= '<tr style="background-color: #EEEEEE">';
            $html .= '<td><strong>ยอดเงินรวมทั้งหมด</strong></td>';
            $html .= '<td style="text-align: right">'.number_format($sum_mgt,2).'</td>';
            $html .= '<td style="text-align: right">'.number_format($sum_payment,2).'</td>';
            $html .= '<td style="text-align: right">'.number_format($sum_total_amount,2).'</td>';
            $html .= '</tr></tfoot>';
        
		 return $html; 
        //    dump($html);
	    // $this->output->enable_profiler(TRUE);
	}
    
    public function get_costs_group_level($budget_main_ID, $plans_ID, $product_ID, $costs_ID, $parent, $start_date, $end_date)
	{
        $html = "";
        $arr = array();
        
        $data = $this->disbursement_model->costs_group_level($budget_main_ID,$plans_ID, $product_ID, $costs_ID, $start_date, $end_date);
		foreach ($data as $key => $value) {
            $arr[$value["costs_group_id"]]["nodeID"] = $parent.$value["costs_group_id"];
            $arr[$value["costs_group_id"]]["name"] = $value["name"];
            $arr[$value["costs_group_id"]]["payment"] = $value["payment"];
            $arr[$value["costs_group_id"]]["mgt"] = 0.00;
        }
     
        $data = $this->mgt_costs_model->mgt_costs_group_level($product_ID, $costs_ID);
         foreach ($data as $key => $value) {
             if(array_key_exists($value["costs_group_id"], $arr)){
                 $arr[$value["costs_group_id"]]["mgt"] = $value["amount"];
             }
        }

        foreach ($arr as $key => $value) {  
            $html .= '<tr class="teegrid-'.$value["nodeID"].' teegrid-parent-'.$parent.'">';
            $html .= '<td class="cost-group-level" style="padding-left:20mm;">'.$value["name"].'</td>';
            $html .= '<td style="text-align: right">'.number_format($value["mgt"],2).'</td>';
            $html .= '<td style="text-align: right">'.number_format($value["payment"],2).'</td>';	 
            $html .= '<td style="text-align: right">'.number_format($value["mgt"]-$value["payment"],2).'</td>';
            $html .= '</tr>';
            $html .= $this->get_costs_type_level($budget_main_ID, $plans_ID, $product_ID, $costs_ID, $key, $value["nodeID"], $start_date, $end_date);
           
        }
      
       return $html;
	   // dump($arr);
	   //$this->output->enable_profiler(TRUE);
	}
	
    public function get_costs_type_level($budget_main_ID, $plans_ID, $product_ID, $costs_ID, $costs_group_ID, $parent, $start_date, $end_date)
	{
        $html = "";
        $arr = array();
        
        $data = $this->disbursement_model->costs_type_level($budget_main_ID,$plans_ID, $product_ID, $costs_ID, $costs_group_ID, $start_date, $end_date);
		foreach ($data as $key => $value) {
            $arr[$value["costs_type_id"]]["nodeID"] = $parent.$value["costs_type_id"];
            $arr[$value["costs_type_id"]]["name"] = "ประเภท".$value["name"];
            $arr[$value["costs_type_id"]]["payment"] = $value["payment"];
            $arr[$value["costs_type_id"]]["mgt"] = 0.00;
        }
        
       $data = $this->mgt_costs_model->mgt_costs_type_level($product_ID, $costs_ID,  $costs_group_ID);
       foreach ($data as $key => $value) {
           if(array_key_exists($value["costs_type_id"], $arr)){
                $arr[$value["costs_type_id"]]["mgt"] = $value["amount"];
           }
        }

        foreach ($arr as $key => $value) {  
            $html .= '<tr class="teegrid-'.$value["nodeID"].' teegrid-parent-'.$parent.'">';
            $html .= '<td class="cost-type-level" style="padding-left:23mm;">'.$value["name"].'</td>';
            $html .= '<td style="text-align: right">'.number_format($value["mgt"],2).'</td>';
            $html .= '<td style="text-align: right">'.number_format($value["payment"],2).'</td>';	 
            $html .= '<td style="text-align: right">'.number_format($value["mgt"]-$value["payment"],2).'</td>';
            $html .= '</tr>';
            $html .= $this->get_costs_lists_level($budget_main_ID, $plans_ID, $product_ID, $costs_ID, $costs_group_ID, $key, $value["nodeID"], $start_date, $end_date);
            
        }
     
       return $html;
     //   dump($arr);
       //  dump($data);
        //$this->output->enable_profiler(TRUE);
	}
    
    public function get_costs_lists_level($budget_main_ID, $plans_ID, $product_ID, $costs_ID, $costs_group_ID, $costs_type_ID, $parent, $start_date, $end_date)
	{
        $html = "";
        $arr = array();
        
        $data = $this->disbursement_model->costs_lists_level($budget_main_ID,$plans_ID, $product_ID, $costs_ID, $costs_group_ID, $costs_type_ID, $start_date, $end_date);
		foreach ($data as $key => $value) {
            $arr[$value["costs_lists_id"]]["nodeID"] = $parent.$value["costs_lists_id"];
            $arr[$value["costs_lists_id"]]["name"] = $value["name"];
            $arr[$value["costs_lists_id"]]["payment"] = $value["payment"];
            $arr[$value["costs_lists_id"]]["mgt"] = 0.00;
        }
        
        $data = $this->mgt_costs_model->mgt_costs_lists_level($product_ID, $costs_ID, $costs_group_ID, $costs_type_ID);
        foreach ($data as $key => $value) {
            if(array_key_exists($value["costs_lists_id"], $arr)){
                $arr[$value["costs_lists_id"]]["mgt"] = $value["amount"];
            }
        }
  
        foreach ($arr as $key => $value) {  
            $html .= '<tr class="teegrid-'.$value["nodeID"].' teegrid-parent-'.$parent.'">';
            $html .= '<td class="cost-lists-level" style="padding-left:23mm;">'."- ".$value["name"].'</td>';
            $html .= '<td style="text-align: right">'.number_format($value["mgt"],2).'</td>';
            $html .= '<td style="text-align: right">'.number_format($value["payment"],2).'</td>';	 
            $html .= '<td style="text-align: right">'.number_format($value["mgt"]-$value["payment"],2).'</td>';
            $html .= '</tr>';
        }
       
        return $html;
       //   dump($arr);
        //  dump($data);
        //$this->output->enable_profiler(TRUE);
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
        $html .= "</tr></thead>";
        $html .= "<tbody>";
        $html .= '<tr>';
        $html .= '<td class="plan-level"  colspan="4"><strong>'.$this->session->userdata('pdf_plan_name').'</strong></td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td class="product-level" colspan="4">'.$this->session->userdata('pdf_product_name').'</td>';
        $html .= '</tr>';
        $html .= $this->get_costs_level($this->session->userdata('budget_year_id'),$this->session->userdata('pdf_plan_id'),$this->session->userdata('pdf_product_id'));
        $html .= "</tbody>";
		$html .= "</table>";			
        
        $this->mpdf = new mPDF('utf-8', 'A4-L');
        $stylesheet = file_get_contents(base_url('assets/css/report_disbursement_pdf.css'));
        $this->mpdf->SetAutoFont();

        $this->mpdf->mirrorMargins = 1;

        $this->mpdf->defaultheaderfontsize = 10;	
        $this->mpdf->defaultheaderfontstyle = B;	
        $this->mpdf->defaultheaderline = 1; 	

        $this->mpdf->defaultfooterfontsize = 12;	
        $this->mpdf->defaultfooterfontstyle = B;	
        $this->mpdf->defaultfooterline = 1; 	


        $this->mpdf->SetHeader('{DATE j-m-Y}|{PAGENO}/{nb}| FMIS Report');
        $this->mpdf->SetFooter('{PAGENO}');
        
        $this->mpdf->WriteHTML($stylesheet,1);
        $this->mpdf->WriteHTML($html);
        $this->mpdf->Output();
      
    }
}