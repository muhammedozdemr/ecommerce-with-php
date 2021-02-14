<?php include 'header.php';

 ?>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="page-title-wrap">
				<div class="page-title-inner">
					<div class="row">
						<div class="col-md-12">
							<div class="bigtitle">Hesap Bilgilerim</div>
							<p >Bilgilerinizi aşağıdan düzenleyebilirsiniz</p>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>

	<form action="nedmin/netting/islem.php" method="POST" class="form-horizontal checkout" role="form">
		<div class="row">
			<div class="col-md-6">
				<div class="title-bg">
					<div class="title">Kayıt Bilgileri</div>
				</div>


				<div class="form-group dob">
					<div class="col-sm-12">
						
						<input type="text" class="form-control"  required="" name="kullanici_adsoyad" disabled="" value="<?php echo $kullanicicek['kullanici_adsoyad']; ?>">
					</div>
					
				</div>
				<div class="form-group">
					<div class="col-sm-12">
						<input type="email" class="form-control" required="" name="kullanici_mail" value="<?php echo $kullanicicek['kullanici_mail']; ?>">
					</div>
				</div>
				<div class="form-group dob">
					<div class="col-sm-12">
						<input type="password" class="form-control" name="kullanici_password" value="<?php echo $kullanicicek['kullanici_password']; ?>">
					</div>
					
				</div>

				<input type="hidden" name="kullanici_id" value="<?php echo $kullanicicek['kullanici_id']?>">



				<button type="submit" name="bilgilerimiduzenle" class="btn btn-default btn-red">Bilgilerimi Güncelle</button>
			</div>
			<div class="col-md-6">
				<div class="title-bg">
					<div class="title">Parolanızı mı Unuttunuz?</div>
				</div>


				<center><img width="400" src="dimg/pass.jpeg"></center>
			</div>
		</div>
	</div>
</form>
<div class="spacer"></div>
</div>

<?php include 'footer.php'; ?>