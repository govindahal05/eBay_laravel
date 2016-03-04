<?php
use \DTS\eBaySDK\Constants;
use \DTS\eBaySDK\Finding\Services;
use \DTS\eBaySDK\Finding\Types;
use \DTS\eBaySDK\Finding\Enums;

class FindingController extends \BaseController {

	public function __construct()
	{

	}
	public function keyWordSearch(){
		$config = Config::get('configuration');
        // var_dump($config['sandbox']['appId']);
        $service = new Services\FindingService(array(
            'appId' => $config['sandbox']['appId'],
            'apiVersion' => $config['findingApiVersion'],
            'globalId' => Constants\GlobalIds::US
        ));
        // dd($service);
        $request = new Types\FindItemsByKeywordsRequest();
        $request->keywords = 'Harry Potter';

        $response = $service->findItemsByKeywords($request);

        // dd($response);

        if ($response->ack !== 'Success') {
            if (isset($response->errorMessage)) {
                foreach ($response->errorMessage->error as $error) {
                 printf("Error: %s\n", $error->message);
                }
            }
        } 
        else {
            foreach ($response->searchResult->item as $item) {
                printf("(%s) %s: %s %.2f\n",
                    $item->itemId,
                    $item->title,
                    $item->sellingStatus->currentPrice->currencyId,
                    $item->sellingStatus->currentPrice->value
                );
            }
        }

	}
	public function keyWordSearchWithPagination(){
		$config = Config::get('configuration');
        // var_dump($config['sandbox']['appId']);
        $service = new Services\FindingService(array(
            'appId' => $config['sandbox']['appId'],
            'apiVersion' => $config['findingApiVersion'],
            'globalId' => Constants\GlobalIds::US
        ));
        // dd($service);
        $request = new Types\FindItemsByKeywordsRequest();
        $request->keywords = 'Harry Potter';

        $request->paginationInput = new Types\PaginationInput();
		$request->paginationInput->entriesPerPage = 10;

		for ($pageNum = 1; $pageNum <= 3; $pageNum++ ) {
		    $request->paginationInput->pageNumber = $pageNum;

		    $response = $service->findItemsByKeywords($request);

		    echo "==================\nResults for page $pageNum\n==================\n";

	    	if ($response->ack !== 'Success') {
		        if (isset($response->errorMessage)) {
		            foreach ($response->errorMessage->error as $error) {
		                printf("Error: %s\n", $error->message);
		            }
		        }
	    	} 
	    	else {
       		foreach ($response->searchResult->item as $item) {
	            printf("(%s) %s: %s %.2f\n",
	                $item->itemId,
	                $item->title,
	                $item->sellingStatus->currentPrice->currencyId,
	                $item->sellingStatus->currentPrice->value
	            );
	        }
	   	}
		}

	}
	public function itemByProduct(){
		$config = Config::get('configuration');
        // var_dump($config['sandbox']['appId']);
       $service = new Services\FindingService(array(
            'appId' => $config['sandbox']['appId'],
            'apiVersion' => $config['findingApiVersion'],
            'globalId' => Constants\GlobalIds::US
        ));
		$request = new Types\FindItemsByProductRequest();

		$productId = new Types\ProductId();
		$productId->value = '085392246724';
		$productId->type = 'UPC';
		$request->productId = $productId;

		$response = $service->findItemsByProduct($request);

		if (isset($response->errorMessage)) {
		    foreach ($response->errorMessage->error as $error) {
		        printf("%s: %s\n\n",
		            $error->severity=== Enums\ErrorSeverity::C_ERROR ? 'Error' : 'Warning',
		            $error->message
		        );
		    }
		}
		if ($response->ack !== 'Failure') {
		    foreach ($response->searchResult->item as $item) {
		        printf("(%s) %s: %s %.2f\n",
		            $item->itemId,
		            $item->title,
		            $item->sellingStatus->currentPrice->currencyId,
		            $item->sellingStatus->currentPrice->value
		        );
		    }
		}

	}
	public function itemByProductWithFilter(){
		
		$productId = new Types\ProductId();
		$productId->value = '085392246724';
		$productId->type = 'UPC';
		$request->productId = $productId;

		$itemFilter = new Types\ItemFilter();
		$itemFilter->name = 'ListingType';
		$itemFilter->value[] = 'Auction';
		$itemFilter->value[] = 'AuctionWithBIN';
		$request->itemFilter[] = $itemFilter;

		$request->itemFilter[] = new Types\ItemFilter(array(
		    'name' => 'MinPrice',
		    'value' => array('1.00')
		));

		$request->itemFilter[] = new Types\ItemFilter(array(
		    'name' => 'MaxPrice',
		    'value' => array('10.00')
		));

		$request->sortOrder = 'CurrentPriceHighest';

		$request->paginationInput = new Types\PaginationInput();
		$request->paginationInput->entriesPerPage = 10;
		$request->paginationInput->pageNumber = 1;

		$response = $service->findItemsByProduct($request);

		if (isset($response->errorMessage)) {
		    foreach ($response->errorMessage->error as $error) {
		        printf("%s: %s\n\n",
		            $error->severity=== Enums\ErrorSeverity::C_ERROR ? 'Error' : 'Warning',
		            $error->message
		        );
		    }
		}

		printf("%s items found over %s pages.\n\n",
		    $response->paginationOutput->totalEntries,
		    $response->paginationOutput->totalPages
		);

		echo "==================\nResults for page 1\n==================\n";

		if ($response->ack !== 'Failure') {
		    foreach ($response->searchResult->item as $item) {
		        printf("(%s) %s: %s %.2f\n",
		            $item->itemId,
		            $item->title,
		            $item->sellingStatus->currentPrice->currencyId,
		            $item->sellingStatus->currentPrice->value
		        );
		    }
		}

		$limit = min($response->paginationOutput->totalPages, 3);
		for ($pageNum = 2; $pageNum <= $limit; $pageNum++ ) {
		    $request->paginationInput->pageNumber = $pageNum;

		    $response = $service->findItemsByProduct($request);

		    echo "==================\nResults for page $pageNum\n==================\n";

		    if ($response->ack !== 'Failure') {
		        foreach ($response->searchResult->item as $item) {
		            printf("(%s) %s: %s %.2f\n",
		                $item->itemId,
		                $item->title,
		                $item->sellingStatus->currentPrice->currencyId,
		                $item->sellingStatus->currentPrice->value
		            );
		        }
		    }
		}

	}
	public function findItemsAdvanced(){
		$config = Config::get('configuration');
        // var_dump($config['sandbox']['appId']);
       $service = new Services\FindingService(array(
            'appId' => $config['sandbox']['appId'],
            'apiVersion' => $config['findingApiVersion'],
            'globalId' => Constants\GlobalIds::US
        ));
		$request = new Types\FindItemsByProductRequest();
		$request->keywords = 'Harry Potter';

		$request->categoryId = array('617', '171228');

		$itemFilter = new Types\ItemFilter();
		$itemFilter->name = 'ListingType';
		$itemFilter->value[] = 'Auction';
		$itemFilter->value[] = 'AuctionWithBIN';
		$request->itemFilter[] = $itemFilter;

		$request->itemFilter[] = new Types\ItemFilter(array(
		    'name' => 'MinPrice',
		    'value' => array('1.00')
		));

		$request->itemFilter[] = new Types\ItemFilter(array(
		    'name' => 'MaxPrice',
		    'value' => array('10.00')
		));

		$request->sortOrder = 'CurrentPriceHighest';
		$request->paginationInput = new Types\PaginationInput();
		$request->paginationInput->entriesPerPage = 10;
		$request->paginationInput->pageNumber = 1;

		$response = $service->findItemsAdvanced($request);

		if (isset($response->errorMessage)) {
		    foreach ($response->errorMessage->error as $error) {
		        printf("%s: %s\n\n",
		            $error->severity=== Enums\ErrorSeverity::C_ERROR ? 'Error' : 'Warning',
		            $error->message
		        );
		    }
		}

		echo "==================\nResults for page 1\n==================\n";

		if ($response->ack !== 'Failure') {
		    foreach ($response->searchResult->item as $item) {
		        printf("(%s) %s: %s %.2f\n",
		            $item->itemId,
		            $item->title,
		            $item->sellingStatus->currentPrice->currencyId,
		            $item->sellingStatus->currentPrice->value
		        );
		    }
		}

		$limit = min($response->paginationOutput->totalPages, 3);
		for ($pageNum = 2; $pageNum <= $limit; $pageNum++ ) {
		    $request->paginationInput->pageNumber = $pageNum;

		    $response = $service->findItemsAdvanced($request);

		    echo "==================\nResults for page $pageNum\n==================\n";

		    if ($response->ack !== 'Failure') {
		        foreach ($response->searchResult->item as $item) {
		            printf("(%s) %s: %s %.2f\n",
		                $item->itemId,
		                $item->title,
		                $item->sellingStatus->currentPrice->currencyId,
		                $item->sellingStatus->currentPrice->value
		            );
		        }
		    }
		}
	}
}
