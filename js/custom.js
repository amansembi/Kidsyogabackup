jQuery(document).ready(function($){	
	
	// Sticky header
	$(document).scroll(function() {    
	    var scroll = $(window).scrollTop();
	    if (scroll >= 100) {
	        $(".mainhead").addClass("stckyhead");
	    } else {
	        $(".mainhead").removeClass("stckyhead");
	    }
	});


	
	// Experts slider
	$('.experts').slick({		
  		dots: false,
		arrows: true,
  		infinite: true,
  		speed: 300,
  		slidesToShow: 4,
  		slidesToScroll: 4,
		prevArrow: '.prevbtn',
    	nextArrow: '.nextbtn',
  		responsive: [
    		{
      			breakpoint: 1024,
      			settings: {
        			slidesToShow: 3,
        			slidesToScroll: 3,
        			infinite: true,
        			dots: true
      			}
    		},
    		{
      			breakpoint: 600,
      			settings: {
        			slidesToShow: 2,
        			slidesToScroll: 2
      			}
    		},
    		{
      			breakpoint: 480,
      			settings: {
        			slidesToShow: 1,
        			slidesToScroll: 1
      			}
    		}    
  		]
	});	
	
	// Gift cards slider
	$('.giftsldr').slick({		
  		dots: false,
		arrows: true,
  		infinite: true,
  		speed: 300,
  		slidesToShow: 3,
  		slidesToScroll: 2,
      prevArrow:'.prevbtn',
      nextArrow:'.nextbtn',
  		responsive: [
    		{
      			breakpoint: 1024,
      			settings: {
        			slidesToShow: 3,
        			slidesToScroll: 3,
        			infinite: true,
        			dots: true
      			}
    		},
    		{
      			breakpoint: 600,
      			settings: {
        			slidesToShow: 2,
        			slidesToScroll: 2
      			}
    		},
    		{
      			breakpoint: 480,
      			settings: {
        			slidesToShow: 1,
        			slidesToScroll: 1
      			}
    		}    
  		]
	});



  $('.giftboxitem').click(function(){
     $('.giftboxitem').removeClass('activeCard');
      $(this).addClass('activeCard');

   });

  $('input[type=radio][name=carAmount]').change(function() {
     var cart_status = $('input[name="carAmount"]:checked').val();
      var cartId = $('.activeCard').find('.cartId').val();
      var cardcode = $('.activeCard').find('.cardcode').val();
	  //alert(cartId);
      if(cartId){
         $('.getCardDetails').removeClass('disabledcmn'); 
      }
  });
 
 $('.card_mnth').bind('keyup','keydown', function(event) {
    var inputLength = event.target.value.length;
    if(inputLength === 2){
      var thisVal = event.target.value;
      thisVal += '/';
      $(event.target).val(thisVal);
    }
  });


  $('.getCardDetails ').click(function(){
     var cartId = $('.activeCard').find('.cartId').val();
     var cardcode = $('.activeCard').find('.cardcode').val();
	 //alert(cartId);
     var cart_Amount = $('input[name="carAmount"]:checked').val();
     var expirStatus = $('input[name="carAmount"]:checked').attr('for');
     var imgUrl = $('.activeCard').find('img').attr('src');
     $('.giftselectbox').find('img').attr('src',imgUrl);
     setTimeout(function(){ 
       $('.expirStatus').val(expirStatus);
       $('.popCartID').val(cartId);
       $('.popCartCode').val(cardcode);
       $('.popCartAmount').val(cart_Amount);
	   if(expirStatus == 'yearly'){
		   var realprice = 'Go to checkout  $'+cart_Amount+'/Year';
	   }else if(expirStatus == 'monthly'){
		  var realprice = 'Go to checkout  $'+cart_Amount+'/Month'; 
	   }
	   
       $('#gotoCheckout').val(realprice);

     }, 1000);
  });


$('#gotoCheckout').click(function(){
   var current_userID =  $('.current_userID').val();
   var popCartID =  $('.popCartID').val();
   var popCartCode =  $('.popCartCode').val();
   var popCartAmount = $('.popCartAmount').val();
   var to_name = $('.to_name').val();
   var pop_msg = $('.pop_msg').val();
   var to_email = $('.to_email').val();
   var from_name = $('.from_name').val();
   var from_email = $('.from_email').val();
   var childUrl = $('.childUrl').val();
   var expirStatus = $('.expirStatus').val();
   var controllerPath = childUrl+'/ajaxController.php';
   var url = $('.checkoutUrl').val();
   var giftselectitem = $('.giftselectitem').parent().html();
   console.log(giftselectitem);
   
    $.ajax({
          type:"post",
          url:controllerPath,
          data:{type:'purchaseCartDetails',expirStatus:expirStatus,user_id:current_userID,popCartID:popCartID,popCartAmount:popCartAmount,to_name:to_name,to_email:to_email,pop_msg:pop_msg,from_name:from_name,from_email:from_email,giftselectitem:giftselectitem,popCartCode:popCartCode},
          success:function(res){
            console.log(res);
            window.location = url;
          }
        });

});


	// Gift popup box
	$('.giftform .btnpink').click(function(){
		$('body').addClass('showgiftpop');
		$('.giftpop').addClass('d-flex');
	});
	$('.giftpopcls').click(function(){
		$('body').removeClass('showgiftpop');
		$('.giftpop').removeClass('d-flex');
	});
	
	
	$('.giftpopltcol .to_name').bind('keyup', function() {
		var to_name = $(this).val();  
		$('.giftselectinfo .giftinfotxt1 h5').text(to_name);
	});
	$('.giftpopltcol .pop_msg').bind('keyup', function() {   
		var pop_msg = $(this).val();	
		$('.giftselectinfo .giftinfotxt2 h5').text(pop_msg);
	});
	$('.giftpopltcol .from_name').bind('keyup', function() {   
		var from = $(this).val();	
		$('.giftselectitem .from').text(from);
	});
	//Single classs video banner duration
	//  var vid = document.getElementById("video-active");
 //     var s = vid.duration;
	//  var m = Math.floor(s / 60);
	// 	m = (m >= 10) ? m : "0" + m;
	// 	s = Math.floor(s % 60);
	// 	s = (s >= 10) ? s : "0" + s;
	//  var Duration = m + ":" + s;
	// $('body .durationval').text(Duration);





});