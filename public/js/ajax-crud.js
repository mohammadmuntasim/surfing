/*!
 * Design and develop by RIZWANA ANSARI ( rizwanawork786@gmail.com ) at FUDUGO SOLUTIONS PVT. LTD. 
 *
 * Copyright 2017 www.fudugo.com
 * Licensed Authorize by fudugosolutions@2017
 */

//add loader on submit
$('form#mediaAlbum').submit(function() {
    
    $(".medialoader").show();
});




function updatepost(data)
{
	console.log(data);
	var userid = data.user_id;
	var updatedcontent = $('#updatedcontentonly').val();
	var postId = data.id;
	var imageid = $("#editimageid").val();
	console.log("eee"+updatedcontent);
	console.log("dd"+imageid)
	if(updatedcontent=='')
	{
		alert("This post appears to be blank. Please write something.");
		return;
	}
  
	$("#editMyPostModal"+postId).modal('hide');

    
	$.ajax({
	    'url'   :'/updatepost',
	    'type'  :'GET',
	    'data'  :{'userid':userid,'updatedcontent':updatedcontent,'type':2,'postId':postId},
	    'success':function(result){ 
	       console.log(result);
	         if (result != '' && result != null) {	     
				$('#singplepostid-'+postId).html(result);
	        };
	    }
	});
}

function updatephoto(data)
	{
	
	var userid = data.user_id;
	var content = $('#updatedphotocontent').val();
	var postId = data.id;
	var imageid = $("#editimageid").val();
	console.log(imageid, content);
	if(imageid==0 && content=='')
	{
		alert("This post appears to be blank. Please write something.");
		return;
	}
	
  
	$("#editMyPostModal"+postId).modal('hide');

    
	$.ajax({
	    'url'   :'/updatepost',
	    'type'  :'GET',
	    'data'  :{'userid':userid,'content':content,'type':3,'postId':postId,'imageid':imageid},
	    'success':function(result){ 
	       console.log(result);
	         if (result != '' && result != null) {	     
				$('#singplepostid-'+postId).html(result);
	        };
	    }
	});
}

function updateshare(data)
{
	console.log(data)
	var userid = data.user_id;
	var content = $('#updatedsharedcontent').val();
	var postId = data.id;
	data.type=0;
	
	var shareinfo = $("#editsharetype").val();
	if(shareinfo==0)
	{
		var imageid=0;
	}
	else
	{
		var imageid=data.media_id;
	}
	
	console.log(data);

	if(shareinfo==0 && content=='')
	{
		alert("This post appears to be blank. Please write something.");
		return;
	}
	console.log(data);
	console.log(content,postId);
  
	$("#editMyPostModal"+postId).modal('hide');

    
	$.ajax({
	    'url'   :'/updatepost',
	    'type'  :'GET',
	    'data'  :{'userid':userid,'content':content,'type':4,'postId':postId,'imageid':imageid,'shareinfo':shareinfo},
	    'success':function(result){ 
	       console.log(result);
	         if (result != '' && result != null) {	     
				$('#singplepostid-'+postId).html(result);
	        };
	    }
	});
}


function removeme(id)
{

	$("#myimg"+id).css('display','none');
	$("#mecross"+id).css('display','none');
	$("#editimageid").val('0');
	console.log($("#editimageid").val())
}


function removemesharephot(id)
{
	$("#sharewithphoto"+id).css('display','none');
	$("#mecross"+id).css('display','none');
	$("#editsharetype").val('0');
	
}
function shareeditpost(id)
{
	$("#myshare"+id).css('display','none');
	$("#mecross"+id).css('display','none');
	$("#editsharetype").val('0');
	
}
function deletepost(data)
{
	
	var postId = data.id;
	

	 $.ajax({
	    'url'   :'/updatepost',
	    'type'  :'GET',
	    'data'  :{'postId':postId,'type':1},
	    'success':function(result){ //alert('question'+result);
	     	
	       location.reload();
	     }
		});
	
}
function editcommentfunction(data)
{
	var target = $(data).attr('rel');
	console.log(target);
   $("#"+target).show().siblings(".dd-comment-footer #"+target).hide();
}

function editreply(replyeditbox)
{
	//var updated =replyeditbox.value;

	var rid=replyeditbox.id;
	var ret = rid.split("-");
	var str1 = ret[0];
	var replyId = ret[1];
	
	 
    var reply = replyeditbox.value;
    var alldetailsId = $('textarea#editreplytextbox-'+replyId).attr('post');
    var splitdetails=alldetailsId;
	var ret = splitdetails.split("-");
	var commentId = ret[1];
	var postId = ret[0];

	
   
    console.log(replyId,reply,postId);
 //    $('span#replydiv-'+replyId).html($('textarea#'+replyId).val());
	// $('textarea#'+replyId).hide();
	// $("#ajax-"+postId).hide();


    
	$.ajax({
	    'url'   :'/homecommentajaxrequest',
	    'type'  :'GET',
	    'data'  :{'replyId':replyId,'reply':reply,'type':5,'postId':postId},
	    'success':function(result){ //alert('question'+result);
	        console.log(result);
	      //  alert(result);
	         if (result != '' && result != null) {	        	
	         	console.log(result);
	         	  $('#myeditreply'+replyId).html(result);
	         	  $('#med-'+replyId).html(result);
	         	  
	        	 $('textarea#editreplytextbox-'+replyId).hide();
	        	 
	        	
	        };
	    }
	});
	event.preventDefault();
	
    //alert(postId);
	
}

