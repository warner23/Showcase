   <form  class="form-horizontal website">
      <fieldset>
        <div id="legend">
          <legend class="center">Shop Settings</legend>
        </div>  

        <div class="form-group">
          <!-- website name -->
          <div class="col-lg-4 col-xs-4 col-sm-s col-md-4">
          <label class="control-label"  for="shop_name">Shop Name:</label>
        </div>
          <div class="controls col-lg-8">
            <input type="text" id="shop_name"  maxlength="88" name="shop_name" placeholder="Shop Name" class="input-xlarge form-control" value="<?php echo $shop->Shop_Info('shop_name')?>"> <br />
          </div>
        </div>

        <div class="form-group">
          <!-- website domain-->
          <div class="col-lg-4 col-xs-4 col-sm-s col-md-4">
          <label class="control-label" for="business_email">Business Email:</label>
        </div>
          <div class="controls col-lg-8">
            <input type="email" id="business_email" maxlength="100" name="business_email" placeholder="Business Email" class="input-xlarge form-control" value="<?php echo $shop->Shop_Info('business_email')?>">
          </div>
        </div>

        <div class="form-group">
          <!-- website url-->
          <div class="col-lg-4 col-xs-4 col-sm-s col-md-4">
          <label class="control-label" for="paypal_id">Paypal ID:</label>
        </div>
          <div class="controls col-lg-8">
            <input type="text" id="paypal_id" maxlength="100" name="paypal_id" placeholder="Paypal ID" class="input-xlarge form-control" value="<?php echo $shop->Shop_Info('paypal_id')?>">
          </div>
        </div>

                <div class="form-group">
          <!-- website url-->
          <div class="col-lg-4 col-xs-4 col-sm-s col-md-4">
          <label class="control-label" for="paypal_secret">Paypal Secret:</label>
        </div>
          <div class="controls col-lg-8">
            <input type="text" id="paypal_secret" maxlength="100" name="paypal_secret" placeholder="Paypal Secret" class="input-xlarge form-control" value="<?php echo $shop->Shop_Info('paypal_secret')?>">
          </div>
        </div>

                <div class="form-group">
          <!-- website url-->
          <div class="col-lg-4 col-xs-4 col-sm-s col-md-4">
          <label class="control-label" for="paypal_callback">Paypal Callback Url:</label>
        </div>
          <div class="controls col-lg-8">
            <input type="text" id="paypal_callback" maxlength="100" name="paypal_callback" placeholder="Paypal Callback" class="input-xlarge form-control" value="<?php echo $shop->Shop_Info('paypal_callback')?>">
          </div>
        </div>

                <div class="form-group">
          <!-- website url-->
          <div class="col-lg-4 col-xs-4 col-sm-s col-md-4">
          <label class="control-label" for="cancel_url">Paypal Cancel Url:</label>
        </div>
          <div class="controls col-lg-8">
            <input type="text" id="cancel_url" maxlength="100" name="cancel_url" placeholder="Paypal Cancel Url" class="input-xlarge form-control" value="<?php echo $shop->Shop_Info('cancel_url')?>">
          </div>
        </div>

                <div class="form-group">
          <!-- website url-->
          <div class="col-lg-4 col-xs-4 col-sm-s col-md-4">
          <label class="control-label" for="notify_url">Paypal Notify Url:</label>
        </div>
          <div class="controls col-lg-8">
            <input type="text" id="notify_url" maxlength="100" name="notify_url" placeholder="Paypal Notify Url" class="input-xlarge form-control" value="<?php echo $shop->Shop_Info('notify_url')?>">
          </div>
        </div>


        <br />
        
        

        <div class="form-group">
          <!-- Button -->
          <div class="controls col-lg-offset-10 col-lg-2">
             <button id="shop_settings" class="btn btn-success">Save</button> 
          </div>
        </div>

        <div class="results" id="sresults"></div>
      </fieldset>
    </form> 
    