    <link href="<?php echo base_url('assets');?>/css/plugins/ladda/ladda-themeless.min.css" rel="stylesheet">
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-9">
                <h2>Dashboard</h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo site_url();?>">Dashboard</a>
                    </li>
                </ol>
            </div>
        </div>

		<!-- baris pertama -->
        <div class="row">
	        <div class="col-lg-3">
	        	<a href="<?php echo site_url();?>/MainControler/DataDosen">
		            <div class="widget style1 red-bg">
	                    <div class="row">
	                        <div class="col-xs-4 text-center">
	                            <i class="fa fa-users fa-5x"></i>
	                        </div>
	                        <div class="col-xs-8 text-right">
	                            <span> Total Dosen <?php echo ucfirst(strtolower($datasession['namafakultas'])); ?></span>
	                            <h2 class="font-bold"> <?php echo $totaldosen[0]['total'];?></h2>
	                        </div>
	                    </div>
		            </div>
	        	</a>
	        	<div class="ibox-content">
	                <div>
						<?php foreach($totalprodi as $data) {?>
		                    <div>
		                        <span><?php echo $data->nama; ?></span>
		                        <small class="pull-right"><?php echo $data->total; ?>/<?php echo $totaldosen[0]['total']; ?></small>
		                    </div>
		                    <?php $n=number_format(($data->total/$totaldosen[0]['total'])*100,2); ?>
		                    <div class="progress progress-small">
		                        <div style="width: <?php echo $n; ?>%; background-color:#ed5565;" class="progress-bar"></div>
		                    </div>
		                <?php } ?>
	                </div>
	            </div>
	        </div>

	        <div class="col-lg-3">
	        	<a href="<?php echo site_url();?>/Penunjang/ListSK">
		            <div class="widget style1 navy-bg">
	                    <div class="row">
	                        <div class="col-xs-4 text-center">
	                            <i class="fa fa-users fa-5x"></i>
	                        </div>
	                        <div class="col-xs-8 text-right">
	                            <span> Total SK Penunjang</span>
	                            <h2 class="font-bold"> <?php echo $totalPenunjang; ?></h2>
	                        </div>
	                    </div>
		            </div>
	        	</a>
	            <div class="ibox-content" style="margin-top:8px;">
	                <div>
	                	<h2>Jabatan Fungsional</h2><hr style="margin-top: 0px;">
						<?php foreach($getFungsional as $data) {?>
		                    <div>
		                        <span><?php echo $data->nama; ?></span>
		                        <small class="pull-right"><?php echo $data->total; ?>/<?php echo $totaldosen[0]['total']; ?></small>
		                    </div>
		                    <?php $n=number_format(($data->total/$totaldosen[0]['total'])*100,2); ?>
		                    <div class="progress progress-small">
		                        <div style="width: <?php echo $n; ?>%;" class="progress-bar"></div>
		                    </div>
		                <?php } ?>
	                </div>
	            </div>
	        </div>

	        <div class="col-lg-6">
	            <div class="ibox float-e-margins" style="margin-top:8px;">
                    <div class="ibox-title">
                        <h5>Line Chart SKSR
                            <small>Perbulan.</small>
                        </h5>
                    </div>
                    <div class="ibox-content">
                        <div>
                        	<button id="chart" class="ladda-button btn btn-lg btn-danger" data-style="expand-right" style="margin-left:10px;"> Tampilkan</button>
                        	<canvas id="lineChart" height="180" style="display:none;"></canvas>
                        </div>
                    </div>
                </div>
	        </div>
	    </div>
	    <!-- baris 2 -->

	<!-- ChartJS-->
    <script src="<?php echo base_url('assets');?>/js/plugins/chartJs/Chart.min.js"></script>

    <script src="<?php echo base_url('assets');?>/js/plugins/ladda/spin.min.js"></script>
    <script src="<?php echo base_url('assets');?>/js/plugins/ladda/ladda.min.js"></script>
    <script src="<?php echo base_url('assets');?>/js/plugins/ladda/ladda.jquery.min.js"></script>
    <script>
        <?php 
			$date=date("m"); $b="";
			$test=array("","Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep","Okt", "Nov", "Des");
			for ($i=1;$i<=$date;$i++) { 
				$b=$b.'"'.$test[$i].'",';
			}
		?>
	    $(document).ready(function (){
	        // Bind normal buttons
	        var t = $('.ladda-button').ladda();
	        t.click(function(){
	            t.ladda('start');
	            
	            $.ajax({
		            url: "<?php echo base_url();?>index.php/MainControler/getChart",
		            type: "GET",
		            data : { data:<?php echo $totaldosen[0]['total'];?>},
					success: function(ajaxData){
						var returnedData = JSON.parse(ajaxData);
						var pengajaran=[],penelitian=[],penunjang=[],struktural=[],nonstruktural=[];
						    
							for(var i=1; i<=returnedData['bulan'];i++){
								pengajaran.push(parseFloat(returnedData['pengajaran'][i]));
								penelitian.push(parseFloat(returnedData['penelitian'][i]));
								penunjang.push(parseFloat(returnedData['penunjang'][i]));
								struktural.push(parseFloat(returnedData['struktural'][i]));
								nonstruktural.push(parseFloat(returnedData['nonstruktural'][i]));
							}

						    var lineData = {
						        labels: [<?php echo $b; ?>],
						        datasets: [
						            {
						                label: "Pengajaran",
						                backgroundColor: 'rgba(35, 198, 200, 0.3)',
						                borderColor: "rgba(35, 198, 200, 0.85)",
						                pointBackgroundColor: "rgba(35, 198, 200, 1)",
						                pointBorderColor: "#fff",
						                data: pengajaran
						            },{
						                label: "Penelitian",
						                backgroundColor: 'rgba(248, 172, 89, 0.3)',
						                borderColor: "rgba(248, 172, 89, 0.85)",
						                pointBackgroundColor: "rgba(248, 172, 89, 1)",
						                pointBorderColor: "#fff",
						                data: penelitian
						            },{
						                label: "Penunjang",
						                backgroundColor: 'rgba(173, 173, 173, 0.3)',
						                borderColor: "rgba(173, 173, 173, 0.85)",
						                pointBackgroundColor: "rgba(173, 173, 173, 1)",
						                pointBorderColor: "#fff",
						                data: penunjang
						            },{
						                label: "Struktural",
						                backgroundColor: 'rgba(237, 85, 101, 0.3)',
						                borderColor: "rgba(237, 85, 101, 0.85)",
						                pointBackgroundColor: "rgba(237, 85, 101, 1)",
						                pointBorderColor: "#fff",
						                data: struktural
						            },{
						                label: "Non Struktural",
						                backgroundColor: 'rgba(26, 179, 148, 0.3)',
						                borderColor: "rgba(26, 179, 148, 0.85)",
						                pointBackgroundColor: "rgba(26, 179, 148, 1)",
						                pointBorderColor: "#fff",
						                data: nonstruktural
						            }
						        ]
						    };

						    var lineOptions = {
						        scaleShowGridLines: true,
						        scaleGridLineColor: "rgba(0,0,0,.05)",
						        scaleGridLineWidth: 1,
						        bezierCurve: true,
						        bezierCurveTension: 0.4,
						        pointDot: true,
						        pointDotRadius: 4,
						        pointDotStrokeWidth: 1,
						        pointHitDetectionRadius: 20,
						        datasetStroke: true,
						        datasetStrokeWidth: 2,
						        datasetFill: true,
						        responsive: true,
						    };

						    $("#lineChart").css("display", "inline");
							$("#chart").css("display", "none");
						    var ctx = document.getElementById("lineChart").getContext("2d");
						    new Chart(ctx, {type: 'line', data: lineData, options:lineOptions});
						setTimeout(function(){t.ladda('stop');},100);
					},
					error: function(status){

					}
        		});
	    	});
	    });     
	</script>