//  Edit Reply box show

function editreplyfunction(data)
{
	console.log(data);
	var myreply = $(data).attr('rel');
	console.log(myreply);
	var breakit = myreply.split('-')
 	 var myreplywords = breakit[1];
 	 var myreplyid = breakit[3];
 	 var mycontentid = breakit[2];
 	 console.log(myreplyid);
	$('textarea#editreplytextbox-'+myreplyid).show();	
	$('textarea#editreplytextbox-'+myreplyid).val(myreplywords);	

}


// COMMENT EDIT Update Function
function editcomments(s)
{	
	console.log(s);
	var rid=s.id;
	var ret = rid.split("-");
	var str1 = ret[0];
	var commentId = ret[1];

	

    var comment = s.value;
   
	var postId = $("#Postid-of-Edited-Comment-"+commentId).val();	
	
	$('span#commentdiv-'+commentId).html($('textarea#'+commentId).val());
	$('textarea#'+commentId).hide();
	 $('#editcomment-'+commentId).hide();

	console.log(str1,commentId,comment,postId);

	$.ajax({
	    'url'   :'/homecommentajaxrequest',
	    'type'  :'GET',
	    'data'  :{'commentId':commentId,'postId':postId,'comment':comment,'type':3},
	    'success':function(result){ //alert('question'+result);
	        
	        if (result != '' && result != null) {		  
	        
	          $('#myeditcomment'+commentId).html(result);
	         
	        };
	    }
	});
	event.preventDefault();
}

// Delete Funtion
function deletecommentorreply(s)
{

	var rid=s.id;
	var ret = rid.split("-");
	var str1 = ret[0];
	var str2 = ret[1];	
	var str3 = ret[2];	
	var commentId =str2; 
	
	var liketotalstr = $('#mainrepy-'+str3).text();
	var retrivevalue = liketotalstr.split(" ");
	var likecount = retrivevalue[0];
	var likestr = retrivevalue[1];
	$('#mainrepy-'+str3).text(parseInt(likecount)-1+' Reply');
	console.log(commentId);
	$('#replybox-'+commentId).hide();
	
  	 $.ajax({
	    'url'   :'/homecommentajaxrequest',
	    'type'  :'GET',
	    'data'  :{'commentId':commentId,'type':4},
	    'success':function(result){ //alert('question'+result);
	       console.log(result);
	       $("#wholereply-"+commentId).css('display','none');
	     }
		});
}

function deletecomment(s)
{

	var rid=s.id;
	var ret = rid.split("-");
	var str1 = ret[0];
	var str2 = ret[1];
	var str3 = ret[2];	
	var commentId =str2;
	console.log($('#mainrepy-'+commentId).val());
	console.log(str2);
	console.log(str1);	


	var liketotalstr = $('#maincomment-'+str3).text();
	var retrivevalue = liketotalstr.split(" ");
	var likecount = retrivevalue[0];
	var likestr = retrivevalue[1];
	$('#maincomment-'+str3).text(parseInt(likecount)-1+' Comments');
	$('#reply-row-id-'+commentId).hide();

	
  	 $.ajax({
	    'url'   :'/homecommentajaxrequest',
	    'type'  :'GET',
	    'data'  :{'commentId':commentId,'type':4},
	    'success':function(result){ //alert('question'+result);
	       console.log(result);
	       $("#old-comment-hide-after-edit"+commentId).css('display','none');
	     }
		});
}


// function homereply(s){
//  	//event.preventDefault();
 	
//  	var statusId = s.id;    
//     var comment = s.value;
//     var postId = $('textarea#'+statusId).attr('post');
//     var replyid = $('textarea#'+statusId).attr('replyid');
//     console.log(replyid);
//     console.log(postId);
//     console.log(statusId);
    
 	
// 	//$('#reply-row-id-'+replyid).hide();
  
