<?php
require_once('helper.php');


// Allow CORS & Headers
cors();

if (isset($_GET['cmd'])):
	$cmd = $_GET['cmd'];

	$api_point = '';
	if (isset($_GET['engagex'])) {
		$api_point = $_GET['engagex'];
	}
	
	if ($api_point == 'prod') {
		// Production
		$uid = 'engagex';
		$pwd = 'faTTgoWauQomIpV5T0GEM4I0LUFnJTdXODosj3uneRjG75V3x2BFf10aIS8BZiHR';
	} else {
		// Development
		$uid = 'engagex';
		$pwd = 'saJLlees9NpLRszspKeAMbNzu4gFCu55TcYETmMu6PBSk2QLoPgaX2nHDJQgyPfE';
	}
	
	$ch = curl_init();

	switch($cmd) {
		case 'create_order':
			if (!isset($_POST['payload'])) {
				echo 'Invalid parameter';
				exit;
			} else {

				// Sample payload for testing
				// $payload = '{
				// 	 "order": {
				// 	  "programid":"47332",
				// 	  "clientid":"1231",
				// 	  "accounts":[
				// 	   {
				// 	   "firstname":"Joven",
				// 	   "lastname":"Barola",
				// 	   "email":"joven.barola@engagex.com",
				// 	   "sku":"GCP-V-030",
				// 	   "amount":"5.00"
				// 	   }
				// 	  ]
				// 	 }
				// }';

				$payload = $_POST['payload'];

	
				$endpoint = "https://rest.virtualincentives.com/v4/json/orders";
				curl_setopt($ch, CURLOPT_URL,$endpoint);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
				curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			}
			break;

		case 'get_orders':
			$endpoint = "https://rest.virtualincentives.com/v4/json/orders";
			curl_setopt($ch, CURLOPT_URL,$endpoint);
			curl_setopt($ch, CURLOPT_HTTPGET, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			break;

		case 'get_orders_by_status':
			if (isset($_GET['status'])) {
				$endpoint = "https://rest.virtualincentives.com/v4/json/orders?status=".$_GET['status'];
				curl_setopt($ch, CURLOPT_URL,$endpoint);
				curl_setopt($ch, CURLOPT_HTTPGET, 1);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			}
			break;

		case 'get_orders_by_number':
			if (isset($_GET['number'])) {
				$endpoint = "https://rest.virtualincentives.com/v4/json/orders/".$_GET['number'];
				curl_setopt($ch, CURLOPT_URL,$endpoint);
				curl_setopt($ch, CURLOPT_HTTPGET, 1);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			}
			break;

		case 'get_brands':
			$endpoint = "https://rest.virtualincentives.com/v4/json/products";
			curl_setopt($ch, CURLOPT_URL,$endpoint);
			curl_setopt($ch, CURLOPT_HTTPGET, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			break;

		case 'get_brand':
			if (isset($_GET['sku'])) {
				$endpoint = "https://rest.virtualincentives.com/v4/json/products/". $_GET['sku'];
				curl_setopt($ch, CURLOPT_URL,$endpoint);
				curl_setopt($ch, CURLOPT_HTTPGET, 1);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			} else {
				exit;
			}
			break;

		case 'get_brand_faceplate':
			if (isset($_GET['sku'])) {
				$endpoint = "https://rest.virtualincentives.com/v4/json/products/". $_GET['sku'] . '/faceplate';
				curl_setopt($ch, CURLOPT_URL,$endpoint);
				curl_setopt($ch, CURLOPT_HTTPGET, 1);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			} else {
				exit;
			}
			break;

		case 'get_brand_marketing':
			if (isset($_GET['sku'])) {
				$endpoint = "https://rest.virtualincentives.com/v4/json/products/". $_GET['sku'] . '/marketing';
				curl_setopt($ch, CURLOPT_URL,$endpoint);
				curl_setopt($ch, CURLOPT_HTTPGET, 1);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			} else {
				exit;
			}
			break;

		case 'get_brand_terms':
			if (isset($_GET['sku'])) {
				$endpoint = "https://rest.virtualincentives.com/v4/json/products/". $_GET['sku'] . '/terms';
				curl_setopt($ch, CURLOPT_URL,$endpoint);
				curl_setopt($ch, CURLOPT_HTTPGET, 1);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			} else {
				exit;
			}
			break;

		case 'get_master_funding_balances':
			$endpoint = "https://rest.virtualincentives.com/v4/json/balances";
			curl_setopt($ch, CURLOPT_URL,$endpoint);
			curl_setopt($ch, CURLOPT_HTTPGET, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			break;

		case 'get_program_balances':
			$endpoint = "https://rest.virtualincentives.com/v4/json/balances/programs";
			curl_setopt($ch, CURLOPT_URL,$endpoint);
			curl_setopt($ch, CURLOPT_HTTPGET, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			break;

		case 'get_program_balance':
			if (isset($_GET['program_id'])) {
				$endpoint = "https://rest.virtualincentives.com/v4/json/balances/programs/". $_GET['program_id'];
				curl_setopt($ch, CURLOPT_URL,$endpoint);
				curl_setopt($ch, CURLOPT_HTTPGET, 1);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			} else {
				exit;
			}
			break;

		case 'get_programs':
			$endpoint = "https://rest.virtualincentives.com/v4/json/programs/";
			curl_setopt($ch, CURLOPT_URL,$endpoint);
			curl_setopt($ch, CURLOPT_HTTPGET, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			break;

		case 'get_program_brands':
			if (isset($_GET['program_id'])) {
				$endpoint = "https://rest.virtualincentives.com/v4/json/programs/". $_GET['program_id'] . "/products";
				curl_setopt($ch, CURLOPT_URL,$endpoint);
				curl_setopt($ch, CURLOPT_HTTPGET, 1);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			} else {
				exit;
			}
			break;

		case 'get_program_brand':
			if (isset($_GET['program_id']) && isset($_GET['sku'])) {
				$endpoint = "https://rest.virtualincentives.com/v4/json/programs/". $_GET['program_id'] . '/products/' . $_GET['sku'];
				curl_setopt($ch, CURLOPT_URL,$endpoint);
				curl_setopt($ch, CURLOPT_HTTPGET, 1);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			} else {
				exit;
			}
			break;
	}

	if (!isset($server_output)) {
		// Authorization
		$uid_pwd = base64_encode($uid . ':' . $pwd);
		$headers = [
			'Content-Type: application/json',
			'Authorization: Basic '. $uid_pwd,
			'Host: rest.virtualincentives.com'
		];
		
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		
		$server_output = curl_exec ($ch);
		
		curl_close ($ch);

		echo $server_output;
	} else {
		echo $server_output;
	}
	exit;


endif;



if (isset($_GET['health'])) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,"https://rest.virtualincentives.com/v3/xml/order/26929881");
	curl_setopt($ch, CURLOPT_HTTPGET, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	
	// Development
	$uid = 'engagex';
	$pwd = 'saJLlees9NpLRszspKeAMbNzu4gFCu55TcYETmMu6PBSk2QLoPgaX2nHDJQgyPfE';

	// Authorization
	$uid_pwd = base64_encode($uid . ':' . $pwd);
	$headers = [
		'Content-Type: application/json',
		'Authorization: Basic '. $uid_pwd,
		'Host: rest.virtualincentives.com'
	];
	
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	
	$server_output = curl_exec ($ch);
	
	curl_close ($ch);

	echo '<b>This Server IP Address:</b> '. $_SERVER['SERVER_ADDR'] . '<br><br>';

	echo '<h2>API Request (in PHP):</h2>';
	echo '<code>';
	echo '<?php <br><br>';
	echo '$ch = curl_init();  <br>';
	echo 'curl_setopt($ch, CURLOPT_URL,"https://rest.virtualincentives.com/v3/xml/order/26929881"); <br>';
	echo 'curl_setopt($ch, CURLOPT_HTTPGET, 1); <br>';
	echo 'curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); <br><br>';
	echo '$headers = [   <br>';
	echo "    'Content-Type: application/xml', <br>";
	echo "	'Authorization: Basic ZW5nYWdleDpzYUpMbGVlczlOcExSc3pzcEtlQU1iTnp1NGdGQ3U1NVRjWUVUbU11NlBCU2syUUxvUGdhWDJuSERKUWd5UGZF', <br>";
	echo "	'Host: rest.virtualincentives.com'  <br>";
	echo "]; <br><br>";
	echo 'curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); <br><br>';
	echo '$server_output = curl_exec ($ch); <br>';
	echo 'curl_close ($ch);';
	echo '</code>';
	echo '<br>';
	
	echo '<h2>API Response:</h2>';
	echo '<textarea cols="60" rows="10">' . $server_output . '</textarea>';
	
	//216.21.163.236
}