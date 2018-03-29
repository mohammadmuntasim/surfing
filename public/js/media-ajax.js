/*!
 * Design and develop by RIZWANA ANSARI ( rizwanawork786@gmail.com ) at FUDUGO SOLUTIONS PVT. LTD. 
 *
 * Copyright 2017 www.fudugo.com
 * Licensed Authorize by fudugosolutions@2017
 */

//remove album or delete album
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
//delete Album
function deleteAlbumPhoto(s){
	//alert('Stupid');
	 $('#deletealbum').submit();
	 window.location.replace("{{Request::path()}}");
	
}


//delete album
function deleteMyAlbum(s){
	var albumid= s.getAttribute('data-album');
	$.ajax({
    url: '/photos',
    type: 'POST',
    data: {_token: CSRF_TOKEN,album:albumid},
    dataType: 'JSON',
    success: function (data) {
        
        $('div#album-div-'+data).remove();
    }
});
}


/**** delete media image User ***/

function deleteAlbumImage(s){

    var imgid=s.getAttribute('data-imageid');
    $.ajax({
    url: '/deletemedia',
    type: 'GET',
    data: {imgid:imgid,_token: CSRF_TOKEN},
    dataType: 'JSON',
    success: function (data) {
        
         $('#mediaalbum'+imgid).css('display','none');
         if(data==1){
            window.location.replace("{{Request::path()}}");
         }
    }
    });
    
}