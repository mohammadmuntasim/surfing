/* Design & develop By Suraj Wasnik ( suraj.wasnik0126@gmail.com ) @ Fudugo Solutions  */

var baseUrl = $('input#base_url').val();

$('.dd-footer-nav ul').addClass('list-inline');

/* Profile Cover Photo Update */

$("#prof-cover-photo-file").change(function(){	
	var updatedCover = $("#prof-cover-photo-file").val();
	var uplodFile = previewCoverImage(this,'coverPic');
    if (uplodFile == 1) {
        $("a#edit-cover-icon").hide();
        $("button#save-cover-pic-change").show();   
    }else{
        alert("Look like you upload wrong format image, please make sure to upload jpg or png format image.");
    }	
});
/*$("button#save-cover-pic-change").click( function(){
    $("form#cover-edit-form").submit(); 
});*/

/* Profile photo update */

$("#prof-pic-photo-file").change(function(event){  
     event.preventDefault();
    var updatedCover = $("#prof-pic-photo-file").val();
    var uplodFile = previewCoverImage(this,'profilePic');
    if (uplodFile == 1) {
		$('#avatar-modal').modal('show');
        //$("a#prof-pic-photo").hide();
       // $(".profile-pic-edit-form").css('display','block');              
        //$("button#save-profile-pic-change").css('display','block');              
    }else{
        alert("Look like you upload wrong format image, please make sure to upload jpg or png format image.");
    }   
});

function previewCoverImage(input,div) {
    if (input.files && input.files[0]) {
        var file = input.files[0];
        var fileType = file["type"];
        var ValidImageTypes = ["image/gif", "image/jpeg", "image/png"];
        if ($.inArray(fileType, ValidImageTypes) < 0) {
            return 0;
        }else{
            var reader = new FileReader();
            reader.onload = function (e) {
                if(div == 'coverPic'){
                    $('#cover-image-individiual').attr('src', e.target.result);
                }
                if(div == 'profilePic'){
                    $('#profile-image-individiual').attr('src', e.target.result);
                }
            }
            reader.readAsDataURL(input.files[0]);
            return 1;
        }
        
    }
}
$("button#save-profile-pic-change").click( function(){
    $("form#profile-pic-edit-form").submit(); 
});

/* Edit page vertical tab */
$(document).ready(function() {
    $("div.fudugo-tab-menu>div.list-group>a").click(function(e) {
        e.preventDefault();
        $(this).siblings('a.active').removeClass("active");
        $(this).addClass("active");
        var index = $(this).index();
        $("div.fudugo-tab>div.fudugo-tab-content").removeClass("active");
        $("div.fudugo-tab>div.fudugo-tab-content").eq(index).addClass("active");
    });
});

/* Like post ajax call */
$('a#like-post').click(function(){
    var likedata = $(this).attr('data-like');    
    var likeDataObj = $.parseJSON( likedata );    
    var ajaxUrl = baseUrl+'/ajax-request-like';
    $.ajax({
        'url'   : ajaxUrl,
        'type'  :'POST',
        'data'  :{'likedata':likedata,'actionOfLike':likeDataObj.l_status},
        'success':function(result){
            alert(result);
        }
    });
});

/**$(document).ready(function(){
 // header fiexd js

var leftInit = $(".navbar-fixed-top").offset().left;
var top = $('.navbar-fixed-top').offset().top - parseFloat($('.navbar-fixed-top').css('margin-top').replace(/auto/, 0));


$(window).scroll(function(event) {

    var x = 0 - $(this).scrollLeft();
    var y = $(this).scrollTop();
    $(".navbar-fixed-top").offset({
        left: x + leftInit,
        
    });
     
    
    

});

});**/

//* Register page email validation if already register */
$('form#registration input#email').keyup( function(e){  
   validateEmailNotExist();
});

$('form#registration input#email').blur( function(e){  
   validateEmailNotExist();
});

function validateEmailNotExist(){    
    var email_val=$('form#registration input#email').val();  
    if($('div#email-error').html() == '' || $('div#email-error').html() == null && email_val != ''){
        $.ajax({
            'url'   :'/email-validate',
            'type'  :'get',
            'data'  :{'email':email_val},
            'success':function(result){
                console.log(result);
                if (result == 1) {
                   $('div#email-error').html('Email is already exist.'); 
                   $('form#registration input#email_exist').val('1');
                   $('div#email-exist-error').html(''); 
                    $('div#email-exist-error').css({'margin-bottom':'0px','margin-top':'0px'}); 
                    $('form#registration input#email').css({'border-color':'#a94442'}); 
                    $('div#email-error').css({'color':'#a94442'});
                   //$('div#email-error').css({'margin-bottom':'10px','margin-top':'-10px'});
                   return false;
                }else{
                   $('div#email-error').html('');
                   $('div#email-exist-error').html('');
                   $('div#email-exist-error').css({'margin-bottom':'0px','margin-top':'0px'}); 
                   $('form#registration input#email').css({'border-color':'#d8d8d8'});
                   $('form#registration input#email_exist').val('0');
                }
            }
        });
        
    }else{
        $('div#email-error').html('');
        //$('div#email-error').css({'margin-bottom':'10px','margin-top':'0px'}); 
    }
}

