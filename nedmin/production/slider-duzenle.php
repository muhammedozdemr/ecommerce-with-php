<?php 
include 'header.php'; 

$slidersor=$db->prepare("SELECT * FROM slider WHERE slider_id=:slider_id");
$slidersor->execute(array(
  'slider_id' => $_GET['slider_id']
));

$slidercek=$slidersor->fetch(PDO::FETCH_ASSOC);
?>  
   <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
         
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Slider Düzenle 
                    	<small>	
                    	<?php if($_GET['durum']=="ok"){?>
                    		<b style="color: green">İşlem Başarılı...</b>
                    	<?php }elseif($_GET['durum']=="no") {?>
                    		<b style="color: red">İşlem Başarısız...</b>
                    	<?php } ?>
                 		 </small>
                 	</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
               <form action="../netting/islem.php" method="POST" id="demo-form2" enctype="multipart/for-data" data-parsley-validate class="form-horizontal form-label-left">
         <input type="hidden" name="slider_id" value="<?php echo $slidercek["slider_id"] ?>">
         <input type="hidden" name="slider_resimyol" value="<?php echo $slidercek["slider_resimyol"] ?>">
         	<div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Yüklü Resim <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                   <img width="200" height="120"  src="../../<?php echo $slidercek["slider_resimyol"]; ?>">
                </div>
          	</div>
          	<div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Slider Resim <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="file" id="first-name" name="slider_resimyol" class="form-control col-md-7 col-xs-12">
                </div>
            </div>
                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Slider Adı <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="first-name" name="slider_ad" value="<?php echo $slidercek["slider_ad"] ?>" required="required" class="form-control col-md-7 col-xs-12">
                </div>
                </div>
                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Slider Link <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="first-name" name="slider_link" value="<?php echo $slidercek["slider_link"] ?>"  class="form-control col-md-7 col-xs-12">
                </div>
                </div>
                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Slider Sıra <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="first-name" name="slider_sira" value="<?php echo $slidercek["slider_sira"] ?>" required="required" class="form-control col-md-7 col-xs-12">
                </div>
                </div>
                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Slider Durum <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control" name="slider_durum" id="heard" required>
                <?php
                  if($slidercek["slider_durum"]==1){ ?>
                        <option value="1">Aktif</option>
                        <option value="0">Pasif</option>
                  <?php } else { ?>
                  
                      <option value="0">Pasif</option>
                      <option value="1">Aktif</option>
                  <?php }    ?>
                    
                      
                    
                    </select>
                </div>
                </div>
                
                
            
                <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3" align="right">
                          <button class="btn btn-success" name="sliderduzenle" type="submit">Güncelle</button>
						 
                          
                        </div>
                      </div>
                </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
       

<?php include 'footer.php'; ?>       