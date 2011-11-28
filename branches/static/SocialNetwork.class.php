<?php
require DS."modules/twitter/twitteroauth.php";
require DS."modules/facebook/facebook.php";

/**
 * @author remi
 * @version 1.1
 */
class SocialNetwork
{

    const TWITTER_CONSUMER_KEY      = "";
    const TWITTER_CONSUMER_SECRET   = "";
    const TWITTER_TOKEN             = "";
    const TWITTER_TOKEN_SECRET      = "";

    const BITLY_LOGIN               = "";
    const BITLY_API_KEY             = "";
    
    const GOOGLE_API_KEY			= "";
    

    const FB_ID_APPLICATION         = "";
    const FB_API_KEY                = "";
    const FB_API_SECRET             = "";
    const FB_FAN_PAGE_ID            = "";


	const bitly 					= false;
	const google					= false;

    static public function postToTwitter($message)
    {
        $message = self::shortMessage($message);
       
        $connection = new TwitterOAuth(self::TWITTER_CONSUMER_KEY, self::TWITTER_CONSUMER_SECRET, self::TWITTER_TOKEN, self::TWITTER_TOKEN_SECRET);
        $twitterInfos = $connection->get('account/verify_credentials');

        if (200 == $connection->http_code) {
            $parameters = array('status' => $message);
            $status = $connection->post('statuses/update', $parameters);

            return $status;
        }
        
        return "";
    }

    static public function shortenURL($url)
    {
    	if(self::bitly)
    	{
			$eUrl = urlencode($url);
        	$ret = self::get_curl("http://api.bitly.com/v3/shorten?login=".self::BITLY_LOGIN."&apiKey=".self::BITLY_API_KEY."&longUrl=".$eUrl."&format=json");
        	
        	$json = json_decode($f,true);
			
        	return $json["data"]["url"]; 	
    	}
    	elseif(self::google)
    	{
    		$ret = self::get_curl("https://www.googleapis.com/urlshortener/v1/url?key=".self::GOOGLE_API_KEY,json_encode(array("longUrl"=>$url)),array("Content-Type: application/json"));
    		$json = json_decode($ret);
    		
    		return $json->id;
    	}
        
    }
    
    static private function get_curl( $url, $params = array(), $contentType=array() )
    {
    	$ch = curl_init($url);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    	curl_setopt($ch, CURLOPT_HEADER, false);
    	if(!empty($contentType))
    		curl_setopt($ch,CURLOPT_HTTPHEADER,$contentType);

    	if(!empty($params))
    	{
    		curl_setopt($ch, CURLOPT_POST,true);
			curl_setopt($ch, CURLOPT_POSTFIELDS,$params);	
    	}
    	
    	$data = curl_exec($ch);
    	curl_close($ch);
    	return $data;
    }

    static function shortMessage($message)
    {
        $in = '`((?:https?|ftp)://\S+?)(?=[[:punct:]]?(?:\s|\Z)|\Z)`';
            
        $text = preg_replace_callback($in, array("SocialNetwork","shortCallback"), $message);
        return $text;
    }
    
    protected function shortCallback($match)
    {
        return self::shortenURL($match[0]);
    }


    static public function postOnFacebookFanPage($message,$title,$caption,$picture,$description,$link,$actions)
    {
        try{
                $facebook = new Facebook(array(
                        'appId'  => self::FB_ID_APPLICATION,
                        'secret' => self::FB_API_SECRET,
                        'cookie' => true,
                ));
        }
        catch(FacebookApiException $e){
                print_r($e);
        }


        $attachment = array(
            'message' => $message,
            'name' => $title,
            'link' => $link,
            'description' => $description,
            'picture' => $picture,
            'actions' => $actions
        );
        try{
                $result = $facebook->api('/'.self::FB_FAN_PAGE_ID.'/feed/', 'post', $attachment);
                return $result;
        }
        catch(FacebookApiException $e){
                print_r($e);
        }


    }

}
?>
