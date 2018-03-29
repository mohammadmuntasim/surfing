// JavaScript Document


/****8patient booking dob ***/
 var d = new Date();
var year = d.getFullYear();

$('#patientdob').datepicker({dateFormat:'dd-mm-yy',changeMonth: true,yearRange: '1917:' + year + '', defaultDate: d,  changeYear: true});

/**** appoint ment calender ***/
$(document).ready(function() {
		
            $.urlParam = function(name){
				var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
				if (results==null){
				   return null;
				}
				else{
				   return results[1] || 0;
				}
			}
			
			var recursiveEncoded = $.urlParam( 'ref_app' );
			var my_calendar = $("#dncalendar-container").dnCalendar({
				minDate: "2017-01-15",
				maxDate: "2017-12-31",
				defaultDate: "2017-04-03",
				monthNames: [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ], 
				monthNamesShort: [ 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Agu', 'Sep', 'Oct', 'Nov', 'Dec' ],
				dayNames: [ 'Sunday','Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                dayNamesShort: [  'Sun','Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat' ],
                dataTitles: { defaultDate: 'default', today : 'Today' },
                notes: [
                		{ "date": "2016-05-25", "note": ["Natal"] },
                		{ "date": "2016-05-12", "note": ["Tahun Baru"] }
                		],
                showNotes: true,
                startWeek: '3',
                dayClick: function(date, view) {
					if(recursiveEncoded==null){
						
						 if($('.card .alert.alert-danger').length == 0) {

						$('.card').prepend('<div class="alert alert-danger" role="alert"><strong>Oh snap!</strong> Please search doctor profile to book appointment.</div>');		
						 }		
                	
					}else{
						var weekday = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];

var a = new Date('08/11/2015');
var vday=weekday[date.getDay()];
console.log(weekday[date.getDay()]);
var docid=$("[name='docid']").val();
var bdate=date.getDate() + "-" + (date.getMonth() + 1) + "-" + date.getFullYear();
$.get('/schedule/?dayname='+vday+'&docname='+docid+'&date='+bdate,function(data){ 
              //console.log(data['options']);
               $('#myAppoTime .modal-body p').html(data);
                // $('.user_city_div .dropdown-menu.inner').html(data['lis']);
               
              });
//alert(weekday[date.getDay()]);
					$('#bookingModal').modal('show');
                    $('#booking_date').val(date.getDate() + "-" + (date.getMonth() + 1) + "-" + date.getFullYear());

                	$('#bookingModal h4.modal-title span').text(date.getDate() + "-" + (date.getMonth() + 1) + "-" + date.getFullYear());
					}
                }
			});
   
			// init calendar
			my_calendar.build();
		});
/****** crop image profile  ***/
"use strict";
(function (factory) {
    if (typeof define === 'function' && define.amd) {
        define(['jquery'], factory);
    } else {
        factory(jQuery);
    }
}(function ($) {
    var cropbox = function(options, el){
        var el = el || $(options.imageBox),
            obj =
            {
                state : {},
                ratio : 1,
                options : options,
                imageBox : el,
                thumbBox : el.find(options.thumbBox),
                spinner : el.find(options.spinner),
                image : new Image(),
                getDataURL: function ()
                {
                    var width = this.thumbBox.width(),
                        height = this.thumbBox.height(),
                        canvas = document.createElement("canvas"),
                        dim = el.css('background-position').split(' '),
                        size = el.css('background-size').split(' '),
                        
                        dx = parseInt(dim[0]) - el.width()/2 + width/2,
                        dy = parseInt(dim[1]) - el.height()/2 + height/2,
                        dw = parseInt(size[0]),
                        dh = parseInt(size[1]),
                        sh = parseInt(this.image.height),
                        sw = parseInt(this.image.width);


                    canvas.width = width;
                    canvas.height = height;
                    var context = canvas.getContext("2d");
                    
                    context.drawImage(this.image, 0, 0, sw, sh, dx, dy, dw, dh);

                    var imageData = canvas.toDataURL('image/jpg');
                 
                    return imageData;
                },
               getBlob: function()
                {
                    var imageData = this.getDataURL();
                    var b64 = imageData.replace('data:image/jpg;base64,','');
                    var binary = atob(b64);
                    var array = [];
                    for (var i = 0; i < 2; i++) {
                        array.push(binary.charCodeAt(i));
                    }
                    return  new Blob([new Uint8Array(array)], {type: 'image/jpg'});
                },
                zoomIn: function ()
                {
                    this.ratio*=1.1;
                    setBackground();
                },
                zoomOut: function ()
                {
                    this.ratio*=0.9;
                    setBackground();
                }
            },
            setBackground = function()
            {
                var w =  parseInt(obj.image.width)*obj.ratio;
                var h =  parseInt(obj.image.height)*obj.ratio;

                var pw = (el.width() - w) / 2;
                var ph = (el.height() - h) / 2;

                el.css({
                    'background-image': 'url(' + obj.image.src + ')',
                    'background-size': w +'px ' + h + 'px',
                    'background-position': pw + 'px ' + ph + 'px',
                    'background-repeat': 'no-repeat'});
            },
            imgMouseDown = function(e)
            {
                e.stopImmediatePropagation();

                obj.state.dragable = true;
                obj.state.mouseX = e.clientX;
                obj.state.mouseY = e.clientY;
            },
            imgMouseMove = function(e)
            {
                e.stopImmediatePropagation();

                if (obj.state.dragable)
                {
                    var x = e.clientX - obj.state.mouseX;
                    var y = e.clientY - obj.state.mouseY;

                    var bg = el.css('background-position').split(' ');

                    var bgX = x + parseInt(bg[0]);
                    var bgY = y + parseInt(bg[1]);

                    el.css('background-position', bgX +'px ' + bgY + 'px');

                    obj.state.mouseX = e.clientX;
                    obj.state.mouseY = e.clientY;
                }
            },
            imgMouseUp = function(e)
            {
                e.stopImmediatePropagation();
                obj.state.dragable = false;
            },
            zoomImage = function(e)
            {
                e.originalEvent.wheelDelta > 0 || e.originalEvent.detail < 0 ? obj.ratio*=1.1 : obj.ratio*=0.9;
                setBackground();
            }

        obj.spinner.show();
        obj.image.onload = function() {
            obj.spinner.hide();
            setBackground();

            el.bind('mousedown', imgMouseDown);
            el.bind('mousemove', imgMouseMove);
            $(window).bind('mouseup', imgMouseUp);
            el.bind('mousewheel DOMMouseScroll', zoomImage);
        };
        obj.image.src = options.imgSrc;
        el.on('remove', function(){$(window).unbind('mouseup', imgMouseUp)});

        return obj;
    };

    jQuery.fn.cropbox = function(options){
        return new cropbox(options, this);
    };
}));




    $(window).load(function() {
        var options =
        {
            thumbBox: '.thumbBox',
            spinner: '.spinner',
            imgSrc: 'avatar.jpg'
        }
        var cropper;
        $('#file').on('change', function(){
            $('.imageBox').css('display','block')
            var reader = new FileReader();
            reader.onload = function(e) {
                options.imgSrc = e.target.result;
                cropper = $('.imageBox').cropbox(options);
            }
            reader.readAsDataURL(this.files[0]);
            this.files = [];
        })
        $('#btnCrop').on('click', function(){
            var img = cropper.getDataURL()
          //$('.cropped').append('<img id="canvasimage" src="'+img+'">');
$('#profilepic').val(img);
        })
        $('#btnZoomIn').on('click', function(){
            cropper.zoomIn();
        })
        $('#btnZoomOut').on('click', function(){
            cropper.zoomOut();
        })
    });
<!---star rating review -->



$(function(){

  //$('#new-review').autosize({append: "\n"});

  var reviewBox = $('#post-review-box');
  var newReview = $('#new-review');
  var openReviewBtn = $('#open-review-box');
  var closeReviewBtn = $('#close-review-box');
  var closetopReviewBtn = $('#myReviews .close');
  var ratingsField = $('#ratings-hidden');

  openReviewBtn.click(function(e)
  {
    reviewBox.slideDown(400, function()
      {
        $('#new-review').trigger('autosize.resize');
        newReview.focus();
      });
    openReviewBtn.fadeOut(100);
	$('#myReviews').modal('show');
    closeReviewBtn.show();
  });

closetopReviewBtn.click(function(e)
  {
    e.preventDefault();
    reviewBox.slideUp(300, function()
      {
        newReview.focus();
        openReviewBtn.fadeIn(200);
		$('#myReviews').modal('hide');
                $('#new-review').val('');
      });
    closeReviewBtn.hide();
    
  });
  closeReviewBtn.click(function(e)
  {
    e.preventDefault();
    reviewBox.slideUp(300, function()
      {
        newReview.focus();
        openReviewBtn.fadeIn(200);
		$('#myReviews').modal('hide');
$('#new-review').val('');
      });
    closeReviewBtn.hide();
    
  });


 
});

//file

;(function ( $, window, document, undefined ) {

  'use strict';

  // Create the defaults once
  var pluginName = 'starRating';
  var noop = function(){};
  var defaults = {
    totalStars: 5,
    useFullStars: false,
    starShape: 'straight',
    emptyColor: '#ffffff',
    hoverColor: '#ffda0a',
    activeColor: '#ffda0a',
    useGradient: false,
    readOnly: false,
    disableAfterRate: false,
    baseUrl: false,
    starGradient: {
      start: '#ffda0a',
      end: '#ffda0a'
    },
    strokeWidth: 40,
    strokeColor: '#ffda0a',
    initialRating: 0,
    starSize: 40,
    callback: noop,
    onHover: noop,
    onLeave: noop
  };

	// The actual plugin constructor
  var Plugin = function( element, options ) {
    var _rating;
    this.element = element;
    this.$el = $(element);
    this.settings = $.extend( {}, defaults, options );

    // grab rating if defined on the element
    _rating = this.$el.data('rating') || this.settings.initialRating;
    this._state = {
      // round to the nearest half
      rating: (Math.round( _rating * 2 ) / 2).toFixed(1)
    };

    // create unique id for stars
    this._uid = Math.floor( Math.random() * 999 );

    // override gradient if not used
    if( !options.starGradient && !this.settings.useGradient ){
      this.settings.starGradient.start = this.settings.starGradient.end = this.settings.activeColor;
    }

    this._defaults = defaults;
    this._name = pluginName;
    this.init();
  };

  var methods = {
    init: function () {
      this.renderMarkup();
      this.addListeners();
      this.initRating();
    },

    addListeners: function(){
      if( this.settings.readOnly ){ return; }
      this.$stars.on('mouseover', this.hoverRating.bind(this));
      this.$stars.on('mouseout', this.restoreState.bind(this));
      this.$stars.on('click', this.handleRating.bind(this));
    },

    // apply styles to hovered stars
    hoverRating: function(e){
      var index = this.getIndex(e);
      this.paintStars(index, 'hovered');
      this.settings.onHover(index + 1, this._state.rating, this.$el);
    },

    // clicked on a rate, apply style and state
    handleRating: function(e){
      var index = this.getIndex(e);
      var rating = index + 1;

      this.applyRating(rating, this.$el);
      this.executeCallback( rating, this.$el );

      if(this.settings.disableAfterRate){
        this.$stars.off();
      }
    },

    applyRating: function(rating){
      var index = rating - 1;
      // paint selected and remove hovered color
      this.paintStars(index, 'active');
      this._state.rating = index + 1;
    },

    restoreState: function(e){
      var index = this.getIndex(e);
      var rating = this._state.rating || -1;
      this.paintStars(rating - 1, 'active');
      this.settings.onLeave(index + 1, this._state.rating, this.$el);
    },

    getIndex: function(e){
      var $target = $(e.currentTarget);
      var width = $target.width();
      var side = $(e.target).attr('data-side');

      // hovered outside the star, calculate by pixel instead
      side = (!side) ? this.getOffsetByPixel(e, $target, width) : side;
      side = (this.settings.useFullStars) ? 'right' : side ;

      // get index for half or whole star
      var index = $target.index() - ((side === 'left') ? 0.5 : 0);

      // pointer is way to the left, rating should be none
      index = ( index < 0.5 && (e.offsetX < width / 4) ) ? -1 : index;
      return index;
    },

    getOffsetByPixel: function(e, $target, width){
      var leftX = e.pageX - $target.offset().left;
      return ( leftX <= (width / 2) && !this.settings.useFullStars) ? 'left' : 'right';
    },

    initRating: function(){
      this.paintStars(this._state.rating - 1, 'active');
    },

    paintStars: function(endIndex, stateClass){
      var $polygonLeft;
      var $polygonRight;
      var leftClass;
      var rightClass;

      $.each(this.$stars, function(index, star){
        $polygonLeft = $(star).find('[data-side="left"]');
        $polygonRight = $(star).find('[data-side="right"]');
        leftClass = rightClass = (index <= endIndex) ? stateClass : 'empty';

        // has another half rating, add half star
        leftClass = ( index - endIndex === 0.5 ) ? stateClass : leftClass;

        $polygonLeft.attr('class', 'svg-'  + leftClass + '-' + this._uid);
        $polygonRight.attr('class', 'svg-'  + rightClass + '-' + this._uid);

      }.bind(this));
    },

    renderMarkup: function () {
      var s = this.settings;
      var baseUrl = s.baseUrl ? location.href.split('#')[0] : '';

      // inject an svg manually to have control over attributes
      var star = '<div class="jq-star" style="width:' + s.starSize+ 'px;  height:' + s.starSize + 'px;"><svg version="1.0" class="jq-star-svg" shape-rendering="geometricPrecision" xmlns="http://www.w3.org/2000/svg" ' + this.getSvgDimensions(s.starShape) +  ' stroke-width:' + s.strokeWidth + 'px;" xml:space="preserve"><style type="text/css">.svg-empty-' + this._uid + '{fill:url(' + baseUrl + '#' + this._uid + '_SVGID_1_);}.svg-hovered-' + this._uid + '{fill:url(' + baseUrl + '#' + this._uid + '_SVGID_2_);}.svg-active-' + this._uid + '{fill:url(' + baseUrl + '#' + this._uid + '_SVGID_3_);}</style>' +

      this.getLinearGradient(this._uid + '_SVGID_1_', s.emptyColor, s.emptyColor, s.starShape) +
      this.getLinearGradient(this._uid + '_SVGID_2_', s.hoverColor, s.hoverColor, s.starShape) +
      this.getLinearGradient(this._uid + '_SVGID_3_', s.starGradient.start, s.starGradient.end, s.starShape) +
      this.getVectorPath(this._uid, {
        starShape: s.starShape,
        strokeWidth: s.strokeWidth,
        strokeColor: s.strokeColor
      } ) +
      '</svg></div>';

      // inject svg markup
      var starsMarkup = '';
      for( var i = 0; i < s.totalStars; i++){
        starsMarkup += star;
      }
      this.$el.append(starsMarkup);
      this.$stars = this.$el.find('.jq-star');
    },

    getVectorPath: function(id, attrs){
      return (attrs.starShape === 'rounded') ?
        this.getRoundedVectorPath(id, attrs) : this.getSpikeVectorPath(id, attrs);
    },

    getSpikeVectorPath: function(id, attrs){
      return '<polygon data-side="center" class="svg-empty-' + id + '" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 212.9,181.1 213.9,181 306.5,241 " style="fill: transparent; stroke: ' + attrs.strokeColor + ';" />' +
        '<polygon data-side="left" class="svg-empty-' + id + '" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 213.9,181.1 213.9,181 306.5,241 " style="stroke-opacity: 0;" />' +
          '<polygon data-side="right" class="svg-empty-' + id + '" points="364,55.7 255.5,46.8 214,-59 213.9,181 306.5,241 281.1,129.8 " style="stroke-opacity: 0;" />';
    },

    getRoundedVectorPath: function(id, attrs){
      var fullPoints = 'M520.9,336.5c-3.8-11.8-14.2-20.5-26.5-22.2l-140.9-20.5l-63-127.7 c-5.5-11.2-16.8-18.2-29.3-18.2c-12.5,0-23.8,7-29.3,18.2l-63,127.7L28,314.2C15.7,316,5.4,324.7,1.6,336.5S1,361.3,9.9,370 l102,99.4l-24,140.3c-2.1,12.3,2.9,24.6,13,32c5.7,4.2,12.4,6.2,19.2,6.2c5.2,0,10.5-1.2,15.2-3.8l126-66.3l126,66.2 c4.8,2.6,10,3.8,15.2,3.8c6.8,0,13.5-2.1,19.2-6.2c10.1-7.3,15.1-19.7,13-32l-24-140.3l102-99.4 C521.6,361.3,524.8,348.3,520.9,336.5z';

      return '<path data-side="center" class="svg-empty-' + id + '" d="' + fullPoints + '" style="stroke: ' + attrs.strokeColor + '; fill: transparent; " /><path data-side="right" class="svg-empty-' + id + '" d="' + fullPoints + '" style="stroke-opacity: 0;" /><path data-side="left" class="svg-empty-' + id + '" d="M121,648c-7.3,0-14.1-2.2-19.8-6.4c-10.4-7.6-15.6-20.3-13.4-33l24-139.9l-101.6-99 c-9.1-8.9-12.4-22.4-8.6-34.5c3.9-12.1,14.6-21.1,27.2-23l140.4-20.4L232,164.6c5.7-11.6,17.3-18.8,30.2-16.8c0.6,0,1,0.4,1,1 v430.1c0,0.4-0.2,0.7-0.5,0.9l-126,66.3C132,646.6,126.6,648,121,648z" style="stroke: ' + attrs.strokeColor + '; stroke-opacity: 0;" />';
    },

    getSvgDimensions: function(starShape){
      return (starShape === 'rounded') ? 'width="550px" height="500.2px" viewBox="0 146.8 550 500.2" style="enable-background:new 0 0 550 500.2;' : 'x="0px" y="0px" width="305px" height="305px" viewBox="60 -62 309 309" style="enable-background:new 64 -59 305 305;';
    },

    getLinearGradient: function(id, startColor, endColor, starShape){
      var height = (starShape === 'rounded') ? 500 : 250;
      return '<linearGradient id="' + id + '" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="' + height + '"><stop  offset="0" style="stop-color:' + startColor + '"/><stop  offset="1" style="stop-color:' + endColor + '"/> </linearGradient>';
    },

    executeCallback: function(rating, $el){
      var callback = this.settings.callback;
      callback(rating, $el);
    }

  };

  var publicMethods = {

    unload: function() {
      var _name = 'plugin_' + pluginName;
      var $el = $(this);
      var $starSet = $el.data(_name).$stars;
      $starSet.off();
      $el.removeData(_name).remove();
    },

    setRating: function(rating, round) {
      var _name = 'plugin_' + pluginName;
      var $el = $(this);
      var $plugin = $el.data(_name);
      if( rating > $plugin.settings.totalStars || rating < 0 ) { return; }
      if( round ){
        rating = Math.round(rating);
      }
      $plugin.applyRating(rating);
    },

    getRating: function() {
      var _name = 'plugin_' + pluginName;
      var $el = $(this);
      var $starSet = $el.data(_name);
      return $starSet._state.rating;
    },

    resize: function(newSize) {
      var _name = 'plugin_' + pluginName;
      var $el = $(this);
      var $starSet = $el.data(_name);
      var $stars = $starSet.$stars;

      if(newSize <= 1 || newSize > 200) {
        //console.log('star size out of bounds');
        return;
      }

      $stars = Array.prototype.slice.call($stars);
      $stars.forEach(function(star){
        $(star).css({
          'width': newSize + 'px',
          'height': newSize + 'px'
        });
      });
    },

    setReadOnly: function(flag) {
      var _name = 'plugin_' + pluginName;
      var $el = $(this);
      var $plugin = $el.data(_name);
      if(flag === true){
        $plugin.$stars.off('mouseover mouseout click');
      } else {
        $plugin.settings.readOnly = false;
        $plugin.addListeners();
      }
    }

  };


  // Avoid Plugin.prototype conflicts
  $.extend(Plugin.prototype, methods);

  $.fn[ pluginName ] = function ( options ) {

    // if options is a public method
    if( !$.isPlainObject(options) ){
      if( publicMethods.hasOwnProperty(options) ){
        return publicMethods[options].apply(this, Array.prototype.slice.call(arguments, 1));
      } else {
        $.error('Method '+ options +' does not exist on ' + pluginName + '.js');
      }
    }

    return this.each(function() {
      // preventing against multiple instantiations
      if ( !$.data( this, 'plugin_' + pluginName ) ) {
        $.data( this, 'plugin_' + pluginName, new Plugin( this, options ) );
      }
    });
  };

})( jQuery, window, document );


//new start
//new start
$(".overall").starRating({
  starSize: 20,
  callback: function(currentRating, $el){
	  $('#overall').val(currentRating);
        
    }
});
$(".punctuality").starRating({
  starSize: 20,
  callback: function(currentRating, $el){
      $('#punctuality').val(currentRating);
    }
});
$(".knowledge").starRating({
  starSize: 20,
  callback: function(currentRating, $el){
       $('#knowledge').val(currentRating);
    }
});
$(".staff").starRating({
  starSize: 20,
  callback: function(currentRating, $el){
       $('#staff').val(currentRating);
    }
});
/* Javascript */
 
   
//Tootl tips
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
        /****popover and carousel ***/		
		$('[data-toggle="popover"]').popover(); 
		$('#mywelcomeCarousel').carousel({
		interval:3000
		})
		
    for (i = new Date().getFullYear(); i > 1916; i--)
   {
    $('#year').append($('<option />').val(i).html(i));
   }
  });