// 	$.ajax({
// 	    'url'   :'/homecommentajaxrequest',
// 	    'type'  :'GET',
// 	    'data'  :{'statusid':statusId,'comment':comment,'type':1,'postId':postId,'replyid':replyid},
// 	    'success':function(result){ //alert('question'+result);
// 	        console.log(result);
// 	        if (result != '' && result != null) {	        	
// 	        	$(result).insertBefore('textarea#'+statusId);
// 	        	$('textarea#'+statusId).val('');
// 	        };
// 	    }
// 	});
//  event.preventDefault();
//   	/*$.get('/homecommentajaxrequest/?statusid='+s.id+'&comment='+s.value+'&type=1',function(data){
// 		location.reload();
//  	})*/
// };
function homereply(s){
 	//event.preventDefault();
 if(jQuery.trim(s.value).length > 0)
   {
	 	var statusId = s.id;  
	 	console.log(statusId);
	    var comment = s.value;
	    var postId = $('textarea#'+statusId).attr('post');
	    console.log(postId);
	    var replyid = $('textarea#'+statusId).attr('replyid');
	    $('#'+statusId).attr('disabled','disabled'); 
	    console.log("===============================");
	    console.log(replyid);
	    console.log(postId);
	    console.log(statusId);

    
	    var liketotalstr = $('#mainrepy-'+statusId).text();
		var retrivevalue = liketotalstr.split(" ");
		var likecount = retrivevalue[0];
		var likestr = retrivevalue[1];
		$('#mainrepy-'+statusId).text(parseInt(likecount)+1+' Reply');
    	//alert(postId);
		$.ajax({
		    'url'   :'/homecommentajaxrequest',
		    'type'  :'GET',
		    'data'  :{'statusid':statusId,'comment':comment,'type':1,'postId':postId,'replyid':replyid},
		    'success':function(result){ //alert('question'+result);
		        console.log(result);
		        if (result != '' && result != null) {	        	
		        	$(result).insertBefore('textarea#'+statusId);
		        	$('textarea#'+statusId).val('');
		        	$('#wholereply-'+replyid).hide();
		        	  $('#'+statusId).removeAttr('disabled'); 
		        	
		        };
		    }
		});
 		event.preventDefault();
	  	/*$.get('/homecommentajaxrequest/?statusid='+s.id+'&comment='+s.value+'&type=1',function(data){
			location.reload();
	 	})*/
	}
	else
	{
		event.preventDefault();
	}
};

function subreplyhide2(rr)
{
	console.log('#replybox-'+rr)
	$('#replybox-'+rr).toggle();
	$('textarea#'+rr).css('display','block');
}


/**** delete media image User ***/

function deletemediaImage(s){

	var imgid=s.getAttribute('data-imageid');

	 $.get('/deletemedia/?imgid='+imgid,function(data){
		 
	 	$('#media'+imgid).css('display','none');
	            
     });
	
}

/**** connect list User ***/

function connectionlist(s){
	var docid=$('#receiverid').val();
	$('#refer-id #ReferTitle').html('Refer '+$('.dd-profile-name h3').text()+' to');
	 $.get('/connectionlist?doctorid='+docid+'&_token='+$('meta[name="csrf-token"]').attr('content'),function(data){
		 
	 	$('#refer-id .dd-grid-2-column').html(data);
	            
     });
	
}
/***** Follow ***/
function followusers(s){
	var datas = s.getAttribute("data-followuser");
	 $.get('/userfollow/?getdata='+datas,function(data){
	             $('#follows').html(data);
     });
	
}
/**** Refer User ***/

function ReferUser(s){
	var datas = s.getAttribute("data-referuser");
	var doctorid=$('#receiverid').val();
	 $.get('/referuser/?getdata='+datas+'&docid='+doctorid,function(data){
	 	$('#your-refer-id').modal('show');
		$('#your-refer-id .modal-body .dd-text-modal h1').html(data);
		setTimeout(function() { $('#your-refer-id').modal('hide');}, 1000);
	            
     });
	
}

/***  Share with content   ****/
function getpostid(s){
	//$('[data-toggle="popover"]').popover('hide');
	var rid=s.id;
	var ret = rid.split("-");
var str1 = ret[0];
var str2 = ret[1];
var data1=$('#timeline-post-content'+str2+' .post-content .postimage').html();
var data2=$('#postcontent'+str2).html();
var data3=$('#timeline-post-content'+str2+' .post-content .posttext').html();
if(data3=='undefined'|| data3==null || data3=='' ){
 data3='';
}
if(data2=='undefined'|| data2==null || data2=='' ){
 data2='';
}
if(data1=='undefined'|| data1==null || data1=='' ){

 data1='';
}
var userdata='<div class="post-content shared clearfix">'+data2+'<div class="posttext">'+data3+'</div></div>';
var topcontests='<textarea class="form-control" rows="3" cols="40" placeholder="Say something about this..." name="content" id="sharedc"></textarea>';
var bottomcontet='<div class="modal-footer"><button type="button" class="closed btn btn-default" id="dismissshare" data-dismiss="modal">Cancel</button><button type="button" class="btn btn-default" onclick="SharePost(this)" id="sharenowd-'+str2+'">Share</button></div>';
setTimeout(function() {
       				$('#sharewithcontentform').html(topcontests+data1+userdata+bottomcontet);
    				}, 4000);
/* $.get('/sharepostdata/?getdata='+str2,function(data){
	              setTimeout(function() {
       				$('#sharewithcontentform').html(topcontests+data+bottomcontet);
    				}, 4000);
			   });*/
	
}
/****on share share clos button remove html ***/
$('#sharewithcontent .close').click(function(){
	setTimeout(function() {
       				var bn=document.location.origin;
	$('#sharewithcontentform').html('<center><img src="'+bn+'/css/assets/img/ring.gif" ></center>');
    				}, 1000);
	
});

