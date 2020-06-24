<?php



class WIproductReview
{


    function __construct(){
       $this->WIdb = WIdb::getInstance();
       $this->Page = new WIPagination();
    }

    public function OpenReview($id)
    {
        echo '<div class="container">
    <div class="row" style="margin-top:40px;">
        <div class="col-md-6">
        <div class="well well-sm">
            <div class="text-right">
                <a class="btn btn-success btn-green" href="#reviews-anchor" id="open-review-box">Leave a Review</a>
            </div>
        
            <div class="row" id="post-review-box" style="display:none;">
                <div class="col-md-12">
                    
                    <form accept-charset="UTF-8" action="" method="post">
                        <input id="ratings-hidden" name="rating" type="hidden"> 
                        <textarea class="form-control animated" cols="50" id="new-review" name="comment" placeholder="Enter your review here..." rows="5"></textarea>
        
                        <div class="text-right">


                        <div class="container">
    <br/>
    <label for="input-1" class="control-label">Give a rating for this product:</label>
    <input id="input-1" name="input-1" class="rating rating-loading" data-min="0" data-max="5" data-step="0.1" value="2">
    <br/>

</div>





                            <div class="stars starrr" data-rating="0"></div>
                            <a class="btn btn-danger btn-sm" href="#" id="close-review-box" style="display:none; margin-right: 10px;">
                            <span class="glyphicon glyphicon-remove"></span>Cancel</a>
                            <button class="btn btn-success btn-lg" type="submit">Save</button>
                        </div>

                    </form>
                </div>
            </div>
        </div> 
         
        </div>
    </div>
</div>

';


echo "<script type='text/javascript'>


</script>";
    }
}