/****submit contact form ***/
function SubmitFormcontact(){

	 var pdv=jQuery('#cemail').val();
if(pdv == '') {
 			 jQuery(".cemail .alert.alert-info").show();
			 jQuery(".cemail .alert.alert-info").slideDown('slow');
            jQuery('.cemail .alert.alert-info').text('Email is required');
}else{
    if (!ValidateEmail(pdv)) {    
          
            if(pdv.length < 6) {
				 jQuery(".cemail .alert.alert-info").show();
            jQuery('.cemail .alert.alert-info').text('Too short. Use at least 6 characters');

            return false;
          }else{
             jQuery(".cemail .alert.alert-info").show();
            jQuery(".cemail .alert.alert-info").text("Please enter a valid email address");
          }  
    
          
        }else{          
          
          jQuery(".cemail .alert.alert-info").hide();
           jQuery(".cemail .alert.alert-info").text("");
        }
}
if(jQuery("#phone").val()==''){    
         jQuery(".phone .alert.alert-info").show();   
		 jQuery(".phone .alert.alert-info").slideDown('slow');  
         jQuery(".phone .alert.alert-info").text("Phone Number is required");
       }else{
		 jQuery(".phone .alert.alert-info").hide();     
         jQuery(".phone .alert.alert-info").text("");
	   }
	   if(jQuery("#message_area").val()==''){    
         jQuery(".message_area .alert.alert-info").show();   
		 jQuery(".message_area .alert.alert-info").slideDown('slow');  
         jQuery(".message_area .alert.alert-info").text("Message is required");
       }else{
		 jQuery(".message_area .alert.alert-info").hide();     
         jQuery(".message_area .alert.alert-info").text("");
	   }
	    if(jQuery("#fname").val()==''){    
         jQuery(".fname .alert.alert-info").show();   
		 jQuery(".fname .alert.alert-info").slideDown('slow');  
         jQuery(".fname .alert.alert-info").text("Full Name is required");
       }else{
		 jQuery(".fname .alert.alert-info").hide();     
         jQuery(".fname .alert.alert-info").text("");
	   }
	   var errorss= jQuery('.alert.alert-info').text();
       if(errorss==''){
	    $("form#contactform").submit(); 
       }
}
/****text validation ***/
function textonly(s)
      {
      var fid=s.id;
     
      var sd = jQuery('#'+fid).attr('placeholder'); 
      var errs=jQuery("."+fid+" .alert.alert-info").text();
      var fieldvalue=s.value;      
      var letters = /^[A-Za-z\s]+$/;
      if(fieldvalue!='') {                     
      if(fieldvalue.match(letters)){
		  jQuery("."+fid+" .alert.alert-info").hide();
      jQuery("."+fid+" .alert.alert-info").text('');    
      return true;
      } else
      { 
     // if(errs == ''){
		 jQuery("."+fid+" .alert.alert-info").show();
       jQuery("."+fid+" .alert.alert-info").text("No special characters or numbers");    
      return false;  

       // }      
      }
    }else{
		jQuery("."+fid+" .alert.alert-info").show();
        jQuery("."+fid+" .alert.alert-info").text(sd+" is required");  
    }
    }
	
	/*****enter number only ***/
	function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;		
    }
    return true;
}

/*****email validation ****/
jQuery('#cemail').blur(function() {
   var pdv=jQuery('#cemail').val();
if(pdv == '') {
 			 jQuery(".cemail .alert.alert-info").show();
            jQuery('.cemail .alert.alert-info').text('Email is required');
}else{
    if (!ValidateEmail(pdv)) {    
          
            if(pdv.length < 6) {
				 jQuery(".cemail .alert.alert-info").show();
            jQuery('.cemail .alert.alert-info').text('Too short. Use at least 6 characters');

            return false;
          }else{
             jQuery(".cemail .alert.alert-info").show();
            jQuery(".cemail .alert.alert-info").text("Please enter a valid email address");
          }  
    
          
        }else{
          
          
          jQuery(".cemail .alert.alert-info").hide();
           jQuery(".cemail .alert.alert-info").text("");
        }
}
      });
	  