$('#dismissshare.closed').click(function(){
	setTimeout(function() {
	var bn=document.location.origin;
	$('#sharewithcontentform').html('<center><img src="'+bn+'/css/assets/img/ring.gif" ></center>');
	}, 1000);
});
/*** Share Post ***/
function SharePost(s){
	//$('[data-toggle="popover"]').popover('hide');
	var rid=s.id;
	var ret = rid.split("-");
	var str1 = ret[0];
	var str2 = ret[1];
	var sdvalue='';
	if(str1=='sharenow'){
		sdvalue='';
	}else if(str1=='sharenowd'){
		sdvalue=$('#sharedc').val();
	}
$('#sharewithcontent').modal('hide');
	 $('#overlay').modal('show');
				 $('#overlay').css('display','block');
				 
				 $('#overlay .modal-body').html('This has been shared to your timeline ');
				setTimeout(function() {
	var bn=document.location.origin;
	$('#overlay').html('<center><img src="'+bn+'/css/assets/img/ring.gif" ></center>');
	}, 2000);
	console.log(str2+sdvalue);
	 $.get('/sharepost/?shareid='+str2+'&scd='+sdvalue,function(data){	
				location.reload(); 
				//console.log(data);
			   });
	
}

/*** Delete reviews***/
function deletereviews(s){
	var rid=s.id;
	console.log(rid);
	 $.get('/reviewsaction/?delr='+rid,function(data){
				  console.log(data);
				  $(".reviews"+rid).hide();
			   });
	
}

/*** Delete reviews***/
function approvereviews(s){
	var rid=s.id;
	console.log(rid);
	 $.get('/reviewsaction/?approved='+rid,function(data){
				  console.log(data);
				  $(".reviews"+rid).css('border','2px solid green');
			   });
	
}
 
 /****add to Reviews ***/
$("#postreview .btn.btn-success.btn-lg").click(function(){
	/*Add new catagory Event*/
	//$('#new-review').val().trim()
	if($('#new-review').val().trim().length > 0){
    $('#new-review').css('border','1px solid green');
	var data= $("#postreview").serialize();
	
	$('#myReviews').modal('hide');
    $.get('/reviews/?datas='+data,function(data){
				 $('#overlay').modal('show');
				 $('#open-review-box').css('display','block');
				 $('#overlay .modal-body').html('<i class="fa fa-smile-o" aria-hidden="true"></i>  Thank you for giving reviews');
				setTimeout(function() {
	var bn=document.location.origin;
	$('#overlay').html('<center><img src="'+bn+'/css/assets/img/ring.gif" ></center>'); $('#overlay').modal('hide');
	}, 2000);
				 
			   });
	}else{
     $('#new-review').css('border','1px solid red');
	}

 });

 /****remove from connnect ***/
function removeconnection(s){
	/*Add new catagory Event*/
 $.ajaxSetup({
               headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
            });
var bh=s.id;
 var dv=$('#'+bh).closest('div').attr('id');
console.log(dv);
var userid=dv.split('-');

              $.get('/removeconnection/?id='+userid[1],function(data){
              	//$('#sentrequest-'+userid[1]).css('display','block');
				  $('#'+dv).css('display','none');
				  $('#makeconnection-'+userid[1]).css('display','block');
				 
				  $('#makeconnection-'+userid[1]).removeClass('sentrequest');
				  
				  //$("#"+bh).html('<i class="fa fa-user-plus" aria-hidden="true"></i> connection remove');
			   });
 }
  //accept connection from notification

function acceptRequestnotify(s){
	/*Add new catagory Event*/
 $.ajaxSetup({
               headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
            });
  var bh=s.id;
 
var userid=bh.split('-');

 	$.ajax({
	    'url'   :'/ajaxresponserequest',
	    'type'  :'GET',
	    'data'  :{'uid':userid[1],'_token':$('meta[name="csrf-token"]').attr('content')},
	    'success':function(result){ 
	       console.log(result);
	       $('#deleteRequestnotify-'+userid[1]).css('display','none');
				  $('#'+bh).html('Accept request');
	         /*if (result != '' && result != null) {	     
				$('#singplepostid-'+postId).html(result);
	        };*/
	    }
	});
 }
 //remove/delete connection from notification

function deleteRequestnotify(s){
	/*Add new catagory Event*/
 $.ajaxSetup({
               headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
            });
  var bh=s.id;
var userid=bh.split('-');
 	$.ajax({
	    'url'   :'/removeconnection',
	    'type'  :'GET',
	    'data'  :{'id':userid[1],'_token':$('meta[name="csrf-token"]').attr('content')},
	    'success':function(result){ 
	       console.log(result);
	       $('#acceptRequestnotify-'+userid[1]).css('display','none');
				  $('#'+bh).html('Request deleted');
	        
	    }
	});
 }
  /****add to connnect ***/
function addtoconnect(s){
	/*Add new catagory Event*/
 $.ajaxSetup({
               headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
            });
 var bh=s.id;
var userid=bh.split('-');
 $.get('/ajaxrequest/?id='+userid[1],function(data){
				  $('#sentrequest-'+userid[1]).css('display','block');
				  $('#'+bh).css('display','none');
				  
			   });
 }
 /*****cancel request ***/
 function cancelrequest(s){
 $.ajaxSetup({
               headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
            });
var bh=s.id;
$('#upload_forms2').hide();
 $.get('/ajaxrequest/?id='+bh,function(data){
				  console.log(data);

				  $("#"+bh).html('<i class="fa fa-user-plus" aria-hidden="true"></i> Request Canceled');
			   });
 }




 ///single request
 
