<?php 
include 'header.php';
$yorumsor=$db->prepare("SELECT * FROM yorumlar");
$yorumsor->execute();

 ?>  
   <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
         
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Yorumlar Listele 
                    	<small>	
                    	<?php if($_GET['durum']=="ok"){?>
                    		<b style="color: green">İşlem Başarılı...</b>
                    	<?php }elseif($_GET['durum']=="no") {?>
                    		<b style="color: red">İşlem Başarısız...</b>
                    	<?php } ?>
                 		 </small>
                 	</h2>
                  
                    <div class="clearfix"></div>
                    
                  </div>
                  <div class="x_content">
                    <br />
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>S.No</th>
                          <th>Kullanıcı id</th>
                          <th>Ürün id</th>
                          <th>Yorum Detay</th>
                          <th>Zaman</th>
                          <th></th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody> 
                      <?php $say=0; while($yorumcek=$yorumsor->fetch(PDO::FETCH_ASSOC)) {$say++?>                      
                        <tr>
                          <td width="20"><?php echo $say; ?></td>
                          <td><?php echo $yorumcek['kullanici_id'] ?></td>
                          <td><?php echo $yorumcek['urun_id'] ?></td>
                          <td><?php echo $yorumcek['yorum_detay'] ?></td>
                          <td><?php echo $yorumcek['yorum_zaman'] ?></td>         
                          <td></td>
                          <td><a href="../netting/islem.php?yorum_id=<?php echo $yorumcek['yorum_id']?>&yorumsil=ok"><button class="btn btn-danger btn-xs">Sil</button></td>
                          	
                        </tr>
                    <?php } ?>
                      </tbody>
                    </table>
                	
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

<?php include 'footer.php'; ?>       