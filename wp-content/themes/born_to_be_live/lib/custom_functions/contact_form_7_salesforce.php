<?php
if( file_exists( 'contact-form-7/wp-contact-form-7.php' ) && is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ){
    add_action( 'wpcf7_before_send_mail', 'my_conversion' );
}

function my_conversion( $cf7 ) {
    $data = set_propBase_data( $cf7 );
    if(!sp_do_propBase( $data ))
        return false;
}

function set_propBase_data ( $cf7 ){
    $proenquiry['FirstName']   = $cf7->posted_data["your-firstname"];
    $proenquiry['LastName']    = $cf7->posted_data["your-lastname"];
    $proenquiry['PersonEmail'] = $cf7->posted_data["your-email"];
    $proenquiry['Phone']       = $cf7->posted_data["your-phone"];
    $proenquiry['Description'] = $cf7->posted_data["your-message"];
    
    //tracking code
    $proenquiry['Lead_Status__c']                 = 'Weblead';
    $proenquiry['Lead_Status__pc']                = 'Web Lead';
    $proenquiry['Lead_Source_SP__c']              = ($cf7->posted_data['source']) ? $cf7->posted_data['source'] : 'Website';
    $proenquiry['Original_Lead_Source__c']        = ($cf7->posted_data['source']) ? $cf7->posted_data['source'] : 'Website';
    $proenquiry['Source_Information__c']          = 'Vita Ventures';
    $proenquiry['Original_Source_Information__c'] = 'Vita Ventures';
    $proenquiry['Tracking_Country__c']            = get_country();
    $proenquiry['Website_Origin_c__c']            = (site_url() == 'http://www.selectproperty.ae')?'UAE':'UK';
    $proenquiry['Tracking_Page__c']               = $cf7->title;
    $proenquiry['IP_Address__c']                  = $_SERVER['REMOTE_ADDR'];
    $proenquiry['Web_Tracking_Note__c']           = (isset($cf7->posted_data['type'])) ? $cf7->posted_data['type'] : 'NO TYPE';
    $proenquiry['Preferred_Development__c']       = (isset($cf7->posted_data['development'])) ? $cf7->posted_data['development']:'Contact Us';
    $proenquiry['Preferred_Country__c']           = (site_url() == 'http://www.selectproperty.ae')?'Dubai':'United Kingdom';
    $proenquiry['success_page']                   = 'http://www.selectproperty.com/thank-you';
    
    return $proenquiry;
}

function sp_do_propBase( $data ){
    //Initialize the $query_string variable for later use
    $query_string = ""; 

    //If there are POST variables
    if ($data) {
        $query_string = http_build_query($data, '&');
        $query_string .= '&return_error=false';
    }
    //Check to see if cURL is installed ...
    if (!function_exists('curl_init')){
        echo 'Sorry cURL is not installed!';
        return false;
    }

    //The original form action URL from Step 2 :)
    $url = 'https://selectproperty.secure.force.com/pb__WebserviceWebToProspect?'.$query_string;

    //Open cURL connection
    $ch = curl_init();

    //Set the url, number of POST vars, POST data
    curl_setopt($ch, CURLOPT_URL, $url);

    //Set some settings that make it all work :)
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_NOBODY, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);

    //Execute SalesForce web to lead PHP cURL
    if(curl_exec($ch) === false){
        echo 'Curl error: ' . curl_error($ch);
        return false;
    }

    //close cURL connection
    curl_close($ch);
    
    return true;
} 
?>