function requestfunction(s){
	/*Add new catagory Event*/
 $.ajaxSetup({
               headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
            });
			

              
			   var setmsg =s.id;
			   var ret = setmsg.split("-");
var str1 = ret[0];
var str2 = ret[1]; 
var dv=$('#'+setmsg).closest('div').attr('id');
 console.log('response'+dv);
			    
			   
			   $.get('/ajaxresponserequest/?uid='+str2,function(data){
			   	 $('#removeconnection-'+str2).css('display','block');
				   $('#'+dv).css('display','none');
				  
			   });
 }
  /******like post ****/
 function likepostfunct(s){
	 var likeid=s.id;
	 if($( "#"+likeid ).hasClass( "orangecolor" ))
	 {
		 $( "#"+likeid ).removeClass('orangecolor');
	 }else{
		 
		 $( "#"+likeid ).addClass('orangecolor');
	 } 
               var datas = s.getAttribute("data-like");
			   $.get('/ajax-request-like/?likeid='+datas,function(data){
				   var ret = likeid.split("-");
var str1 = ret[0];
var str2 = ret[1];
if(data['type']==0){
if(data['mylike']==0){
	 $(".dd-comments-holder.postid"+str2).hide();
     $(".postid"+str2+" .dd-show-likes a").html("");
	 
}else if(data['mylike']==1){
	var totaloslike=data['totallikes']-1;
	if(data['totallikes']==1){
	$(".dd-comments-holder.postid"+str2).show();	
	$(".postid"+str2+" .dd-show-likes a").html('<i class="fa fa-thumbs-up" aria-hidden="true"></i> '+data['name']);
	}else{
		$(".dd-comments-holder.postid"+str2).show();	 
		$(".postid"+str2+" .dd-show-likes a").html('<i class="fa fa-thumbs-up" aria-hidden="true"></i> '+data['name']+" "+totaloslike+' others');
	}
}else{
	var totaloslike=data['totallikes']-1;
	$(".dd-comments-holder.postid"+str2).show();
				   $(".postid"+str2+" .dd-show-likes a").html('<i class="fa fa-thumbs-up" aria-hidden="true"></i> '+totaloslike+' others');
}
}else{
	var totaloslike=data['totallikes'];
	$(".dd-comment-footer #likepost-"+str2).html('<i class="fa fa-thumbs-o-up" aria-hidden="true"></i>  '+totaloslike+'  Likes');
}
				  
				  
			   });
 }
 
 
/*Add image show on select Event*/
$("#file-1").change(function(){	
	var updatedCover = $("#file-1").val();
	var uplodFile = previewCoverImage(this,'coverPic');
    if (uplodFile == 1) {
		 $(".dd-cover-changer").show();
        
        $(".removedpost").show();   
    }else{
        alert("Look like you upload wrong format image, please make sure to upload jpg or png format image.");
    }	
});



$(function(){
  $('.removedpost').click(function(){

      $('#file-1').val('');
      $("#file-1").prop('disabled', false);
	  $(".removedpost").hide();
	  $(".dd-cover-changer").hide();

  });
});


$( function ( document, window, index )
{
	var inputs = document.querySelectorAll( '.inputfile' );
	Array.prototype.forEach.call( inputs, function( input )
	{
		var label	 = input.nextElementSibling,
			labelVal = label.innerHTML;

		input.addEventListener( 'change', function( e )
		{
			var fileName = '';
			if( this.files && this.files.length > 1 )
				fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
			else
				fileName = e.target.value.split( '\\' ).pop();

			if( fileName )
				label.querySelector( 'span' ).innerHTML = fileName;
			else
				label.innerHTML = labelVal;
		});

		// Firefox bug fix
		input.addEventListener( 'focus', function(){ input.classList.add( 'has-focus' ); });
		input.addEventListener( 'blur', function(){ input.classList.remove( 'has-focus' ); });
	});
}( document, window, 0 ));
/*****register form validation ***/
function ValidateEmail(email) {
        var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        return expr.test(email);
    };
	
