<!--reminder start-->
@if(Auth::check())
@include('layouts.reminder')
@endif
<!--reminder end-->


<script type="text/javascript" src="{{asset('/css/assets/js/jquery-1.11.1.min.js')}}"></script>
<!-- <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script> -->
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>
<script type="text/javascript" src="{{asset('/js/surfhealth.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/fudugo-chat.js')}}"></script>
<script type="text/javascript" src="{{asset('/css/assets/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/css/assets/js/bootstrap-tagsinput.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/media-ajax.js')}}"></script>
<script type="text/javascript" src="{{asset('/css/assets/js/animations.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/css/assets/js/bootstrap-select.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/custom.js')}}"></script>
<script type="text/javascript" src="{{asset('/css/assets/js/dncalendar.min.js')}}"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBWxSwqOvmw8hT9r-nYlhRBOsqOI49069g&sensor=false"></script>
<script src="{{asset('js/map.js')}}"></script>
<script src="{{asset('js/ajax-crud.js')}}"></script>
<script type="text/javascript" src="{{asset('/css/assets/js/fileinput.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/css/assets/js/dd-panel.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/validation-ajax.js')}}"></script>
<script type="text/javascript" src="{{asset('/css/assets/js/validator.min.js')}}"></script>
@include('layouts.post-pagination')
<script type="text/javascript">
$(document).ready(function(){
    $('.filterable .btn-filter').click(function(){
        var $panel = $(this).parents('.filterable'),
        $filters = $panel.find('.filters input'),
        $tbody = $panel.find('.table tbody');
        if ($filters.prop('disabled') == true) {
            $filters.prop('disabled', false);
            $filters.first().focus();
        } else {
            $filters.val('').prop('disabled', true);
            $tbody.find('.no-result').remove();
            $tbody.find('tr').show();
        }
    });

    $('.filterable .filters input').keyup(function(e){
        /* Ignore tab key */
        var code = e.keyCode || e.which;
        if (code == '9') return;
        /* Useful DOM data and selectors */
        var $input = $(this),
        inputContent = $input.val().toLowerCase(),
        $panel = $input.parents('.filterable'),
        column = $panel.find('.filters th').index($input.parents('th')),
        $table = $panel.find('.table'),
        $rows = $table.find('tbody tr');
        /* Dirtiest filter function ever ;) */
        var $filteredRows = $rows.filter(function(){
            var value = $(this).find('td').eq(column).text().toLowerCase();
            return value.indexOf(inputContent) === -1;
        });
        /* Clean previous no-result if exist */
        $table.find('tbody .no-result').remove();
        /* Show all rows, hide filtered ones (never do that outside of a demo ! xD) */
        $rows.show();
        $filteredRows.hide();
        /* Prepend no-result row if all rows are filtered */
        if ($filteredRows.length === $rows.length) {
            $table.find('tbody').prepend($('<tr class="no-result text-center"><td colspan="'+ $table.find('.filters th').length +'">No result found</td></tr>'));
        }
    });
});
</script>
<!-- upload photo image  -->
<script type="text/javascript">

/*$('#alconfirm').confirmation('show');*/
  $('#myCarousel').carousel({
    interval: 3000
  });

  // handles the carousel thumbnails
  $('[id^=carousel-selector-]').hover(function() {
    var id_selector = $(this).attr("id");
    //console.log(id_selector);
    var id = id_selector.substr(id_selector.length - 1);
    //console.log(id);
    id = parseInt(id);
    $('#myCarousel').carousel(id - 1);
    $('[id^=carousel-selector-]').removeClass('selected');
    $(this).addClass('selected');
    //console.log(this);
  });

  // when the carousel slides, auto update
  $('#myCarousel').on('slid.bs.carousel', function(e) {
    var id = $('.item.active').data('slide-number');
    id = parseInt(id);
    $('[id^=carousel-selector-]').removeClass('selected');
    $('[id=carousel-selector-' + id + ']').addClass('selected');
  });




