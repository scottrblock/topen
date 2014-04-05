<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-47431114-2', 'twitterplays.com');
  ga('send', 'pageview');

</script>

<?php 
   include_once("partials/header.php");
?>    
  <div class="container">
    <div class="col-md-12">      
      <ul class="main-contain col-md-8 col-md-offset-2">
      
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

          $all_tweets = array();

          # https://github.com/J7mbo/twitter-api-php

          $url = 'https://api.twitter.com/1.1/search/tweets.json';
          $getfield = '?q=%23sctop10&result_type=mixed&count=100&include_entities=true';
          $requestMethod = 'GET';
          $twitter = new TwitterAPIExchange($settings);
          $tweets = json_decode($twitter->setGetfield($getfield) 
                       ->buildOauth($url, $requestMethod) 
                       ->performRequest()); 


          $url2 = 'https://api.twitter.com/1.1/search/tweets.json';
          $getfield2 = '?q=@sctop10&result_type=mixed&count=100&include_entities=true';
          $tweets2 = json_decode($twitter->setGetfield($getfield2) 
                       ->buildOauth($url2, $requestMethod) 
                       ->performRequest()); 

          $all_tweets = array_merge($tweets->statuses, $tweets2->statuses);

          # avoid duplicates by keeping track of used youtube videos
          $youtube_ids = array();

          # loop through all tweets
          foreach($all_tweets as $t){
            
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
                $question_i = strpos($youtube_id, "?");

                if ($question_i){
                  $youtube_id = substr($youtube_id, 0, $question_i);
                }
               
                if(in_array($youtube_id, $youtube_ids)){
                  continue;
                }

                array_push($youtube_ids, $youtube_id);
              } else{
                continue;
              }

              # add avi and twitter handle
              $user_name = $t->user->screen_name;

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

              echo "<li class='tweet-container'>";
                echo "<div class='user-icon'>";
                  echo "<a href='http://twitter.com/" . $user_name . "'>";
                    echo "<img class='user-avatar' src='" . $t->user->profile_image_url . "'/>";
                  echo "</a>";
                echo "</div>";

                echo "<div class='user-handle'>";
                  echo "<a href='http://twitter.com/" . $user_name . "'>";
                    echo "@" . $user_name;
                  echo "</a>";
                echo "</div>";

                echo "<div class='tweet-user-media-wrap clearfix'>";
                  echo "<div class='user-tweet-area'>";

                    echo "<div class='tweet-time'>";
                      $date = strtotime($t->created_at);
                      echo ago($date);
                    echo "</div>";
                    
                    echo "<div class='tweet-text'>";
                      echo "<p>" . $i . "</p>";
                    echo "</div>";

                  echo "</div>";

                  echo "<div class='tweet-media'>";
                    echo '<iframe src="//www.youtube.com/embed/' . $youtube_id . '" frameborder="0" allowfullscreen></iframe>';
                  echo "</div>";
                
                echo "</div>";

              echo "</li>";

            }
          }

          function ago($time)
          {
             $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
             $lengths = array("60","60","24","7","4.35","12","10");

             $now = time();

                 $difference     = $now - $time;
                 $tense         = "ago";

             for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
                 $difference /= $lengths[$j];
             }

             $difference = round($difference);

             if($difference != 1) {
                 $periods[$j].= "s";
             }

             return "$difference $periods[$j] ago ";
          }

        
        ?>
      </ul>
    </div>
  </div>

<?php 
   include_once("partials/footer.php");
?>  

