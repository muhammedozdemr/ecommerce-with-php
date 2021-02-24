<?php 
include 'header.php';
$bankasor=$db->prepare("SELECT * FROM banka ORDER BY banka_id ASC");
$bankasor->execute();

 ?>  
   <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
         
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Kullanıcıları Listele 
                    	<small>	
                    	<?php if($_GET['durum']=="ok"){?>
                    		<b style="color: green">İşlem Başarılı...</b>
                    	<?php }elseif($_GET['durum']=="no") {?>
                    		<b style="color: red">İşlem Başarısız...</b>
                    	<?php } ?>
                 		 </small>
                 	</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <a href="banka-ekle.php"><button class="btn btn-success btn-xs">Yeni Ekle</button></a>
                    </ul>
                    <div class="clearfix"></div>
                    
                  </div>
                  <div class="x_content">
                    <br />
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>S.No</th>
                          <th>Banka Ad</th>
                          <th>Banka IBAN</th>
                          <th>Banka Hesap Ad Soyad</th>
                          <th>Banka Durum</th>
                          <th></th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody> 
                      <?php $say=0; while($bankacek=$bankasor->fetch(PDO::FETCH_ASSOC)) {$say++?>                      
                        <tr>
                          <td width="20"><?php echo $say; ?></td>
                          <td><?php echo $bankacek['banka_ad'] ?></td>
                          <td><?php echo $bankacek['banka_iban'] ?></td>
                          <td><?php echo $bankacek['banka_hesapadsoyad'] ?></td>
                          <td>
                          	<?php if ($bankacek['banka_durum']==1) {?>
                          		<button class="btn btn-success btn-xs">Aktif</button>
                          	<?php }else {?>
                          		<button class="btn btn-danger btn-xs">Pasif</button>
                          	<?php } ?>
                          		
                          </td>         
                          <td><a href="banka-duzenle.php?banka_id=<?php echo $bankacek['banka_id'] ?>"><button class="btn btn-primary btn-xs">Düzenle</button></a></td>
                          <td><a href="../netting/islem.php?kategori_id=<?php echo $bankacek['banka_id']?>&bankasil=ok"><button class="btn btn-danger btn-xs">Sil</button></td>
                          	
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