function formvalidation(){
	
			/****check Role empty or not***/
			var dobyear= $('#dobyear').find(":selected").val();
			
 if(dobyear==undefined){  
 $(".borderred").addClass('errors'); 
 		$(".borderred").show();
		
         
		
         $(".borderred.errors").text("Select Year");
       }
			/****check Role empty or not***/
			 var dobmonth= $('#dobmonth').find(":selected").val();
			 
			 
 if(dobmonth==0){  
 $(".borderred").addClass('errors'); 
 		$(".borderred").show();
		 
		
         $(".borderred.errors").text("Select Month");
       }
	   var dobday= $('#dobday').find(":selected").val();
			/****check Role empty or not***/

 if(dobday==' '){  
 $(".borderred").addClass('errors'); 
 		$(".borderred").show();
		
         $(".borderred.errors").text("Select Day");
       }
		/****check Role empty or not***/
var userrole= $('#userrole').find(":selected").text();

 if(userrole=='Who your are ?'){  
        $(".borderred").addClass('errors'); 
 		$(".borderred").show();   
		
         $(".borderred.errors").text("Select Who you are?");
       }
	

	/*****email validation ***/
	var pdv=$('#remail').val();
if(pdv == '') {
	$(".borderred").show();
 $(".borderred").addClass('errors');
            $('.errors').text('Email is required');
}else{
	$(".borderred").show();
    if (!ValidateEmail(pdv)) {  
          
            if(pdv.length < 6) {

             $(".borderred").addClass('errors');
            $('.errors').text('Too short. Use at least 6 characters');

            return false;
          }else{
            $(".borderred").addClass('errors'); 
            $(".errors").text("Please enter a valid email address");
          }  
    
          
        }
}

/****check password field empty or not***/
	var pass = $("#rpassword").val();
	///alert(pass);
 if( pass == ''){  
 		$(".borderred").show();
		
		
        $(".borderred").addClass('errors'); 
		 
		
         $(".borderred.errors").text("Password is required");
       }


	/*****name validation***/
/*if($(".genders1").val()=='' ){   
       $(".borderred").addClass('errors');       
         $(".borderred.errors").text("Last Name is required");
       }else if($(".genders2").val()=='' ){   
       $(".borderred").addClass('errors');       
         $(".borderred.errors").text("Last Name is required");
       }*/
	   
       if($("#lname").val()=='' ){   
       $(".borderred").addClass('errors');       
         $(".borderred.errors").text("Last Name is required");
       }
	   if($("#fname").val()=='' ){  
	   
        $(".borderred").addClass('errors');       
         $(".borderred.errors").text("First Name is required");
       }
	   
	   
	   var errorss= $('.borderred.errors').text();
       if(errorss!=''){
		   $(".borderred").hide();
       jQuery('.requiredvalues').val('sets');
       }

}
$('#rpassword').keyup(function(e) {
    var pdv=$('#rpassword').val();
	$('#passwordconfirm').val(pdv);
    if( pdv != "") {
      if(pdv.length < 8) {
         $(".borderred").addClass('errors');
        $('.borderred.errors').text('Too short. Use at least 8 characters');
        return false;
      }     
      re = /[0-9]/;
      if(!re.test(pdv)) {        
         $(".borderred").addClass('errors');
        $('.borderred.errors').text('Use at least 1 letter & number or symbol');
        return false;
      }
      re = /[A-Za-z]/;
      if(!re.test(pdv)) {
        $(".borderred").addClass('errors');
        $('.borderred.errors').text('Use at least 1 letter & number or symbol');
        return false;
      }      
    } else {      
       var spaceCount = 0;
  
if( e.keyCode == 32 && spaceCount > 1 ){
        e.preventDefault();
    }else if(pdv== ""){
        $(".borderred").addClass('errors');
        $(".borderred.errors").text('Password is required');       
    }    
      return false;
    }
	
    $(".borderred").removeClass('errors');
        $(".borderred").text('');
    return true; 
  });
function getPostData(data)
{
	//console.log(data);
		$.get('/timelinepostajaxrequest/?id='+data,function(data){
			//console.log(data);
		})
			 location.reload(); 

}
function mapmycontact(mapid)
{

	$.ajaxSetup({
               headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
            });
 var map = mapid.id;
	//console.log(map);
 	$.get('/mapid/?map='+map,function(data){
 					console.log(data)
				   //console.log(typeof(data[0]));
				  if(typeof(data[0])=='string')
				  {
				  		//console.log('dd')
				        var map;
    					var marker;

				        var addressInput =data[0];

				        var geocoder = new google.maps.Geocoder();

				        geocoder.geocode({address: addressInput}, function(results, status) {

				            if (status == google.maps.GeocoderStatus.OK) {

				          var myResult = results[0].geometry.location;

				          createMarker(myResult);

				          map.setCenter(myResult);

				          map.setZoom(15);
				            }
				        });    
				 


   					 	google.maps.event.addDomListener(window, 'load', initialize);


				        
				        var marker;

					    function createMarker(latlng) {

					      if(marker != undefined && marker != ''){
					        marker.setMap(null);
					        marker = '';
					      }

					      marker = new google.maps.Marker({
					        map: map,
					        position: latlng
					      });
					    }

					    if(data)
				    	{
				  		
				          		var addressInput =data;
				          		map = new google.maps.Map(document.getElementById("map-canvas"));

				        		 var geocoder = new google.maps.Geocoder();

				        		 geocoder.geocode({address: addressInput}, function(results, status) {

					             if (status == google.maps.GeocoderStatus.OK) {

							           var myResult = results[0].geometry.location;
							         //   console.log(myResult)

							           createMarker(myResult);

							           map.setCenter(myResult);

							           map.setZoom(15);
				             	}
				        	});
				        }



				  }
				  else
				  {
				  	$('#map-canvas').html('<h5><center>Sorry,Address is Not Availabe.</center></h5>')
				  }
				  
						  
	 });
}

