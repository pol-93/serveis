
	<body>
		<div class="container-fluid">
			<div id="tot" class="col-xs-12 col-md-8 col-md-offset-2" style="border:1px solid black;background-color:#DFDFDF;border-color:black;margin-top:20px;">
				<div class="row" style="margin-bottom:20px;">
					<a href="<?php echo site_url("LoginEmpresa/Index"); ?>"><input type="button" class="btn btn-danger" onclick="sortir()" style="float:right;display:block;margin-top:15px;margin-right:15px;" value="Sortir"></input></a>
					<a href="<?php  echo site_url("/Entrada/Index"); ?>"><input type="button" class="btn btn-danger" style="float:right;display:block;margin-top:15px;margin-right:15px;" value="Tots els Comunicats"></input></a>
				</div>
				<h1 style="text-align:center;margin:20px;">Avui tens Comunicats en els seguents emplaçaments</h1>
				<?php 
				foreach ($emplacaments as $emplaçament){
					?>
					<div style="margin:20px;">
					<form name="f1" method="POST" action="<?php echo site_url("LoginEmpresaQr/mostrarparte"); ?>">
						<?php echo '<h2 style="text-align:center;margin:10px;"> '.$emplaçament["Equip"].'</h2>'; ?> 
						<input type="hidden" name="CodiClient" value="<?php echo $emplaçament["CodiClient"]; ?>"></input>
						<button name="valor" value="<?php echo $emplaçament["CodiEmplaçament"]; ?>" style="display:block;background-color:#CA3C38;width:80%;font-family:helvetica;padding:10px;margin:0px auto;border-radius:5px;border:1px solid black;color:white;">
							<?php echo $emplaçament["NomEmplaçament"]; ?>
						</button>
					</form>
					</div>
					<?php
				}
					?>
			</div>
		</div>
</body>
</html>
