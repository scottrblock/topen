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

<<<<<<< HEAD
         $url = 'https://api.twitter.com/1.1/search/tweets.json';
=======
          $url = 'https://api.twitter.com/1.1/search/tweets.json';
>>>>>>> a778960d5d04039c08c6b45128df70df6bfc7195
          $getfield = '?q=#sctop10&result_type=mixed&include_entities=true';
          $requestMethod = 'GET';
          $twitter = new TwitterAPIExchange($settings);
          $tweets = $twitter->setGetfield($getfield) 
                       ->buildOauth($url, $requestMethod) 
                       ->performRequest(); 

<<<<<<< HEAD
<<<<<<< HEAD
          $tweets = json_decode($tweets);
          foreach($tweets->statuses as $t){

            if (strlen($t->entities->media[0]->media_url) > 0 ){
              echo "<li><pre>";
                echo ( $t->text );
              echo "</pre></li>";
            }
           
           //echo "<li>" . $t->text . "</li>";
=======
=======

>>>>>>> c543fce8559319ba0d9fc77dfc8a02daf05369e7
          //echo $tweets;
          $tweets = json_decode($tweets);
          
          foreach($tweets->statuses as $t){
            
            if(isset($t->entities->media) && strlen($t->entities->media[0]->media_url) > 0){
              echo "<pre>" . $t->text . "</pre>";
            }
>>>>>>> a778960d5d04039c08c6b45128df70df6bfc7195
          }

        ?>
      </ul>
    </div>
  </div>

<?php 
   include_once("partials/footer.php");
?>  

