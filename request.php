<?php

// API key.
$API_KEY = "85RiZs2_TOOVp7468rtKldyA2Go1GJAe34uGWLlKVMp-TnHsGDAKNUO20tR8BloFcQ2KV4JS9in7Ie3ol99UEpSOxkeSlvqkxJhkHIAqC6Q8__29Ib6RNrG2t8GeWnYx"; 


// API constants, you shouldn't have to change these.
$API_HOST = 'https://api.yelp.com';
$SEARCH_PATH = '/v3/businesses/search';
$BUSINESS_PATH = '/v3/businesses/';
$REVIEW_PATH = '/reviews';

// Parameters to pass to API call
$SEARCH_LIMIT = 10;
$SORT_BY = 'rating';


/** 
 * Makes a request to the Yelp API and returns the response
 * 
 * @param    $host    The domain host of the API 
 * @param    $path    The path of the API after the domain.
 * @param    $url_params    Array of query-string parameters.
 * @return   The JSON response from the request      
 */
function request($host, $path, $url_params = array()) {
    // Send Yelp API Call
    try {
        $curl = curl_init();
        if (FALSE === $curl)
            throw new Exception('Failed to initialize');

        $url = $host . $path . "?" . http_build_query($url_params);
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,  // Capture response.
            CURLOPT_ENCODING => "",  // Accept gzip/deflate/whatever.
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer " . $GLOBALS['API_KEY'],
                "cache-control: no-cache",
            ),
        ));

        $response = curl_exec($curl);

        if (FALSE === $response)
            throw new Exception(curl_error($curl), curl_errno($curl));
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if (200 != $http_status)
            throw new Exception($response, $http_status);

        curl_close($curl);
    } catch(Exception $e) {
        trigger_error(sprintf(
            'Curl failed with error #%d: %s',
            $e->getCode(), $e->getMessage()),
            E_USER_ERROR);
    }

    return $response;
}

/**
 * Query the Search API by a search term and location 
 * 
 * @param    $category        The search term passed to the API 
 * @param    $location    The search location passed to the API 
 * @return   The JSON response from the request 
 */
function search($category, $location) {
    $url_params = array();
    
    $url_params['categories'] = $category;
    $url_params['location'] = $location;
    $url_params['limit'] = $GLOBALS['SEARCH_LIMIT'];
    $url_params['sort_by'] = $GLOBALS['SORT_BY'];
    
    return request($GLOBALS['API_HOST'], $GLOBALS['SEARCH_PATH'], $url_params);
}

/**
 * Query the Review API by business_id
 * 
 * @param    $business_id    The ID of the business to query
 * @return   The JSON response from the request 
 */
function get_reviews($business_id) {
    $review_path = $GLOBALS['BUSINESS_PATH'] . urlencode($business_id) . $GLOBALS['REVIEW_PATH'];
    
    return request($GLOBALS['API_HOST'], $review_path);
}

/**
 * Queries the API by the input values from the user 
 * 
 * @param    $category        The search term to query
 * @param    $location    The location of the business to query
function query_api($category, $location) {     
    $response = search($category, $location);

    return $response;
}
 */
?>
