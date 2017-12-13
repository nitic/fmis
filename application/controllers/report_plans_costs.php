<?php
class Report_Plans_Costs extends CI_Controller {
	
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
		$data["title"] = "รายละเอียดการเบิกจ่ายแยกตามแผนงาน";
		$data["path"] = array("งานแผน","รายงาน","รายละเอียดการเบิกจ่ายแยกตามแผนงาน");
		$data["submenu"] = Finance_menu(3);

		if (isset($_POST) && !empty($_POST))
		{
			$budget_id = $this->session->userdata('budget_year_id');
            $plans_id = $_POST["ccplan"];
            $product_id = $_POST["ccproduct"];

			$start_date = (!empty($_POST['start_date']))? formatDateToMySql($_POST['start_date']) : '';
            $end_date =  (!empty($_POST['end_date']))? formatDateToMySql($_POST['end_date']) : '' ;

			$data["groupview"] = $this->get_costs_groupview($budget_id, $plans_id, $product_id, $start_date, $end_date);

             // Pdf
            if (!empty($_POST['plan_name'])){ 
                $this->session->set_userdata('pdf_plan_name', $_POST["plan_name"]);
            }
            if (!empty($_POST['product_name'])){ 
                $this->session->set_userdata('pdf_product_name', $_POST["product_name"]);
            }
            
            // send back for viewstate
            $data["post"] = $_POST;

		}