/* Registration form validation */


$('form#registration input#fname').on('keyup', function(e) {
    removeStartSpace('form#registration input#fname');
});
$('form#registration input#fname').blur(function() {
    removeStartSpace('form#registration input#fname');
});
$('form#registration input#lname').on('keyup', function(e) { 
    removeStartSpace('form#registration input#lname');
});
$('form#registration input#lname').blur(function() {
    removeStartSpace('form#registration input#lname');
});
$('form#registration input#email').on('keyup', function(e) { 
    removeAllSpace('form#registration input#email');    
});
$('form#registration input#email').blur(function() {
    removeAllSpace('form#registration input#email');
    isValidEmail()
});
$('form#registration input#password').on('keyup', function(e) { 
    removeAllSpace('form#registration input#password');
    isPasswordValid();
});
$('form#registration input#password').blur(function() {
    removeAllSpace('form#registration input#password');
    isPasswordValid();
});

/* Email is valid format */
function isValidEmail() {
    var email = $('form#registration input#email').val();
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    console.log(regex.test(email));    
    if(!regex.test(email)){
        $('form#registration input#email').css({'border-color':'#a94442'});
        $('div#email-format-error').html('Please Check Email Format');   
        $('div#email-format-error').css({'color':'#a94442'}); 
        $('div#email-format-error').css({'margin-bottom':'10px','margin-top':'5px','margin-left':'5px','float':'left'});  
        $('div#email-error').css({'float':'left','margin-bottom':'0px'});  
        //$('form#registration input#email').focus();         
        return false;
    }else{
        $('div#email-error').css({'float':'none'});  
        $('form#registration input#email').css({'border-color':'#d8d8d8'});
        $('div#email-format-error').css({'margin-bottom':'0px','margin-top':'0px'});
        $('div#email-format-error').html('');   
    }
}

/* Password validation */
function isPasswordValid() {
    var password = $('form#registration input#password').val();
    if (password == '' || password.length < 6 ) {
        console.log(password.length);
        $('div#password-error').css({'visibility':'visible'});  
        $('form#registration input#password').css({'border-color':'#a94442'});
        $('div#password-error').html('Enter password with min 6 character');   
        $('div#password-error').css({'color':'#a94442'});   
        // $('form#registration input#password').focus(); 
        return false;      
    }else{
        console.log(password.length);
        $('form#registration input#password').css({'border-color':'#d8d8d8'});
        $('div#password-error').html(' ');      
        $('div#password-error').css({'visibility':'hidden'});     

    }
}

/* Remove initial space */
function removeStartSpace(field) {
    if ($(field).val().length <= 1 ) {
        str = $(field).val();
        str = str.replace(/\s/g,'');
        str = str.replace(' ','');
        $(field).val(str);
    };
}
/* Remove all space */
function removeAllSpace(field) {
    str = $(field).val();
    str = str.replace(/\s/g,'');
    str = str.replace(' ','-');
    $(field).val(str);        
}

function validateRegisterForm() {   
    var emailExist = $('form#registration input#email_exist').val();
    var password = $('form#registration input#password').val();
    if (emailExist == 1) {       
        $('div#email-exist-error').html('Email is already exist.'); 
        $('div#email-error').css({'color':'#a94442'}); 
        $('div#email-exist-error').css({'margin-bottom':'10px','margin-top':'-5px'}); 
        $('form#registration input#email').css({'border-color':'#a94442'}); 
        $('form#registration input#email_exist').focus();
        return false;
    };
    isValidEmail();
    isPasswordValid();
}