$("#file-1").change(function(){
     /*console.log(this);
     readURL(this);*/
     $("#uploadPhoto").modal('show');
});
</script>
<style type="text/css">
ul.dd-notification-list li a{font-weight: 300;font-size: 12px;}
.content h1 {
  text-align: center;
}
</style>
@if(Request::path()=='login')
<script type="text/javascript">
if($("span.help-block").length > 1 ){
    $('#mainlogin div#login-email-error').hide();
}
</script>
@endif
@if(Request::path()=='register')
<script type="text/javascript">
if($("span.help-block").length > 1 ){
    $('#registration div#login-email-error').hide();
}
</script>
@endif
<script type="text/javascript">
$(document).ready(function () {

<!--profile success message-->
function availableTime(s){
var bn=$('#'+s.id).closest("div").prop("id");
console.log(bn);
var res = bn.split("-");
  $('#availtime-'+res[1]).css('display','block');
  $('.notavail-'+res[1]).css('display','none');
 $('#'+res[0]+' .available_times button.btn.dropdown-toggle.bs-placeholder.btn-default').css('cursor','auto');
  $('#'+res[0]+' .available_times button.btn.dropdown-toggle.bs-placeholder.btn-default').css('pointer-events','auto');

}
function notAvailable(s){
  var bn=$('#'+s.id).closest("div").prop("id");
  console.log(bn);
  var res = bn.split("-");
  $('#availtime-'+res[1]).css('display','none');

  $('.notavail-'+res[1]).css('display','block');
  $('#'+res[0]+' .available_times button.btn.dropdown-toggle.bs-placeholder.btn-default').css('cursor','not-allowed');
  $('#'+res[0]+' .available_times button.btn.dropdown-toggle.bs-placeholder.btn-default').css('pointer-events','none');
}
$(document).on("click", function(e) {
  if(!$(event.target).closest('#demo').length) {
        if($('#demo').is(":visible")) {
            $('#demo').hide();
        }
    }    
  
});
$("#connections").click(function(){
    $('.collapse').collapse();
    if($('.collapse').is(":visible")) {
            $('.collapse').hide();
        }else{
          $('.collapse').show();
        }
});

//$('.collapse').collapse();
$('#confirm #delete').on('click',function(){
 //var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
// console.log(CSRF_TOKEN);
   var bn=$("#confirm form").serialize();
    $.ajax({
      url: '/ajax-cover',
      type: 'POST',
      data: bn,
      dataType: 'JSON',
      success: function (data) {
        $('#cover-image-individiuals').attr('src','/css/assets/img/default-cover.jpg');
          console.log(data);
      }
  });
});
});

/*$('#mybutton').on('click',function(){
//cancel booking
alert('test');
 var bn=$("form#canceldoc").serialize();
 console.log(bn);
  $.ajax({
    url: '/appointments',
    type: 'POST',
    data: bn,
    dataType: 'JSON',
    success: function (data) {
      //$('#cover-image-individiuals').attr('src','/css/assets/img/default-cover.jpg');
        console.log(data);
        $('#bookingModaldoctor').modal('hide');
    }
});
});*/

</script>
    <!-- Remove attributes onlick notification -->
    <script type="text/javascript">
    <!--remove tags-->
    function removetags(s){
 $.ajaxSetup({
               headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
            });
  var name=s.getAttribute('data-id');;

             $.get('/removetags/?name='+name,function(data){ 
             
               $('#tags'+name).hide();
               
              });
}
 $('#workfrom').on('click',function(){
    $('#workfrom label').hide();
 });
         var d = new Date();
var year = d.getFullYear();
    $('.datepicker').datepicker({ 
      changeMonth: true,
      yearRange: '1917:' + year + '',format:'dd-mm-yyyy',
    changeYear: true
    });
      //booking time

//get city name
$('.user_county').on('change',function(){
  var name=this.value;
  //console.log(name);
             $.get('/states/?name='+name,function(data){ 
              //console.log(data['options']);
                $('.form-control.selectpicker.user_city').html(data).selectpicker('refresh');
                // $('.user_city_div .dropdown-menu.inner').html(data['lis']);
               
              });
});

$('.insurance_provider').on('change',function(){

  var name=this.value;
    var doctor=$("input[name=docid]").val();
             $.get('/makeplans/?name='+name+'&docid='+doctor,function(data){ 
             
              //console.log(data['options']);
              $('.form-control.selectpicker.insurance_palns').html(data).selectpicker('refresh');
                // $('.user_city_div .dropdown-menu.inner').html(data['lis']);
               
              });
})

