<?php
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
 * An user token is required when using the Trading service.
 *
 * For more information about getting your user tokens, see:
 * http://devbay.net/sdk/guides/application-keys/
 */

/**
 * Send the request to the GeteBayOfficialTime service operation.
 *
 * For more information about calling a service operation, see:
 * http://devbay.net/sdk/guides/getting-started/#service-operation
 */
/**
 * Output the result of calling the service operation.
 *
 * For more information about working with the service response object, see:
 * http://devbay.net/sdk/guides/getting-started/#response-object
 */
require 'vendor/autoload.php';

use \DTS\eBaySDK\Constants;
use \DTS\eBaySDK\Trading\Services;
use \DTS\eBaySDK\Trading\Types;

class GetOfficalEbayTimeController extends BaseController{

	function start(){
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

}
