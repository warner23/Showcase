  <form class="form-horizontal" id="product">
                      <fieldset>
                      <div id="legend">
                        <legend class="">Add Product</legend>
                      </div>  
                      <div id="pstatus"></div>


                       <div class="col-sm-12 col-lg-12 col-md-12 col-xs-12">
                        <input type="hidden" name="user_id" id="user_id"value="<?php echo WISession::get('user_id'); ?>">
                        <div class="col-sm-6 col-lg-6 col-md-6 col-xs-6">
                      <div class="form-group">
                        <!-- Username -->
                        
                <div class="modal-body" id="details-body">

                    <?php $categories = $WIdb->select("SELECT * FROM `wi_categories`"); ?>
                    <?php if(count($categories) > 0): ?>
                      <p><?php echo WILang::get('Pick_Category'); ?>:</p>
                      <select id="cat_Selector" class="form-control" style="width: 100%;">
                      <?php foreach($categories as $category): ?>
                          <option value="<?php echo $category['cat_id']; ?>">
                            <?php echo e(ucfirst($category['title'])); ?>
                          </option>
                      <?php endforeach; ?>
                      </select>
                    <?php endif; ?>
                </div>
                        </div>
                      </div>

                      <div class="col-sm-6 col-lg-6 col-md-6 col-xs-6">

                        <div class="form-group">
                        
                       
                <div class="modal-body" id="details-body">
                    <?php $brands = $WIdb->select("SELECT * FROM `wi_brands`"); ?>
                    <?php if(count($brands) > 0): ?>
                      <p><?php echo WILang::get('Pick_Brand'); ?>:</p>
                      <select id="brand_selector" class="form-control" style="width: 100%;">
                      <?php foreach($brands as $brand): ?>
                          <option value="<?php echo $brand['brand_id']; ?>">
                            <?php echo e(ucfirst($brand['title'])); ?>
                          </option>
                      <?php endforeach; ?>
                      </select>
                    <?php endif; ?>
                </div>
              
                        </div>
                      </div>

                        <div class="col-sm-6 col-lg-6 col-md-6 col-xs-6">
                          <style>

#productdragandrophandler{
  border: 2px dotted #0B85A1;
    color: #92AAB0;
    text-align: left;
    vertical-align: middle;
    padding: 10px 10px 10 10px;
    margin-bottom: 10px;
    font-size: 200%;
}
.progressBar {
    height: 22px;
    border: 1px solid #ddd;
    border-radius: 5px; 
    overflow: hidden;
    display:inline-block;
    margin:0px 10px 5px 5px;
    vertical-align:top;
}
 
.progressBar div {
    height: 100%;
    color: #fff;
    text-align: right;
    line-height: 22px; /* same as #progressBar height if we want text middle aligned */
    width: 0;
    background-color: #0ba1b5; border-radius: 3px; 
}
.statusbar
{
    border-top:1px solid #A9CCD1;
    min-height:25px;
    padding:10px 10px 0px 10px;
    vertical-align:top;
}
.statusbar:nth-child(odd){
    background:#EBEFF0;
}
.filename
{
display:inline-block;
vertical-align:top;
}
.filesize
{
display:inline-block;
vertical-align:top;
color:#30693D;
margin-left:10px;
margin-right:5px;
}