function unregmap(mapid)
{
  	$.ajaxSetup({
               headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
            });
 var map = mapid;
	//console.log(map);
 	$.get('/mapid/?map='+map,function(data){
				   //console.log(typeof(data[0]));
				  if(mapid)
				  {
				  		//console.log('dd')
				        var map;
    					var marker;

				        var addressInput =mapid;

				        var geocoder = new google.maps.Geocoder();

				        geocoder.geocode({address: addressInput}, function(results, status) {

				            if (status == google.maps.GeocoderStatus.OK) {

				          var myResult = results[0].geometry.location;

				          createMarker(myResult);

				          map.setCenter(myResult);

				          map.setZoom(15);
				            }
				        });    
				 


   					 	google.maps.event.addDomListener(window, 'load', initialize);


				        
				        var marker;

					    function createMarker(latlng) {

					      if(marker != undefined && marker != ''){
					        marker.setMap(null);
					        marker = '';
					      }

					      marker = new google.maps.Marker({
					        map: map,
					        position: latlng
					      });
					    }

					    if(data)
				    	{
				  		
				          		var addressInput =data;
				          		map = new google.maps.Map(document.getElementById("map-canvas"));

				        		 var geocoder = new google.maps.Geocoder();

				        		 geocoder.geocode({address: addressInput}, function(results, status) {

					             if (status == google.maps.GeocoderStatus.OK) {

							           var myResult = results[0].geometry.location;
							         //   console.log(myResult)

							           createMarker(myResult);

							           map.setCenter(myResult);

							           map.setZoom(15);
				             	}
				        	});
				        }



				  }
				  else
				  {
				  	$('#map-canvas').html('<h5><center>Sorry,Address is Not Availabe.</center></h5>')
				  }
				  
						  
	 });

  
}
function chide(getid)
{

console.log(getid.id)

var postid = getid.id
var combinedele = postid.split("-");
var str1 = combinedele[0];
var str2 = combinedele[1];
	
var link = $(this);
$("#commentbox-"+str2).toggle();
		 
}

function rhide(getid)
{

console.log(getid.id)

var postid = getid.id
var combinedele = postid.split("-");
var str1 = combinedele[0];
var str2 = combinedele[1];
	console.log(str2)

var link = $(this);
$("#replybox-"+str2).toggle();
		 
}

function subreplyhide(rr)
{
console.log('#replybox-'+rr)
$('#'+rr).toggle();
	}
function comments(s){
     event.preventDefault();


	  $.get('/timelinepostcommentajaxrequest/?statusid='+s.id+'&comment='+s.value+'&type=0',function(data){
	 		// console.log(sendData)
	 		 location.reload();
	 	})
};
function reply(s){
     event.preventDefault();



 	  $.get('/timelinepostcommentajaxrequest/?statusid='+s.id+'&comment='+s.value+'&type=1',function(data){
 	 		 location.reload();
 	 	})
};

function homecomments(s){
    //event.preventDefault();
    if(jQuery.trim(s.value).length > 0)
    {

	    var statusId = s.id;    
	    var comment = s.value;

	    var liketotalstr = $('#maincomment-'+statusId).text();
		var retrivevalue = liketotalstr.split(" ");
		var likecount = retrivevalue[0];
		var likestr = retrivevalue[1];
		 $('#'+statusId).attr('disabled','disabled'); 

		
		$('#maincomment-'+statusId).text(parseInt(likecount)+1+' Comments')


		$.ajax({
		    'url'   :'/homecommentajaxrequest',
		    'type'  :'GET',
		    'data'  :{'statusid':statusId,'comment':comment,'type':0},
		    'success':function(result){ //alert('question'+result);
		        console.log(result);
		        if (result != '' && result != null) {	        	
		        	$(result).insertAfter('div#comment-box-'+statusId);
		        	$('textarea#'+statusId).val('');
		        	$('#'+statusId).removeAttr('disabled'); 
		        };
		    }
		});
		/*$.get('/homecommentajaxrequest/?statusid='+s.id+'&comment='+s.value+'&type=0',function(data){
		 	console.log(data);
		 	//location.reload();
		})*/
 		event.preventDefault();
 	}
 	else
 	{
 		event.preventDefault();
 	}
};
// function homereply(s){
//  	//event.preventDefault();
//  	var statusId = s.id;    
//     var comment = s.value;
//     var postId = $('textarea#'+statusId).attr('post');
//     //alert(postId);
// 	$.ajax({
// 	    'url'   :'/homecommentajaxrequest',
// 	    'type'  :'GET',
// 	    'data'  :{'statusid':statusId,'comment':comment,'type':1,'postId':postId},
// 	    'success':function(result){ //alert('question'+result);
// 	        console.log(result);
// 	        if (result != '' && result != null) {	        	
// 	        	$(result).insertBefore('textarea#'+statusId);
// 	        	$('textarea#'+statusId).val('');
// 	        };
// 	    }
// 	});
//  event.preventDefault();
//   	/*$.get('/homecommentajaxrequest/?statusid='+s.id+'&comment='+s.value+'&type=1',function(data){
// 		location.reload();
//  	})*/
// };