		$this->template->load('template', 'report/report_plans_by_costs_view', $data);
	}
	
	public function get_costs_groupview($budget_main_ID, $plans_ID, $product_ID, $start_date, $end_date)
	{
		
		   $data = $this->disbursement_model->costs_level($budget_main_ID, $plans_ID, $product_ID, $start_date, $end_date);	
		
		   $arr = array();	
		   foreach ($data as $key => $value) {
	            $arr[$value["costs_id"]]["group_id"] = $value["costs_id"];
				$arr[$value["costs_id"]]["group_name"] = $value["name"];
				$arr[$value["costs_id"]]["group_items"] = $this->disbursement_model->costs_groupview($budget_main_ID, $plans_ID, $product_ID, $value["costs_id"], $start_date, $end_date);
				$arr[$value["costs_id"]]["group_amount"] = $value["payment"];
	        }	
		  
	       return $arr;
		 // dump($arr);
		 // $this->output->enable_profiler(TRUE);
	}
	
	public function pdf()
    {
        ini_set('memory_limit', '1024M');
        
        $budget_id = $this->session->userdata('budget_year_id');
        $plans_id = $this->uri->segment(3);
        $product_id = $this->uri->segment(4);
        $start_date = $this->uri->segment(5);
        $end_date = $this->uri->segment(6);
          
          if(!empty($start_date)){
             $start_date = str_replace('-', '/', $start_date);
             $text_start_date = $start_date;
             $start_date = formatDateToMySql($start_date);
          }
          
          if(!empty($end_date)){
             $end_date = str_replace('-', '/', $end_date);
             $text_end_date = $end_date;
             $end_date = formatDateToMySql($end_date);
          }
     
     
        $groupview = $this->get_costs_groupview($budget_id, $plans_id, $product_id, $start_date, $end_date);
        
        
        $html = "<h3>รายงานรายจ่ายงบประมาณเงินรายได้ จำแนกตามงบรายจ่าย</h3>";
        $html .= "<h5>".$this->session->userdata('pdf_plan_name')." / ".$this->session->userdata('pdf_product_name');
         
        if(isset($text_start_date) && isset($text_end_date))
           $html .= " ( วันที่ ".$text_start_date." - ".$text_end_date." )</h5>";
        else
           $html .= "</h5>";
        
        $html .= "<h5>แหล่งเงิน: ".$this->session->userdata('budget_year_title')."</h5>";
        $html .= "<table>";
        $html .= "<thead><tr>";
        $html .= "<th style='width:550px'>ชื่อค่าใช้จ่าย</th>";
        $html .= "<th style='width:50px'>คำสั่ง 1432/5</th>";
        $html .= "<th>ขออนุมัติเบิก</th>";
        $html .= "<th>หนังสือที่ มอ.</th>";
        $html .= "<th>วันที่เบิกจ่าย</th>";
        $html .= "<th>ประเภท</th>";
        $html .= "<th>จำนวนเงินอนุมัติ</th>";
        $html .= "</tr></thead>";
        $html .= "<tbody>";
    
     
     
        if (isset($groupview) && !empty($groupview)){
                        
                $arr_costs_type = array();
                $sum_amount_total = 0.0;
                
                foreach ($groupview as $value) {
                           
                           // show costs group header
                           $html .= '<tr><td colspan = "7" class="group-header"><strong>'.$value["group_name"].'</strong> - ('.count($value["group_items"]).' รายการ)</td></tr>';                    
                           
                           foreach ($value["group_items"] as $item) {
                               
                               // costs type summary
                                $arr_costs_type[$item["costs_type_id"]]["name"] = $item["costs_type_name"];
                                
                                if(!isset($arr_costs_type[$item["costs_type_id"]]["sumtotal"]))
                                  $arr_costs_type[$item["costs_type_id"]]["sumtotal"] = floatval($item["payment"]);
                                else                               
                                  $arr_costs_type[$item["costs_type_id"]]["sumtotal"] += floatval($item["payment"]);
                               
                                // show group_items
                                $html .= '<tr>';
                                $html .= '<td style="padding:0 5px 0 30px;overflow:hidden;line-height: 18px;">'.$item["name"].'</td>';
                                $html .= '<td>&nbsp;</td>';
                                $html .= '<td>'.$item["file_number"].'</td>';
                                $html .= '<td>'.$item["doc_number"].'</td>';
                                $html .= '<td>'.formatThaiDate($item["doc_date"]).'</td>';
                                $html .= '<td>'.$item["costs_type_name"].'</td>';
                                $html .= '<td style="text-align:right;border-right: 0.1mm solid #333;">'.number_format($item["payment"],2).'</td>';
                                $html .= '</tr>';
                           }
                            
                            // show costs type summary
                            foreach ($arr_costs_type as $item2){
                                $html .= '<tr><td colspan = "6" class="costs-type">'.$item2["name"].'</td><td class="costs-type" style="text-align:right;font-weight:700;border-right: 0.1mm solid #333;">'.number_format($item2["sumtotal"],2).'</td></tr>'; 
                            }
                            unset($arr_costs_type);
                            
                            // show costs amount summary
                            $html .= '<tr><td colspan = "6" class="sum">รวมเงิน</td><td class="sum" style="text-align:right;font-weight:800;border-right: 0.1mm solid #333;">'.number_format($value["group_amount"],2).'</td></tr>';  
                            $sum_amount_total += floatval($value["group_amount"]);
                     
                 }
                 
                           // show sum amount all total
                           $html .= '<tr><td colspan = "6" class="sum-total">รวมเงินทั้งหมด</td><td class="sum-total" style="text-align:right;font-weight:900;border-right: 0.1mm solid #333;">'.number_format($sum_amount_total,2).'</td></tr>'; 
          
           }
           else{
                $html .= '<tr  style="height:80px"><td colspan = "7" style="text-align:center;padding: 10px;"><strong>กรุณาเลือกแผนงานและงาน เพื่อเรียกดูข้อมูล !</strong></td></tr>';
               }    
     

        $html .= "</tbody>";
		$html .= "</table>";			
        
        $this->mpdf = new mPDF('utf-8', 'A4-L');
        $stylesheet = file_get_contents(base_url('assets/css/report_plans_costs_pdf.css'));
        $this->mpdf->SetAutoFont();

        $this->mpdf->mirrorMargins = 1;

        $this->mpdf->defaultheaderfontsize = 8;	
        $this->mpdf->defaultheaderfontstyle = '';	
        $this->mpdf->defaultheaderline = 0; 	

        $this->mpdf->defaultfooterfontsize = 8;	
        $this->mpdf->defaultfooterfontstyle = '';	
        $this->mpdf->defaultfooterline = 0; 	


        $this->mpdf->SetHeader('{DATE j-m-Y}|{PAGENO}/{nb}| TTM-FMIS Report');
        $this->mpdf->SetFooter('{PAGENO}');
        
        $this->mpdf->WriteHTML($stylesheet,1);
        $this->mpdf->WriteHTML($html);
        $this->mpdf->Output();

    }
	
}