/** change error message of character only **/
$(function() {
    $('#fname').keydown(function(e) {
       
        if($('#fname').val()==''){
            $('.characterfname').css('display','block');
        }

      if (e.shiftKey || e.ctrlKey || e.altKey || e.which == 9) {
        e.preventDefault();
           
      } else {
        var key = e.keyCode;
        if (!((key == 8) || (key == 32) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
          e.preventDefault();
           $('.characterfname').css('display','block');
          $('.characterfname').text('Enter Alphabets only');
          $('.characterfname').fadeOut(3000);
          
        }

      }
      
       if(e.which == 9){
        $('.characterfname').text('');
        $('.characterfname').css('display','block');
        $('#lname').focus();
       }
       
    });
$('#lname').keydown(function(e) {
     if($('#lname').val()==''){
            $('.characterfname').css('display','block');
        }
      if (e.shiftKey || e.ctrlKey || e.altKey || e.which == 9) {
        e.preventDefault();

      } else {
        var key = e.keyCode;
        if (!((key == 8) || (key == 32) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
          e.preventDefault();
           $('.characterlname').css('display','block');
           $('.characterlname').text('Enter Alphabets only');
           $('.characterlname').fadeOut(3000);
           
        }
      }
      if(e.which == 9){
        $('.characterlname').text('');
        $('.characterlname').css('display','block');

   //   $('#email').focus();
     }
    });
  });
/* Review Comment */

function showReplyReviewForm(reviewId) {
    $('div#review-modal-'+reviewId).toggle(500);
}

function  reviewReply(s){    
    
    if(jQuery.trim(s.value).length > 0)
   {   
        var reviewId = s.id;  
        console.log(reviewId);
        var comment = s.value;
           $('#'+reviewId).attr('disabled','disabled'); 
        var countComment = parseInt($('#comment-count-'+reviewId).text());
        var drId = $('input#dr_id').val();    
        var commentUserId = $('input#sender_id').val();
        $('div#review-error-'+reviewId).html('');
        if (comment != '') {
            $.ajax({
                'url'   :'/profile/review-comment/send',
                'type'  :'GET',
                'data'  :{'reviewId':reviewId,'comment':comment,'drId':drId,'senderId':commentUserId,'type':0},
                'success':function(result){ //alert('question'+result);
                    console.log(result);
                    //$('textarea#'+reviewId).val('');
                    if (result != '' && result != null) {               
                        $(result).insertAfter('div#new-review-comment-'+reviewId);
                        $('textarea#'+reviewId).val('');
                        $('#comment-count-'+reviewId).text(countComment+1);
                          $('#'+reviewId).removeAttr('disabled'); 
                    };
                }
            });  
            event.preventDefault();  
        }else{
            $('div#review-error-'+reviewId).html('<p style="color:red;text-align: left;">Enter comment.</p>');
        }
        event.preventDefault();
    }
    else
    {
        event.preventDefault();
    }
};

/* pagination on review comment */
$("div.dd-review-reply.review-action").each(function() {
    var commentID = '#'+$(this).attr('id');
    var reviewID = commentID.replace("#review-comment-div-", "");
    var size_li = $(commentID+" div.review-comment-row").size();
    $(commentID+' div.review-comment-row').hide();
    var x=1;
    if(size_li > x ){
        $('#loadMore-review-comment-'+reviewID).show();
    }else{
        $('#loadMore-review-comment-'+reviewID).hide();
    }
    $(commentID+' div.review-comment-row:lt('+x+')').show();
    $('a#loadMore-review-comment-'+reviewID).click(function () {  
        //alert(x+'=='+commentID+" div.comment-row==="+size_li);      
        x = (x <= size_li) ? x+5 : size_li;
        $(commentID+' div.review-comment-row:lt('+x+')').show(500);
        if (size_li <= x) {
            $('#loadMore-review-comment-'+reviewID).hide(1000);
            $('a#write-review-comment-link-'+reviewID).show(1000);
        };
    });
    $('a#write-review-comment-link-'+reviewID).click(function() {
        $("div#review-modal-"+reviewID).show(500);
        $('html, body').animate({ scrollTop:$("div#review-div-"+reviewID).offset().top}, 500);
    });
});

/* Login form header email verifation error hide if other email field has error */
/*if($("span.help-block").length > 1 ){
    $('div#login-email-error').hide();
}*/

/* Cancel booking validation */
function checkDoctorBookingSelection(){    
    if($('form#cancel-form-doctor input[type=checkbox]:checked').length <= 0){
        $('form#cancel-form-doctor div#cancel-user-not-select-error').show();
    }else{
        $('form#cancel-form-doctor div#cancel-user-not-select-error').hide(500);
        $('form#cancel-form-doctor div.cancel-booking-error-section').hide(500);
        $('form#cancel-form-doctor .cancel-reason-box').show(500);
        $('form#cancel-form-doctor .dd-grid-style-two.booking-list-section').hide(500);
    }
}

function rejectDoctorCancelBookingProcess(){       
    $('form#cancel-form-doctor div.cancel-booking-error-section').show(500);
    $('form#cancel-form-doctor .cancel-reason-box').hide(500);
    $('form#cancel-form-doctor .dd-grid-style-two.booking-list-section').show(500);
}

function checkPatientBookingSelection(){    
    if($('form#cancel-form-patient input[type=checkbox]:checked').length <= 0){
        $('form#cancel-form-patient div#cancel-user-not-select-error').show();
    }else{
        $('form#cancel-form-patient div#cancel-user-not-select-error').hide(500);
        $('form#cancel-form-patient div.cancel-booking-error-section').hide(500);
        $('form#cancel-form-patient .cancel-reason-box').show(500);
        $('form#cancel-form-patient .dd-grid-style-two.booking-list-section').hide(500);
    }
}

function rejectPatientCancelBookingProcess(){       
    $('form#cancel-form-patient div.cancel-booking-error-section').show(500);
    $('form#cancel-form-patient .cancel-reason-box').hide(500);
    $('form#cancel-form-patient .dd-grid-style-two.booking-list-section').show(500);
}

function checklistappointmentvalid()
{
    $cancelReason =  $('#cancelmsg').val();

    if($cancelReason=='' || $cancelReason=='empty')
    {
        $('#error-apppointmentlist-msg').css('display','block');
        return false;
    }
    else
    {
        $('#error-apppointmentlist-msg').css('display','none');
        return true;
    }
}