/*function homecomments(s){
    
    event.preventDefault();

	$.get('/homecommentajaxrequest/?statusid='+s.id+'&comment='+s.value+'&type=0',function(data){
	 		
        
	 		// console.log(sendData);
	 		 location.reload();
	 		
	 	})
};
function homereply(s){

 event.preventDefault();
 	

 	  $.get('/homecommentajaxrequest/?statusid='+s.id+'&comment='+s.value+'&type=1',function(data){

 	 		 location.reload();
 	 	})
};*/



      function validate()
      {
        var total_file=document.getElementById("upload_file").files.length;
        var albumtitle=document.getElementById("albumname").value;
       
       if(albumtitle=='' || albumtitle=="undefined" || albumtitle=="empty")
       {
          $("#alert2").css("display",'block');
          return false;
       }     
       if(total_file==0)
       {
          $("#alert1").css("display",'block');
          return false;
       }    
       else
       {
         return true;
       }
      }
         


        function preview_image() 
        {
         var total_file=document.getElementById("upload_file").files.length;
         var imgPreview = $('div.album-img-div').length;
        
         for(var i=0;i<total_file;i++)
         {  
         	if (i>0) {
         		imgPreview = imgPreview + i;
         	};
         	 
            // alert(event.target.files[i].type);
           if(event.target.files[i].type == 'image/png' || event.target.files[i].type == 'image/jpeg' ||  event.target.files[i].type == 'image/jpg')
            {  
            	$('#image_preview').append("<div class='album-img-div' id='img-prev-"+imgPreview+"'><i class='fa fa-times remove-img' aria-hidden='true' onclick='removeAlbumImg("+imgPreview+")'></i><img class='col-md-2' id='img-"+i+"' src='"+URL.createObjectURL(event.target.files[i])+"'><input type='hidden' name='is_remove_"+imgPreview+"' value='0'></div>");
            	
            }
            else
            {    
            	alert(event.target.files[i].name+ "is not valid image. Please Upload Valid Image");
            }
         }
        }



$('.upload_file').click(function(){	
	var total_file=$("input.up_img").length;
	//console.log(total_file);
	if (total_file > 0) {
		$('<input type="file" id="upload_file" class="up_img upload_img_'+total_file+'" name="upload_file[]" onchange="preview_image();" multiple="">').insertAfter('label.image_preview2.upload_file');
		$('.upload_img_'+total_file).trigger('click'); 
	}else{
		$('#upload_file').trigger('click'); 
	}
	
});


$('label.add_more_image_preview2.add_more_upload_file').click(function() {
	var total_file=$("input.add_more_up_img").length;
	//console.log(total_file);
	if (total_file > 0) {
		$('<input type="file" id="add_more_img_album" class="add_more_up_img add_more_upload_img_'+total_file+'" name="more_upload_file[]" onchange="add_more_preview_image();" multiple="">').insertAfter('label.add_more_image_preview2.add_more_upload_file');
		$('.add_more_upload_img_'+total_file).trigger('click'); 
	}else{
		$('input#add_more_img_album').trigger('click'); 
	}	
});
function add_more_preview_image() {
	var total_file=document.getElementById("add_more_img_album").files.length;
	var imgPreview = $('div.add_more_album-img-div').length;
	console.log(total_file);
	for(var i=0;i<total_file;i++)
	{  
		if (i>0) {
			imgPreview = imgPreview + i;
		};

		//alert(event.target.files[i].type);
		if(event.target.files[i].type == 'image/png' || event.target.files[i].type == 'image/jpeg' ||  event.target.files[i].type == 'image/jpg'){  
			$('span#add_more_image_preview').append("<div class='add_more_album-img-div' id='img-prev-"+imgPreview+"'><i class='fa fa-times remove-img' aria-hidden='true' onclick='removeAlbumImg("+imgPreview+")'></i><img class='col-md-2' id='img-"+i+"' src='"+URL.createObjectURL(event.target.files[i])+"'></div>");
		}else{    
			alert(event.target.files[i].name+ "is not valid image. Please Upload Valid Image");
		}
	}
}



function removeAlbumImg(imgNo) {	
	//alert(imgNo);		
	$('#image_preview div#img-prev-'+imgNo).remove();
	$('span#add_more_image_preview div#img-prev-'+imgNo).remove();
	imgNo = imgNo + 1;
	$('input.up_img.upload_img_'+imgNo).remove();
	$('input.add_more_up_img.add_more_upload_img_'+imgNo).remove();
}


function deleteAlbum(albumId){	
	$.get('/photoalbum/delete-album?albumId='+albumId,function(data){
		$('div#album-div-'+data).remove();
	});
}

// VALIDATION OF PHONE AND FAX

$('#number').keydown(function(e) {
        var number = $(this).val();
        if(number.length==3)
        {
        	 if (e.keyCode !== 8) {
                number = '('+number+')';
                $(this).val(number);
                console.log(number.length)
            }

        }
        else if (number.length == 8) {
            if (e.keyCode !== 8) {
                number = number+'-';
                $(this).val(number);
            }
        } else if (number.length == 13) {
            
            if (e.keyCode !== 8 && e.keyCode !== 9 && e.keyCode !== 37 && e.keyCode !== 39 && e.keyCode !== 46) {
                return false;
            };
        } else {
           
        }
    });
  $('#fax').keydown(function(e) {
        var number = $(this).val();
        if (number.length == 3 || number.length == 7) {
            if (e.keyCode !== 8) {
                number = number+'-';
                $(this).val(number);
            }
        } else if (number.length == 12) {
            
            if (e.keyCode !== 8 && e.keyCode !== 9 && e.keyCode !== 37 && e.keyCode !== 39 && e.keyCode !== 46) {
                return false;
            };
        } else {
          
        }
   	});
   function disablepostingstatus()
  {
  	  console.log('dd')
  	  $('#postNewStatus').attr('disabled','disabled'); 
  	  $('#postNewStatus2').attr('disabled','disabled'); 
  	  return true;
  	
  }