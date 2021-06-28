<?php
	require_once("../../../wp-load.php");
	require_once('stripe/vendor/autoload.php');
	//require_once('wp-config.php');
    session_start();
	global $wpdb; 
	global $current_user;
	   if($_POST['type'] == 'purchaseCartDetails'){
			$user_id = $_POST['user_id'];
			$popCartID = $_POST['popCartID'];
			$popCartCode = $_POST['popCartCode'];
			$popCartAmount = $_POST['popCartAmount'];
			$to_name = $_POST['to_name'];
			$to_email = $_POST['to_email'];
			$pop_msg = $_POST['pop_msg'];
			$from_name = $_POST['from_name'];
			$from_email = $_POST['from_email'];
			$payStatus = 'pending';
			$expireStatus = $_POST['expirStatus'];
			$giftselectitem = $_POST['giftselectitem'];

			$success = $wpdb->insert("wp_user_cards", array(					   
				"user_id" => $user_id,
				"card_id" => $popCartID,
				"card_code" => $popCartCode,
				"cost" => $popCartAmount,
				"to_email" => $to_email,
				"to_name" => $to_name,
				"message" => $pop_msg,
				"from_name" => $from_name,
				"from_email" => $from_email,
				"payment_status" => $payStatus,
				"cart_expr_status" => $expireStatus
			));

			if($success){
				$lastid = $wpdb->insert_id;
				$_SESSION["lastid"] = $lastid;
				$_SESSION["type"] = 'Gift_Card';
				$_SESSION["amount"] = $popCartAmount;
				$_SESSION["user_id"] = $user_id;
				$_SESSION["card_id"] = $popCartID;
				$_SESSION["to_email"] = $_POST['to_email'];
				$_SESSION["giftselectitem"] = $_POST['giftselectitem'];
			}


		}elseif($_POST['type'] == 'Buy_Card') {
		   $cart_num = $_POST['cart_num'];
		   $card_mnth = explode('/', $_POST['card_mnth']);
		   $card_cvv = $_POST['card_cvv'];
		   $card_name = $_POST['card_name'];
		   $card_adrs = $_POST['card_adrs'];
		   $card_city = $_POST['card_city'];
		   $card_state = $_POST['card_state'];
		   $card_zip = $_POST['card_zip'];
		   $card_state = $_POST['card_state'];
		   $card_country = $_POST['card_country'];
		   $user_id = $_POST['user_id'];
		   $cart_id = $_POST['cart_id'];
		   $last_inserted_id = $_POST['lastid'];
		   $amount = $_POST['amount'];
		   $to_email = $_POST['to_email'];
		   $giftselectitem = $_SESSION["giftselectitem"];
           $year = date("Y"); 
		   //$newStr = str_replace('\"', '', $str);
		$giftselectitem = str_replace('\"', '', $giftselectitem);
            $current_userID = $current_user->data->ID;
		    $stripeSecret = 'sk_test_4RI3HShlrBN4M1gPdhWEb6mz00KWc37fHW';
            $payDetails = \Stripe\Stripe::setApiKey($stripeSecret);
            $stripe = new \Stripe\StripeClient('sk_test_4RI3HShlrBN4M1gPdhWEb6mz00KWc37fHW');
	        $token = $stripe->tokens->create([
	          'card' => [
	            'number' => $cart_num,
	            'exp_month' => $card_mnth[0],
	            'exp_year' => $card_mnth[1],
	            'cvc' => $card_cvv,
	          ],
	        ]);

	        $stripeToken  = $token->id;
		        $charge = \Stripe\Charge::create(array(
		        "amount" => $amount * 100,
		        "currency" => "usd",
		        "description" => "Gift Card",
		        "source" => $stripeToken,
		    ));
			//print_r($giftselectitem);
		   $paymenyResponse = $charge->jsonSerialize(); 
			     if($paymenyResponse['amount_refunded'] == 0 && empty($paymenyResponse['failure_code']) && $paymenyResponse['paid'] == 1 && $paymenyResponse['captured'] == 1){  
			           
			           $cartDetails = array('id' => $last_inserted_id,'user_id' => $user_id,'cart_id' => $cart_id, 'amount' =>$amount,'cart_num' =>$cart_num,'card_mnth' => $card_mnth, 'card_cvv' => $card_cvv, 'card_name' =>$card_name, 'card_adrs'=> $card_adrs,'card_city' =>$card_city, 'card_state' =>$card_state, 'card_country' =>$card_country);  

                      $data = json_encode($cartDetails);  
			          $wpdb->update( 'wp_user_cards', array('payment_status' => 'Done', 'payment_details' => $data), array('id' => $last_inserted_id));

						$body = $giftselectitem;
						$to = $to_email;
						$subject = 'Gift card Sending';
				        $from = 'wordpress@kidsyoga.securework.co';
						$headers = array('Content-Type: text/html; charset=UTF-8\r\n','From: '. $from . "\r\n" . 'Reply-To: ' . $from . "\r\n");
						//$headers .= 'From: '. $from . "\r\n" . 'Reply-To: ' . $from . "\r\n";
						$sent = wp_mail($to, $subject,$body, $headers); 
			     }else{
			        echo "Somthing Wrong";
			     }
	   }elseif($_POST['type'] == 'BuyPlan') {
		   $subscribe_type = $_POST['subscribe_type'];
		   
			$monthpriceID =  MONTH_PRODUCT;
			$yearpriceID = YEAR_PRODUCT;
			if($subscribe_type == 'monthly'){
			   $priceID = $monthpriceID; 
			   }elseif($subscribe_type == 'yearly'){
				   $priceID = $yearpriceID;
				}else{
					$priceID = 0;
				}
		  
	   	   $cart_num = $_POST['cart_num'];
		   $card_mnth = explode('/', $_POST['card_mnth']);
		   $card_cvv = $_POST['card_cvv'];
		   $card_name = $_POST['card_name'];
		   $card_adrs = $_POST['card_adrs'];
		   $card_city = $_POST['card_city'];
		   $card_state = $_POST['card_state'];
		   $card_zip = $_POST['card_zip'];
		   //$card_state = $_POST['card_state'];
		   $card_country = $_POST['card_country'];
		   $user_id = $_POST['user_id'];
		   $cart_id = $_POST['cart_id'];
		   $amount = $_POST['amount'];
           $year = date("Y"); 
           $current_userID = $current_user->data->ID;
           
		   
			  $stripeSecret = 'sk_test_4RI3HShlrBN4M1gPdhWEb6mz00KWc37fHW';
				$payDetails = \Stripe\Stripe::setApiKey($stripeSecret);
				$stripe = new \Stripe\StripeClient('sk_test_4RI3HShlrBN4M1gPdhWEb6mz00KWc37fHW');
				$token = $stripe->tokens->create([
				  'card' => [
					'number' => $cart_num,
					'exp_month' => $card_mnth[0],
					'exp_year' => $card_mnth[1],
					'cvc' => '',
				  ],
				]);
			
				$stripeToken  = $token->id;
				$description = get_user_meta($current_user->data->ID,'description',true);

				$customer = \Stripe\Customer::create(array(
								'name' => $current_user->data->display_name,
								'description' => $description,
								'email' => $current_user->data->user_email,
								'source' => $token->id,
								"address" => ["city" => $card_city, "country" => $card_country, "line1" => $card_adrs, "line2" => "", "postal_code" => $card_zip, "state" => $card_state]
				));
				
				

				$subscriptions = \Stripe\Subscription::create([
				  'customer' => $customer->id,
				  'items' => [
					['price' => $priceID],
				  ],
				  'trial_period_days' => 14
				]);
		        
				//print_r($subscriptions);
				
			
			if(!empty($subscriptions)){
					$card_type = $customer->sources->data[0]->brand;
					$exp_month = $customer->sources->data[0]->exp_month;
					$exp_year = $customer->sources->data[0]->exp_year;
					$last4 = $customer->sources->data[0]->last4;
					$gateway = $customer->id;
					$subscriptionsID = $subscriptions->id;
					$customerID = $subscriptions->customer;
					$status ='Active';
					$trial_start_num = $subscriptions->trial_start;
					$trial_end_num = $subscriptions->trial_end;
					$subscriptions_status = $subscriptions->status;
					$plan_id = $subscriptions->items->data[0]->plan->id;
					$subscription_amount = $subscriptions->plan->amount;
					
					
					$trial_start = date("Y-m-d H:i:s", $trial_start_num);
					$trial_end = date("Y-m-d H:i:s", $trial_end_num);
					
					
					
					 
					$success_card_details = $wpdb->insert("wp_card_details", array(					   
					   "user_id" => $current_userID,
					   "customer_id" => $customerID,
					   "gateway" => $gateway,
					   "card_brand" => $card_type,
					   "card_last_four"=> $last4,
					   "card_expiry_month"=> $exp_month,
					   "card_expiry_year"=> $exp_year,
					   "status"=> 'Active',
					   					   
				     ));
					 
					 $success_user_subscriptions = $wpdb->insert("wp_user_subscriptions", array(					   
					   "user_id" => $current_userID,
					   "subscription_id" => $subscriptionsID,
					   "customer_id" => $customerID,
					   "trail_ends_at"=> $trial_end,
					   "subscription_status"=> $subscriptions_status,
					   "plan_id"=> $plan_id,
					   "subscription_amount"=> $subscription_amount/100,
					   "status"=> 'Active',					   
				     ));
					
					 //print_r($trial_end);
					 if(!empty($success_user_subscriptions)){
							echo "true";
						}else{
							echo "false";
						}
			}	
		     
		  }elseif($_POST['type'] == 'AddSubuser') {
			  
	   	  	ob_start();
			//$userallkids = array();
	   	  $userID = $_POST['userID'];
	   	  $username = $_POST['username']; 
	   	  $kidsname = $_POST['kidsname']; 
		 $userallkids = get_user_meta($userID,'kids_'.$userID,true);
		 $kidscount = count($userallkids);
		 if($kidscount != 3){
			if(!is_array($userallkids) || $userallkids == ''){
						$userallkids = array();	
			}
					if(!in_array($kidsname,$userallkids)){
						$userallkids[$kidsname] = $kidsname;
							$_SESSION["kidsName"] = $kidsname;
			update_user_meta($userID,'kids_'.$userID,$userallkids);
			update_user_meta($userID, 'kids_count', $kidscount );
				echo "done";
					}else{
						echo "nameexist";
					}
					$kidscount = $kidscount + 1;
		  
		 }else{
			 echo "kidslengthcomplete";
		 }   
	}elseif($_POST['type'] == 'AddkidsProfileImage') {
		$kidID = $_POST['kidID'];
		$imageSrc = $_POST['imageSrc'];
		update_user_meta($kidID, 'kidsProfile', $imageSrc);


	}elseif($_POST['type'] == 'emailIDgenrater') {
		if($_POST['parent_user_id']){
		   $_SESSION["update_parent_user_id"] = $_POST['parent_user_id'];  
		}
	}elseif ($_POST['type'] == 'passwordIDgenrater') {
		echo"hsdjkbfkjsdfbjksdf";
		
	}elseif ($_POST['type'] == 'planIDgenrater') {
		
	}elseif($_POST['type'] == 'usernamedIDgenrater') {
		
	}elseif($_POST['type'] == 'change_mail') {
		 global $current_user;  
            $parent_user_id = $_POST['parent_user_id'];
            $new_email = $_POST['new_email'];
			$user = get_user_by('id',$parent_user_id );
            $reset_key = get_password_reset_key( $user );
			$exists = email_exists($new_email);
            $encodeString = convert_uuencode($new_email);			
			update_user_meta($parent_user_id,'email_reset_key',$reset_key);
			update_user_meta($parent_user_id,'change_email_request',$new_email);
			
            $body .=" <a href='".site_url()."/changes-confirmation/?key=". $reset_key."&id=".$parent_user_id."&path=".$encodeString."'>Click here to reset your password</a>";
              
            $to = $new_email;
			$subject = 'Chnage Mail Request';

       		$from = 'wordpress@kidsyoga.securework.co';
			$headers = array('Content-Type: text/html; charset=UTF-8\r\n','From: '. $from . "\r\n" . 'Reply-To: ' . $from . "\r\n");
			$sent = wp_mail($to, $subject,$body, $headers); 
			
			echo $sent;
	}elseif($_POST['type'] == 'updatePaymentMethod') {
			global $current_user;
			global $wpdb; 
			$current_userID = $current_user->data->ID;
			//print_r($_POST['carddate']);
			$ExpDatMonth = explode("/", $_POST['carddate']);
			$card_last_digit =  str_pad(substr($_POST['cardnumber'], -4), strlen($_POST['cardnumber']), '*', STR_PAD_LEFT);
			$result = $wpdb->update( 
				'wp_card_details', 
				array( 					
					'card_last_four' => $card_last_digit,   
					'card_expiry_month' => $ExpDatMonth[0],   
					'card_expiry_year' => $ExpDatMonth[1],   
					'card_name' =>$_POST['nameoncard'],   
					'status' => 'Active',   
					  
				), 
				array( 'user_id' => $current_userID )
			);
			print_r($result);
			// $current_userID = $current_user->data->ID;
			 // $plan_details = $wpdb->get_results("SELECT * FROM wp_card_details WHERE user_id = '$current_userID'");
			 // $userDetails = $plan_details[0]->plan_details;
			 // $paymentDetails = json_decode($userDetails);
			// $cardnumber = $_POST['cardnumber'];
			// $carddate = $_POST['carddate'];
			// $cardcvc =  $_POST['cardcvc'];
			// $nameoncard = $_POST['nameoncard'];         
			// $cartDetails = array('amount' => $paymentDetails->amount,'cart_num' => $cardnumber, 'card_mnth'=>$carddate, 'card_cvv'=>$cardcvc, 'nameoncard'=> $nameoncard);
           // $data = json_encode($cartDetails);  
			    // $response = $wpdb->update('wp_user_plan_details',array('plan_details' => $data), array('user_id' => $current_userID));	
	}
	elseif($_POST['type'] == 'cancellation') {
		 global $wpdb;		 
		 $userID = $_POST['user_id'];
		$plan_details = $wpdb->get_results("SELECT * FROM wp_user_plan_details WHERE user_id = '$userID'");
		$payment_method = $plan_details[0]->payment_method;		
		$stripeSecret = 'sk_test_4RI3HShlrBN4M1gPdhWEb6mz00KWc37fHW';
            $payDetails = \Stripe\Stripe::setApiKey($stripeSecret);
            $stripe = new \Stripe\StripeClient('sk_test_4RI3HShlrBN4M1gPdhWEb6mz00KWc37fHW');

			$re = \Stripe\Refund::create([
			  'ID' => 'ch_1Idv6UA5JkmCD4aieMNJfbAT',
			]);
			print_r($re);
			
	}elseif($_POST['type'] == 'particle') {
			global $wpdb; 
			
			$refund_amount = $_POST['refund_amount'];
			$customer_id_refund = $_POST['customer_id_refund'];
			 $returnID = $_POST['returnID'];			
		 $stripeSecret = 'sk_test_4RI3HShlrBN4M1gPdhWEb6mz00KWc37fHW';
            $payDetails = \Stripe\Stripe::setApiKey($stripeSecret);
            $stripe = new \Stripe\StripeClient('sk_test_4RI3HShlrBN4M1gPdhWEb6mz00KWc37fHW');

			
			$re = \Stripe\Refund::create([
				  'amount' => $refund_amount*100,
				  'charge' => $returnID,
				]);
				print_r($returnID);
	}elseif($_POST['type'] == 'full'){
			$returnID = $_POST['returnID'];			
			$stripeSecret = 'sk_test_4RI3HShlrBN4M1gPdhWEb6mz00KWc37fHW';
            $payDetails = \Stripe\Stripe::setApiKey($stripeSecret);
            $stripe = new \Stripe\StripeClient('sk_test_4RI3HShlrBN4M1gPdhWEb6mz00KWc37fHW');			
			$re = \Stripe\Refund::create([				  
				  'charge' => $returnID,
				]);
	print_r($re);
	 }
	elseif($_POST['type'] == 'cancel_user'){
		global $wpdb; 
		$user_id = $_POST['userId'];
		$plan_details = $wpdb->get_results("SELECT * FROM wp_user_subscriptions WHERE user_id = '$user_id'");
		$subscription_id = $plan_details[0]->subscription_id;
			$stripeSecret = 'sk_test_4RI3HShlrBN4M1gPdhWEb6mz00KWc37fHW';
            $payDetails = \Stripe\Stripe::setApiKey($stripeSecret);
            $stripe = new \Stripe\StripeClient('sk_test_4RI3HShlrBN4M1gPdhWEb6mz00KWc37fHW');
			print_r($subscription_id);
			if($subscription_id){				
				$cancel_subscriptions = $stripe->subscriptions->cancel(
				$subscription_id,
				[]
			);
			print_r($cancel_subscriptions);
			}
			
		
		}elseif($_POST['type'] == 'watchedvideoaddtree'){
			$finalWatched = array(); 
			$videoId = $_POST['videoId'];
			$current_user = get_current_user_id();
			$watchedVideoIds = get_user_meta($current_user,'watched_video',true);
			if(!is_array($watchedVideoIds) || $watchedVideoIds == ''){
				$watchedVideoIds = array();	
			}				
			if(!in_array($videoId,$watchedVideoIds)){
				$watchedVideoIds[$videoId] = $videoId;
				echo $videoId;
			}			
			update_user_meta($current_user,'watched_video',$watchedVideoIds);
		}elseif($_POST['type'] == 'change_subscription_plan') {
			
			global $wpdb; 
		   $subscribe_type = $_POST['subscribe_type'];
		   
			$monthpriceID =  MONTH_PRODUCT;
			$yearpriceID = YEAR_PRODUCT;
			if($subscribe_type == 'monthly'){
			   $priceID = $monthpriceID; 
			   }elseif($subscribe_type == 'yearly'){
				   $priceID = $yearpriceID;
				}else{
					$priceID = 0;
				}
		  
	   	   $cart_num = $_POST['cart_num'];
		   $card_mnth = explode('/', $_POST['card_mnth']);
		   $card_cvv = $_POST['card_cvv'];
		   $card_name = $_POST['card_name'];
		   $card_adrs = $_POST['card_adrs'];
		   $card_city = $_POST['card_city'];
		   $card_state = $_POST['card_state'];
		   $card_zip = $_POST['card_zip'];
		   $card_state = $_POST['card_state'];
		   $card_country = $_POST['card_country'];
		   $user_id = $_POST['user_id'];
		   $cart_id = $_POST['cart_id'];
		   $amount = $_POST['amount'];
           $year = date("Y"); 
           $current_userID = $current_user->data->ID;
           $plan_details = $wpdb->get_results("SELECT * FROM wp_user_subscriptions WHERE user_id = '$user_id'");
		$subscription_id = $plan_details[0]->subscription_id;
		   
			  $stripeSecret = 'sk_test_4RI3HShlrBN4M1gPdhWEb6mz00KWc37fHW';
				$payDetails = \Stripe\Stripe::setApiKey($stripeSecret);
				$stripe = new \Stripe\StripeClient('sk_test_4RI3HShlrBN4M1gPdhWEb6mz00KWc37fHW');
				// $token = $stripe->tokens->create([
				  // 'card' => [
					// 'number' => $cart_num,
					// 'exp_month' => $card_mnth[0],
					// 'exp_year' => $card_mnth[1],
					// 'cvc' => '',
				  // ],
				// ]);
			
				// $stripeToken  = $token->id;
				// $description = get_user_meta($current_user->data->ID,'description',true);

				// $customer = \Stripe\Customer::create(array(
								// 'name' => $current_user->data->display_name,
								// 'description' => $description,
								// 'email' => $current_user->data->user_email,
								// 'source' => $token->id,
								// "address" => ["city" => $card_city, "country" => $card_country, "line1" => $card_adrs, "line2" => "", "postal_code" => $card_zip, "state" => $card_state]
				// ));
				
				

				// $subscriptions = \Stripe\Subscription::create([
				  // 'customer' => $customer->id,
				  // 'items' => [
					// ['price' => $priceID],
				  // ],
				  // 'trial_period_days' => 14
				// ]);
				
				
				$subscription = \Stripe\Subscription::retrieve($subscription_id);
					$subscriptionUpdate = \Stripe\Subscription::update($subscription_id, [
					  'cancel_at_period_end' => false,
					  'proration_behavior' => 'create_prorations',
					  'items' => [
						[
						  'id' => $subscription->items->data[0]->id,
						  'price' => $priceID,
						],
					  ],
					]);
		        
				//print_r($subscriptionUpdate);
				if(!empty($subscriptionUpdate)){
					echo "true";
				}else{
					echo "false";
				}
			
			if(!empty($subscriptions)){
					$card_type = $customer->sources->data[0]->brand;
					$exp_month = $customer->sources->data[0]->exp_month;
					$exp_year = $customer->sources->data[0]->exp_year;
					$last4 = $customer->sources->data[0]->last4;
					$gateway = $customer->id;
					$subscriptionsID = $subscriptions->id;
					$customerID = $subscriptions->customer;
					$status ='Active';
					$trial_start_num = $subscriptions->trial_start;
					$trial_end_num = $subscriptions->trial_end;
					$subscriptions_status = $subscriptions->status;
					$plan_id = $subscriptions->items->data[0]->plan->id;
					$subscription_amount = $subscriptions->plan->amount;
					
					
					$trial_start = date("Y-m-d H:i:s", $trial_start_num);
					$trial_end = date("Y-m-d H:i:s", $trial_end_num);
					
					
					
					 
					// $success_card_details = $wpdb->insert("wp_card_details", array(					   
					   // "user_id" => $current_userID,
					   // "customer_id" => $customerID,
					   // "gateway" => $gateway,
					   // "card_brand" => $card_type,
					   // "card_last_four"=> $last4,
					   // "card_expiry_month"=> $exp_month,
					   // "card_expiry_year"=> $exp_year,
					   // "status"=> 'Active',
					   					   
				     // ));
					 
					 // $success_user_subscriptions = $wpdb->insert("wp_user_subscriptions", array(					   
					   // "user_id" => $current_userID,
					   // "subscription_id" => $subscriptionsID,
					   // "customer_id" => $customerID,
					   // "trail_ends_at"=> $trial_end,
					   // "subscription_status"=> $subscriptions_status,
					   // "plan_id"=> $plan_id,
					   // "subscription_amount"=> $subscription_amount/100,
					   // "status"=> 'Active',					   
				     // ));
					
					 //print_r($trial_end);
					 // if(!empty($success_user_subscriptions)){
							// echo "true";
						// }else{
							// echo "false";
						// }
			}	
		     
		  }elseif($_POST['type'] == 'filter_class') {
			  
			  $matchCondition = array();
			  $count = 0;
			 global $ajduration, $ajage, $ajtype;			  
			  function getVimeoStats($id) {
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, "http://vimeo.com/api/v2/video/$id.php");
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($ch, CURLOPT_TIMEOUT, 30);
						$output = unserialize(curl_exec($ch));
						$output = $output[0];
						curl_close($ch);
						return $output;
					}
			  $filterValues = $_POST['filterparams'];			
			  $ajaxArraycount = array_count_values($filterValues);			  
			  foreach($filterValues as $filterValue){				  
				  if($filterValue['duration']){
					  $count = $count + 1;
				  }
				  if($filterValue['age']){
					  $count = $count + 1;
				  }
				  if($filterValue['type']){
					  $count = $count + 1;
				  }
				  if($filterValue['duration']){
				  $ajax_duration = $filterValue['duration'];
				  $ajaxDuration = explode("-",$ajax_duration);
				 // print_r($ajaxDuration);
				  }
				  
				  if($filterValue['age']){
				  $ajax_age = $filterValue['age'];
				  $ajaxAge = explode("-",$ajax_age);				 
				   }
				   
				  if($filterValue['type']){
				  $ajax_type = $filterValue['type'];
				   }
				  
			  }
			  
			  $args = array( 'post_type' => 'classes', 'posts_per_page' => -1 );
					$the_query = new WP_Query( $args );	
					if ( $the_query->have_posts() ) :
					while ( $the_query->have_posts() ) : $the_query->the_post(); 
						
						$exploreimg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' ); 
						$post_id = get_the_ID();
						$video_id = get_post_meta( get_the_ID(), 'vimeo_videos_id', true );
						$vemeo_vid = get_post_meta($video_id, 'dgv_response', true );
						$vd_id = preg_replace( '/\D/', '', html_entity_decode($vemeo_vid) );
						$videoType = get_option( 'dgv_response_type_'.$vd_id );
						
						
						$term = get_term_by('slug', $videoType, 'classes_category'); 
						$className = trim($term->name);
						
						$VimeoStats = getVimeoStats($vd_id);
						
						$duration = $VimeoStats['duration'];
						$age = get_post_meta( $post_id, 'age_', true );
						 $Age = explode("-",$age);
						$type = get_post_meta( $post_id, 'type', true );
						
						
				  $ajduration = $filterValues[0]['duration'];
				  $ajage = $filterValues[1]['age'];
				  $ajtype = $filterValues[2]['type'];
				  
				 
				 
	switch ($count) {
		case 1: 
			
						if($ajage){
							
							if((int)$Age[0] >= (int)$ajaxAge[0] && (int)$Age[1] <= (int)$ajaxAge[1])
							{
								array_push($matchCondition,$post_id);
								
							}
							
						}elseif($ajduration){
							if($duration >= (int)$ajaxDuration[0] && $duration <= (int)$ajaxDuration[1])
							{
								array_push($matchCondition,$post_id);
								
							}
							
						}elseif($ajtype){
							if($className == $ajax_type)
							{
								array_push($matchCondition,$post_id);
								
							}
							
						}
		break;
		case 2:
		
						if($ajage && $ajduration){
							if((int)$Age[0] >= (int)$ajaxAge[0] && (int)$Age[1] <= (int)$ajaxAge[1] && $duration >= (int)$ajaxDuration[0] && $duration <= (int)$ajaxDuration[1]){
								array_push($matchCondition,$post_id);
							
							}
							
							
						}elseif($ajduration && $ajtype){
							if($duration >= (int)$ajaxDuration[0] && $duration <= (int)$ajaxDuration[1] && $className == $ajax_type){
								array_push($matchCondition,$post_id);
							
							}
	
							
						}elseif($ajage && $ajtype){							
							
							if((int)$Age[0] >= (int)$ajaxAge[0] && (int)$Age[1] <= (int)$ajaxAge[1] && $className == $ajax_type){
								array_push($matchCondition,$post_id);
											
							}
		
							
						}
		break;
		case 3:				
				if($ajduration && $ajage && $ajtype){					
				 if((int)$Age[0] >= (int)$ajaxAge[0] && (int)$Age[1] <= (int)$ajaxAge[1] && (int)$duration >= (int)$ajaxDuration[0] && (int)$duration <= (int)$ajaxDuration[1] && $className == $ajax_type){
								 array_push($matchCondition,$post_id);								
							}
						}						
		break;		
		default:
		echo "Nothing";
	}		
						if(in_array($post_id, $matchCondition)){
						?>
						
						<div class="col-md-3">
						<div class="classbox">
							<div class="classimg bgtopcentr" style="background-image: url('<?php echo $exploreimg[0]; ?>')">
								<span><?php echo $className; ?></span>
							</div>
							<div class="classtitle">
								<h5><?php the_field('sub_title');?></h5>					
							</div>
							<div class="classmeta">
								<ul class="d-flex">
									<li class="d-flex align-items-center"><i class="fa fa-eye"></i> <?php echo $plays; ?></li>									
								</ul>						
							</div>
							<div class="classsubtitle">
								<h5><?php the_title();?></h5>
							</div>
							<div class="classsdesc">
								<?php echo wp_trim_words( get_the_content(), 30, '[...]' ); ?> <a class="morelink" href="<?php the_permalink();?>">Read more</a>
							</div>	
						</div>                                                          
					</div>
						
						
						<?php
						
						}
						 endwhile;
						  endif;
			 
			 
		  }

?>


