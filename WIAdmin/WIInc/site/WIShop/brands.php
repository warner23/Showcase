  <form class="form-horizontal" id="brands">
     <fieldset>
                      <div id="legend">
                        <legend class="">Add / Edit Brands</legend>
                      </div>  


                       <div class="col-sm-12 col-lg-12 col-md-12 col-xs-12">
                        <div id="get_brand"> </div>
                       </div>

      </fieldset>

  </form>

  <?php
$modal->moduleModal('add-brand', 'Add brand', 'WIProduct', 'addbrand','Save'); 
$modal->moduleModal('edit-brand', 'edit brand', 'WIProduct', 'editbrand','Save'); 
$modal->moduleModal('delete-brand', 'Delete brand', 'WIProduct', 'deletebrand','Save'); 
?>
  
                       
                     

                    

                        