<?php 
   include_once("partials/header.php");
?>    
  <div class="container">
    <div class="col-md-12">
      <h1>TwitterPlays</h1>

      
      <ul>
      
        <?php
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

         # https://github.com/J7mbo/twitter-api-php

          $url = 'https://api.twitter.com/1.1/search/tweets.json';
          $getfield = '?q=%23sctop10&result_type=mixed&count=200&include_entities=true';
          $requestMethod = 'GET';
          $twitter = new TwitterAPIExchange($settings);
          $tweets = json_decode($twitter->setGetfield($getfield) 
                       ->buildOauth($url, $requestMethod) 
                       ->performRequest()); 


          # avoid duplicates by keeping track of used youtube videos
          $youtube_ids = array();

          # loop through all tweets
          foreach($tweets->statuses as $t){
            
            # only tweets that have a link and are not retweets
            if( substr($t->text, 0, 2) !== 'RT' && strpos($t->text, 'RT') == false){
              if (!is_array($t->entities->urls)){

                continue;
              } else{
                $boner_url = $t->entities->urls[0]->expanded_url;
                $flacid_url = $t->entities->urls[0]->url;
              }

              # extract youtube id from link
              $youtube_string = "http://youtu.be/";
              if( strpos($boner_url, $youtube_string) !== false ){
                $youtube_id = str_replace($youtube_string, "", $boner_url);

                if(in_array($youtube_id, $youtube_ids)){
                  continue;
                }

                array_push($youtube_ids, $youtube_id);
              } else{
                continue;
              }

              # add avi and twitter handle
              $user_name = $t->user->screen_name;

             /* echo "<pre>";
              print_r($t);
              echo "</pre>";*/
              echo "<div class='user-info'>";
                echo "<a href='http://twitter.com/" . $user_name . "'>";
                  echo "<img class='user-avatar' src='" . $t->user->profile_image_url . "'/>";
                  echo "@" . $user_name;
                echo "</a>";
              echo "</div>";

              # remove things from the tweet
              $a = str_replace(" " . $flacid_url, "", $t->text);
              $b = str_replace(" #SCtop10", "", $a);
              $c = str_replace(" #sctop10", "", $b);
              $d = str_replace(" #SCTop10", "", $c);
              $e = str_replace("#SCTop10 ", "", $d);
              $f = str_replace("#SCtop10 ", "", $e);
              $g = str_replace("#sctop10 ", "", $f);
              $h = str_replace("»", "", $g);
              $i = str_replace($flacid_url . " ", "", $h);
              echo "<div>" . $i . "</div>";
              echo '<iframe width="560" height="315" src="//www.youtube.com/embed/' . $youtube_id . '" frameborder="0" allowfullscreen></iframe>';
            }
          }

        
        ?>
      </ul>
    </div>
  </div>

<?php 
   include_once("partials/footer.php");
?>  

