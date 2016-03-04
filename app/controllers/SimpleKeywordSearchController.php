<?php
    
require 'vendor/autoload.php';

use \DTS\eBaySDK\Constants;
use \DTS\eBaySDK\Finding\Services;
use \DTS\eBaySDK\Finding\Types;
// $config;

class SimpleKeywordSearchController extends BaseController
{
  

    function __construct()
    {
        // dd($config);
        // $configu = Config::get('configuration');
       /* $config[] = $config;
        dd($config);*/

    }
    public function start(){
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
    
}

    /**
     * Copyright 2014 David T. Sadler
     *
     * Licensed under the Apache License, Version 2.0 (the "License");
     * you may not use this file except in compliance with the License.
     * You may obtain a copy of the License at
     *
     * http://www.apache.org/licenses/LICENSE-2.0
     *
     * Unless required by applicable law or agreed to in writing, software
     * distributed under the License is distributed on an "AS IS" BASIS,
     * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
     * See the License for the specific language governing permissions and
     * limitations under the License.
     */
    /**
     * Include the SDK by using the autoloader from Composer.
     */
 // require __DIR__.'/../vendor/autoload.php';
    /**
     * Include the configuration values.
     *
     * Ensure that you have edited the configuration.php file 
     * to include your application keys.
     * 
     * For more information about getting your application keys, see:
     * http://devbay.net/sdk/guides/application-keys/
     */
    /**
     * The namespaces provided by the SDK.
     */

    /**
     * Create the service object.
     *
     * For more information about creating a service object, see:
     * http://devbay.net/sdk/guides/getting-started/#service-object
     */

/**
 * Create the request object.
 *
 * For more information about creating a request object, see:
 * http://devbay.net/sdk/guides/getting-started/#request-object
 */
/**
 * Assign the keywords.
 */
/**
 * Send the request to the findItemsByKeywords service operation.
 *
 * For more information about calling a service operation, see:
 * http://devbay.net/sdk/guides/getting-started/#service-operation
 */
/**
 * Output the result of the search.
 *
 * For more information about working with the service response object, see:
 * http://devbay.net/sdk/guides/getting-started/#response-object
 */
