<?php 
   include_once("partials/header.php");
?>    
  <div class="container">
    <div class="col-md-12">
      <h1>Hello World</h1>

      <h2><?php echo "Hello from php";?></h2>
      
      <ul>
      
        <?php
        #kevin was here
          define('TWEET_LIMIT', 5);
          define('TWITTER_USERNAME', 'theMikeSikora');
          define('CONSUMER_KEY', 'b6J0iMKWMyeDcXKVZuxw');
          define('CONSUMER_SECRET', 'shkIvWQnTWS2tphJQi2EASnlzGaSZecI6fvrxmHSk');
          define('ACCESS_TOKEN', '480963993-dVWPw1Gn9gYYx0EKotTh59gdq1NmdLIoetKJUT9R');
          define('ACCESS_TOKEN_SECRET', 'P9TciGLDqFrC83Sx5LTlx0yVlI8otiM4z6kYuSshC6o3U');

          require_once('TwitterAPIExchange.php');

          /** Set access tokens here - see: https://dev.twitter.com/apps/ **/
          $settings = array(
              'oauth_access_token' => ACCESS_TOKEN,
              'oauth_access_token_secret' => ACCESS_TOKEN_SECRET,
              'consumer_key' => CONSUMER_KEY,
              'consumer_secret' => CONSUMER_SECRET
          );

          https://github.com/J7mbo/twitter-api-php

          $url = 'https://api.twitter.com/1.1/search/tweets.json';
          $getfield = '?q=%23sctop10&result_type=mixed&include_entities=true&count=200';
          $requestMethod = 'GET';
          $twitter = new TwitterAPIExchange($settings);
          $tweets = $twitter->setGetfield($getfield) 
                       ->buildOauth($url, $requestMethod) 
                       ->performRequest(); 

          //echo $tweets;
          $tweets = json_decode($tweets);

          foreach($tweets->statuses as $t){
            
            if(strpos($t->text, 'http://t.co') !== false && substr($t->text, 0, 2) !== 'RT'){
              preg_match("/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/", $t->text, $link);
              if(is_array($link)){
                $temp = expandShortUrl($link[0]);
              }else{
                $temp = expandShortUrl($link);
              }
              if($temp === "null"){
                continue;
              }
              echo "<pre>" . $t->text . "\n" . $temp . "</pre>";
            }
          }

          function expandShortUrl($url) {
            $headers = get_headers($url, 1);
            if(isset($headers['location'])){
              if(!is_array($headers['location'])){
                $out = $headers['location'];
              }else {
                $out = $headers['location'][0];
              }
              return $out;
            }else {
              return "null";
            }
          }

        ?>
      </ul>
    </div>
  </div>

<?php 
   include_once("partials/footer.php");
?>  

