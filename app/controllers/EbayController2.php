<?php


use \DTS\eBaySDK\Constants;
use \DTS\eBaySDK\Finding\Services;
use \DTS\eBaySDK\Finding\Types;

class EbayController2 extends BaseController
{
	public function __construct(){
	// Pass associative array of configuration options.
		$service = new Services\FindingService(array(
		    'globalId' => Constants\GlobalIds::US,
		    'sandbox' => true
		));

	}
	public function call(){
		$service->config('globalId', Constants\GlobalIds::US);
		return $globalId = $service->config('globalId');

	}
}