.abort{
    background-color:#A8352F;
    -moz-border-radius:4px;
    -webkit-border-radius:4px;
    border-radius:4px;display:inline-block;
    color:#fff;
    font-family:arial;font-size:13px;font-weight:normal;
    padding:4px 15px;
    cursor:pointer;
    vertical-align:top
    }

    .ui-widget input {
    width: 100% !important;
}
</style>
                          <div>
                            <div id="product_pic">
                          <img src="../../WIAdmin/WIMedia/Img/shop/products/default.png" class="img-responsive product cp">
                          </div>
                          <a href="javascript:void(0);" id="change" onclick="WIMedia.changePic('product-edit')"><span>Change Product Photo</span>
                          </a>
                          </div>
                          <br><br>
                         
                        </div>

                        <div class="col-sm-6 col-lg-6 col-md-6 col-xs-6">

                          <div class="form-group">
                        <!-- Password-->
                        <label class="control-label col-lg-4" for="title">Title:</label>
                        <div class="col-lg-8">
                          <input type="text" id="title" maxlength="100" name="title" placeholder="title" class="input-xlarge form-control" value="title">
                        </div>
                      </div>

                      <div class="form-group">
                        <!-- Password-->
                        <label class="control-label col-lg-4" for="meta_title">Meta Title ( for SEO ):</label>
                        <div class="col-lg-8">
                          <input type="text" id="meta_title" maxlength="100" name="title" placeholder="meta title" class="input-xlarge form-control" value="meta_title">
                        </div>
                      </div>

                      <div class="form-group">
                        <!-- Password-->
                        <label class="control-label col-lg-4" for="Description">Description:</label>
                        <div class="col-lg-8">
                          <textarea type="text" id="description" maxlength="100" name="description" placeholder="description" class="input-xlarge form-control" value="description">
                        </textarea>
                      </div>

                     <div class="form-group">
                        <!-- Password-->
                        <label class="control-label col-lg-4" for="price">Price:</label>
                        <div class="col-lg-8">
                          <input type="text" id="price" maxlength="100" name="price" placeholder="price" class="input-xlarge form-control" value="price">
                        </div>
                      </div>

                      <div class="form-group">
                        <!-- Password-->
                        <label class="control-label col-lg-4" for="shipping">Shipping:</label>
                        <div class="col-lg-8">
                          <input type="text" id="shipping" maxlength="100" name="shipping" placeholder="shipping" class="input-xlarge form-control" value="shipping">
                        </div>
                      </div>

                      <div class="form-group">
                        <!-- Password-->
                        <label class="control-label col-lg-4" for="Quantity">Quantity:</label>
                        <div class="col-lg-8">
                          <input type="text" id="quantity" maxlength="100" name="quantity" placeholder="quantity" class="input-xlarge form-control" value="quantity">
                        </div>
                      </div>

                      <div class="form-group">
                        <!-- Password-->
                        <label class="control-label col-lg-4" for="discount">discount:</label>
                        <div class="col-lg-8">
                          <input type="text" id="discount" maxlength="100" name="discount" placeholder="discount" class="input-xlarge form-control" value="discount">
                        </div>
                      </div>


                      <div class="form-group">
                        <!-- Password-->
                        <label class="control-label col-lg-4" for="sku">sku:</label>
                        <div class="col-lg-8">
                          <input type="text" id="sku" maxlength="100" name="sku" placeholder="sku" class="input-xlarge form-control" value="sku">
                        </div>
                      </div>





                      <button class="btn" id="NewProduct" onclick="WIProduct.NewProduct();">Save</button>

                        </div>

                        
                       </div>
                     </fieldset>
                      
                      </form>


                     <script type="text/javascript">

                      $('#cat_Selector').on('change', function() {
                          //alert( this.value );

                          var mailer  = $("#cat_Selector").val();
                          //alert(mailer);

                        if( mailer === "smtp"){
                          $("#smtp-wrapper").css("display", "block");
                          $("#email-settings").attr("id","email-settings-smtp");
                        }else{
                           $("#smtp-wrapper").css("display", "none");
                           $("#email-settings-smtp").removeAttr("id","email-settings-smtp");
                           $(".btn").attr("id","email-settings");
                        }
                        })

                        
                      </script>
<?php  
 $modal->moduleModal('product-edit', 'Change Product', 'WIMedia', 'changeProductPic','Save'); 
 $modal->moduleModal('product-media', 'Change Media', 'WIMedia', 'ProductPics','Save'); 
 $modal->moduleModal('product-upload', 'Upload Media', 'WIMedia', 'UploadProductPics','Save'); 

?>
                    

                        