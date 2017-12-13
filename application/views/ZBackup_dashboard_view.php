<div class="container-fluid">
				<div class="row-fluid">
					<div class="span6">
						<div class="box">
							<div class="box-title">
								<h3>
									<i class="icon-bar-chart"></i>
									สัดส่วนการใช้งบประมาณ
								</h3>
							</div>
							<div class="box-content">
								<div id="flot-1" class='flot'></div>
							</div>
						</div>
					</div>
					<div class="span6">
						<div class="box">
							<div class="box-title">
								<h3>
									<i class="icon-bar-chart"></i>
									สัดส่วนการจัดสรรงบตามแผนงาน
								</h3>
							</div>
							<div class="box-content">
								<div id="flot-2" class='flot'></div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="row-fluid">
					<div class="span12">
						<div class="box">
							<div class="box-title">
								<h3>
									<i class="icon-bar-chart"></i>
									จำนวนการอนุมัติและการเบิกจ่าย
								</h3>
							</div>
							<div class="box-content">
								<div id="placeholder" class='flot'></div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="row-fluid">
					<div class="span6">
						<div class="box">
							<div class="box-title">
								<h3>
									<i class="icon-bar-chart"></i>
									สัดส่วนการอนุมัติแยกตามแผนงาน
								</h3>
							</div>
							<div class="box-content">
								<div id="flot-3" class='flot'></div>
							</div>
						</div>
					</div>
					<div class="span6">
						<div class="box">
							<div class="box-title">
								<h3>
									<i class="icon-bar-chart"></i>
									สัดส่วนการเบิกจ่ายแยกตามแผนงาน
								</h3>
							</div>
							<div class="box-content">
								<div id="flot-4" class='flot'></div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="row-fluid">
					<div class="span6">
						<div class="box">
							<div class="box-title">
								<h3>
									<i class="icon-bar-chart"></i>
									สัดส่วนการอนุมัติแยกตามงบรายจ่าย
								</h3>
							</div>
							<div class="box-content">
								<div id="flot-5" class='flot'></div>
							</div>
						</div>
					</div>
					<div class="span6">
						<div class="box">
							<div class="box-title">
								<h3>
									<i class="icon-bar-chart"></i>
									สัดส่วนการเบิกจ่ายแยกตามงบรายจ่าย
								</h3>
							</div>
							<div class="box-content">
								<div id="flot-6" class='flot'></div>
							</div>
						</div>
					</div>
				</div>
	</div>

    



<script type="text/javascript">
  

var pie_data1 = <?php echo json_encode($arr_pie1); ?>

var pie_data2 = <?php echo json_encode($arr_pie2); ?>

var pie_data3 = <?php echo json_encode($arr_pie3); ?>

var pie_data4 = <?php echo json_encode($arr_pie4); ?>

var pie_data5 = <?php echo json_encode($arr_pie5); ?>

var pie_data6 = <?php echo json_encode($arr_pie6); ?>


/* Bar Chart Data */  
    var d1_1 = [<?php echo $arr_bar_data1; ?>];
 
    var d1_2 = [<?php echo $arr_bar_data2; ?>];


$(document).ready(function () {
  console.log(d1_1);
  /* Pie Chart */   
  $.plot($("#flot-1"), pie_data1, {
        series: {
        pie: {
            show: true,
            radius: 1,
            label: {
                show: true,
                radius: 1,
                formatter: function(label, series) {
                    return '<div style="font-size:11px; text-align:center; padding:2px; color:white;">'+label+'<br/>'+Math.round(series.percent)+'%</div>';
                },
                background: {
                    opacity: 0.8
                }
            }
        }
      }
	    
   });   
    
   $.plot($("#flot-2"), pie_data2, {
    series: {
        pie: {
            show: true,
            radius: 1,
            label: {
                show: true,
                radius: 1,
                formatter: function(label, series) {
                    return '<div style="font-size:11px; text-align:center; padding:2px; color:white;">'+Math.round(series.percent)+'%</div>';
                },
                background: {
                    opacity: 0.8
                }
            }
        }
      }
   });
   
    $.plot($("#flot-3"), pie_data3, {
    series: {
        pie: {
            show: true,
            radius: 1,
            label: {
                show: true,
                radius: 1,
                formatter: function(label, series) {
                    return '<div style="font-size:11px; text-align:center; padding:2px; color:white;">'+Math.round(series.percent)+'%</div>';
                },
                background: {
                    opacity: 0.8
                }
            }
        }
    }
   });
   
   $.plot($("#flot-4"), pie_data4, {
    series: {
        pie: {
            show: true,
            radius: 1,
            label: {
                show: true,
                radius: 1,
                formatter: function(label, series) {
                    return '<div style="font-size:11px; text-align:center; padding:2px; color:white;">'+Math.round(series.percent)+'%</div>';
                },
                background: {
                    opacity: 0.8
                }
            }
        }
    }
   });
   
    /*
   $.plot($("#flot-5"), pie_data5, {
    series: {
        pie: {
            show: true,
            radius: 1,
            label: {
                show: true,
                radius: 1,
                formatter: function(label, series) {
                    return '<div style="font-size:11px; text-align:center; padding:2px; color:white;">'+Math.round(series.percent)+'%</div>';
                },
                background: {
                    opacity: 0.8
                }
            }
        }
    }
   });
   
   $.plot($("#flot-6"), pie_data6, {
    series: {
        pie: {
            show: true,
            radius: 1,
            label: {
                show: true,
                radius: 1,
                formatter: function(label, series) {
                    return '<div style="font-size:11px; text-align:center; padding:2px; color:white;">'+Math.round(series.percent)+'%</div>';
                },
                background: {
                    opacity: 0.8
                }
            }
        }
    }
   });
  */
  /* Bar Chart Data */  
   /* var data1 = [
        {
            label: "การอนุมัติ",
            data: d1_1,
            bars: {
                show: true,
                barWidth: 12*24*60*60*300,
                fill: true,
                lineWidth: 1,
                order: 1,
                fillColor:  "#AA4643"
            },
            color: "#AA4643"
        },
        {
            label: "การเบิกจ่าย",
            data: d1_2,
            bars: {
                show: true,
                barWidth: 12*24*60*60*300,
                fill: true,
                lineWidth: 1,
                order: 2,
                fillColor:  "#89A54E"
            },
            color: "#89A54E"
        }
        
    ];
 
 
    $.plot($("#placeholder"), data1, {
        xaxis: {
            min: (new Date(<?php // echo $this->session->userdata('budget_year_year') - 1; ?>, 09, 01)).getTime(),
            max: (new Date(<?php // echo $this->session->userdata('budget_year_year'); ?>, 08, 30)).getTime(),
            mode: "time",
            timeformat: "%b",
            tickSize: [1, "month"],
            monthNames: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            tickLength: 0, // hide gridlines
            axisLabel: 'Month',
            axisLabelUseCanvas: true,
            axisLabelFontSizePixels: 12,
            axisLabelFontFamily: 'Verdana, Arial, Helvetica, Tahoma, sans-serif',
            axisLabelPadding: 5
        },
        yaxis: {
            axisLabel: 'Value',
            axisLabelUseCanvas: true,
            axisLabelFontSizePixels: 12,
            axisLabelFontFamily: 'Verdana, Arial, Helvetica, Tahoma, sans-serif',
            axisLabelPadding: 5
        },
        grid: {
            hoverable: true,
            clickable: false,
            borderWidth: 1
        }
    });
    
    
   
// end document.ready
});
</script>
