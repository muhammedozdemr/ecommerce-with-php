<?php include 'header.php'; ?>  
   <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
         
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Menü Ekle</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    
                    <form action="../netting/islem.php" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">


                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Menü Ad <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="menu_ad" id="first-name" required="required" class="form-control col-md-7 col-xs-12" placeholder="Menü adını giriniz">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Menü Detay  <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                         <textarea class="ckeditor" id="editor1" name="menu_detay"></textarea>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Menü URL <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="menu_url" id="first-name" class="form-control col-md-7 col-xs-12" placeholder="Menü url giriniz">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Menü Sıra <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="menu_sira" id="first-name" required="required" class="form-control col-md-7 col-xs-12" placeholder="Menü sıra giriniz">
                        </div>
                      </div>
                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Menü Durum <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select id="heard" class="form-control" name="menu_durum">
                          <option value="1">Aktif</option>
                          <option value="0">Pasif</option>
                          </select>
                        </div>

                      </div>
                                        
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div align="right" class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button type="submit" name="menukaydet" class="btn btn-success">Kaydet</button>
                          
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

         <script type="text/javascript">

              CKEDITOR.replace( 'editor1',


              {


                filebrowserBrowserUrl:'ckfinder/ckfinder.html',

                filebrowserImageBrowserUrl:'ckfinder/ckfinder.html?type=Images',

                filebrowserFlashBrowserUrl:'ckfinder/ckfinder.html?type=Flash',

                filebrowserUploadUrl:'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',

                forcePasteAsPlainText:true

              }

              );


            </script>


<?php include 'footer.php'; ?>       