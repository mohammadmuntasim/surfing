/*!
 * Design and develop by RIZWANA ANSARI ( rizwanawork786@gmail.com ) at FUDUGO SOLUTIONS PVT. LTD. 
 *
 * Copyright 2017 www.fudugo.com
 * Licensed Authorize by fudugosolutions@2017
 */

var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
//reminder show onlick
$("#reminder").click(function(){
    $("#bookingNotify").fadeIn('slow');
});
$("#bookingNotify .close").click(function(){
    $("#bookingNotify").fadeOut();
});

<!--notification script -->
///FETCH NOTIFICATION CONTENT NOTIFICATION START
      $(function() {
          $('.dd-user-point a').click(function() { 
           var idss=$(this).attr('id');
                      var bn=document.location.origin;
                $('.'+idss+'.dropdown-menu.dd-notification-list').html('<span class="dd-notification-title">Notifications</span><center><img src="'+bn+'/css/assets/img/loader.gif" ></center>');
           setTimeout(function() {
           
            $.ajax({
                      url: '/notifications',
                      type: 'GET',
                      data: {_token: CSRF_TOKEN,name:idss},
                      dataType: 'JSON',
                      success: function (data) {
                      	if(data==''){
			                if(idss=='connections'){
			                $('.'+idss+'.dropdown-menu.dd-notification-list').html('<span class="dd-notification-title">No Connection Notifications</span><br>No Connection Notification');
			                }else{
			                $('.'+idss+'.dropdown-menu.dd-notification-list').html('<span class="dd-notification-title">No Notifications</span><br>No Notification');

			                }
			               
			              }else{
			                 if(idss=='connections'){
			                 $('.'+idss+'.dropdown-menu.dd-notification-list').html('<span class="dd-notification-title">Connection Notifications</span>'+data);

			                 }else{
			                   $('.'+idss+'.dropdown-menu.dd-notification-list').html('<span class="dd-notification-title">Notifications</span>'+data);
			                 }
			               }
                      }
                  });

            }, 2000);

            $('#'+idss).removeAttr( "data-bubble" ); 
          });

          
      });
///FETCH NOTIFICATION CONTENT NOTIFICATION START
///FETCH NOTIFICATION NUMBER NOTIFICATION START
/*notification top bar*/
     function notifications(){         
           var refers=$('#allnotifications').attr("data-bubble");
           var countvalue='counts';
           setTimeout(function() {
            var bn=document.location.origin;
             $('.'+refers+' .dropdown-menu.dd-notification-list').html('<center><img src="'+bn+'/css/assets/img/ring.gif" ></center>');
            }, 2000);
            $.ajax({
                  url: '/notifications',
                  type: 'GET',
                  data: {_token: CSRF_TOKEN,name:countvalue},
                  dataType: 'JSON',
                  success: function (data) {
	                 if(data['notifications']===0) {
	                  $('#allnotifications').removeAttr("data-bubble");
	                 }else{
	                  $('#allnotifications').attr("data-bubble",data['notifications']);
	                 }
	                 if(data['connections']===0) {                 
	                  $('#connections').removeAttr("data-bubble");
	                 }else{
	                  $('#connections').attr("data-bubble",data['connections']);
	                  }
	              }
              });       
                       
      }
      ///FETCH NOTIFICATION NUMBER NOTIFICATION END