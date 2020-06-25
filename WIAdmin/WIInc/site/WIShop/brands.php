  <form class="form-horizontal" id="brands">
     <fieldset>
                      <div id="legend">
                        <legend class="">Brands</legend>
                      </div>  


                       <div class="col-sm-12 col-lg-12 col-md-12 col-xs-12">

                        <br>
<fieldset class="form-inline">
  <input class="form-control" placeholder='add new item' id="newItem">
  <button class="btn btn-primary" type="button" title='Add to the top of the list' onclick="WIShop.brandprependList();">prepend</button>
  <button class="btn btn-primary" type="button" title='Add to the bottom of the list' onclick="WIShop.brandapppendList();">append</button>

                        <div id="get_brand"> </div>

                        </div>
                      <button class="btn btn-primary" type="button" title='Save' onclick="WIShop.saveBrand();">Save</button>


      </fieldset>

  </form>

  <?php
$modal->moduleModal('delete-brand', 'Delete brand', 'WIProduct', 'deletebrand','Save'); 
?>
  
                       
                     

                    

                        