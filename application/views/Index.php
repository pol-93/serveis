<body style="background-color:#abc;">
		
		<div class="container">
			<div class="row">
				<div class="col-xs-10 col-xs-offset-1 col-md-6 col-md-offset-3">
					<form id="f1" name="f1" action="<?php echo site_url("indexController/validar"); ?>" method="Post">
						<div id="dadesUsuari" style="background-color:white;border:2px solid black;border-radius:5px;padding:20px;">
								<div style="text-align:center;margin:0px auto;">
								<img style="float:left;margin-left:10px;margin:0px auto;margin-bottom:20px;" src="<?php echo base_url()."/img/logo.jpg"; ?>"></img>
								</div>
								<input placeholder="Usuari" style="margin-bottom:20px;" class="form-control" type="text" name="usuari" id="usuari"/>
								<input placeholder="Contrasenya" style="margin-bottom:20px;" class="form-control" type="password" name="clau" id="clau"/>
								<input style="background-image:-webkit-linear-gradient(to bottom,#d9534f 0,#FC3828 100%);background-color: #FC3828;border-color:#594F4D;background-image:linear-gradient(to bottom,#d9534f 0,#FC3828 100%);width:100%;font-size:18px;font-family:helvetica;display:block;margin-top:10px;clear:both;" type="submit" class="btn btn-info" value="Validar" style="width:100%;" />		
						</div>
					</form>
				</div>
			</div>
		</div>
		<script>
			$("#dadesUsuari").css("margin-top", function() {
				$(this).css("left",20);
				return ($(window).height()-$(this).height())/2-100;
			});
		</script>
	</body>
</html>

