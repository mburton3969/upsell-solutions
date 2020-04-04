<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);

ini_set('max_execution_time',18000); // in seconds
ini_set('memory_limit','256M');
ini_set('max_input_time',18000); // in seconds

$public_key = 'AKIAIA2BXYKUIRRRABUQ';
$private_key = 'iw/Y0qi2aEzuSRbKh1F44aIyksRFAbW4i95J//mC';
$associate_tag = 'resellersolut-20';
$region = 'com';
$search_index = '';
$version='2011-08-01';
$operation = 'ItemLookup';


//aws_signed_request($region, $params, $public_key, $private_key, $associate_tag=NULL, $version='2011-08-01'){
	
		// Send Signed Request to Amazon.com API

		// Paramaters
		$method = 'GET';
		$host = 'webservices.amazon.'.$region;
		$uri = '/onca/xml';
		
		// additional parameters
		$params['Service'] = 'AWSECommerceService';
		$params['AWSAccessKeyId'] = $public_key;
    //Operation
    $params['Operation'] = $operation;
    $params['IdType'] = $upc_code;
    $params['ResponseGroup'] = 'SalesRank,ItemAttributes,OfferSummary,Reviews';
    
		// GMT timestamp
		$params['Timestamp'] = gmdate('Y-m-d\TH:i:s\Z');
		// API version
		$params['Version'] = $version;
		if ($associate_tag !== NULL) {
			$params['AssociateTag'] = $associate_tag;
		}
		
		// Sort the Parameters
		ksort($params);
		
		// Create the canonicalized query
		$canonicalized_query = array();
		foreach ($params as $param=>$value)
		{
			$param = str_replace('%7E', '~', rawurlencode($param));
			$value = str_replace('%7E', '~', rawurlencode($value));
			$canonicalized_query[] = $param.'='.$value;
		}
		$canonicalized_query = implode('&', $canonicalized_query);
		
		// Create the string to sign
		$string_to_sign = $method."\n".$host."\n".$uri."\n".$canonicalized_query;
		
		// Calculate HMAC with SHA256 and base64-encoding
		$signature = base64_encode(hash_hmac('sha256', $string_to_sign, $private_key, TRUE));
		
		// Encode the signature for the request
		$signature = str_replace('%7E', '~', rawurlencode($signature));
		
		// Create request
		$request = 'http://'.$host.$uri.'?'.$canonicalized_query.'&Signature='.$signature;
		
echo $request;