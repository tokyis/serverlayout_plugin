<?php
require_once('serverlayout_constants.php');

$rows = $myJSONconfig["LAYOUT"]['ROWS'];
$columns = $myJSONconfig["LAYOUT"]['COLUMNS'];
$orientation = $myJSONconfig["LAYOUT"]['ORIENTATION'];
$num_trays = $num_columns * $num_rows;

$count_usb_devices = 0;
foreach ($myJSONconfig["DISK_DATA"] as $disk) {
  if ($disk["TYPE"] == "USB") {
    $count_usb_devices++;
  }
}

if ($orientation == 0) {
  if (($columns * $width) > ($rows * $height)) {
    $layout_orientation = 0;
  } else {
    $layout_orientation = 90;
  }
} else {
  if (($columns * $height) > ($rows * $width)) {
    $layout_orientation = 0;
  } else {
    $layout_orientation = 90;
  }
}
?>

<HTML>
<HEAD>
<style>
.container {
  width: <? echo ($width * $columns); ?>px;
  height: <? echo ($width * $rows); ?>px;
  margin-left: auto;
  margin-right: auto;
  background: rgba(54, 25, 25, 0);  /* Transparent Background */
  overflow: hidden;
  box-sizing: border-box;
}

.row_container {
  width: <? echo ($width * $columns); ?>px;
  height: <? if ($orientation == 0) { echo $height; } else { echo $width; } ?>px;
  box-sizing: border-box;
  overflow: hidden;
}

.cell_container {
  width: <? echo $width; ?>px;
  height: <? echo $height; ?>px;
  box-sizing: border-box;
  float:left;
  overflow: hidden;
}

.cell_background, .cell_background_hide {
  width: <? echo ($width-$background_padding); ?>px;
  height: <? echo ($height-$background_padding); ?>px;
  text-align: center;
  box-sizing: border-box;
  float:left;
  background-image: url(<?php echo $frontpanel_imgfile; ?>);
  border-radius: <?php echo $border_radius; ?>px;
  background-position: center;
  background-size: cover;
  background-repeat: no-repeat;
  overflow: hidden;
}  

.cell_background_hide {
  opacity: 0.2;
}

.cell_status {
  width: <?php echo $status_width; ?>px;
  position: relative;           /* Vertical Center */
  top: 50%;                     /* Vertical Center */
  -webkit-transform: translateY(-50%);  /* Vertical Center */
      -ms-transform: translateY(-50%);  /* Vertical Center */
          transform: translateY(-50%);  /* Vertical Center */
  box-sizing: border-box;
  overflow: hidden;
  float: left;
}

.cell_text_exist, .cell_text_not_exist {
  width: 100%;
  text-align: center;
  position: relative;           /* Vertical Center */
  top: 50%;                     /* Vertical Center */
  -webkit-transform: translateY(-50%);  /* Vertical Center */
      -ms-transform: translateY(-50%);  /* Vertical Center */
          transform: translateY(-50%);  /* Vertical Center */
  padding-left: 5px;
  padding-right: 5px;
  box-sizing: border-box;
  overflow: hidden;
  color: white;
  float: left;
}

.cell_text_exist {
  width: <? echo ($width-$background_padding-$status_width); ?>px;
  padding-left: 0px;
}

.cell_text_exist span:nth-child(even) {
  color: black;
}

.cell_text_exist span:nth-child(odd) {
  color: white;
}

.cell_background_usb {
  width: <? echo ($width_usb); ?>px;
  height: <? echo ($height_usb); ?>px;
  box-sizing: border-box;
  display: inline-block;
  background-image: url(<?php echo $frontpanelusb_imgfile; ?>);
  background-position: center;
  background-size: cover;
  background-repeat: no-repeat;
  overflow: hidden;
}  

.cell_text_usb {
  width: 100%;
  text-align: center;
  position: relative;           /* Vertical Center */
  top: 50%;                     /* Vertical Center */
  -webkit-transform: translateY(-50%);  /* Vertical Center */
      -ms-transform: translateY(-50%);  /* Vertical Center */
          transform: translateY(-50%);  /* Vertical Center */
  padding-left: 30px;
  padding-right: 100px;
  box-sizing: border-box;
  overflow: hidden;
  color: white;
}

.cell_text_usb span:nth-child(even) {
  color: black;
}

.cell_text_usb span:nth-child(odd) {
  color: white;
}

a.tooltip {outline:none; }
a.tooltip:hover {text-decoration:none;}

