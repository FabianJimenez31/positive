<?php

function osticketfieldsShowd($array){

	if($array['is_osticket']==1 && $array['is_service']==1){

		$nuevos=json_decode($array['osticket_fields'],1);

		foreach($nuevos as $nu){

			if($nu['value']=='manual.input'){

				$array['osf_'.$nu['field']]='';

			}

		}


	}


	return $array;

}


function osticketvalueslabels(){

return array(

			array(

				'option'=>'customer.account_number',
				'display'=>lang('common_customer')." ".lang('customers_account_number'),

			),

			array(

				'option'=>'customer.tax_certificate',
				'display'=>lang('common_customer')." ".lang('customers_tax_certificate'),

			),
			array(

				'option'=>'customer.name',
				'display'=>lang('common_customer_name'),

			),
			array(

				'option'=>'customer.email',
				'display'=>lang('common_customer')." ".lang('common_email'),

			),
			array(

				'option'=>'customer.phone',
				'display'=>lang('common_customer')." ".lang('common_phone_number'),

			),
			array(

				'option'=>'customer.address_1',
				'display'=>lang('common_customer')." ".lang('common_address_1'),

			),
			array(

				'option'=>'customer.address_2',
				'display'=>lang('common_customer')." ".lang('common_address_2'),

			),
			array(

				'option'=>'customer.city',
				'display'=>lang('common_customer')." ".lang('common_city'),

			),
			array(

				'option'=>'customer.state',
				'display'=>lang('common_customer')." ".lang('common_state'),

			),
			array(

				'option'=>'customer.zip',
				'display'=>lang('common_customer')." ".lang('common_zip'),

			),
			array(

				'option'=>'customer.country',
				'display'=>lang('common_customer')." ".lang('common_country'),

			),

			array(

				'option'=>'employee.employee_number',
				'display'=>lang('common_employees_number'),

			),
			array(

				'option'=>'employee.name',
				'display'=>lang('common_employee')." ".lang('common_name'),

			),
			array(

				'option'=>'employee.email',
				'display'=>lang('common_employee')." ".lang('common_email'),

			),
			array(

				'option'=>'employee.phone',
				'display'=>lang('common_employee')." ".lang('common_phone_number'),

			),
			array(

				'option'=>'employee.address_1',
				'display'=>lang('common_employee')." ".lang('common_address_1'),

			),
			array(

				'option'=>'employee.address_2',
				'display'=>lang('common_employee')." ".lang('common_address_2'),

			),
			array(

				'option'=>'employee.city',
				'display'=>lang('common_employee')." ".lang('common_city'),

			),
			array(

				'option'=>'employee.state',
				'display'=>lang('common_employee')." ".lang('common_state'),

			),
			array(

				'option'=>'employee.zip',
				'display'=>lang('common_employee')." ".lang('common_zip'),

			),
			array(

				'option'=>'employee.country',
				'display'=>lang('common_employee')." ".lang('common_country'),

			),
			array(

				'option'=>'manual.input',
				'display'=>lang('common_custom_field'),


			)


	);



}

function osticketCleanValues($string){

	$array=array();
	$already_saved=array();
	$fields=json_decode($string,1);

	foreach($fields as $f){

		if(!(in_array($f['field'],$already_saved))){

			unset($f['id']);
			if(strlen(osTremoveSpaces($f['field']))>=1){
				$f['field']=osTremoveSpaces($f['field']);
				$array[]=$f;
				$already_saved[]=$f['field'];

			}
		}

	}


	return json_encode($array);
}

