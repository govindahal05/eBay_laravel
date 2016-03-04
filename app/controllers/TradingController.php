<?php
use \DTS\eBaySDK\Constants;
use \DTS\eBaySDK\Finding\Services;
use \DTS\eBaySDK\Finding\Types;
use \DTS\eBaySDK\Finding\Enums;

class TradingController extends \BaseController {

	public function __construct()
	{
		//
	}

	public function getOfficaleBayTime()
	{
		$config = Config::get('configuration');
        $service = new Services\TradingService(array(
		    'apiVersion' => $config['tradingApiVersion'],
		    // 'siteId' => '15'
		    'siteId' => Constants\SiteIds::AU
		));
		// dd($service);
		$request = new Types\GeteBayOfficialTimeRequestType();

		$request->RequesterCredentials = new Types\CustomSecurityHeaderType();
		$request->RequesterCredentials->eBayAuthToken = $config['sandbox']['userToken'];

		$response = $service->geteBayOfficialTime($request);
		// dd($response);

		if ($response->Ack !== 'Success') {
		    if (isset($response->Errors)) {
		        foreach ($response->Errors as $error) {
		            printf("Error: %s\n", $error->ShortMessage);
		        }
		    }
		}
		else {
		    printf("The official eBay time is: %s\n", $response->Timestamp->format('H:i (\G\M\T) \o\n l jS F Y'));
		}

	}
	public function categoryHierarchy(){
		$config = Config::get('configuration');

        $service = new Services\TradingService(array('apiVersion' => $config['tradingApiVersion'],'siteId' => Constants\SiteIds::US
		));
		$request = new Types\GetCategoriesRequestType();

	    $request->RequesterCredentials = new Types\CustomSecurityHeaderType();
		$request->RequesterCredentials->eBayAuthToken = $config['production']['userToken'];  

		$request->DetailLevel = array('ReturnAll');

		$request->OutputSelector = array(
		    'CategoryArray.Category.CategoryID',
		    'CategoryArray.Category.CategoryParentID',
		    'CategoryArray.Category.CategoryLevel',
		    'CategoryArray.Category.CategoryName'
		);

		$response = $service->getCategories($request);

		if ($response->Ack !== 'Success') {
		    if (isset($response->Errors)) {
		        foreach ($response->Errors as $error) {
		            printf("Error: %s\n", $error->ShortMessage);
		        }
		    }
		} 
		else {

			foreach ($response->CategoryArray->Category as $category) {
		        printf("Level %s : %s (%s) : Parent ID %s\n", 
		            $category->CategoryLevel,
		            $category->CategoryName,
		            $category->CategoryID,
		            $category->CategoryParentID[0]
		        );
		    }
		}


	}
	public function getStore(){
		$config = Config::get('configuration');

		$service = new Services\TradingService(array('apiVersion' => $config['tradingApiVersion'],'siteId' => Constants\SiteIds::US
			));

		$request = new Types\GetStoreRequestType();

		$request->RequesterCredentials = new Types\CustomSecurityHeaderType();
		$request->RequesterCredentials->eBayAuthToken = $config['production']['userToken'];

		$response = $service->getStore($request);

		if (isset($response->Errors)) {
		    foreach ($response->Errors as $error) {
		        printf("%s: %s\n%s\n\n",
		            $error->SeverityCode === Enums\SeverityCodeType::C_ERROR ? 'Error' : 'Warning',
		            $error->ShortMessage,
		            $error->LongMessage
		        );
		    }
		}

		if ($response->Ack !== 'Failure') {
		    $store = $response->Store;

		    printf("Name: %s\nDescription: %s\nURL: %s\n\n",
		        $store->Name,
		        $store->Description,
		        $store->URL
		    );

		    foreach ($store->CustomCategories->CustomCategory as $category) {
		        printCategory($category, 0);
		    }
		}

		function printCategory($category, $level)
		{
    		printf("%s%s : (%s)\n",str_pad('', $level * 4),$category->Name,$category->CategoryID);

		    foreach ($category->ChildCategory as $category) {
		        printCategory($category, $level + 1);
		    }
		}
	}
	public function uploadPictureToeBayPictureService(){
		$config = Config::get('configuration');

		$service = new Services\TradingService(array('apiVersion' => $config['tradingApiVersion'],'sandbox' => true,'siteId' => Constants\SiteIds::US));

		$request = new Types\UploadSiteHostedPicturesRequestType();

		$request->RequesterCredentials = new Types\CustomSecurityHeaderType();
		$request->RequesterCredentials->eBayAuthToken = $config['sandbox']['userToken'];

		$request->PictureName = 'Example';

		$request->attachment(file_get_contents(__DIR__.'/picture.jpg'), 'image/jpeg');

		$response = $service->uploadSiteHostedPictures($request);

		if (isset($response->Errors)) {
		    foreach ($response->Errors as $error) {
		        printf("%s: %s\n%s\n\n",
		            $error->SeverityCode === Enums\SeverityCodeType::C_ERROR ? 'Error' : 'Warning',
		            $error->ShortMessage,
		            $error->LongMessage
		        );
		    }
		}

		if ($response->Ack !== 'Failure') {
		    printf("The picture [%s] can be found at %s\n",
		        $response->SiteHostedPictureDetails->PictureName,
		        $response->SiteHostedPictureDetails->FullURL
		    );
		}


	}
}