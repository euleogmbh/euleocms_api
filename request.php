<?php
/**
 * Euleo-CMS API - Request
 *
 * PHP Version 5.3
 *
 * @copyright 2014 Euleo GmbH (https://www.euleo.com)
 * @license GPL v2 or later
 * @link https://www.euleo.com
 */

header('Content-Type: text/html; charset="utf8"');

require_once 'lib/EuleoRequest.php';

$config = json_decode(file_get_contents('config.json'));

if ($config->customer) {
    try {
        $req = new EuleoRequest($config->customer, $config->usercode);
        
        // show current customer
        var_dump($req->getCustomerData());
        
        // set the languages which can be selected in the shopping cart (on euleo.com)
        $req->setLanguageList('en,hu,it');
        
        $rows = array();
        
        $row = array();
        $row['code'] = 'test_1';
        $row['title'] = 'test 1';
        $row['description'] = 'this is a test';
        $row['srclang'] = 'de';
        $row['languages'] = 'en';
        
        $row['fields'] = array();
        
        $field = array();
        $field['type'] = 'textarea';
        $field['value'] = 'foo, dies ist ein js-test';
        
        $row['fields']['test'] = $field;
        
    //     $row['rows'] = array($row);
        
        $rows[] = $row;
        
        $req->sendRows($rows);
        
        // show the current cart
        var_dump($req->getCart());
        
        // add a language to the row test_1
        $req->addLanguage('test_1', 'hu');
        
        // remove a language to the row test_1
        $req->removeLanguage('test_1', 'en');
        
        // clear the cart and show it
        $req->clearCart();
        var_dump($req->getCart());
        
        
        // show the login link
        var_dump($req->startEuleoWebsite());
    } catch (Exception $e) {
        unlink('config.json');
        
        var_dump($e);
    }
} else {
    $req = new EuleoRequest();
    
    $cmsroot = 'http://ianus/euleocms/api/';
    $returnUrl = $cmsroot . 'request.php';
    $callbackUrl = $cmsroot . 'callback.php';
    
    
    $token = $req->getRegisterToken($cmsroot, $returnUrl, $callbackUrl);

    $config = new stdClass();
    $config->token = $token;
    
    file_put_contents('config.json', json_encode($config));
    
    // FIXME: für veröffentlichung entfernen
    if ( $_SERVER [ 'SERVER_ADDR' ] == '192.168.1.10' ) {
		$link = 'http://euleo/registercms/' . $token;
	} else {
		$link = 'https://www.euleo.com/registercms/' . $token;
	}
	
	header('Location: ' . $link);
	exit;
}
