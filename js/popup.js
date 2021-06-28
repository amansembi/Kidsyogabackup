$(document).ready(function(){
	$('.cancel_user_id_value').click(function(){
		$('.cancle_the_user').prop('disabled', false);
		$('.confirm_msg').text('Are you sure to Cancel the user.');
		var userId = $(this).attr('userid');
		var cancelUser = $(this).attr('cancelUser');
		//alert(cancelUser);
		if(cancelUser == 'canceled'){
			$('.confirm_msg').text('User is Alredy Canceled');
			$('.cancle_the_user').prop('disabled', true);
		}
		
		$('#userid_in_popup').val(userId);
	});
	$('.cancle_the_user').click(function(){
		
		var childUrl = $('.childUrl').val();
		var userId = $('#userid_in_popup').val();
		var controllerPath = childUrl+'/ajaxController.php';
		$.ajax({
          type:"post",
          url:controllerPath,
          data:{type:'cancel_user',userId:userId},
          success:function(res){
			 if(res){
				$('.cancel_user_responding').html('<small style="color:green">User cancel successfully</small>'); 
			 }
            console.log(res);
          }
        });
	});
	
});