<?php for ($j = 1; $j<=$columns; $j++) {
  if ($orientation == "0") {
    if ($j <= $columns/2) {
      $margin_left = -50;
    } else {
      $margin_left = -(2*$width) + 50;
    }
  } else if ($orientation == "90") {
    $margin_left = -($j-1)*($width-$height) - $width/2 - $height/2 - 60;
  }
  echo "a.tooltip .table_".$j." td{padding:2px;}\n";
  echo "a.tooltip .table_".$j." {\n";
    echo "  z-index:10;display:none; padding:5px 5px;\n";
    echo "  margin-top:-10px; margin-left:".$margin_left."px;\n";
    echo "  width:".$width."px; line-height:100%;\n";
    echo "  border-radius:".$border_radius."px;\n";
    echo "  box-shadow: 5px 5px 8px #CCC;\n";
  echo "}\n";

  echo "a.tooltip:hover .table_".$j."{\n";
    echo "  display:inline; position:absolute; color:#111;\n";
    echo "  border:1px solid #DCA; background:#fffAF0;\n";
  echo "}\n";

  echo "a.tooltip .table_".$j.":after {\n";
    echo "  border-top: solid transparent 10px;\n";
    echo "  border-bottom: solid transparent 10px;\n";
    echo "  top: ".($height/2-$background_padding)."px;\n";
    echo "  content: \" \";\n";
    echo "  height: 0;\n";
    if ((($orientation == "0") and ($j <= $columns/2)) or ($orientation == "90")) {
      echo "  right: 100%;\n";
      echo "  border-right: solid #fffAF0 10px;\n";
      echo "  margin-right: -2px;\n";
    } else {
      echo "  left: 100%;\n";
      echo "  border-left: solid #fffAF0 10px;\n";
      echo "  margin-left: -2px;\n";
    }
    echo "  position: absolute;\n";
    echo "  width: 0;\n";
  echo "}\n";
} ?>

  a.tooltip .table_usb td{padding:2px;}
  a.tooltip .table_usb {
    z-index:10;display:none; padding:5px 5px;
    margin-bottom:0px; margin-left:<?php echo (-($width_usb+$width)/2); ?>px;
    width:<?php echo $width; ?>px; line-height:100%;
    border-radius:<?php echo $border_radius; ?>px;
    box-shadow: 5px 5px 8px #CCC;
    bottom: <?php echo ($height_usb); ?>px;
  }

  a.tooltip:hover .table_usb{
    display:inline; position:absolute; color:#111;
    border:1px solid #DCA; background:#fffAF0;
  }

  a.tooltip .table_usb:after {
    border-left: solid transparent 10px;
    border-right: solid transparent 10px;
    left: 50%;
    content: " ";
    height: 0;
    border-top: solid #fffAF0 10px;
    bottom: -10px;
    margin-left: -13px;
    position: absolute;
    width: 0;
  }

</style>

<script type="text/javascript">
function UpdateDIVSizes() {
  var orientation = <?php echo $orientation; ?>;
  var element = document.getElementById("container");
  if (orientation == 0) {
    element.style.height = "<?php echo ($height * $rows); ?>px";
  } else {
    element.style.width = "<?php echo ($height * $columns); ?>px";
  }
}
</script>
</HEAD>
<BODY>