function osticketinitvalues($array=array() ){

	$prev=array(

		array(

			'field'=>'email',
			'label'=>lang('common_customer')." ".lang('common_email'),
			'required'=>true,
			'value'=>'customer.email',
			'change_required'=>false,
			'can_delete'=>false,
			'only_hide'=>false,
			'editable'=>false,
			'hide'=>false,

		),

		array(

			'field'=>'name',
			'label'=>lang('common_customer_name'),
			'required'=>true,
			'value'=>'customer.name',
			'change_required'=>false,
			'can_delete'=>false,
			'only_hide'=>false,
			'editable'=>false,
			'hide'=>false,


		),

		array(

			'field'=>'phone',
			'label'=>lang('common_customer')." ".lang('common_phone_number'),
			'required'=>false,
			'value'=>'customer.phone',
			'change_required'=>true,
			'can_delete'=>false,
			'only_hide'=>true,
			'editable'=>false,
			'hide'=>false,

		),

	);

	foreach($array as $current){

		if(is_array($current)){


			if($current['field']=='email'){
				$prev[0]['label']=$current['label'];
				$prev[0]['value']=$current['value'];

			}elseif($current['field']=='name'){
				$prev[1]['label']=$current['label'];
				$prev[1]['value']=$current['value'];

			}elseif($current['field']=='phone'){
				$prev[2]['label']=$current['label'];
				$prev[2]['value']=$current['value'];
				$prev[2]['required']=$current['required'];
				$prev[2]['hide']=$current['hide'];

			}else{

				$prev[]=$current;

			}



		}


	}

	return $prev;


}

function osTremoveSpaces($string){

	return( str_replace(array(' ',"\r","\n","\t"),'',$string) );

}

function osticketCreateTicket($host,$key,$fields)
{


	$externalContent = file_get_contents('http://checkip.dyndns.com/');
preg_match('/Current IP Address: \[?([:.0-9a-fA-F]+)\]?/', $externalContent, $m);
	$externalIp = $m[1];
	$config = array(
		    'url'=>$host.'/api/tickets.json',
		    'key'=>$key
		    );

	# Fill in the data for the new ticket, this will likely come from $_POST.

	$data = array(
		'name'      =>      $fields['name'],
		'email'     =>      ((filter_var($fields['email'], FILTER_VALIDATE_EMAIL))?$fields['email']:(rand(1000,9999).md5(time())."@skyone.com.co")),
		'subject'   =>      lang('sales_new_sale')." [ ".date('YmdHis')." ]",
		'message'   =>      $fields['_osT_sale_details'],
		'ip'        =>      $externalIp,
		'attachments' => array(),
	);

	foreach($fields as $k=>$v){

		if(!isset($data[$k]) && $k!='_osT_sale_details'){
			$data[$k]=$v;
		}

	}

	#pre-checks
	/*ADD ATTACHMENTS*/
	/*
	$data['attachments'][] =
	array('filename.pdf' =>
		    'data:application/pdf;base64,' .
		        base64_encode(file_get_contents('/path/to/filename.pdf')));
	*/
	#set timeout
	set_time_limit(120);

	#curl post
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $config['url']);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
	curl_setopt($ch, CURLOPT_USERAGENT, 'osTicket API Client v1.7');
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array( 'Expect:', 'X-API-Key: '.$config['key']));
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$result=curl_exec($ch);
	$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);

	if ($code != 201){
		return false;
	}
	$ticket_id = (int) $result;

	if($ticket_id>0){
		return $ticket_id;
	}

	return false;


}






function osticketRequestStatus($host,$key,$ticketNumber)
{



	$config = array(
		    'url'=>$host.'/api/status.json',
		    'key'=>$key
		    );

	# Fill in the data for the new ticket, this will likely come from $_POST.

	$data = array(
		'number'      =>      $ticketNumber,
		'Status'        =>     1,
		'ClientThread' => 1
	);


	#pre-checks
	/*ADD ATTACHMENTS*/
	/*
	$data['attachments'][] =
	array('filename.pdf' =>
		    'data:application/pdf;base64,' .
		        base64_encode(file_get_contents('/path/to/filename.pdf')));
	*/
	#set timeout
	set_time_limit(120);

	#curl post
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $config['url']);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
	curl_setopt($ch, CURLOPT_USERAGENT, 'osTicket API Client v1.7');
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array( 'Expect:', 'X-API-Key: '.$config['key']));
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$result=curl_exec($ch);
	$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);

	

	if ($code != 201 && $code != 200){
		return false;
	}
	$ticket_status = json_decode($result,1);

	if(isset($ticket_status['Status'])){
		return $ticket_status;
	}

	return false;


}














//var_dump(osticketRequestStatus("http://ostickets01.brainerhq.com","1945F8E2CF0263D0A5A9F22F46F9BDAE","324234"));
?>
