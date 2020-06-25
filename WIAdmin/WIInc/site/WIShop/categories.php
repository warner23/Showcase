  <form class="form-horizontal" id="cats">
     <fieldset>
          <div id="legend">
            <legend class="">Categories</legend>
          </div>  
           <div class="col-sm-12 col-lg-12 col-md-12 col-xs-12">
<br>
<fieldset class="form-inline">
  <input class="form-control" placeholder='add new item' id="newItem">
  <button class="btn btn-primary" type="button" title='Add to the top of the list' onclick="WIShop.catprependList();">prepend</button>
  <button class="btn btn-primary" type="button" title='Add to the bottom of the list' onclick="WIShop.catapppendList();">append</button>
  
            <div id="getCats"> </div>
           </div>

           <button class="btn btn-primary" type="button" title='Save' onclick="WIShop.saveCat();">Save</button>
      </fieldset>
  </form>

  <?php
$modal->moduleModal('delete-categories', 'Delete Categories', 'WIProduct', 'deletecategories','Save'); 
?>