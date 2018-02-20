<html>
<body>
  <div class="container" style="margin-top:20px;">
      <div class="row">
          <p style="float:right;margin-bottom:20px;margin-right:20px;font-family:helvetica;"><a href="<?php echo site_url("LoginController/sortir");?>">Sortir <i class="fa fa-sign-out" aria-hidden="true"></i>
              </a></p>
    <div class="row" style="margin-bottom:20px;">
        <div class="col-xs-12">
        <p style="text-align:center;font-size:20px;font-family:helvetica;">Codi Fitxa: <?php echo $logs[0]["CodiFitxa"];?></p>
        </div>
    </div>
    <div class="row">
      <?php
if($logs!=0){
        echo '<div class="col-xs-12">';
      echo '<div class="row">';
      echo '<div class="col-xs-5" style="font-family:Helvetica;font-size:18px;text-align:center;margin-bottom:10px;"> Dia </div>';
      echo '<div class="col-xs-4" style="font-family:Helvetica;font-size:18px;text-align:center;margin-bottom:10px;"> Hora </div>';
      echo '<div class="col-xs-3" style="font-family:Helvetica;font-size:18px;text-align:center;margin-bottom:10px;"> Borrar </div>';
      echo '</div>';
        for($i=0;$i<sizeof($logs);$i++){
            echo '<div style=" border-bottom:1px solid gray;margin-bottom:5px;" class="row">';
            echo '<div class="col-xs-5" style="text-align:center;font-family:helvetica;">'. $logs[$i]["Data"] .'</div>';
            echo '<div class="col-xs-4" style="text-align:center;font-family:helvetica;">'. $logs[$i]["Hora"] .'</div>';
            echo '<div class="col-xs-3" style="text-align:center;font-family:helvetica;"> <a href="'.site_url("LoginController/borrarfitxar/".$logs[$i]["CodiFitxa"]."/".$logs[$i]["Data"]."/".$logs[$i]["Hora"]."/".$logs[$i]["Longitud"]."/".$logs[$i]["Altitud"]).'"><i class="fa fa-trash-o" aria-hidden="true"></i>
</a></div>';
            echo '</div>';
        }
        echo '</div>';
}
      else{
          echo '<p>sense fitxatges</p>';
      }
      ?>
    </div>
  </div>
</body>
  <script type="text/javascript" src="<?php echo base_url("assets/Ajax/code.js");?>"></script>
</html>