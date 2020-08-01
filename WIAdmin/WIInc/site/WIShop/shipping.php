  <form class="form-horizontal" id="shipping">
     <fieldset>
                      <div id="legend">
                        <legend class="">Shipping</legend>
                      </div>  


                       <div class="col-sm-12 col-lg-12 col-md-12 col-xs-12">

                        <br>
<fieldset class="form-inline">
  <input class="form-control" placeholder='add new item' id="shippingnewItem">
  <button class="btn btn-primary" type="button" title='Add to the top of the list' onclick="WIShop.shippingprependList();">prepend</button>
  <button class="btn btn-primary" type="button" title='Add to the bottom of the list' onclick="WIShop.shippingapppendList();">append</button>

                        <div id="get_shipping"> </div>

                        </div>
                      <button class="btn btn-primary" type="button" title='Save' onclick="WIShop.saveShipping();">Save</button>


      </fieldset>

  </form>

  <?php
?>
  
                       
                     

                    

                        