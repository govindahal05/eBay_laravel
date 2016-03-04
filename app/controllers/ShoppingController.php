<?php
use \DTS\eBaySDK\Shopping\Services;
use \DTS\eBaySDK\Shopping\Types;
//additional to getSingleItem()
use \DTS\eBaySDK\Shopping\Enums;


class ShoppingController extends \BaseController {

	
	public function __construct()
	{
		//
	}
	public function geteBayTime()
	{
		$config = Config::get('configuration');
		$service = new Services\ShoppingService(array('apiVersion' => $config['shoppingApiVersion'],'appId' => $config['production']['appId']));

		$request = new Types\GeteBayTimeRequestType();

		$response = $service->geteBayTime($request);

		if ($response->Ack !== 'Success') {
		    if (isset($response->Errors)) {
		        foreach ($response->Errors as $error) {
		            printf("Error: %s\n", $error->ShortMessage);
		        }
		    }
		} else {
		    printf("The official eBay time is: %s\n", $response->Timestamp->format('H:i (\G\M\T) \o\n l jS F Y'));
		}
	}

	public function getSingleItem()
	{
		
		$config = Config::get('configuration');
				$service = new Services\ShoppingService(array('apiVersion' => $config['shoppingApiVersion'],'appId' => $config['production']['appId']));
		$request = new Types\GetSingleItemRequestType();

		$request->ItemID = '111111111111';

		$request->IncludeSelector = 'ItemSpecifics,Variations,Compatibility,Details';

		$response = $service->getSingleItem($request);

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
		    $item = $response->Item;

		    print("$item->Title\n");

		    printf("Quantity sold %s, quantiy available %s\n",
		        $item->QuantitySold,
		        $item->Quantity - $item->QuantitySold
		    );

		    if (isset($item->ItemSpecifics)) {
		        print("\nThis item has the following item specifics:\n\n");

		        foreach($item->ItemSpecifics->NameValueList as $nameValues) {
		            printf("%s: %s\n",
		                $nameValues->Name,
		                implode(', ', iterator_to_array($nameValues->Value))
		            );
		        }
		    }

	    if (isset($item->Variations)) {
	        print("\nThis item has the following variations:\n");

	        foreach($item->Variations->Variation as $variation) {
	            printf("\nSKU: %s\nStart Price: %s\n",
	                $variation->SKU,
	                $variation->StartPrice->value
	            );

	            printf("Quantity sold %s, quantiy available %s\n",
	                $variation->SellingStatus->QuantitySold,
	                $variation->Quantity - $variation->SellingStatus->QuantitySold
	            );

	            foreach($variation->VariationSpecifics as $specific) {
	                foreach($specific->NameValueList as $nameValues) {
	                    printf("%s: %s\n",
	                        $nameValues->Name,
	                        implode(', ', iterator_to_array($nameValues->Value))
	                    );
	                }
	            }
	        }
	    }

	    if (isset($item->ItemCompatibilityCount)) {
	        printf("\nThis item is compatible with %s vehicles:\n\n", $item->ItemCompatibilityCount);

	        // Only show the first 3.
	        $limit = min($item->ItemCompatibilityCount, 3);
	        for ($x = 0; $x < $limit; $x++) {
	            $compatibility = $item->ItemCompatibilityList->Compatibility[$x];
	            foreach($compatibility->NameValueList as $nameValues) {
	                printf("%s: %s\n",
	                    $nameValues->Name,
	                    implode(', ', iterator_to_array($nameValues->Value))
	                );
	            }
	            printf("Notes: %s \n", $compatibility->CompatibilityNotes);
	        }
	    }
	}

	}
	

}