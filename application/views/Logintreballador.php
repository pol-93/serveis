
		<div class="container">
			<div style="margin-bottom:-35px;width:50%;margin:0px auto;">
			
				<p style="float:right;margin-top:2px;"><a href="<?php echo site_url("IndexController/deletesessions/"); ?>"><input type="button" class="btn btn-danger" value="Pàgina Principal"></a></input></p>
			</div>
			<div class="row">
				<div class="col-xs-10 col-xs-offset-1 col-md-6 col-md-offset-3">
					<div id="dadesUsuari" style="background-color:white;border:2px solid black;border-radius:5px;padding:20px;">
							<img style="display:block;margin:0px auto;margin-bottom:20px;" src="<?php echo base_url("./assets/img/logo.jpg") ?>"></img>
							<?php echo '<p style="font-size:25px;font-family:helvetica;margin-bottom:10px;">'.$treballadors[0][0].'</p>'; ?>
							<div style="margin-bottom:10px;">
							<p id="myElem" class="alert alert-danger" style="Display:none;font-size:16px;font-family:helvetica;padding:5px;"> Dades incorrectes </p>
							<select class="form-control" id="treballador" name="treballadors">
							<option selected disabled> Seleccionar un treballador</option>
							
							<?php
								foreach($treballadors as $r){
									echo '<option value="'.$r[1].'">'.$r[2].'</option>';
								}
							?>						
							
							</select>
							</div>	
							<input placeholder="CodiFitxa" class="form-control input-md" style="display:inline-block;height: 26px;padding: 4px 6px;margin-bottom: 10px;font-size: 16px;line-height: 20px;color: #555555;-webkit-border-radius: 4px;-moz-border-radius: 4px;border-radius: 4px;vertical-align: middle;" id="clau"/>
							<input style="background-image:-webkit-linear-gradient(to bottom,#d9534f 0,#FC3828 100%);background-color: #FC3828;border-color:#594F4D;background-image:linear-gradient(to bottom,#d9534f 0,#FC3828 100%);width:100%;font-size:18px;font-family:helvetica;display:block;margin-top:10px;clear:both;" type="button" class="btn btn-info" onclick="validar()" value="Validar" style="width:100%;" />			
					</div>
				</div>
			</div>
		</div>
		<script>

			$("#dadesUsuari").css("margin-top", function() {
				$(this).css("left",20);
				return ($(window).height()-$(this).height())/2-150;
			});
			
			function validar() {

				$.ajax({
					url: "validarteaempresa",
					method: "POST",
					data: {usuari:$("#treballador").val(),clau:$("#clau").val()},
					success: function(resultat){
						console.log(resultat);
						if (resultat==1) {
							document.location.href="<?php echo site_url("entrada"); ?>";
						}
						else if(resultat==2){
							document.location.href="<?php echo site_url("LoginEmpresaQr"); ?>";
						}
						else{
							$("#myElem").show().delay(5000).fadeOut();
						}
					}
				});
				return false;
			}
		</script>
	</body>
</html>