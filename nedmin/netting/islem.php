<?php
ob_start();
session_start();
include 'baglan.php';
include '../fonksiyon.php';

//Kullanıcı Kaydet
if (isset($_POST['kullanicikaydet'])) {

	
	echo $kullanici_adsoyad=htmlspecialchars($_POST['kullanici_adsoyad']); echo "<br>";
	echo $kullanici_mail=htmlspecialchars($_POST['kullanici_mail']); echo "<br>";

	echo $kullanici_passwordone=$_POST['kullanici_passwordone']; echo "<br>";
	echo $kullanici_passwordtwo=$_POST['kullanici_passwordtwo']; echo "<br>";


	if ($kullanici_passwordone==$kullanici_passwordtwo) {


		if (strlen($kullanici_passwordone>=6)) {


// Başlangıç

			$kullanicisor=$db->prepare("SELECT * FROM kullanici WHERE kullanici_mail=:mail");
			$kullanicisor->execute(array(
				'mail' => $kullanici_mail
				));

			//dönen satır sayısını belirtir
			$say=$kullanicisor->rowCount();



			if ($say==0) {

				//md5 fonksiyonu şifreyi md5 şifreli hale getirir.
				$password=md5($kullanici_passwordone);

				$kullanici_yetki=0;

			//Kullanıcı kayıt işlemi yapılıyor...
				$kullanicikaydet=$db->prepare("INSERT INTO kullanici SET
					kullanici_adsoyad=:kullanici_adsoyad,
					kullanici_mail=:kullanici_mail,
					kullanici_password=:kullanici_password,
					kullanici_yetki=:kullanici_yetki
					");
				$insert=$kullanicikaydet->execute(array(
					'kullanici_adsoyad' => $kullanici_adsoyad,
					'kullanici_mail' => $kullanici_mail,
					'kullanici_password' => $password,
					'kullanici_yetki' => $kullanici_yetki
					));

				if ($insert) {


					header("Location:../../index.php?durum=loginbasarili");


				//Header("Location:../production/genel-ayarlar.php?durum=ok");

				} else {


					header("Location:../../register.php?durum=basarisiz");
				}

			} else {

				header("Location:../../register.php?durum=mukerrerkayit");



			}




		// Bitiş



		} else {


			header("Location:../../register.php?durum=eksikparola");


		}



	} else {



		header("Location:../../register.php?durum=farkliparola");
	}
	


}


//Admin giriş işlemleri
if(isset($_POST['admingiris']))
{
	$kullanici_mail=$_POST['kullanici_mail'];
	$kullanici_password=md5($_POST['kullanici_password']);

	$kullanicisor=$db->prepare("SELECT * FROM kullanici WHERE kullanici_mail=:mail and kullanici_password=:password and kullanici_yetki=:yetki");
	$kullanicisor->execute(array(
		'mail'=>$kullanici_mail,
		'password'=>$kullanici_password,
		'yetki'=>1
	));

	$say=$kullanicisor->rowCount();

	if($say==1)
	{
		$_SESSION['kullanici_mail']=$kullanici_mail;
		header("Location:../production/index.php");
	}else{
		header("Location:../production/login.php?durum=no");
		exit;
	}

}

//Kullanıcı Giriş
if(isset($_POST['kullanicigiris']))
{
	echo $kullanici_mail=htmlspecialchars($_POST['kullanici_mail']);
	echo $kullanici_password=md5($_POST['kullanici_password']);

	$kullanicisor=$db->prepare("SELECT * FROM kullanici WHERE kullanici_mail=:mail and kullanici_password=:password and kullanici_yetki=:yetki and kullanici_durum=:durum");
	$kullanicisor->execute(array(
		'mail'=>$kullanici_mail,
		'password'=>$kullanici_password,
		'yetki'=>1,
		'durum'=>1
	));

	$say=$kullanicisor->rowCount();

	if($say==1)
	{
		echo $_SESSION['userkullanici_mail']=$kullanici_mail;

		header("Location:../../");
		exit;
	}else{
		header("Location:../../?durum=basarisiz");
		exit;
	}

}

//Kullanıcı Bilgilerini Düzenle
if(isset($_POST['bilgilerimiduzenle']))
{
	$kullanici_id=$_POST['kullanici_id'];
	
	$ayarkaydet=$db->prepare("UPDATE kullanici SET
		kullanici_mail=:kullanici_mail,
		kullanici_password=:kullanici_password
		WHERE kullanici_id={$_POST['kullanici_id']}");

	$update=$ayarkaydet->execute(array(
		'kullanici_mail' =>$_POST['kullanici_mail'],
		'kullanici_password' =>md5($_POST['kullanici_password'])
		));

	if ($update) {
		header("Location:../../hesabim.php?durum=ok");
	}else{
		header("Location:../../hesabim.php?durum=no");
	}
}

//Logo Güncelle
if(isset($_POST['logoduzenle'])){

	$uploads_dir = '../../dimg';//resmin yüklenecegi adres
	@$tmp_name = $_FILES['ayar_logo']["tmp_name"];//önbelleğe alma işlemi
	@$name = $_FILES['ayar_logo']["name"];//isim atama

	$benzersizsayi4=rand(20000,32000);//random değer atama
	$refimgyol=substr($uploads_dir, 6)."/".$benzersizsayi4.$name;//6 karakterden sonrakileri yaz

	@move_uploaded_file($tmp_name,"$uploads_dir/$benzersizsayi4$name");//resmi klasöre yükle

	$duzenle=$db->prepare("UPDATE ayar SET
		ayar_logo=:logo
		WHERE ayar_id=0");
	$update=$duzenle->execute(array(
		'logo' => $refimgyol
	));

	if($update){
		$resimsilunlink=$_POST['eski_yol'];
		unlink("../../$resimsilunlink");

		Header("Location:../production/genel-ayar.php?durum=ok");
	}else {
		Header("Location:../production/genel-ayar.php?durum=no");
	}
}


//Genel Ayar Güncelle
if(isset($_POST['genelayarkaydet']))
{
	$ayarkaydet=$db->prepare("UPDATE ayar SET
		ayar_title=:ayar_title,
		ayar_description=:ayar_description,
		ayar_keywords=:ayar_keywords,
		ayar_author=:ayar_author
		WHERE ayar_id=0");

	$update=$ayarkaydet->execute(array(
		'ayar_title' =>$_POST['ayar_title'],
		'ayar_description' =>$_POST['ayar_description'],
		'ayar_keywords' =>$_POST['ayar_keywords'],
		'ayar_author' =>$_POST['ayar_author']
	));

	if ($update) {
		header("Location:../production/genel-ayar.php?durum=ok");
	}else{
		header("Location:../production/genel-ayar.php?durum=no");
	}
}

//İletişim Ayar Güncelle
if(isset($_POST['iletisimayarkaydet']))
{
	$ayarkaydet=$db->prepare("UPDATE ayar SET
		ayar_tel=:ayar_tel,
		ayar_gsm=:ayar_gsm,
		ayar_fax=:ayar_fax,
		ayar_mail=:ayar_mail,
		ayar_ilce=:ayar_ilce,
		ayar_il=:ayar_il,
		ayar_adres=:ayar_adres,
		ayar_mesai=:ayar_mesai
		WHERE ayar_id=0");

	$update=$ayarkaydet->execute(array(
		'ayar_tel' =>$_POST['ayar_tel'],
		'ayar_gsm' =>$_POST['ayar_gsm'],
		'ayar_fax' =>$_POST['ayar_fax'],
		'ayar_mail' =>$_POST['ayar_mail'],
		'ayar_ilce' =>$_POST['ayar_ilce'],
		'ayar_il' =>$_POST['ayar_il'],
		'ayar_adres' =>$_POST['ayar_adres'],
		'ayar_mesai' =>$_POST['ayar_mesai']
	));

	if ($update) {
		header("Location:../production/iletisim-ayar.php?durum=ok");
	}else{
		header("Location:../production/iletisim-ayar.php?durum=no");
	}
}

//Api Ayar Güncelle
if(isset($_POST['apiayarkaydet']))
{
	$ayarkaydet=$db->prepare("UPDATE ayar SET
		ayar_analystic=:ayar_analystic,
		ayar_maps=:ayar_maps,
		ayar_zopim=:ayar_zopim
		WHERE ayar_id=0");

	$update=$ayarkaydet->execute(array(
		'ayar_analystic' =>$_POST['ayar_analystic'],
		'ayar_maps' =>$_POST['ayar_maps'],
		'ayar_zopim' =>$_POST['ayar_zopim']
	));

	if ($update) {
		header("Location:../production/api-ayar.php?durum=ok");
	}else{
		header("Location:../production/api-ayar.php?durum=no");
	}
}

//Sosyal Ayar Güncelle
if(isset($_POST['sosyalayarkaydet']))
{
	$ayarkaydet=$db->prepare("UPDATE ayar SET
		ayar_facebook=:ayar_facebook,
		ayar_twitter=:ayar_twitter,
		ayar_google=:ayar_google,
		ayar_youtube=:ayar_youtube
		WHERE ayar_id=0");

	$update=$ayarkaydet->execute(array(
		'ayar_facebook' =>$_POST['ayar_facebook'],
		'ayar_twitter' =>$_POST['ayar_twitter'],
		'ayar_google' =>$_POST['ayar_google'],
		'ayar_youtube' =>$_POST['ayar_youtube']
	));

	if ($update) {
		header("Location:../production/sosyal-ayar.php?durum=ok");
	}else{
		header("Location:../production/sosyal-ayar.php?durum=no");
	}
}

//Mail Ayar Güncelle
if(isset($_POST['mailayarkaydet']))
{
	$ayarkaydet=$db->prepare("UPDATE ayar SET
		ayar_smtphost=:ayar_smtphost,
		ayar_smtpuser=:ayar_smtpuser,
		ayar_smtppassword=:ayar_smtppassword,
		ayar_smtpport=:ayar_smtpport,
		ayar_bakim=:ayar_bakim
		WHERE ayar_id=0");

	$update=$ayarkaydet->execute(array(
		'ayar_smtphost' =>$_POST['ayar_smtphost'],
		'ayar_smtpuser' =>$_POST['ayar_smtpuser'],
		'ayar_smtppassword' =>$_POST['ayar_smtppassword'],
		'ayar_smtpport' =>$_POST['ayar_smtpport'],
		'ayar_bakim' =>$_POST['ayar_bakim']
	));

	if ($update) {
		header("Location:../production/mail-ayar.php?durum=ok");
	}else{
		header("Location:../production/mail-ayar.php?durum=no");
	}
}

//Hakkımızda Güncelle
if(isset($_POST['hakkimizdakaydet']))
{
	$ayarkaydet=$db->prepare("UPDATE hakkimizda SET
		hakkimizda_baslik=:hakkimizda_baslik,
		hakkimizda_icerik=:hakkimizda_icerik,
		hakkimizda_video=:hakkimizda_video,
		hakkimizda_vizyon=:hakkimizda_vizyon,
		hakkimizda_misyon=:hakkimizda_misyon
		WHERE hakkimizda_id=0");

	$update=$ayarkaydet->execute(array(
		'hakkimizda_baslik' =>$_POST['hakkimizda_baslik'],
		'hakkimizda_icerik' =>$_POST['hakkimizda_icerik'],
		'hakkimizda_video' =>$_POST['hakkimizda_video'],
		'hakkimizda_vizyon' =>$_POST['hakkimizda_vizyon'],
		'hakkimizda_misyon' =>$_POST['hakkimizda_misyon']
	));

	if ($update) {
		header("Location:../production/hakkimizda.php?durum=ok");
	}else{
		header("Location:../production/hakkimizda.php?durum=no");
	}
}

//Kullanıcı Düzenle
if(isset($_POST['kullaniciduzenle']))
{
	$kullanici_id=$_POST['kullanici_id'];

	$ayarkaydet=$db->prepare("UPDATE kullanici SET
		kullanici_tc=:kullanici_tc,
		kullanici_adsoyad=:kullanici_adsoyad,
		kullanici_durum=:kullanici_durum
		WHERE kullanici_id={$_POST['kullanici_id']}");

	$update=$ayarkaydet->execute(array(
		'kullanici_tc' =>$_POST['kullanici_tc'],
		'kullanici_adsoyad' =>$_POST['kullanici_adsoyad'],
		'kullanici_durum' =>$_POST['kullanici_durum']	
	));

	if ($update) {
		header("Location:../production/kullanici-duzenle.php?kullanici_id=$kullanici_id&durum=ok");
	}else{
		header("Location:../production/kullanici-duzenle.php?kullanici_id=$kullanici_id&durum=no");
	}
}

//Kullanıcı Sil

if($_GET['kullanicisil']=="ok"){
	$sil=$db->prepare("DELETE FROM kullanici WHERE kullanici_id=:id");
	$kontrol=$sil->execute(array(
		'id' => $_GET['kullanici_id']
	));

	if($kontrol){
		header("Location:../production/kullanici.php?sil=ok");
	}else{
		header("Location:../production/kullanici.php?sil=no");
	}
}

//Menü Düzenle
if(isset($_POST['menuduzenle']))
{
	$menu_id=$_POST['menu_id'];
	$menu_seourl=seo($_POST['menu_ad']);

	$ayarkaydet=$db->prepare("UPDATE menu SET
		menu_ad=:menu_ad,
		menu_detay=:menu_detay,
		menu_url=:menu_url,
		menu_sira=:menu_sira,
		menu_seourl=:menu_seourl,
		menu_durum=:menu_durum
		WHERE menu_id={$_POST['menu_id']}");

	$update=$ayarkaydet->execute(array(
		'menu_ad' =>$_POST['menu_ad'],
		'menu_detay' =>$_POST['menu_detay'],
		'menu_url' =>$_POST['menu_url'],
		'menu_sira' =>$_POST['menu_sira'],
		'menu_seourl' =>$menu_seourl,
		'menu_durum' =>$_POST['menu_durum']
	));

	if ($update) {
		header("Location:../production/menu-duzenle.php?menu_id=$menu_id&durum=ok");
	}else{
		header("Location:../production/menu-duzenle.php?menu_id=$menu_id&durum=no");
	}
}

//Menu Sil

if($_GET['menusil']=="ok"){
	$sil=$db->prepare("DELETE FROM menu WHERE menu_id=:id");
	$kontrol=$sil->execute(array(
		'id' => $_GET['menu_id']
	));

	if($kontrol){
		header("Location:../production/menu.php?sil=ok");
	}else{
		header("Location:../production/menu.php?sil=no");
	}
}
//Menü Ekle
if(isset($_POST['menukaydet']))
{

	$menu_seourl=seo($_POST['menu_ad']);

	$ayarekle=$db->prepare("INSERT INTO menu SET
		menu_ad=:menu_ad,
		menu_detay=:menu_detay,
		menu_url=:menu_url,
		menu_sira=:menu_sira,
		menu_seourl=:menu_seourl,
		menu_durum=:menu_durum
		");

	$update=$ayarekle->execute(array(
		'menu_ad' =>$_POST['menu_ad'],
		'menu_detay' =>$_POST['menu_detay'],
		'menu_url' =>$_POST['menu_url'],
		'menu_sira' =>$_POST['menu_sira'],
		'menu_seourl' =>$menu_seourl,
		'menu_durum' =>$_POST['menu_durum']
	));

	if ($insert) {
		header("Location:../production/menu.php?durum=ok");
	}else{
		header("Location:../production/menu.php?durum=no");
	}
}

//Slider Ekle
if(isset($_POST['sliderkaydet'])){

    $uploads_dir = '../../dimg/slider';
    @$tmp_name = $_FILES['slider_resimyol']["tmp_name"];
    @$name = $_FILES['slider_resimyol']["name"];
    $benzersizsayi1=rand(20000,32000);
    $benzersizsayi2=rand(20000,32000);
    $benzersizsayi3=rand(20000,32000);
    $benzersizsayi4=rand(20000,32000);
    $benzersizad=$benzersizsayi1.$benzersizsayi2.$benzersizsayi3.$benzersizsayi4;
    $refimgyol=substr($uploads_dir, 6)."/".$benzersizad.$name;
    @move_uploaded_file($tmp_name, "$uploads_dir/$benzersizad$name");

    $kaydet=$db->prepare("INSERT INTO slider SET
    slider_ad=:slider_ad, 
    slider_link=:slider_link,
    slider_sira=:slider_sira,
    slider_durum=:slider_durum,
    slider_resimyol=:slider_resimyol");
   
    $insert=$kaydet->execute(array(
     'slider_ad' => $_POST['slider_ad'],
     'slider_link' => $_POST['slider_link'],
     'slider_sira' => $_POST['slider_sira'],
     'slider_durum' => $_POST['slider_durum'],
     'slider_resimyol'=> $refimgyol,
     ));
        
    
    if ($insert)
    {
        Header("Location:../production/slider.php?durum=ok");
    }
    else
    {
        Header("Location:../production/slider.php?durum=no");
    }
}

//slider Düzenle
if(isset($_POST["sliderduzenle"])){
            
            if($_FILES['slider_resimyol']["size"] > 0 ){

            $uploads_dir = '../../dimg/slider';
		    @$tmp_name = $_FILES['slider_resimyol']["tmp_name"];
		    @$name = $_FILES['slider_resimyol']["name"];
		    $benzersizsayi1=rand(20000,32000);
		    $benzersizsayi2=rand(20000,32000);
		    $benzersizsayi3=rand(20000,32000);
		    $benzersizsayi4=rand(20000,32000);
		    $benzersizad=$benzersizsayi1.$benzersizsayi2.$benzersizsayi3.$benzersizsayi4;
		    $refimgyol=substr($uploads_dir, 6)."/".$benzersizad.$name;
		    @move_uploaded_file($tmp_name, "$uploads_dir/$benzersizad$name");

            $duzenle=$db->prepare("UPDATE slider SET
            slider_ad=:slider_ad,
            slider_link=:slider_link,
            slider_sira=:slider_sira,
            slider_durum=:slider_durum,
            slider_resimyol=:slider_resimyol
            WHERE
            slider_id={$_POST['slider_id']}");
        
            $update=$duzenle->execute(array(
            'slider_ad' => $_POST['slider_ad'],
            'slider_link' => $_POST['slider_link'],
            'slider_sira' => $_POST['slider_sira'],
            'slider_durum' => $_POST['slider_durum'],
            'slider_resimyol'=>$refimgyol,
            ));

            $slider_id=$_POST['slider_id'];
            if ($update)
            {
                $resimsilunlink=$_POST['slider_resimyol'];
                unlink("../../$resimsilunlink");
                Header("Location:../production/slider-duzenle.php?slider_id=$slider_id&durum=ok");
            }
            else
            {
                Header("Location:../production/slider-duzenle.php?durum=no");
            }
            

        }
        else
        {
        $duzenle=$db->prepare("UPDATE slider SET
        slider_ad=:ad, # sql injectiondan kaçınmak için database deki isimlendirme verilmedi
        slider_link=:link,
        slider_sira=:sira,
        slider_durum=:durum
        WHERE
       slider_id={$_POST['slider_id']}");
    
        $update=$duzenle->execute(array(
            'ad' => $_POST['slider_ad'],
            'link' => $_POST['slider_link'],
            'sira' => $_POST['slider_sira'],
            'durum' => $_POST['slider_durum']
          

        ));
        
        $slider_id=$_POST['slider_id'];

        if ($update)
        {
            Header("Location:../production/slider-duzenle.php?slider_id=$slider_id&durum=ok");
        }
        else
        {
            Header("Location:../production/slider-duzenle.php?durum=no");
        }
        }

       }

  //Slider Sil
      
   if($_GET['slidersil']=="ok"){
	$sil=$db->prepare("DELETE FROM slider WHERE slider_id=:id");
	$kontrol=$sil->execute(array(
		'id' => $_GET['slider_id']
	));

	if($kontrol){
		header("Location:../production/slider.php?sil=ok");
	}else{
		header("Location:../production/slider.php?sil=no");
	}
}

//Kategori Düzenle
if(isset($_POST['kategoriduzenle']))
{
	$kategori_id=$_POST['kategori_id'];
	$kategori_seourl=seo($_POST['kategori_ad']);

	$ayarkaydet=$db->prepare("UPDATE kategori SET
		kategori_ad=:kategori_ad,	
		kategori_sira=:kategori_sira,
		kategori_seourl=:kategori_seourl,
		kategori_durum=:kategori_durum
		WHERE kategori_id={$_POST['kategori_id']}");

	$update=$ayarkaydet->execute(array(
		'kategori_ad' =>$_POST['kategori_ad'],
		'kategori_sira' =>$_POST['kategori_sira'],
		'kategori_seourl' =>$kategori_seourl,
		'kategori_durum' =>$_POST['kategori_durum']
		
	));

	if ($update) {
		header("Location:../production/kategori-duzenle.php?kategori_id=$kategori_id&durum=ok");
	}else{
		header("Location:../production/kategori-duzenle.php?kategori_id=$kategori_id&durum=no");
	}
}

//Kategori Sil
if($_GET['kategorisil']=="ok"){
	$sil=$db->prepare("DELETE FROM kategori WHERE kategori_id=:id");
	$kontrol=$sil->execute(array(
		'id' => $_GET['kategori_id']
	));

	if($kontrol){
		header("Location:../production/kategori.php?sil=ok");
	}else{
		header("Location:../production/kategori.php?sil=no");
	}
}
//Kategori Ekle
if(isset($_POST['kategoriekle']))
{

	$kategori_seourl=seo($_POST['kategori_ad']);

	$kategoriekle=$db->prepare("INSERT INTO kategori SET
		kategori_ad=:kategori_ad,
		kategori_sira=:kategori_sira,
		kategori_seourl=:kategori_seourl,
		kategori_durum=:kategori_durum
		");

	$insert=$kategoriekle->execute(array(
		'kategori_ad' =>$_POST['kategori_ad'],
		'kategori_sira' =>$_POST['kategori_sira'],
		'kategori_seourl' =>$kategori_seourl,
		'kategori_durum' =>$_POST['kategori_durum']
	));

	if ($insert) {
		header("Location:../production/kategori.php?durum=ok");
	}else{
		header("Location:../production/kategori.php?durum=no");
	}
}

//Ürün Sil
if($_GET['urunsil']=="ok"){
	$sil=$db->prepare("DELETE FROM urun WHERE urun_id=:id");
	$kontrol=$sil->execute(array(
		'id' => $_GET['urun_id']
	));

	if($kontrol){
		header("Location:../production/urun.php?sil=ok");
	}else{
		header("Location:../production/urun.php?sil=no");
	}
}

//Urun duzenle
if(isset($_POST['urunduzenle']))
{
	$urun_id=$_POST['urun_id'];
	$urun_seourl=seo($_POST['urun_ad']);

	$kaydet=$db->prepare("UPDATE urun SET
		kategori_id=:kategori_id,
		urun_ad=:urun_ad,
		urun_detay=:urun_detay,
		urun_fiyat=:urun_fiyat,
		urun_video=:urun_video,
		urun_keyword=:urun_keyword,
		urun_stok=:urun_stok,
		urun_seourl=:urun_seourl,
		urun_onecikar=:urun_onecikar,
		urun_durum=:urun_durum
		WHERE urun_id={$_POST['urun_id']}");

	$update=$kaydet->execute(array(
		'kategori_id'=>$_POST['kategori_id'],
		'urun_ad' =>$_POST['urun_ad'],
		'urun_detay' =>$_POST['urun_detay'],
		'urun_fiyat' =>$_POST['urun_fiyat'],
		'urun_video' =>$_POST['urun_video'],
		'urun_keyword' =>$_POST['urun_keyword'],
		'urun_stok' =>$_POST['urun_stok'],
		'urun_seourl' =>$urun_seourl,
		'urun_onecikar' =>$_POST['urun_onecikar'],
		'urun_durum' =>$_POST['urun_durum']

	));

	if ($update) {
		header("Location:../production/urun-duzenle.php?urun_id=$urun_id&durum=ok");
	}else{
		header("Location:../production/urun-duzenle.php?urun_id=$urun_id&durum=no");
	}
}

//Urun Ekle

if (isset($_POST['urunekle'])) {

	$urun_seourl=seo($_POST['urun_ad']);

	$kaydet=$db->prepare("INSERT INTO urun SET
		kategori_id=:kategori_id,
		urun_ad=:urun_ad,
		urun_detay=:urun_detay,
		urun_fiyat=:urun_fiyat,
		urun_video=:urun_video,
		urun_keyword=:urun_keyword,
		urun_onecikar=:urun_onecikar,
		urun_durum=:urun_durum,
		urun_stok=:urun_stok,	
		urun_seourl=:seourl		
		");
	$insert=$kaydet->execute(array(
		'kategori_id' => $_POST['kategori_id'],
		'urun_ad' => $_POST['urun_ad'],
		'urun_detay' => $_POST['urun_detay'],
		'urun_fiyat' => $_POST['urun_fiyat'],
		'urun_video' => $_POST['urun_video'],
		'urun_keyword' => $_POST['urun_keyword'],
		'urun_onecikar' => $_POST['urun_onecikar'],
		'urun_durum' => $_POST['urun_durum'],
		'urun_stok' => $_POST['urun_stok'],
		'seourl' => $urun_seourl
			
		));

	if ($insert) {

		Header("Location:../production/urun.php?durum=ok");

	} else {

		Header("Location:../production/urun.php?durum=no");
	}

}

//Yorum Ekle
if (isset($_POST['yorumkaydet'])) {
	$gelen_url=$_POST['gelen_url'];

	
	$kaydet=$db->prepare("INSERT INTO yorumlar SET
		kullanici_id=:kullanici_id,
		yorum_detay=:yorum_detay
		
		
		");
	$insert=$kaydet->execute(array(
		'kullanici_id' => $_POST['kullanici_id'],
		'yorum_detay' => $_POST['yorum_detay']
		));

	if ($insert) {

		Header("Location:$gelen_url?durum=ok");

	} else {

		Header("Location:$gelen_url?durum=no");
	}

} 
?>