<?php
/**
 * Euleo-CMS API - Callback
 * 
 * PHP Version 5.3
 * 
 * @copyright 2014 Euleo GmbH (https://www.euleo.com/)
 * @license GPS v2 or later
 * @link https://www.euleo.com/
 */

require_once 'lib/EuleoRequest.php';

$config = json_decode(file_get_contents('config.json'));

if ($config->token) {
	$req = new EuleoRequest();
	$data = $req->install($config->token);

	unset($config->token);
	$config->customer = $data['customer'];
	$config->usercode = $data['usercode'];

	file_put_contents(dirname(__FILE__) . '/config.json', json_encode($config));
} else {
	$req = new EuleoRequest($config->customer, $config->usercode);
	$rows = $req->getRows();

// 	print_r($rows);
	
	$confirmIds = array();

	foreach ((array)$rows as $row) {
		if ($row['ready'] == 1) {
			$confirmIds[] = $row['translationid'];
		}
	}

	$req->confirmDelivery($confirmIds);
}


echo 'callback response';
