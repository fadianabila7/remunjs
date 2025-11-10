    <link href="<?php echo base_url('assets');?>/css/plugins/ladda/ladda-themeless.min.css" rel="stylesheet">
        <div class="row wrapper border-bottom white-bg page-heading" style="margin-bottom:5px;">
            <div class="col-lg-9">
                <h2>Dashboard </h2>
            </div>
        </div>

        <!-- baris pertama -->
        <div class="row">

                <div class="col-lg-6">
                	<div class="col-lg-12">
	                  <div class="ibox float-e-margins">
	                     <div class="ibox-title navy-bg">
	                        <div class="ibox-tools">

	                           <h5 class="collapse-link" style="cursor: pointer;" >Info Kegiatan Dosen</h5>
	                           <a class="collapse-link" style="color:#fff;"><i class="fa fa-chevron-up"></i></a>
	                        </div>
	                     </div>
	                     <div class="ibox-content" style="<?php echo $display; ?>">
	                        <table class="table table-hover no-margins">
	                           <thead>
	                              <tr>
	                                 <th>Bulan</th>
	                                 <th>Status</th>
	                              </tr>
	                           </thead>
	                           <tbody>
	                            <?php
	                                $nama_bulan = array('','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember');

	                                foreach($info_kegiatan as $data) {
	                                    if ($data['status'] == 0) {
	                                        $status = '<span class="label label-warning">Pending</span>';
	                                    }elseif($data['status'] == 1) {
	                                        $status = '<span class="label label-warning">Tidak Valid</span>';
	                                    }elseif($data['status'] == 2) {
	                                        $status = '<span class="label label-success">Valid</span>';
	                                    }elseif($data['status'] == 3) {
	                                        $status = '<span class="label label-primary">Complete</span>';
	                                    }

	                                echo "
	                                    <tr>
	                                        <td>" . $nama_bulan[$data['bulan']] . "</td>
	                                        <td>" . $status . "</td>
	                                    </tr>";
	                                    echo (empty($data['deskripsi'] ))?"":"<tr><td colspan=2><b>Deskripsi</b>: ".$data['deskripsi'] ."</td></tr>";
	                                }
	                            ?>   
	                           </tbody>
	                        </table>
	                     </div>
	                  </div>
	                </div>

	                <div class="col-lg-12" style="<?php echo $wr; ?>">
	                	<div class="ibox">
							<div class="ibox-title">
		                        <h5>Grafik Data Jabatan Fungsional Dosen</h5>
		                        <div class="ibox-tools">
		                            <a class="fullscreen-link">
		                                <i class="fa fa-expand"></i>
		                            </a>
		                        </div>
		                    </div>	                		
	                		<div class="ibox-content">
	                			<canvas id="datadosen" style="display: block; width:100%; height:500px;"></canvas>
	                		</div>
	                	</div>
	                </div>
                </div>

                <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-content">
                            <div>                                
                            	<span class="pull-right text-right">
                            		Total Kelebihan SKSR : <b id="totalsks4" style="font-size: x-large; color:#1ab394;">00.00</b>
                            	</span>
                                <h3 class="font-bold no-margins">
                                    Rekap Remunerasi Dosen
                                </h3>
                                <small><?php echo (date("m")==1)?date("F"):date_format(date_create("2013-01-15"),"F")." - ".date("F"); ?>.</small>
                            </div>

                            <div class="m-t-sm">

                                <div class="row">
                                    <div class="col-lg-8">
                                        <div>
                                            <canvas id="lineChart" height="170" width="auto"></canvas>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <ul class="stat-list m-t-lg">
                                            <li id="cc" class="p-sm text-center">
                                                <small>Total SKSR</small>
                                                <h2 id="totalsks1" class="no-margins">loading...</h2>
                                            </li>
                                            <li>
                                                <h2 id="totalsks2" class="no-margins">loading...</h2>
                                                <small>Total SKSR Gaji</small>
                                                <div class="progress progress-mini">
                                                    <div id="proses2" class="progress-bar" style="width: 60%;"></div>
                                                </div>
                                            </li>
                                            <li>
                                                <h2 id="totalsks3" class="no-margins">loading...</h2>
                                                <small>Total SKSR Kinerja</small>
                                                <div class="progress progress-mini">
                                                    <div id="proses3" class="progress-bar" style="width: 60%;"></div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-12" id="detail" style="display:none;">
                                        <div class="col-md-3">
                                            <div class="ibox">
                                                <div class="ibox-content">
                                                    <h5><a href="<?php echo site_url();?>/KegiatanController/RiwayatKegiatan/1">Pengajaran</a></h5>
                                                    <div id="sparkline1">
                                                        <canvas width="200" height="60" style="display:inline-block;width:200;height:60px; vertical-align:top;"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="ibox">
                                                <div class="ibox-content">
                                                    <h5><a href="<?php echo site_url();?>/KegiatanController/RiwayatKegiatan/2">Penelitian</a></h5>
                                                    <div id="sparkline2">
                                                        <canvas width="200" height="60" style="display:inline-block;width:200;height:60px; vertical-align:top;"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="sparkline3" style="display:none;"></div>
                                        <div class="col-md-3">
                                            <div class="ibox">
                                                <div class="ibox-content">
                                                    <h5><a href="<?php echo site_url();?>/KegiatanController/RiwayatKegiatan/4">Penunjang</a></h5>
                                                    <div id="sparkline4">
                                                        <canvas width="200" height="60" style="display:inline-block;width:200;height:60px; vertical-align:top;"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="ibox">
                                                <div class="ibox-content">
                                                    <h5><a href="<?php echo site_url();?>/KegiatanController/RiwayatKegiatan/5">Non Struktural</a></h5>
                                                    <div id="sparkline5">
                                                        <canvas width="200" height="60" style="display:inline-block;width:200;height:60px; vertical-align:top;"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- <div class="col-md-12" id="buttonDetail">
                                    	<button id="chart" class="ladda-button btn btn-xs btn-primary" data-style="expand-right" style="margin-top:5px;">
                                    	 	<i class="fa fa-star"></i>	Detail SKSR
                                    	</button>
                                    </div> -->
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="ibox float-e-margins" style="<?php echo $wr; ?>">
	                	<div class="ibox">
							<div class="ibox-title">
		                        <h5>Grafik Total SKS Dosen 6</h5>
		                        <div class="ibox-tools">
		                            <a class="fullscreen-link">
		                                <i class="fa fa-expand"></i>
		                            </a>
		                        </div>
		                    </div>	                		
	                		<div class="ibox-content">
	                			<canvas id="grafiksks1" style="display: block; width:100%; height:300px;"></canvas>
	                		</div>
	                	</div>
	                	<div class="ibox">
							<div class="ibox-title">
		                        <h5>Grafik Total SKS Dosen 12</h5>
		                        <div class="ibox-tools">
		                            <a class="fullscreen-link">
		                                <i class="fa fa-expand"></i>
		                            </a>
		                        </div>
		                    </div>	                		
	                		<div class="ibox-content">
	                			<canvas id="grafiksks2" style="display: block; width:100%; height:300px; margin-top:-50px;"></canvas>
	                		</div>
	                	</div>
                    </div>
                </div>
        </div>
		<script async="" src="//www.google-analytics.com/analytics.js"></script>	
		<script src="<?php echo base_url('assets');?>/js/plugins/chartJs/Chart.2.6.0.min.js"></script>
		<script src="<?php echo base_url('assets');?>/js/plugins/sparkline/jquery.sparkline.min.js"></script>
		<script src="<?php echo base_url('assets');?>/js/plugins/ladda/spin.min.js"></script>
		<script src="<?php echo base_url('assets');?>/js/plugins/ladda/ladda.min.js"></script>
		<script src="<?php echo base_url('assets');?>/js/plugins/ladda/ladda.jquery.min.js"></script>
		<script src="<?php echo base_url('assets');?>/js/utils.js"></script>
	    <?php 
	        $date=date("m"); $b="";
	        // $date='12'; $b="";
	        $test=array("","Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep","Okt", "Nov", "Des");
	        for ($i=1;$i<=$date;$i++) { 
	            $b=$b.'"'.$test[$i].'",';
	        }
	    ?>
		<script>
		    $(document).ready(function(){    
		        $.ajax({
		            url: "<?php echo base_url();?>index.php/MainControler/getRekap",
		            type: "GET",
		            // data : { data:0},
		            success: function(ajaxData){
		                var returnedData = JSON.parse(ajaxData);
		                var totalsks=[], avggaji=0; avgkinerja=0, persenavg=0, Hgaji=0, Hkine=0, Hkesi=0;
		                    
		                for(var i=0; i< <?php echo $date;?>;i++){
		                    totalsks.push(parseFloat(returnedData[i]['totalsks']));
		                    avggaji+=eval(returnedData[i]['avggaji']);
		                    avgkinerja+=eval(returnedData[i]['avgkinerja']);
		                }
		                totalsks.push(parseFloat(0));
		                totalsks.push(parseFloat(Math.max.apply(null,totalsks)+eval(1)));

		                var total = document.getElementById("totalsks1").innerHTML=(returnedData[i]['totalsks']);
		                var avg=eval(avggaji)+eval(avgkinerja);
		                var d = document.getElementById("cc");
		                persenavg = (total/avg)*100;

		                Hgaji = Math.min(total,avggaji);
		                Hkine = Math.min((total-Hgaji),avgkinerja);
		                Hkesi = (total - Hgaji - Hkine)<0?0:(total - Hgaji - Hkine);

		                document.getElementById("totalsks2").innerHTML=(Hgaji.toFixed(2));
		                var persenGaji = ((Hgaji)/avggaji*100);
		                document.getElementById("proses2").style.width=(persenGaji+"%");
		                document.getElementById("totalsks3").innerHTML=(Hkine.toFixed(2));
		                document.getElementById("proses3").style.width=((Hkine)/avgkinerja*100)+"%";
		                document.getElementById("totalsks4").innerHTML=(Hkesi.toFixed(2));
		                if(persenGaji<100){
		                    d.className += " red-bg";
		                    var lineData = {
		                        labels: [<?php echo $b; ?>],
		                        datasets: [
		                            {
		                                label: "Total SKSR",
		                                backgroundColor: "rgba(237, 85, 101, 0.4)",
		                                borderColor: "rgba(237, 85, 101, 0.7)",
		                                pointBackgroundColor: "rgba(237, 85, 101, 1)",
		                                pointBorderColor: "#fff",
		                                data: totalsks
		                            },
		                        ]
		                    };
		                }else{
		                    d.className += " navy-bg";
		                    var lineData = {
		                        labels: [<?php echo $b; ?>],
		                        datasets: [
		                            {
		                                label: "Total SKSR",
		                                backgroundColor: "rgba(26,179,148,0.4)",
		                                borderColor: "rgba(26,179,148,0.7)",
		                                pointBackgroundColor: "rgba(26,179,148,1)",
		                                pointBorderColor: "#fff",
		                                data: totalsks
		                            },
		                        ]
		                    };
		                }
		                
		                var lineOptions = {responsive: true, legend:{display:false}};
		                var ctx = document.getElementById("lineChart").getContext("2d");
		                new Chart(ctx, {type: 'bar', data: lineData, options:lineOptions});

		                //tambahan
		                // var t = $('.ladda-button').ladda();
				        // t.click(function(){
				        // t.ladda('start');
			            var tahun = new Date().getFullYear();
	                    $("#detail").css("display", "inline");
			            $.ajax({
				            url: "<?php echo base_url();?>index.php/MainControler/getKegiatanDosenJenisBulanTahun",
				            type: "POST",
				            data : { tahun:tahun},
				            success: function(ajaxData){
	                            var lock = JSON.parse(ajaxData);
	                            var sparklineCharts = function(){

	                                for(var m=1; m<=5; m++){
	                                    if(m==3){m++;}
	                                    var pengajaran=[];
	                                    for(var k=1; k<= <?php echo date('m'); ?>;k++){
	                                        pengajaran.push(parseFloat(lock[m][k]));
	                                    }
	                                    $("#sparkline"+m).sparkline(pengajaran, {
	                                         type: 'line',
	                                         width: '100%',
	                                         height: '60',
	                                         lineColor: '#1c84c6',
	                                         fillColor: "rgba(28, 132, 198, 0.3)"
	                                    });
	                                }
	                            };

	                            var sparkResize;
	                            $(window).resize(function(e){clearTimeout(sparkResize);sparkResize = setTimeout(sparklineCharts, 500); });
	                            sparklineCharts();

				            },
							error: function(status){}
			            });									    

		            },
		            error: function(status){

		            }
		        });
				

				// Rektor dan WR
				<?php 
				if(isset($getfakultas)){
			        $getfakultas = json_decode(json_encode($getfakultas), True); $fak="";
			        for($o=0;$o<count($getfakultas);$o++){
			        	$fak=$fak.'"'.$getfakultas[$o]['singkatan'].'",';
			        }
		        ?>
			        var barJabatan = {
			            labels: [<?php echo $fak; ?>],
			            datasets: 
			            [
			            <?php 

							function array_merge_recursive_sum(){
							    $arrays = func_get_args();
							    $base = array_shift($arrays);
							    foreach ($arrays as $array) :
							        reset($base);
							        while (list($key, $value) = @each($array)) :
							            if (is_array($value) && @is_array($base[$key])) :
							                $base[$key] = array_merge_recursive_sum($base[$key], $value);
							            else :
							                $base[$key] += $value;
							            endif;
							        endwhile;
							    endforeach;
							    return $base;
							}

			            	$color=array("red","yellow","orange","green","blue","purple","grey","darkBrown","darkGreen","blush","darkLavender","dollarBill","crimson","cream","red","yellow","orange","green","yellow","purple","grey","darkBrown","darkGreen","blush","darkLavender","dollarBill","crimson","cream",);
			            	$poin_cx = array(0,0,0,0,0,0,0,0,0,0,0);
			            	for($k=0;$k<count($getFungsional)-1;$k++){ 
			            		$point_b = explode('Gol',$getFungsional[$k]['nf']);
			            		$point_c = ($fungsional[$getFungsional[$k]['ijf']]);
			            		if($getFungsional[$k]['ijf']==202 || $getFungsional[$k]['ijf']==204 || $getFungsional[$k]['ijf']==206 || $getFungsional[$k]['ijf']==208 || $getFungsional[$k]['ijf']==210 || $getFungsional[$k]['ijf']==212 ||
			            			$getFungsional[$k]['ijf']==215 || $getFungsional[$k]['ijf']==216 || $getFungsional[$k]['ijf']==217 || $getFungsional[$k]['ijf']==218){
			            			$poin_cx = $point_c;
			            		}else{
				            		?>
							            {
							                label: "<?php echo (strpos($point_b[0],'Diperbantukan')!==false)?'Diperbantukan':$point_b[0]; ?>",
							                backgroundColor: window.chartColors.<?php echo $color[$k]; ?>,
							                stack: 'Stack 0',
							                data: <?php print_r (json_encode(array_merge_recursive_sum($point_c,$poin_cx))); ?>
							            },
						            <?php
				            		$poin_cx = array(0,0,0,0,0,0,0,0,0,0,0);
			            		}
			            	} ?>
			            ]

			        };	

			        //chart 2
			        var color = Chart.helpers.color;
			        var rekap6 = <?php print_r($rekap6bulan); ?>;
		                rekap6.push(parseFloat(Math.max.apply(null,rekap6)+eval(1)));
			        var grafiksks1 = {
			            labels: [<?php echo $fak; ?>],
			            datasets: [{
			                type: 'bar',
			                label: 'Januari - Juni',
			                backgroundColor: color(window.chartColors.blush).alpha(0.5).rgbString(),
			                borderColor: window.chartColors.blush,
			                data: rekap6
			            }]
			        };
			        var rekap12 = <?php print_r($rekap12bulan); ?>;
		                rekap12.push(parseFloat(Math.max.apply(null,rekap12)+eval(1)));
			        var grafiksks2 = {
			            labels: [<?php echo $fak; ?>],
			            datasets: [{
			                type: 'bar',
			                label: 'Juli - Desember',
			                backgroundColor: color(window.chartColors.yellow).alpha(0.5).rgbString(),
			                borderColor: window.chartColors.yellow,
			                data: rekap12
			            }]
			        };

			        // show chart
			        window.onload = function() {
			            var jabatan = document.getElementById("datadosen").getContext("2d");
			            window.myBar = new Chart(jabatan, {type: 'bar', data: barJabatan,
			                options: {
			                    tooltips: {
			                    	mode: 'index',
				                    callbacks: {
				                        // Use the footer callback to display the sum of the items showing in the tooltip
				                        footer: function(tooltipItems, data) {
				                            var sum = 0;
				                            tooltipItems.forEach(function(tooltipItem) {
				                                sum += eval(data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index]);
				                            });
				                            return 'total: ' + sum;
				                        },
				                    },
				                    footerFontStyle: 'normal',
				                    intersect: false,
				                },
			                    responsive: true,
			                    scales: {xAxes: [{stacked: true,}],yAxes: [{stacked: true}]}
			                }
			            });

			            var sks1 = document.getElementById("grafiksks1").getContext("2d");
			            window.myBar = new Chart(sks1, {type: 'bar', data: grafiksks1, 
			              options: {
			            	responsive: true,
				            legend:{display: false},
				            title:{display:true,text:"Total SKS dari Januari hingga Juni"}
				          }});
			            var sks2 = document.getElementById("grafiksks2").getContext("2d");
			            window.myBar = new Chart(sks2, {type: 'bar', data: grafiksks2, 
			              options: {
			            	responsive: true,
			            	legend:{display: false},
			            	title:{display:true,text:"Total SKS dari Juli hingga Desember"}
			              }});
			        };


		        <?php } ?>	

		        // Define a plugin to provide data labels
		        Chart.plugins.register({
		            afterDatasetsDraw: function(chart, easing) {
		                // To only draw at the end of animation, check for easing === 1
		                var ctx = chart.ctx;

		                chart.data.datasets.forEach(function (dataset, i) {
		                    var meta = chart.getDatasetMeta(i);
		                    if (!meta.stack && !meta.hidden) {
		                        meta.data.forEach(function(element, index) {
		                            // Draw the text in black, with the specified font
		                            ctx.fillStyle = 'rgba(2, 2, 2,0.9)';

		                            var fontSize = 16;
		                            var fontStyle = 'normal';
		                            var fontFamily = 'Helvetica Neue';
		                            ctx.font = Chart.helpers.fontString(fontSize, fontStyle, fontFamily);

		                            // Just naively convert to string for now
		                            var dataString = dataset.data[index].toString();

		                            // Make sure alignment settings are correct
		                            ctx.textAlign = 'center';
		                            ctx.textBaseline = 'middle';

		                            var padding = 5;
		                            var position = element.tooltipPosition();
		                            ctx.fillText(dataString, position.x, position.y - (fontSize / 2) - padding);
		                        });
		                    }
		                });
		            }
		        }); 
    			// end define
		    });

		</script>