$('.insurance_provider_selected').on('change',function(){

  var name=this.value;
            $.get('/makeplans/?name='+name+'&docid=',function(data){ 
              //console.log(data['options']);
              
              $('.form-control.selectpicker.insurance_palns_selected').html(data).selectpicker('refresh');
                // $('.user_city_div .dropdown-menu.inner').html(data['lis']);
               
              });
})
function myshowss(s){

  var name=s.value;
             
             $.get('/plans/?name='+name,function(data){
              
               $('.form-control.insurance_plans.selectpicker.'+s.id).html(data).selectpicker('refresh');
               //$('.form-control.insurance_plans.selectpicker.'+s.id).html(data);
              });
}
 //add more insurance
function myremove(s){
  $('#i'+s.id).remove();
}
  $(function() {
        var scntDiv = $('#p_scents');
        var i = $('#p_scents p').size() + 1;

        $('#addScnt').on('click', function() {
          var   currentEntry = $( "div.city_div select.form-control.insurance_providers" ).html();
          var   currentEntry2 = $( "div.city_div select.form-control.insurance_plans" ).html();
           // console.log(currentEntry);
                $('<div id="insurance'+i+'" class="deletbutton"><div class="col-md-6 col-sm-6 form-colmns"><div class="form-group"><div class="with-icon"><label for="exampleInputEmail1" class="plan_label">INSURANCE PROVIDER</label><select class="form-control selectpicker insurance_providers" id="insurancess_'+i+'" name="insuranceprovider[]" onchange="myshowss(this)" required data-live-search="true" tabindex="-98">'+currentEntry+'</select> </div></div></div><div class="col-md-6 col-sm-6 form-colmns"><div class="form-group"><div class="with-icon"><label for="exampleInputEmail1" class="plan_label">INSURANCE PLAN</label><div class="[ form-group ] removeplans"> <input type="checkbox" name="removeplans[]" id="removeplans'+i+'" autocomplete="off" /> <div class="[ btn-group ]"> <label for="removeplans'+i+'" class="[ btn btn-primary ]"> <span class="[ glyphicon glyphicon-ok ]"></span> <span> </span> </label> <label for="removeplans'+i+'" class="[ btn btn-default active ]"> Remove Plans </label> </div> </div><select required class="form-control selectpicker insurance_plans insurancess_'+ i+'" name="insuranceplan['+ i+'][]" onchange="myshowss(this)" data-actions-box="true" multiple data-live-search="true" tabindex="-98" id="insurance_plan_'+i+'">'+currentEntry2+'</select> </div></div><button type="button" onclick="myremove(this)" class="btn btn-success btn-danger btn-remove " id="nsurance'+i+'"><i class="fa fa-trash-o" aria-hidden="true"></i></button></div></div>').appendTo(scntDiv);
              
                $('#insurance'+i+' .selectpicker.form-control').selectpicker('refresh');
 
                i++;
                
                return false;
        });
        
       
});


    </script>
<script type="text/javascript">
//insurance plans
 $(function()
{
    $(document).on('click', '.btn-add', function(e)
    {
        e.preventDefault();
        
        var controlForm = $('insurance_first:first'),
            currentEntry = $(this).parents('.insurance_second'),
            newEntry = $(currentEntry.clone()).appendTo(controlForm);

        newEntry.find('input').val('');

        controlForm.find('.btn-add:not(:last)')
            .removeClass('btn-default').addClass('btn-danger')
            .removeClass('btn-add').addClass('btn-remove')
            
            .html('<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Remove   ');
    }).on('click', '.btn-remove', function(e)
    {
        $(this).parents('.insurance_second').remove();

        e.preventDefault();
        return false;
    });
});

      ///add more
      $(function()
{
    $(document).on('click', '.btn-add', function(e)
    {
        e.preventDefault();

        var controlForm = $('.controls form:first'),
            currentEntry = $(this).parents('.voca:first'),
            newEntry = $(currentEntry.clone()).appendTo(controlForm);

        newEntry.find('input').val('');

        controlForm.find('.btn-add:not(:last)')
            .removeClass('btn-default').addClass('btn-danger')
            .removeClass('btn-add').addClass('btn-remove')
            
            .html('<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Remove   ');
    }).on('click', '.btn-remove', function(e)
    {
        $(this).parents('.voca:first').remove();

        e.preventDefault();
        return false;
    });
});
       
