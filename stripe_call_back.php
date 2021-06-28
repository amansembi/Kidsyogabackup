<?php

	
	
/* Template Name: Stripe Call Back */
get_header();


global $wpdb; 

session_start();
$input = @file_get_contents("php://input");

//file_put_contents("test.txt", print_r($_REQUEST,true));



$event_json = json_decode($input,true);
$customerID = $event_json['data']['object']['id'];
			 
					 
	switch ($event_json['type']) {
		case "customer.updated":
		
			$customerID = $event_json['data']['object']['id'];		
			$card_type = $event_json['data']['object']['sources']['data'][0]['brand'];
			$exp_month = $event_json['data']['object']['sources']['data'][0]['exp_month'];
			$exp_year = $event_json['data']['object']['sources']['data'][0]['exp_year'];
			$last4 = $event_json['data']['object']['sources']['data'][0]['last4'];
			$gateway = $event_json['data']['object']['sources']['url'];
					
		$path = __DIR__.'/../../uploads/transaction_logs/customer_updated.log';
			$myfile = fopen($path, "w") or die("Unable to open file!");
			fwrite($myfile, print_r($event_json,true));
		break;
		
		
		case "customer.deleted":
	   $path = __DIR__.'/../../uploads/transaction_logs/customer_deleted.log';
			$myfile = fopen($path, "w") or die("Unable to open file!");
			fwrite($myfile, print_r($event_json,true));
		break;
		
		
		case "customer.created":
		$arrayData1 = array();
						
			$customerID = $event_json['data']['object']['id'];		
			$card_type = $event_json['data']['object']['sources']['data'][0]['brand'];
			$exp_month = $event_json['data']['object']['sources']['data'][0]['exp_month'];
			$exp_year = $event_json['data']['object']['sources']['data'][0]['exp_year'];
			$last4 = $event_json['data']['object']['sources']['data'][0]['last4'];
			$gateway = 'Stripe';
			
			$wpdb->update( 
				'wp_card_details', 
				array( 
					'user_id' => $user_id,  
					'customer_id' => $customerID,  
					'gateway' => $gateway,  
					'card_brand' => $card_type,   
					'card_last_four' => $last4,   
					'card_expiry_month' => $exp_month,   
					'card_expiry_year' => $exp_year,   
					'status' => 'Active',   
					  
				), 
				array( 'customer_id' => $customerID )
			);
		
	   $path = __DIR__.'/../../uploads/transaction_logs/customer_created.log';
			$myfile = fopen($path, "w") or die("Unable to open file!");
			fwrite($myfile, print_r($event_json,true));
		break;
		
		
		case "charge.refunded":
	   $path = __DIR__.'/../../uploads/transaction_logs/charge_refunded.log';
	   global $wpdb; 
	   $refunded_id = $event_json['data']['object']['refunds']['data'][0]['id'];
	   $refunded_amt = $event_json['data']['object']['amount_refunded'];
	   $payment_intent = $event_json['data']['object']['refunds']['data'][0]['payment_intent'];
	   $customerID = 	$event_json['data']['object']['customer'];
	   $status = 	$event_json['data']['object']['status'];
	   $user_id = $wpdb->get_results("SELECT user_id,subscription_id FROM wp_user_subscriptions WHERE customer_id = '$customerID'");
		$event_types = explode('.' , $event_json['type']);
		$event_type_value = implode('_' , $event_types);
			 $wpdb->insert("wp_transaction_logs", array(					   
					   "user_id" => $user_id[0]->user_id,
					   "gateway" => "Stripe",
					   "customer_id" => $customerID,
					   "subscription_id"=> $user_id[0]->subscription_id,
					   "return_id"=> $payment_intent,
					   "payment_event"=> $event_type_value,
					   "status"=> $status,
					   "refund_at"=> $refunded_id,
					   
					   "amount"=> $refunded_amt/100,
				     ));
	   
			$myfile = fopen($path, "w") or die("Unable to open file!");
			fwrite($myfile, print_r($event_json,true));
		break;
		
		
		case "charge.failed":
	   $path = __DIR__.'/../../uploads/transaction_logs/charge_failed.log';
			$myfile = fopen($path, "w") or die("Unable to open file!");
			fwrite($myfile, print_r($event_json,true));
		break;
		
		
		case "charge.succeeded":
	   $path = __DIR__.'/../../uploads/transaction_logs/charge_succeeded.log';
	   
		$chargeID = 	$event_json['data']['object']['id'];
		$status = 	$event_json['data']['object']['status'];
		$payment_intent = 	$event_json['data']['object']['payment_intent'];
		$amount = 	$event_json['data']['object']['amount'];
		$createdDate = 	$event_json['data']['object']['created'];
		$customerID = 	$event_json['data']['object']['customer'];
		$payment_msg = 	$event_json['data']['object']['outcome']['seller_message'];			
		$event_types = explode('.' , $event_json['type']);
		$event_type_value = implode('_' , $event_types);
		$user_id = $wpdb->get_results("SELECT user_id,subscription_id FROM wp_user_subscriptions WHERE customer_id = '$customerID'");
			
			 $wpdb->insert("wp_transaction_logs", array(					   
					   "user_id" => $user_id[0]->user_id,
					   "gateway" => "Stripe",
					   "customer_id" => $customerID,
					   "subscription_id"=> $user_id[0]->subscription_id,
					   "return_id"=> $payment_intent,
					   "payment_event"=> $event_type_value,
					   "status"=> $status,					   
					   "amount"=> $amount/100,
				     ));
		
		
			$wpdb->update( 
					'wp_user_subscriptions', 
					array( 						
						'subscription_status' => $payment_msg,   
						'charge_id' => $chargeID,   
						'subscription_amount' => $amount/100, 							   
					), 
					array( 'customer_id' => $customerID )
				);
					
			$myfile = fopen($path, "w") or die("Unable to open file!");
			fwrite($myfile, print_r($event_json,true));
		break;
		
		
		case "customer.subscription.trial_will_end":
	   $path = __DIR__.'/../../uploads/transaction_logs/customer_subscription_trial_will_end.log';
			$myfile = fopen($path, "w") or die("Unable to open file!");
			fwrite($myfile, print_r($event_json,true));
		break;
		/**************************************************************/
		case "checkout.session.completed":
	   $path = __DIR__.'/../../uploads/transaction_logs/checkout_session_completed.log';
			$myfile = fopen($path, "w") or die("Unable to open file!");
			fwrite($myfile, print_r($event_json,true));
		break;
		case "checkout.session.async_payment_succeeded":
	   $path = __DIR__.'/../../uploads/transaction_logs/checkout_session_async_payment_succeeded.log';
			$myfile = fopen($path, "w") or die("Unable to open file!");
			fwrite($myfile, print_r($event_json,true));
		break;
		case "checkout.session.async_payment_failed":
	   $path = __DIR__.'/../../uploads/transaction_logs/checkout_session_async_payment_failed.log';
			$myfile = fopen($path, "w") or die("Unable to open file!");
			fwrite($myfile, print_r($event_json,true));
		break;
		case "subscription_schedule.canceled":
	   $path = __DIR__.'/../../uploads/transaction_logs/subscription_schedule_canceled.log';
			$myfile = fopen($path, "w") or die("Unable to open file!");
			fwrite($myfile, print_r($event_json,true));
		break;
		
		
		/*****************************************************************************/
		case "customer.subscription.deleted":
			global $wpdb;
			$path = __DIR__.'/../../uploads/transaction_logs/customer_subscription_deleted.log';	   
			$customerID = $event_json['data']['object']['customer'];
			$user_id = $wpdb->get_results("SELECT user_id,subscription_id FROM wp_user_subscriptions WHERE customer_id = '$customerID'");
			$userID = $user_id[0]->user_id;
			$payment_intent = 	$event_json['data']['object']['payment_intent'];
			$status = 	$event_json['data']['object']['status'];
			$amount = 	$event_json['data']['object']['plan']['amount'];
			$planid = 	$event_json['data']['object']['plan']['id'];
			$canceled_at = 	$event_json['data']['object']['canceled_at'];
			$event_types = explode('.' , $event_json['type']);
		$event_type_value = implode('_' , $event_types);
			$canceledAt = date("Y-m-d H:i:s", $canceled_at);
			$updated = update_user_meta( $userID, 'subscription_deleted', 'canceled' );
			
			
			$wpdb->insert("wp_transaction_logs", array(					   
					   "user_id" => $user_id[0]->user_id,
					   "gateway" => "Stripe",
					   "customer_id" => $customerID,
					   "subscription_id"=> $user_id[0]->subscription_id,
					   "return_id" => $planid,
					   "payment_event"=> $event_type_value,
					   "status"=> $status,					   
					   "amount"=> $amount/100,
				     ));
				 $wpdb->update( 
					'wp_user_subscriptions', 
					array( 						   
						'trail_ends_at' => '',   
						'subscription_end_at' => '',
						'canceled_at' => $canceledAt,
						'payment_event' => $event_type_value,						   
					), 
					array( 'customer_id' => $customerID )
				);
				
			$myfile = fopen($path, "w") or die("Unable to open file!");
			fwrite($myfile, print_r($canceledAt,true));
		break;
		
		case "customer.subscription.updated":
	   $path = __DIR__.'/../../uploads/transaction_logs/customer_subscription_updated12.log';
			$customerID = 	$event_json['data']['object']['customer'];
			$billing_cycle_anchor = $event_json['data']['previous_attributes']['billing_cycle_anchor'];
			$current_period_end = $event_json['data']['object']['current_period_end'];
			$trial_start_num = $event_json['data']['object']['trial_start'];
			$trial_end_num = $event_json['data']['object']['trial_end'];
			$trial_start = date("Y-m-d H:i:s", $trial_start_num);
			$trial_end = date("Y-m-d H:i:s", $trial_end_num);
			$sub_status = $event_json['data']['object']['items']['data'][0]['plan']['active'];
			$plan_id = $event_json['data']['object']['items']['data'][0]['plan']['id'];
			$amount = $event_json['data']['object']['items']['data'][0]['plan']['amount'];
			 $current_period_end = date("Y-m-d H:i:s", $current_period_end);
			
				
				 $wpdb->update( 
						'wp_user_subscriptions', 
						array( 
							'trail_ends_at' => $trial_end,   
							'subscription_status' => $sub_status,   
							'plan_id' => $plan_id,   
							'subscription_amount' => $amount/100,   
							'subscription_end_at' => $current_period_end, 
							'status' => $status,   
						), 
						array( 'customer_id' => $customerID )
					);
				
				
				
			
			$myfile = fopen($path, "w") or die("Unable to open file!");
			fwrite($myfile, print_r($event_json,true));
		break;
		
		case "customer.subscription.created":
			global $wpdb; 
			
			
					$path = __DIR__.'/../../uploads/transaction_logs/customer_subscription_created.log';
					$myfile = fopen($path, "w") or die("Unable to open file!");			
					$subscriptionsID = $event_json['data']['object']['items']['data'][0]['subscription'];
					$amount = $event_json['data']['object']['items']['data'][0]['plan']['amount'];
					$sub_status = $event_json['data']['object']['items']['data'][0]['plan']['active'];
					$plan_id = $event_json['data']['object']['items']['data'][0]['plan']['id'];
					$customerID = $event_json['data']['object']['customer'];
					$status ='Active';
					$trial_start_num = $event_json['data']['object']['trial_start'];
					$trial_end_num = $event_json['data']['object']['trial_end'];
					$trial_start = date("Y-m-d H:i:s", $trial_start_num);
					$trial_end = date("Y-m-d H:i:s", $trial_end_num);
					$user_id = $wpdb->get_results("SELECT user_id FROM wp_user_subscriptions WHERE customer_id = '$customerID'");
					$event_types = explode('.' , $event_json['type']);
					$event_type_value = implode('_' , $event_types);
			 $wpdb->insert("wp_transaction_logs", array(					   
					   "user_id" => $user_id[0]->user_id,
					   "gateway" => "Stripe",
					   "customer_id" => $customerID,
					   "subscription_id"=> $subscriptionsID,
					   "return_id"=> $plan_id,
					   "payment_event"=> $event_type_value,
					   "status"=> 'Active',					   
					   "amount"=> $amount/100,
				     ));
			 
			 $wpdb->update( 
						'wp_user_subscriptions', 
						array( 
							'trail_ends_at' => $trial_end,   
							'subscription_status' => $sub_status,   
							'plan_id' => $plan_id,   
							'subscription_amount' => $amount/100,   
							//'subscription_end_at' => '',   
							'status' => $status,   
						), 
						array( 'customer_id' => $customerID )
					);
			 
			
			fwrite($myfile, print_r($event_json,true));		   
			break;
	  default:
		echo "Nothing";
	}
					
					
					 
fclose($myfile);

?>



<?php get_footer();