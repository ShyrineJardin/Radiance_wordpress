<?php

namespace AiosInitialSetup\Helpers\Classes;

trait IntegrationsTrait
{
    /**
     * Add leads to Follow Up Boss using the API.
     * 
     * @param string $apiKey The API key for authentication.
     * @param array $dataset The dataset containing lead information.
     * @param array $bodyArray The body array containing lead details.
     * 
     * @return bool True on success, false on failure.
     */
    private function fub_add_leads($apiKey, $dataset = [], $bodyArray = []) 
    {
        $message = "";

        foreach ( $bodyArray as $arr ) {
            foreach ( $arr as $k => $v ) {
                $message .= str_replace( '_', ' ', ucfirst( $k ) ) . ": " . ( is_array( $v ) ? implode( ", ", $v ) : $v ) . "\n";
            }
        }

        return $this->requestViaCurl(
            "basic-base64", 
            "application/json",
            "https://api.followupboss.com/v1/events",
            "POST",
            $apiKey,
            [
                "pageUrl"			=> $dataset['pageUrl'],
                "source"            => $dataset['source'],
                "type"              => "Inquiry",
                "message" 			=> "New lead activity notification \n" . $message,
                "person" 			=> [
                    "firstName"     => $dataset['firstName'],
                    "lastName"      => $dataset['lastName'],
                    "emails"        =>  [
                        [
                            "value" => $dataset['email']
                        ] 
                    ],
                    "phones"        =>  [
                        [
                            "value" => $dataset['phone']
                        ] 
                    ],
                    "tags"        	=> $dataset['tags'],
                    "assignedTo"    => $dataset['assignedTo']
                ]
            ]
        ) ;
    }

    /**
     * Add leads to Follow Up Boss using the API.
     * 
     * @param string $apiKey The API key for authentication.
     * @param array $dataset The dataset containing lead information.
     * @param array $bodyArray The body array containing lead details.
     * 
     * @return bool True on success, false on failure.
     */
    private function mailchimp_add_leads($apiKey, $audienceId, $dataset = []) 
    {
        $dcParts = explode('-', $apiKey);
        $dc = isset($dcParts[1]) ? $dcParts[1] : null;

        if (is_null($dc)) {
            return false;
        }

        return $this->requestViaCurl(
            "bearer", 
            "application/json",
            "https://$dc.api.mailchimp.com/3.0/lists/$audienceId/members",
            "POST",
            $apiKey,
            [
                "email_address" 	=> $dataset['email'],
                "status" 			=> "subscribed",
                "merge_fields" 	=> [
                    "FNAME" 		=> $dataset['firstName'],
                    "LNAME" 		=> $dataset['lastName'],
                ]
            ]
        ) ;
    }

    /**
     * Send a request to an external API using cURL.
     * 
     * @param string $authType The type of authentication to use (e.g., "basic-base64", "bearer").
     * @param string $contentType The content type of the request (e.g., "application/json").
     * @param string $url The URL to send the request to.
     * @param string $requestType The HTTP request method (e.g., "POST", "GET").
     * @param string $apiKey The API key for authentication.
     * @param array $data The data to send in the request body.
     * 
     * @return bool True on success, false on failure.
     */
    private function requestViaCurl( 
        $authType = "basic-base64", 
        $contentType = "application/json",
        $url, 
        $requestType, 
        $apiKey, 
        $data 
    )
	{
        switch ($authType) {
            case "bearer":
                $auth = "Bearer $apiKey";
                break;
            case "basic-base64":
                $auth = "Basic " . base64_encode("$apiKey:");
                break;
            default:
                $auth = "Basic $apiKey";
                break;
        }

        $httpHeaders = [
            "authorization: $auth",
            "content-type: $contentType",
        ];

		$curl = curl_init();
        $curl_options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $requestType,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => $httpHeaders,
		];
        
		curl_setopt_array($curl, $curl_options);

		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);

		if ($err) {
			return false;
		} else {
			return true;
		}
    }
}