$(function()
{
    $(document).on('click', '#add_more_insurance', function(e)
    {
        e.preventDefault();
        var controlForm = $('.city_div2:first'),
            currentEntry = $(this).parents('.city_div:first'),
            newEntry = $(currentEntry.clone()).appendTo(controlForm);

        newEntry.find('input').val('');
        //$('.form-control.user_city').selectpicker('refresh');
        controlForm.find('.btn-add:not(:last)')
            .removeClass('btn-default').addClass('btn-danger')
            .removeClass('btn-add').addClass('btn-remove')
            
            .html('<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Remove   ');
    }).on('click', '.btn-remove', function(e)
    {
        $(this).parents('.city_div:first').remove();

        e.preventDefault();
        return false;
    });


});
//county

$(function()
{
    $(document).on('click', '.btn-add', function(e)
    {
        e.preventDefault();
        var controlForm = $('#county_div:first'),
            currentEntry = $(this).parents('.county_div2:first'),
            newEntry = $(currentEntry.clone()).appendTo(controlForm);

        newEntry.find('input').val('');
        controlForm.find('.btn-add:not(:last)')
            .removeClass('btn-default').addClass('btn-danger')
            .removeClass('btn-add').addClass('btn-remove')
            
            .html('<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Remove   ');
    }).on('click', '.btn-remove', function(e)
    {
        $(this).parents('.county_div2:first').remove();

        e.preventDefault();
        return false;
    });
});
          
//zipcode
 $('#user_zipcode').keydown(function(e) {
        var number = $(this).val();
        
        if (number.length == 5) {
            if (e.keyCode !== 8 && e.keyCode !== 9 && e.keyCode !== 37 && e.keyCode !== 39 && e.keyCode !== 46) {
                return false;
            };
        }
    });