<div class="container" id="container">
<?php for ($i = 1; $i <= $rows; $i++) { ?>
  <div class="row_container">
  <?php for ($j = 1; $j <= $columns; $j++) {
      $x_translate = $orientation/90*(-$width/2 + $height/2 - ($j-1)*($width-$height));
      $y_translate = $orientation/90*(-$width/2 + $height/2); ?>
    <?php if ($myJSONconfig["GENERAL"]["TOOLTIP_ENABLE"] == "YES") { ?>
    <a href="#" class="tooltip"> <?php } ?>
    <div class="cell_container" <?php if ($orientation == 90) {
                                        echo "style=\"-webkit-transform: rotate(-90deg) translate(".$y_translate."px, ".$x_translate."px);
                                                      -ms-transform: rotate(-90deg) translate(".$y_translate."px, ".$x_translate."px);
                                                      transform: rotate(-90deg) translate(".$y_translate."px, ".$x_translate."px);\""; } ?>>
      <?php $tray_num = (($i-1) * $columns) + $j;
            $no_disk_exist = true;
            if ($myJSONconfig["TRAY_SHOW"][$tray_num] == "YES") { ?>
      <div class="cell_background">
        <?php if ($myJSONconfig["DISK_DATA"] != "") {
                foreach ($myJSONconfig["DISK_DATA"] as $disk) {
                  if (($disk["STATUS"]=="INSTALLED") and ($disk["TRAY_NUM"] == $tray_num)) {
                    echo "<div class=\"cell_status\"><img src=\"/webGui/images/".$disk["COLOR"].".png\" width=\"".$status_width."px\"></div>";
                    echo "<div class=\"cell_text_exist\">";
                    $no_disk_exist = false;
                    $no_data_show = true;
                    foreach ($myJSONconfig["DATA_COLUMNS"] as $data_col) {
                      if (($data_col["SHOW_DATA"] == "YES") and ($disk[$data_col["NAME"]] != "")) {
                        $no_data_show = false;
                        echo "<span>".$disk[$data_col["NAME"]]." </span>";
                      }
                    }
                    if ($no_data_show) {
                      echo "<span>No data fields selected in Settings tab</span>";
                    }
                    echo "</div>";
                    break;
                  }
                }
              }
              if ($no_disk_exist) {
                echo "<div class=\"cell_text_not_exist\">";
                echo "<span>".$tray_num."</span>";
                echo "</div>";
              } ?>
      </div>
      <?php } else { ?>
      <div class="cell_background_hide">
      </div>
      <?php } ?>
    </div>
    <?php if ($myJSONconfig["GENERAL"]["TOOLTIP_ENABLE"] == "YES") {
            if (!$no_disk_exist) {
              $no_data_show = true;
              echo "<table class=\"table_".$j."\">";
              foreach ($myJSONconfig["DATA_COLUMNS"] as $data_col) {
                if ($data_col["SHOW_TOOLTIP"] == "YES") {
                  $no_data_show = false;
                  echo "<tr><td style=\"text-align:right; padding-right:5px; width:50%;\">".$data_col["TITLE"].":</td>";
                  echo "<td style=\"text-align:left; padding-left:5px;\"><b>".$disk[$data_col["NAME"]]."</b></td></tr>";
                }
              }
              if ($no_data_show) {
                echo "<tr><td style=\"text-align:center; height:".$height."px; vertical-align:middle;\">No data fields selected in Settings tab</td><tr>";
              }
              echo "</table>";
            }
            echo "</a>";
          } ?>
  <?php } ?>
  </div>
<?php } ?>
</div>

<br>
<br>

<?php if ($count_usb_devices > 0) { ?>
<div style="text-align:center;">
<?php foreach ($myJSONconfig["DISK_DATA"] as $disk) {
        if ($disk["TYPE"] == "USB") {
          $no_data_show = true;
          if ($myJSONconfig["GENERAL"]["TOOLTIP_ENABLE"] == "YES") { ?>
            <a href="#" class="tooltip">
    <?php }
          echo "<div class=\"cell_background_usb\">";
          echo "<div class=\"cell_text_usb\">";
          foreach ($myJSONconfig["DATA_COLUMNS"] as $data_col) {
            if (($data_col["SHOW_DATA"] == "YES") and ($disk[$data_col["NAME"]] != "")) {
              $no_data_show = false;
              echo "<span>".$disk[$data_col["NAME"]]." </span>";
            }
          }
          if ($no_data_show) {
            echo "<span>No data fields selected in Settings tab</span>";
          }
          echo "</div>";
          echo "</div>";
          if ($myJSONconfig["GENERAL"]["TOOLTIP_ENABLE"] == "YES") {
            $no_data_show = true;
            echo "<table class=\"table_usb\">";
            foreach ($myJSONconfig["DATA_COLUMNS"] as $data_col) {
              if ($data_col["SHOW_TOOLTIP"] == "YES") {
                $no_data_show = false;
                echo "<tr><td style=\"text-align:right; padding-right:5px; width:60%;\">".$data_col["TITLE"].":</td>";
                echo "<td style=\"text-align:left; padding-left:5px;\"><b>".$disk[$data_col["NAME"]]."</b></td></tr>";
              }
            }
            if ($no_data_show) {
              echo "<tr><td style=\"text-align:center; height:".$height."px; vertical-align:middle;\">No data fields selected in Settings tab</td><tr>";
            }
            echo "</table>";
            echo "</a>";
          }
        }
      } ?>
</div>
<?php } ?>

<script>UpdateDIVSizes();</script>

</BODY>
</HTML>
