<?Php
ob_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>รายงาน</title>

<style type="text/css">

table { border: 1mm solid black;
	border-collapse: collapse;
	width: 100%;
	}

thead td {
	padding: 2mm;
	border: 0.5mm solid black;
	vertical-align: middle;
    text-align: center;
    font-size: 12pt;
    font-weight: bold;
}
tbody td {
	padding: 1.5mm;
	border: 0.5mm solid black;
	vertical-align: middle;

}

tfoot td {
	padding: 2mm;
	border: 0.5mm solid black;
	vertical-align: middle;
    font-weight: 500;
}
h5 {
	line-height: 1pt;
}


</style>

</head>

<body>
<h3>รายงานประจำเดือนกรกฎาคม 2557</h3>
<h5>(1 ก.ค. 57 - 30 ก.ค. 57)</h5>
  <table>
  	<thead>
  		<tr>
  			<td>
  				รายการ
  			</td>
  			<td>
  				ประมาณการ
  			</td>
  			<td>
  				จ่ายจริง
  			</td>
  			<td>
  				คงเหลือ
  			</td>
  		</tr>
  	</thead>
  	<tbody>
  	   <tr>
  	   	   <td>
  				แผนงานพัฒนาการศึกษา
  			</td>
  			<td>
  				
  			</td>
  			<td>
  				
  			</td>
  			<td>
  				
  			</td>
  	   </tr>
  	    <tr>
  	   	   <td style="padding-left:10mm">
  				งานบริหารทั่วไป
  			</td>
  			<td>
  				
  			</td>
  			<td>
  				
  			</td>
  			<td>
  				
  			</td>
  	   </tr>
  	    <tr>
  	   	   <td style="padding-left:20mm">
  				- aaaa
  			</td>
  			<td>
  				100000
  			</td>
  			<td>
  				234000
  			</td>
  			<td>
  				40000
  			</td>
  	   </tr>
  	 
  	</tbody>
  	 <tfoot>
  	    <tr>
  	   	     <td style="text-align: right;">
  				รวม
  			</td>
  			<td>
  				5670000
  			</td>
  			<td>
  				234000
  			</td>
  			<td>
  				780000
  			</td>
  		 </tr>	
  	   </tfoot>
  </table>
</body>
</html>
<?Php


$html = ob_get_contents();
ob_end_clean();

include("mpdf.php");
$mpdf = new mPDF('UTF-8',array(279.4,203.2));



$mpdf->mirrorMargins = 1;	// Use different Odd/Even headers and footers and mirror margins

$mpdf->defaultheaderfontsize = 10;	/* in pts */
$mpdf->defaultheaderfontstyle = B;	/* blank, B, I, or BI */
$mpdf->defaultheaderline = 1; 	/* 1 to include line below header/above footer */

$mpdf->defaultfooterfontsize = 12;	/* in pts */
$mpdf->defaultfooterfontstyle = B;	/* blank, B, I, or BI */
$mpdf->defaultfooterline = 1; 	/* 1 to include line below header/above footer */


$mpdf->SetHeader('{DATE j-m-Y}|{PAGENO}/{nb}| FMIS Report');
$mpdf->SetFooter('{PAGENO}');	/* defines footer for Odd and Even Pages - placed at Outer margin */

$mpdf->SetAutoFont();
$mpdf->WriteHTML($html);

$mpdf->Output();



