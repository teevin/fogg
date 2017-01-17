<?php
   /*
   Plugin Name: Rest Client
   Plugin URI: http://my-awesomeness-emporium.com
   Description: communicate with an api 
   Version: 1.2
   Author: Mr. Awesome
   Author URI: http://mrtotallyawesome.com
   License: GPL2
   */

function get_rest(){
	// create curl resource
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, "http://localhost/fogg/admin/up/6");

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // $output contains the output string
        $output = curl_exec($ch);
        $output = json_decode($output);
        if ($output != FALSE) {
        	foreach ($output as $key ) {
        	echo $key->id."\t".$key->name."\t".$key->fact."\t".$key->email."\t"."<br>";
        	}
        }else{
        	echo "curl error";
        }
        

        // close curl resource to free up system resources
        curl_close($ch);
}
?>
