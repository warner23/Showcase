   <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

 <form  class="form-horizontal" id="lang-form">
                        <fieldset>
                          <div id="legend">
                        <label>Multi Language</label>
                    <div class="btn-group" id="language" data-toggle="buttons-radio">
                        <input type="hidden" name="multilanguage" id="multilanguage" class="btn-group-value" value="<?php echo $site->Website_Info('multi_lang')?>"/>
                        <button type="button" id="multilanguage_true" name="multilanguage" value="on"  class="btn">yes</button>
                        <button type="button" id="multilanguage_false" name="multilanguage" value="off" class="btn btn-danger activewhens" >No</button>
                    </div>
                  </div>

                    <div id="lang-wrapper">
                      <fieldset>
                    <legend>Select Site Translator </legend>
                    <label for="google-trans">Google translate</label>
                    <input type="radio" name="trans" id="google">
                    <label for="wi-trans">WI translate</label>
                    <input type="radio" name="trans" id="wilang">
                  </fieldset>
                   <span class="help-block">Select <strong>google trans, if you do not want to set up your own lang translations</strong></span>
                    </div>

                   
                    

                   <div class="form-group">
                        <!-- Button -->
                        <div class="controls col-lg-offset-4 col-lg-8">
                           <button id="multilanguage_btn" class="btn btn-success" onclick="WILang.changeLang();">Save</button> 
                        </div>
                      </div>
                      <div class="results" id="mlresults"></div>
                        </fieldset>
                      </form>

                       <script type="text/javascript">
                       var multi_lang = $("#multilanguage").attr('value');
                       if (multi_lang === "off"){
                        $("#multilanguage_true").removeClass('btn-success active')
                        $("#multilanguage_false").addClass('btn-danger active');
                       }else if (multi_lang === "on"){
                        $("#multilanguage_false").removeClass('btn-danger active')
                        $("#multilanguage_true").addClass('btn-success active');
                       }


                        var mailer  = "<?php echo $site->Website_Info('multi_lang'); ?>";
                          //alert(mailer);

                        if( mailer === "on"){
                          $("#lang-wrapper").css("display", "block");
                        }else{
                           $("#lang-wrapper").css("display", "none");
                           
                        }
                       
                      $('#multilanguage_true').on('click', function() {
                          //alert( this.value );

                          $("#lang-wrapper").css("display", "block");
                       
                        })

                      $('#multilanguage_false').on('click', function() {
                          //alert( this.value );

                          $("#lang-wrapper").css("display", "none");
                       
                        })

                        var trans  = "<?php echo $site->Website_Info('lang_choice');?>";

                        if(trans === "google")
                        {
                          $("#google"). prop("checked", true);
                        } else
                        {
                          $("#wilang"). prop("checked", true);
                        }

                      </script>

<style> 

#lang-wrapper{
  width: 60%;
}

label{
  width: 25%;
}

</style>