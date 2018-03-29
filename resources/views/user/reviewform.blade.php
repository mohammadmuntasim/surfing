<!-- Modal -->
<div id="myReviews" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Write a Review</h4>
      </div>
      
<section class="reviewform">
		<div class="col-md-12">

          <div id="rateYo"></div>
         
            <div  id="post-review-box" style="display:none;">
                <div class="col-md-12">
                    <form class="form-horizontal" role="form" method="GET" action="{{ url('/test') }}" id="postreview">
                                     {{ csrf_field() }}
                        <input id="overall" name="overall" type="hidden" value="0">
                        <input id="punctuality" name="punctuality" type="hidden" value="0">
                        <input id="knowledge" name="knowledge" type="hidden" value="0">
                        <input id="staff" name="staff" type="hidden" value="0">                                    
                                     <?php $url= $_SERVER['REQUEST_URI'];
                                        $path = parse_url($url, PHP_URL_PATH);
                                        $pathFragments = explode('/', $path); ?>

                        <input  name="userid" type="hidden" value="{{ $pathFragments[2] }}"> 
                        
                        <textarea class="form-control animated" cols="50" id="new-review" name="comment" placeholder="Enter your review here..." rows="5"></textarea>
                        <div class="col-md-6">
                             <label>Overall Rating</label> <div class="overall"></div>
                        </div>
                        <div class="col-md-6">
                             <label>Punctuality</label> <div class="punctuality"></div>
                        </div>
                        <div class="col-md-6">
                             <label>Knowledge/Helpfulness</label> <div class="knowledge"></div>
                        </div>
                        <div class="col-md-6">
                             <label>Staff</label> <div class="staff"></div>
                        </div>
                        <div class="text-right">
                           
                            <a class="btn btn-danger btn-sm" href="#" id="close-review-box" style="display:none; margin-right: 10px;">
                            <span class="glyphicon glyphicon-remove"></span>Cancel</a>
                            <button class="btn btn-success btn-lg" type="button">Save</button>
                        </div>
                    </form>
                </div>
            </div>
    
         
		</div>

</section>

      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
      </div>
    </div>

  </div>
</div>
