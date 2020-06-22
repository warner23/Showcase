  <form class="form-horizontal" id="cats">
     <fieldset>
                      <div id="legend">
                        <legend class="">Add / Edit Categories</legend>
                      </div>  


                       <div class="col-sm-12 col-lg-12 col-md-12 col-xs-12">
                        <div id="getCats"> </div>
                       </div>

      </fieldset>

  </form>
  <?php
$modal->moduleModal('add-categories', 'Add Categories', 'WIProduct', 'addcategories','Save'); 
$modal->moduleModal('edit-categories', 'edit Categories', 'WIProduct', 'editcategories','Save'); 
$modal->moduleModal('delete-categories', 'Delete Categories', 'WIProduct', 'deletecategories','Save'); 
?>