		
		<div class="row  border-bottom white-bg dashboard-header" id="page-content">
		    <div class="col-md-4">
		        <div>
		        	<div class="ibox-title">
		        		<h4>Dosen per Grade</h4>
		        	</div>
		            <div class="ibox-content" id="grade">
		            	<button class="ladda-button ladda-button-demo btn btn-primary" data-style="expand-right">Loading Grade</button>
		            </div>
		        </div>
		    </div>
		</div>
		
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

		<script async="" src="//www.google-analytics.com/analytics.js"></script>	
		<script src="<?php echo base_url('assets');?>/js/plugins/chartJs/Chart.2.6.0.min.js"></script>
		<script src="<?php echo base_url('assets');?>/js/plugins/sparkline/jquery.sparkline.min.js"></script>
		<script src="<?php echo base_url('assets');?>/js/plugins/ladda/spin.min.js"></script>
		<script src="<?php echo base_url('assets');?>/js/plugins/ladda/ladda.min.js"></script>
		<script src="<?php echo base_url('assets');?>/js/plugins/ladda/ladda.jquery.min.js"></script>
		<script src="<?php echo base_url('assets');?>/js/utils.js"></script>
		<script>
	        var t = $('.ladda-button-demo').ladda();
	        t.ready(function(){
	            t.ladda('start');
	            $.ajax({
		            url: "<?php echo base_url();?>index.php/MainControler/getJsonDosen",
		            type: "POST",
		            // data : { data:0},
		            success: function(ajaxData){
		            	var d = JSON.parse(ajaxData);
		            	var text = '';
		            	for (var i = d.length-1;i >= 7; i--) {
		            		text += 'Grade '+ i +' : '+ d[i] +'<br />';
		            	};
		            	text += 'Grade 0 : '+ d[0];
                    	$("#grade button").remove();
                    	$("#grade").append(text);
		            }
		        });
		        // setTimeout(function(){t.ladda('stop');},2000);
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
		            	}
		            ?>
		            ]
		        };	

		        // show chart
		        window.onload = function() {
		            var jabatan = document.getElementById("datadosen").getContext("2d");
		            window.myBar = new Chart(jabatan, {type: 'bar', data: barJabatan,
		                options: {
		                    tooltips: {
		                    	mode: 'index',
			                    callbacks: {
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
		        };
		    <?php } ?>

	        Chart.plugins.register({
	            afterDatasetsDraw: function(chart, easing) {
	                var ctx = chart.ctx;
	                chart.data.datasets.forEach(function (dataset, i) {
	                    var meta = chart.getDatasetMeta(i);
	                    if (!meta.stack && !meta.hidden) {
	                        meta.data.forEach(function(element, index) {
	                            ctx.fillStyle = 'rgba(2, 2, 2,0.9)';

	                            var fontSize = 16;
	                            var fontStyle = 'normal';
	                            var fontFamily = 'Helvetica Neue';
	                            ctx.font = Chart.helpers.fontString(fontSize, fontStyle, fontFamily);

	                            var dataString = dataset.data[index].toString();

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
		</script>