$(document).ready(function() {
// Only enable if the document has a long scroll bar
// Note the window height + offset
if ( ($(window).height() + 100) < $(document).height() ) {
    $('#top-link-block').removeClass('hidden').affix({
        // how far to scroll down before link "slides" into view
        offset: {top:100}
    });
}

$('#myBooking').validator();
$('#basicinfor').validator();
$('#registeration').validator();



      $("#dialog").dialog({
        autoOpen: false,
        modal: true
      });
      });
      
      $("#canceldoc #mybutton").click(function(e) {
      e.preventDefault();
      
      
      $("#dialog").dialog({
        buttons : {
          "Confirm" : function() {
             $(this).dialog("close");
            $( "#canceldoc" ).submit();
          },
          "Cancel" : function() {
            $(this).dialog("close");
          }
        }
      });
      
      $("#dialog").dialog("open");
      });
      
    </script>
    <script type="text/javascript">
     // $('.timepicker').wickedpicker();
      $('#removecover').on('click', function(e) {
      var $form = $(this).closest('form');
      e.preventDefault();
      $('#confirm').modal({
          backdrop: 'static',
          keyboard: false
        })
        .one('click', '#delete', function(e) {
          $form.trigger('button');
        });
        $('#confirm').addClass('removeCoverpic');
      });
    </script>
    <script type="text/javascript">
      $('#cancelprofile').on('click', function(e) {
        var $form = $(this).closest('form');
        e.preventDefault();
        $('#cancelprofilepoup').modal({
            backdrop: 'static',
            keyboard: false
          })
          .one('click', '#delete', function(e) {
            $form.trigger('submit');
          });
      });
    </script>
    <script language="javascript">
      $(function(){    
        $(".input-group-btn .dropdown-menu li a").click(function(){ 
          var selText = $(this).html();   
          //working version - for single button //
           //$('.btn:first-child').html(selText+'<span class="caret"></span>');  
           
           //working version - for multiple buttons //
           $(this).parents('.input-group-btn').find('.btn-search').html(selText);
      
         });
      
      });
    </script>
    <script language="javascript">
      $("#file-1").fileinput({
          uploadUrl: '#', // you must set a valid URL here else you will get an error
          allowedFileExtensions: ['jpg', 'png', 'gif'],
          overwriteInitial: false,
          maxFileSize: 5000,
          maxFilesNum: 10,
          //allowedFileTypes: ['image', 'video', 'flash'],
          slugCallback: function (filename) {
              return filename.replace('(', '_').replace(']', '_');
          }
      });
    </script>
    <script language="javascript">
      $(document).ready(function(){
         loadGallery(true, 'a.dd-light-box');
      
         //This function disables buttons when needed
         function disableButtons(counter_max, counter_current){
             $('#show-previous-image, #show-next-image').show();
             if(counter_max == counter_current){
                 $('#show-next-image').hide();
             } else if (counter_current == 1){
                 $('#show-previous-image').hide();
             }
         }
      
         /**
          *
          * @param setIDs        Sets IDs when DOM is loaded. If using a PHP counter, set to false.
          * @param setClickAttr  Sets the attribute for the click handler.
          */
      
         function loadGallery(setIDs, setClickAttr){
             var current_image,
                 selector,
                 counter = 0;
      
             $('#show-next-image, #show-previous-image').click(function(){
                 if($(this).attr('id') == 'show-previous-image'){
                     current_image--;
                 } else {
                     current_image++;
                 }
      
                 selector = $('[data-image-id="' + current_image + '"]');
                 updateGallery(selector);
             });
      
             function updateGallery(selector) {
                 var $sel = selector;
                 current_image = $sel.data('image-id');
                 $('#image-gallery-caption').text($sel.data('caption'));
                 $('#image-gallery-title').text($sel.data('title'));
                 $('#image-gallery-image').attr('src', $sel.data('image'));
                 disableButtons(counter, $sel.data('image-id'));
             }
      
             if(setIDs == true){
                 $('[data-image-id]').each(function(){
                     counter++;
                     $(this).attr('data-image-id',counter);
                 });
             }
             $(setClickAttr).on('click',function(){
                 updateGallery($(this));
             });
         }
      });
    </script>
    <!-- Autocomplete name -->
    <script type="text/javascript">
        
      function refername(){
         
           var refers=$('#searchnametorefer').val();
           var docid=$('#receiverid').val();
          // console.log(refers.length);
           if(refers.length>2){
             $.get('/searchconnectname/?refers='+refers+'&doctorid='+docid+'&_token='+$('meta[name="csrf-token"]').attr('content'),function(data){               
                 $('#refer-id  .dd-grid-2-column').html(data);
              });
            }else if(refers==''){
              $.get('/connectionlist',function(data){               
                $('#refer-id  .dd-grid-2-column').html(data);
              });
            }
      }
    </script>
    <script type="text/javascript">
      $('#namekeysearch').autocomplete({
        source : '{!!URL::route('autocomplete')!!}',
        open: function () { $('ul.ui-autocomplete').addClass('opened') },
        close: function () { $('ul.ui-autocomplete').removeClass('opened').css('display','block'); },
        minlenght:1,
        autoFocus:true,
        select:function(e,ui){
          //alert(ui);
        }
      });
    </script>
    <script type="text/javascript">
      $('#namekeysearchpage').autocomplete({
        source : '{!!URL::route('autocomplete')!!}',
        open: function () { $('ul.ui-autocomplete').addClass('opened') },
        close: function () { $('ul.ui-autocomplete').removeClass('opened').css('display','block'); },
        minlenght:1,
        autoFocus:true,
        select:function(e,ui){
          //alert(ui);
        }
      });
    </script>
    <script type="text/javascript">
      /* Show 3 comments and load more */
      function paginateComment(){
        $("div.all-comment-div div.dd-write-comment").each(function() {
            var commentID = '#'+$(this).attr('id');
            var postID = commentID.replace("#comment-div-", "");
            //console.log('ID =='+commentID);
            //console.log('Post ID =='+postID);
            var size_li = $(commentID+" div.comment-row").size();
            //console.log('==='+size_li);
            $(commentID+' div.comment-row').hide();
            var x=3;
            //console.log('==='+x);
            if(size_li > x ){
              $('#loadMore-'+postID).show();
            }else{
              $('#loadMore-'+postID).hide();
            }
            $(commentID+' div.comment-row:lt('+x+')').show();
            $('a#loadMore-'+postID).click(function () {  
              //alert(x+'=='+commentID+" div.comment-row==="+size_li);      
                x = (x <= size_li) ? x+10 : size_li;
                $(commentID+' div.comment-row:lt('+x+')').show(800);
                if (size_li <= x) {
                  $('#loadMore-'+postID).hide(1000);
                  $('a#write-comment-link-'+postID).show(1000);
                };
            });
            $('a#write-comment-link-'+postID).click(function() {
                $('html, body').animate({ scrollTop:$("div#timeline-post-content"+postID).offset().top}, 500);
            });  
        });
      }
    </script>