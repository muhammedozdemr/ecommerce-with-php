<?php 
include 'header.php';
$urunsor=$db->prepare("SELECT * FROM urun ORDER BY urun_id DESC");
$urunsor->execute();

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
                      <a href="urun-ekle.php"><button class="btn btn-success btn-xs">Yeni Ekle</button></a>
                    </ul>
                    <div class="clearfix"></div>
                    
                  </div>
                  <div class="x_content">
                    <br />
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>S.No</th>
                          <th>Ürün Ad</th>
                          <th>Ürün Stok</th>
                          <th>Ürün Fiyat</th>
                          <th>Ürün Durum</th>
                          <th></th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody> 
                      <?php $say=0; while($uruncek=$urunsor->fetch(PDO::FETCH_ASSOC)) {$say++?>                      
                        <tr>
                          <td width="20"><?php echo $say; ?></td>
                          <td><?php echo $uruncek['urun_ad'] ?></td>
                          <td><?php echo $uruncek['urun_stok'] ?></td>
                          <td><?php echo $uruncek['urun_fiyat'] ?></td>
                          <td>
                          	<?php if ($uruncek['urun_durum']==1) {?>
                          		<button class="btn btn-success btn-xs">Aktif</button>
                          	<?php }else {?>
                          		<button class="btn btn-danger btn-xs">Pasif</button>
                          	<?php } ?>
                          		
                          </td>         
                          <td><a href="urun-duzenle.php?menu_id=<?php echo $uruncek['menu_id'] ?>"><button class="btn btn-primary btn-xs">Düzenle</button></a></td>
                          <td><a href="../netting/islem.php?menu_id=<?php echo $uruncek['menu_id']?>&menusil=ok"><button class="btn btn-danger btn-xs">Sil</button></td>
                          	
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