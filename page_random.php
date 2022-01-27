<!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Title Page</title>

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>_assets/css/style.css?v=<?=md5(date("his"))?>">
		<!-- <link rel="stylesheet" type="text/css" href="<?=base_url()?>_assets/css/bootstrap.min.css?v=<?=md5(date("his"))?>"> -->
	    <style type="text/css">
			.style1 {font-family: Franklin Gothic}
        </style>
</head>
	<body>

		<header>
		  <h1 class="text-center">PENGUNDIAN DOORPRIZE</h1>
		</header>

		<canvas id="canvas"></canvas>

		<div id="random" class="container">
			<center>
				<?php
					$arrnama[] = 'XXXXX';
					$arrnik[] = '00000';

					foreach($peserta->result_array() as $key => $value){
						$arrnama[] 	= $value['NAMA'];
						$arrnik[] 	= $value['NIK'];
					}
					$arrsnama 	= '["' . implode('", "', $arrnama) . '"]'; 
					$arrsnik	= '["' . implode('", "', $arrnik) . '"]'; 
          $arrniks   = implode(',', $arrnik); 

				?>
				<div class="areaConatiner">
					<p><span id="timespan"></span></p>
				</div>
				<div class="areaConatiner fixarea">
					<h1 id="nama_am" class="namaAM"></h1>
				</div>
				<div class="areaConatiner fixarea2">
					<input type="button" id="substart" value="START"  class="btn btn-yellow btn-circle" />
					<input type="submit" id="substop" value="Stop" class="btn btn-red btn-circle" />
				</div>

				<input type="hidden" name="nikhidden" id="nikhidden" />
        <input type="hidden" name="arrnama" value="<?=$arrsnama?>">
        <input type="hidden" id="arrnik" value="<?=$arrniks?>">

			</center>
		</div>

		<!-- <footer><center style="margin-top: 20px;">Copyright  &copy;Marketing DES © 2017 PT.Telekomunikasi Indonesia Tbk.</center>
		</footer> -->

		<!-- jQuery -->
		<script language="javascript" src="<?=base_url()?>/_assets/jquery.min.js"></script>
		<!-- <script type="text/javascript" src="<?=base_url()?>/_assets/bootstrap.min.js"></script> -->
		<script type="text/javascript">

			acak 		= 999999999999999999999999999999999999999999999999999999999999;
			urut 		= 0;
      count     = <?php echo $count['JML']; ?>;
      jumlah    = <?php echo $count['JML']; ?>;
			nik_set 	= '000000';
			nik_value	= '';
			nik_awal 	= nik_set.split("");
			nik_html 	= '<div class="areaUndi">' + nik_awal.join('</div><div class="areaUndi">') + '</div>';
			cddisplay();



			$(document).ready(function() {
        getListData();
        
        // console.log(jumlah);
				$("#substop").hide();
				$("#canvas").hide();
				$("#substart").click(function () {
					$('#nama_am').text(null);
					countdown();
					$(this).hide();
					$("#substop").show();
				});

				$("#substop").click(function () {
					cdpause();
		          	$(this).hide();
		          	$("#substart").show();
		          	$("#canvas").show();
					var nik_am = $('#nikhidden').val();
					$.ajax({
			            type: "GET",
			            url: "<?=base_url()?>index.php/welcome/setstatus/"+nik_am,
			            success: function (data) {
			            	if(data){
			            		$('#nama_am').text(data);
                      getListData();
			            	}
			            }
		          	});
		          	setTimeout(function() {
					    $('#canvas').fadeOut('fast');
					}, 3000); 
				});
			});

			function cddisplay() {
				document.getElementById('timespan').innerHTML = nik_html;
				document.getElementById('nikhidden').value = nik_value;
			}
			function countdown() {
				// starts countdown
				cddisplay();
				if (acak === 0) {
					// time is up
				} else {
					var myName = <?php echo $arrsnama; ?>;
          var strNik    = $("#arrnik").val();
					var myNik = strNik.split(',');
          var jmlData = parseInt((myNik.length) - 1);

          console.log('ururtan : '+urut +' - Jumlah Data: '+ jmlData);
					acak--;
					count 		= myName[urut];
					nik_html 	= nik_value = myNik[urut];
					cobaNik 	= nik_html.split("");
					nik_html 	= '<div class="areaUndi">' + cobaNik.join('</div><div class="areaUndi">') + '</div>';
          if (urut == jmlData) {
            urut = 0;
          }else{
            urut++;
          }
					t = setTimeout(countdown, 100);
					// console.log('<div class="areaUndi">' + cobaNik.join('</div><div class="areaUndi">') + '</div>');
				}
			}

      function getListData() {
        $.ajax({
          type: "GET",
          url: "<?=base_url()?>index.php/welcome/getListData",
          success: function (data) {
            if(data){
              $("#arrnik").val(data);
            }
          }
        });
      }
      
			function cdpause() {
				// pauses countdown
				clearTimeout(t);
			}
		</script>

		<!-- Efek FireWorks -->
		<script type="text/javascript">
			(function () {
			    var requestAnimationFrame = window.requestAnimationFrame || window.mozRequestAnimationFrame || window.webkitRequestAnimationFrame || window.msRequestAnimationFrame;
			    window.requestAnimationFrame = requestAnimationFrame;
			})();


			var canvas = document.getElementById("canvas"),
			    ctx = canvas.getContext("2d"),
			    width = 0,
			    height = 0,
			    vanishPointY = 0,
			    vanishPointX = 0,
			    focalLength = 300,
			    angleX = 180,
			    angleY = 180,
			    angleZ = 180,
			    angle = 0,
			    cycle = 0,
			    colors = {r : 255, g : 0, b : 0},
			    lastShot = new Date().getTime();

			canvas.width = width;
			canvas.height = height;

			/*
			 *	Controls the emitter
			 */
			function Emitter() {
			    this.reset();
			}

			Emitter.prototype.reset = function () {
			    var PART_NUM = 200,
			        x = (Math.random() * 400) - 200,
			        y = (Math.random() * 400) - 200,
			        z = (Math.random() * 800) - 200;
			    
			    this.x = x || 0;
			    this.y = y || 0;
			    this.z = z || 0;
			    
			    var color = [~~(Math.random() * 150) + 10, ~~(Math.random() * 150) + 10, ~~(Math.random() * 150) + 10]
			    this.particles = [];

			    for (var i = 0; i < PART_NUM; i++) {
			        this.particles.push(new Particle(this.x, this.y, this.z, {
			            r: colors.r,
			            g: colors.g,
			            b: colors.b
			        }));
			    }
			}

			Emitter.prototype.update = function () {
			    var partLen = this.particles.length;

			    angleY = (angle - vanishPointX) * 0.0001;
			    angleX = (angle - vanishPointX) * 0.0001;

			    this.particles.sort(function (a, b) {
			        return b.z - a.z;
			    });

			    for (var i = 0; i < partLen; i++) {
			        this.particles[i].update();
			    }
			    
			    if(this.particles.length <= 0){
			      this.reset();   
			    }

			};

			Emitter.prototype.render = function (imgData) {
			    var data = imgData.data;

			    for (i = 0; i < this.particles.length; i++) {
			        var particle = this.particles[i],
			            dist = Math.sqrt((particle.x - particle.ox) * (particle.x - particle.ox) + (particle.y - particle.oy) * (particle.y - particle.oy) + (particle.z - particle.oz) * (particle.z - particle.oz));

			        if (dist > 255) {
			            particle.render = false;
			            this.particles.splice(i, 1);
			            this.particles.length--;
			        }

			        if (particle.render && particle.xPos < width && particle.xPos > 0 && particle.yPos > 0 && particle.yPos < height) {
			            for (w = 0; w < particle.size; w++) {
			                for (h = 0; h < particle.size; h++) {
			                    if (particle.xPos + w < width && particle.xPos + w > 0 && particle.yPos + h > 0 && particle.yPos + h < height) {
			                        pData = (~~ (particle.xPos + w) + (~~ (particle.yPos + h) * width)) * 4;
			                        data[pData] = particle.color[0];
			                        data[pData + 1] = particle.color[1];
			                        data[pData + 2] = particle.color[2];
			                        data[pData + 3] = 255 - dist;
			                    }
			                }
			            }
			        }
			    }
			};


			/*
			 *	Controls the individual particles
			 */
			function Particle(x, y, z, color) {
			    this.x = x;
			    this.y = y;
			    this.z = z;

			    this.startX = this.x;
			    this.startY = this.y;
			    this.startZ = this.z;

			    this.ox = this.x;
			    this.oy = this.y;
			    this.oz = this.z;

			    this.xPos = 0;
			    this.yPos = 0;

			    this.vx = (Math.random() * 10) - 5;
			    this.vy = (Math.random() * 10) - 5;
			    this.vz = (Math.random() * 10) - 5;

			    this.color = [color.r, color.g, color.b];
			    this.render = true;

			    this.size = Math.round(1 + Math.random() * 1);
			}

			Particle.prototype.rotate = function () {
			    var x = this.startX * Math.cos(angleZ) - this.startY * Math.sin(angleZ),
			        y = this.startY * Math.cos(angleZ) + this.startX * Math.sin(angleZ);

			     this.x = x;
			     this.y = y;
			}

			Particle.prototype.update = function () {
			    var cosY = Math.cos(angleX),
			        sinY = Math.sin(angleX);

			    this.x = (this.startX += this.vx);
			    this.y = (this.startY += this.vy);
			    this.z = (this.startZ -= this.vz);
			    this.rotate();

			    this.vy += 0.1;
			    this.x += this.vx;
			    this.y += this.vy;
			    this.z -= this.vz;

			    this.render = false;

			    if (this.z > -focalLength) {
			        var scale = focalLength / (focalLength + this.z);

			        this.size = scale * 2;
			        this.xPos = vanishPointX + this.x * scale;
			        this.yPos = vanishPointY + this.y * scale;
			        this.render = true;
			    }
			};

			function render() {
			    colorCycle();
			    angleY = Math.sin(angle += 0.01);
			    angleX = Math.sin(angle);
			    angleZ = Math.sin(angle);

			    var imgData = ctx.createImageData(width, height);

			    for (var e = 0; e < 30; e++) {
			        emitters[e].update();
			        emitters[e].render(imgData);
			    }
			    ctx.putImageData(imgData, 0, 0);
			    requestAnimationFrame(render);
			}

			function colorCycle() {
			    cycle += .6;
			    if (cycle > 100) {
			        cycle = 0;
			    }
			    colors.r = ~~ (Math.sin(.3 * cycle + 0) * 127 + 128);
			    colors.g = ~~ (Math.sin(.3 * cycle + 2) * 127 + 128);
			    colors.b = ~~ (Math.sin(.3 * cycle + 4) * 127 + 128);
			}

			var emitters = [];
			for (var e = 0; e < 30; e++) {
			    colorCycle();
			    emitters.push(new Emitter());
			}
			//render();


			// smart trick from @TimoHausmann for full screen pens
			setTimeout(function () {
			    width = canvas.width = window.innerWidth;
			    height = canvas.height = document.body.offsetHeight;
			    vanishPointY = height / 2;
			    vanishPointX = width / 2;
			    render();
			}, 500);
		</script>

		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
		
	</body>
</html>
