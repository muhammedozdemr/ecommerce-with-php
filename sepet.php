<?php include 'header.php'; ?>

	<div class="container">
		<ul class="small-menu"><!--small-nav -->
			<li><a href="" class="myacc">My Account</a></li>
			<li><a href="" class="myshop">Shopping Chart</a></li>
			<li><a href="" class="mycheck">Checkout</a></li>
		</ul><!--small-nav -->
		<div class="clearfix"></div>
		<div class="lines"></div>
	</div>
	
	<div class="container">
		
		<div class="title-bg">
			<div class="title">Alışveriş Sepetim</div>
		</div>
		
		<div class="table-responsive">
			<table class="table table-bordered chart">
				<thead>
					<tr>
						<th>Remove</th>
						<th>Ürün Resim</th>
						<th>Ürün Ad</th>
						<th>Ürün Kodu</th>
						<th>Adet</th>
						<th>Toplam Fiyat</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$kullanici_id=$kullanicicek['kullanici_id'];
					$sepetsor=$db->prepare("SELECT * FROM sepet WHERE kullanici_id=:id");
					$sepetsor->execute(array(
						'id'=>$kullanici_id
					));
					while($sepetcek=$sepetsor->fetch(PDO::FETCH_ASSOC)){
						$urun_id=$sepetcek['urun_id'];
						$urunsor=$db->prepare("SELECT * FROM urun WHERE urun_id=:urun_id");
						$urunsor->execute(array(
							'urun_id'=>$urun_id
						));
						$uruncek=$urunsor->fetch(PDO::FETCH_ASSOC);
						$toplam_fiyat+=$uruncek['urun_fiyat']*$sepetcek['urun_adet'];
						?>
					
					<tr>
						<td><form><input type="checkbox"></form></td>
						<td><img src="images\demo-img.jpg" width="100" alt=""></td>
						<td><?php echo $uruncek['urun_ad'] ?></td>
						<td><?php echo $uruncek['urun_id'] ?></td>
						<td><form><input type="text" class="form-control quantity" value="<?php echo $sepetcek['urun_adet']; ?>"></form></td>
						<td><?php echo $uruncek['urun_fiyat'] ?></td>
						
					</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
		<div class="row">
			<div class="col-md-6">
				
				
			</div>
			<div class="col-md-3 col-md-offset-3">
			<div class="subtotal-wrap">
				<!--<div class="subtotal">
					<p>Toplam Fiyat : $26.00</p>
					<p>KDV 17% : $54.00</p>
				</div>-->
				<div class="total">Total : <span class="bigprice"><?php echo $toplam_fiyat ?></span></div>
				
				<div class="clearfix"></div>
				<a href="" class="btn btn-default btn-yellow">Ödeme Sayfası</a>
			</div>
			<div class="clearfix"></div>
			</div>
		</div>
		<div class="spacer"></div>
	</div>
	
	<?php include 'footer.php'; ?>