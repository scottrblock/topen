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

          $tweets = tweetsQuery('%23sctop10', $settings);
          $tweets2 = tweetsQuery('@sctop10', $settings);
          $tweets3 = tweetsQuery('@sportscenter', $settings);
          $tweets4 = tweetsQuery('@mlb', $settings);
          $tweets5 = tweetsQuery('@nba', $settings);
          $tweets6 = tweetsQuery('@nhl', $settings);
          $tweets7 = tweetsQuery('@nfl', $settings);
          $tweets8 = tweetsQuery('@espn', $settings);
          $tweets9 = tweetsQuery('%23scnottop10', $settings);

          $all_tweets = array_merge($tweets->statuses, $tweets2->statuses, $tweets3->statuses, 
                            $tweets4->statuses, $tweets5->statuses, $tweets6->statuses, 
                            $tweets7->statuses, $tweets8->statuses, $tweets9->statuses);

          # avoid duplicates by keeping track of used youtube videos
          $youtube_ids = array();

          # loop through all tweets
          foreach($all_tweets as $t){
            # only tweets that have a link and are not retweets
            if( substr($t->text, 0, 2) !== 'RT' && strpos($t->text, 'RT') == false){
              if (!is_array($t->entities->urls) || $t->retweet_count < 5 && $t->favorite_count < 5){
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
              $b = str_replace("»", "", $a);
              $c = str_replace($flacid_url . " ", "", $b);
              $tweetText = $c;
              $tweetText = preg_replace('/@([a-zA-Z0-9_]+)/', '<a class="tweet-link" href="http://www.twitter.com/$1" target="_blank">@$1</a>', $tweetText);
              $tweetText = preg_replace('/#([a-zA-Z0-9_]+)/', '<a class="tweet-link" href="http://array_search(needle, haystack).twitter.com/search?q=$1" target="_blank">#$1</a>', $tweetText);

              echo "<li class='tweet-container'>";
                echo "<div class='user-icon'>";
                  echo "<a href='http://twitter.com/" . $user_name . "'>";
                    echo "<img class='user-avatar' src='" . $t->user->profile_image_url . "'/>";
                  echo "</a>";
                echo "</div>";

                echo "<div class='tweet-user-media-wrap clearfix'>";
                  echo "<div class='user-tweet-area'>";
                    
                    echo "<div class='tweet-text'>";
                      echo "<div class='tweet-header'>";
                        echo "<a class='user-handle' href='http://twitter.com/" . $user_name . "'>";
                    echo "@" . $user_name;
                  echo "</a> | ";
                        $date = strtotime($t->created_at);
                        echo ago($date);
                      echo "</div>";
                      echo "<p>" . $tweetText . "</p>";
                    echo "</div>";

                  echo "</div>";

                  echo "<div class='tweet-media'>";
                    echo '<iframe src="//www.youtube.com/embed/' . $youtube_id . '" frameborder="0" allowfullscreen></iframe>';
                  echo "</div>";
                
                echo "</div>";

              echo "</li>";

            }
          }

          function tweetsQuery($queryStr, $settings){
              $url = 'https://api.twitter.com/1.1/search/tweets.json';
              $getfield = '?q=' . $queryStr . '&result_type=mixed&count=100&include_entities=true';
              $requestMethod = 'GET';
              $twitter = new TwitterAPIExchange($settings);
              return json_decode($twitter->setGetfield($getfield) 
                           ->buildOauth($url, $requestMethod) 
                           ->performRequest()); 
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

