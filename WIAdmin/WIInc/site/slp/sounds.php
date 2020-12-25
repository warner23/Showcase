
 <form  class="form-horizontal database-form" id="sound">
                      <fieldset>
                        <div id="legend">
                          <legend class="">Add Language</legend>
                        </div>

                        <div class="col-lg-12">
                        
                          <?php $slp->soundCard();  ?>
                        </div>
                       

                              <div class="form-group">
                        <!-- Button -->
                        <div class="controls col-lg-offset-4 col-lg-8">
                           <button id="add_lang_btn" onclick="WILang.AddLangModal()" class="btn btn-success" >Add</button> 
                        </div>
                      </div>
                      <div class="results" id="results"></div>
                    </fieldset>
                        <br /><br />
                  </form>

        