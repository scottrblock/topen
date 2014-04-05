<?php 
   include_once("partials/header.php");
?>    
  <div class="container">
    <div class="col-md-12">
      <h1>Hello World</h1>

      <h2><?php echo "Hello from php";?></h2>

      <?php
      #kevin was here
        define('TWEET_LIMIT', 5);
        define('TWITTER_USERNAME', 'theMikeSikora');
        define('CONSUMER_KEY', 'n5SbbMJCKFEHXlPHt5ELSjCVN');
        define('CONSUMER_SECRET', 'd2bPuSfHRM8UtzJDwiEBXClLWRQ7VHdaTbqI9BCl7tZ5eIJmK4');
        define('ACCESS_TOKEN', '480963993-3jvB2ikkBkqCizENWiBVraotcIdHziuKjw2ftOq4');
        define('ACCESS_TOKEN_SECRET', 'B3omhGUKDLu0dJgwcRVsN290FaeYTCz7sKkWleQBYOm4Y');

        require_once('TwitterAPIExchange.php');

        /** Set access tokens here - see: https://dev.twitter.com/apps/ **/
        $settings = array(
            'oauth_access_token' => ACCESS_TOKEN,
            'oauth_access_token_secret' => ACCESS_TOKEN_SECRET,
            'consumer_key' => CONSUMER_KEY,
            'consumer_secret' => CONSUMER_SECRET
        );

        //https://github.com/J7mbo/twitter-api-php

        $url = 'https://api.twitter.com/1.1/followers/list.json';
        $getfield = '?username=' . TWITTER_USERNAME;
        $requestMethod = 'GET';
        $twitter = new TwitterAPIExchange($settings);
        echo $twitter->setGetfield($getfield)
                     ->buildOauth($url, $requestMethod)
                     ->performRequest(); 


      ?>
    </div>
  </div>

<?php 
   include_once("partials/footer.php");
?>  

