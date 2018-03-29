 @if(Auth::check())
 @if(Request::path()=='home' || Request::path()=='profile' )
    <script type="text/javascript">
      var page = 1; //track user scroll as page number, right now page number is 1
      if(page == 1){
        load_more(page);//initial content load
      } 
      $(window).scroll(function() { //detect page scroll
          if($(window).scrollTop() + $(window).height() >= $(document).height()) { //if user scrolled from top to bottom of the page
              page++; //page number increment
              load_more(page); //load content   
          }
      });     
      function load_more(page){
       var urlname='{{Request::path()}}';
        $.ajax(
              {
                  url: '/'+urlname+'?page=' + page,
                  type: "get",
                  datatype: "html",
                  beforeSend: function()
                  {
                      $('.ajax-loading').show();
                  }
              })
              .done(function(data)
              {
                  if(data.length == 0){
                  console.log(data.length);
                     
                      //notify user if nothing to load
                      $('.ajax-loading').html("No more records!");
                      return false;
                  }else{
                  $('.ajax-loading').hide(); //hide loading animation once data is received
                  $("#results").append(data);   //append data into #results element  
                  paginateComment(); //class comment pagination
                  //alert('I am here');  
                  //return true;
                  }        
              })
              .fail(function(jqXHR, ajaxOptions, thrownError)
              {
                    //alert('No response from server');
              });
       }
    </script>
    @endif
     @endif

       @if(Auth::check())
    <script type="text/javascript">
    setInterval(function () { notifications() }, 1000);
      </script>
    @endif