<?php
/**
 * Plugin Name:       Post Waterfall 
 * Description:       Displays social media posts in a masonry layout
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Kevin McGuire
 * Author URI:        https://kpmcguire.github.io
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       post-waterfall
 * Domain Path:       /languages
 */

 

function post_waterfall_register_settings() {
    add_option( 'post_waterfall_oauth_access_token', '');
    register_setting( 'post_waterfall_options_group', 'post_waterfall_oauth_access_token', 'post_waterfall_callback' );
    
    add_option( 'post_waterfall_oauth_access_token_secret', '');
    register_setting( 'post_waterfall_options_group', 'post_waterfall_oauth_access_token_secret', 'post_waterfall_callback' ); 

    add_option( 'post_waterfall_consumer_key', '');
    register_setting( 'post_waterfall_options_group', 'post_waterfall_consumer_key', 'post_waterfall_callback' );    
    
    add_option( 'post_waterfall_consumer_secret', '');
    register_setting( 'post_waterfall_options_group', 'post_waterfall_consumer_secret', 'post_waterfall_callback' );        
    
    add_option( 'post_waterfall_username', 'darth');
    register_setting( 'post_waterfall_options_group', 'post_waterfall_username', 'post_waterfall_callback' );        
    
    add_option( 'post_waterfall_count', '24');
    register_setting( 'post_waterfall_options_group', 'post_waterfall_count', 'post_waterfall_callback' );        
    
    add_option( 'post_waterfall_columns', '3');
    register_setting( 'post_waterfall_options_group', 'post_waterfall_columns', 'post_waterfall_callback' );            
    
}
add_action( 'admin_init', 'post_waterfall_register_settings' );

function post_waterfall_callback($input) {
    $new_input = array();

    $new_input = trim($input);
    
    if (empty($new_input)) {
        echo($input);
        echo($new_input);
        add_settings_error(
            'plugin:post_waterfall_options_group',
            'entry-is-empty',
            "please ensure all the fields have been filled out"
        );
    } else {
        return $new_input;    
    }    
}

function post_waterfall_register_options_page() {
    add_options_page('Post Waterfall Options', 'Post Waterfall', 'manage_options', 'post-waterfall', 'post_waterfall_options_page');
}
add_action('admin_menu', 'post_waterfall_register_options_page');
 
 
function post_waterfall_options_page(){
?>

  <style>
    .form-wrapper + .form-wrapper {
        margin-top: 2rem;
    }
    .form-wrapper label {
        display: block;
        font-weight: bold;
        margin-bottom: 0.25rem;
    }
    
    .form-wrapper input {
        width: 100%;
        max-width: 500px;
    }
    
    .form-wrapper + hr {
        margin: 2rem 0;
    }
    
    .columns-wrapper {
        display: flex;
    }
    
    @media screen and (max-width: 768px) {
        .columns-wrapper {
            display: block;
        }   
    }
    
    .col {
        flex: 1;
        padding: 0 2rem;
    }
    @media screen and (max-width: 768px) {
        .col {
            padding: 0;
        }   
    }    
    
    .form-column {
        flex: 2;
        padding-left: 0;
        padding-right: 2rem;
    }
    @media screen and (max-width: 768px) {
        .col {
            padding-right: 0;
        }   
    }        
    
  </style>

  <div class='columns-wrapper'>
  <div class='col form-column'>
  <div class='errors'>

  </div>      
  <h2>Post Waterfall Settings</h2>
  <form method="post" action="options.php">
  <?php settings_fields( 'post_waterfall_options_group' ); ?>
  <h3>Twitter API Access Information</h3>
  <p>In order to use Post Waterfall, you need to have a <a href="https://developer.twitter.com">Twitter Developer</a> account and set up an App. Once you've done that, come back here and put the account access data in these fields.
  
  <p>
    Once the plugin is set up, you can place it using the shortcode 
    <strong>[postwaterfall]</strong>
  </p>
  
  <div class='form-wrapper'>
    <label for="oat">OAUTH Access Token</label>
    <input type="text" id="oat" name="post_waterfall_oauth_access_token" value="<?php echo get_option('post_waterfall_oauth_access_token'); ?>" />
  </div>
  
  <div class='form-wrapper'>
    <label for="oats">OAUTH Access Token Secret</label>
    <input type="text" id="oats" name="post_waterfall_oauth_access_token_secret" value="<?php echo get_option('post_waterfall_oauth_access_token_secret'); ?>" />
  </div>
  
  <div class='form-wrapper'>
    <label for="ck">Consumer Key</label>
    <input type="text" id="ck" name="post_waterfall_consumer_key" value="<?php echo get_option('post_waterfall_consumer_key'); ?>" />
  </div>
  
  <div class='form-wrapper'>  
    <label for="cs">Consumer Secret</label>
    <input type="text" id="cs" name="post_waterfall_consumer_secret" value="<?php echo get_option('post_waterfall_consumer_secret'); ?>" />
  </div>
    
  <hr>
  
  <h2>Display options</h2>
  <div class='form-wrapper'>
    <label for="un">Username to display tweets from</label>
    <input type="text" id="un" name="post_waterfall_username" value="<?php echo get_option('post_waterfall_username'); ?>" />
  </div>
  
  <div class='form-wrapper'>
    <label for="count">Number of tweets to show</label>
    <input type="text" id="count" name="post_waterfall_count" value="<?php echo get_option('post_waterfall_count'); ?>" />
  </div> 
  
  <div class='form-wrapper'>
    <label for="columns">Max Number of Columns</label>
    <input type="text" id="columns" name="post_waterfall_columns" value="<?php echo get_option('post_waterfall_columns'); ?>" />
  </div>   
  
  <?php  submit_button(); ?>
  </form>
  </div>
  <div class='col'>
      <h2>Like Post Waterfall?</h2>
      <p>If you're using Post Waterfall and enjoying it, please consider making a donation to support its continued development.</p>

      <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="kpmcguire@gmail.com">
<input type="hidden" name="lc" value="US">
<input type="hidden" name="button_subtype" value="services">
<input type="hidden" name="no_note" value="0">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="bn" value="PP-BuyNowBF:btn_paynow_SM.gif:NonHostedGuest">
<table>
<tr><td><input type="hidden" name="on0" value="Amounts">Amounts</td></tr><tr><td><select name="os0">
	<option value="Small">Small $5.00 USD</option>
	<option value="Medium">Medium $20.00 USD</option>
	<option value="Large">Large $50.00 USD</option>
</select> </td></tr>
</table>
<input type="hidden" name="option_select0" value="Small">
<input type="hidden" name="option_amount0" value="5.00">
<input type="hidden" name="option_select1" value="Medium">
<input type="hidden" name="option_amount1" value="20.00">
<input type="hidden" name="option_select2" value="Large">
<input type="hidden" name="option_amount2" value="50.00">
<input type="hidden" name="option_index" value="0">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_paynow_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
      
      

  </div>
<?php
} 

require_once('inc/TwitterAPIExchange.php');
require_once('inc/Autolink.php');
require_once('inc/TimeElapsed.php');

function tweetWaterfall($tw_username, $tw_count, $tw_oat, $tw_oats, $tw_ck, $tw_cs, $tw_columns) {
    $username = $tw_username;
    $count = $tw_count;
    $columns = $tw_columns;

    $all_content = [];
    $replies = [];
    
    $settings = array(
            'oauth_access_token' => $tw_oat,
            'oauth_access_token_secret' => $tw_oats,
            'consumer_key' => $tw_ck,
            'consumer_secret' => $tw_cs
    );
    
    $url = "https://api.twitter.com/1.1/statuses/user_timeline.json";
    
    $show_url = "https://api.twitter.com/1.1/statuses/lookup.json";
    
    $requestMethod = "GET";
    
    $getfield = "?screen_name={$username}&count={$count}";
    
    $twitter = new TwitterAPIExchange($settings);
    
    $image_path = plugin_dir_url( __FILE__ );
    
    $string = json_decode($twitter->setGetfield($getfield)->buildOauth($url, $requestMethod)->performRequest(),$assoc = TRUE);
    
    if(array_key_exists("errors", $string)) {
        echo "<h3>Sorry, there was a problem.</h3><p>Twitter returned the following error message:</p><p><em>".$string[errors][0]["message"]."</em></p>";
        exit();
    }
            
    foreach($string as $t) {
            $tweet_id = $t['id_str'];
            $orig_user = $t['user']['screen_name'];
            $orig_user_name = $t['user']['name'];
            $orig_user_img = str_replace('_normal', "", $t['user']['profile_image_url_https']);
    
                            
            if (isset($t['retweeted_status'])) {
                    $rt_user = $t['retweeted_status']['user']['screen_name'];
                    $rt_user_name = $t['retweeted_status']['user']['name'];
                    
                    $rt_user_img = str_replace('_normal', "", $t['retweeted_status']['user']['profile_image_url_https']);
                    
                    $text = $t['retweeted_status']['text'];
    
            } else {
                    $text;
                    $text = $t['text'];
                    $rt_user = '';
                    $rt_user_name = '';
                    $rt_user_img = '';
            }
            
            $time = new DateTime($t['created_at']);
            $timestamp = $time->format('c');
            
            if(isset($t['entities']['media'][0]['media_url'])) {
                    $image = $t['entities']['media'][0]['media_url'];
                    $media_type = $t['entities']['media'][0]['type'];
            } else {
                    $image = '';
                    $media_type = '';
            }
            
            if(isset($t['in_reply_to_status_id_str'])) {
                    $is_reply = true;
                    $reply_id = $t['in_reply_to_status_id_str'];
                    array_push($replies, $reply_id);
            } else {
                    $is_reply = false;
                    $reply_id = '';
            }
    
                            
            $tweet = Twitter_Autolink::create($text)
                    ->setNoFollow(false)
                    ->addLinks();
            
            
            array_push($all_content, array('tweet_id'=>$tweet_id,'time'=>$timestamp, 'text'=>$tweet, 'image'=>$image, 'platform'=>'twitter', 'media_type'=>$media_type, 'orig_user'=>$orig_user, 'orig_user_name'=>$orig_user_name, 'rt_user'=>$rt_user, 'rt_user_name'=>$rt_user_name,'orig_user_img'=>$orig_user_img, 'rt_user_img'=>$rt_user_img, 'is_reply'=>$is_reply, 'reply_id'=>$reply_id));
    }
            
            
    $reply_ids = implode(",", $replies);
                    
    $reply_data = json_decode($twitter->setGetfield("?id={$reply_ids}")->buildOauth($show_url, $requestMethod)->performRequest(),$assoc = TRUE);
    
    $output = '';
    
    $output .= "<div class='posts columns-{$columns}' id='tweetwaterfall-container'>";
    
    foreach($all_content as $post) {
            $output .= "<div class='post-wrapper'><div class='post'>";
    
            
            $output .= "
                    <div class='marginals'>
                            <div class='marginals-body'>
            ";
                    
            if ($post['rt_user'] !== '') {
                    $output .= "<div class='marginals-wrapper'>
                                    <div class='marginals-object retweet-icon-wrapper text-center'>
                                            <span class='icon icon-small icon-retweet'>
                                                    <svg viewBox='0 0 1024 832.054'>
                                                            <use xlink:href='{$image_path}/images/icon-retweet.svg#icon'></use>
                                                    </svg>
                                            </span>
    
                                    </div>
                                    <div class='marginals-body-inner text-small text-subdued'>
                                            {$post['orig_user_name']}  retweeted 
                                    </div>
                            </div>";
            } 
    
            if ($post['rt_user']) {
                    $user_url = "https://twitter.com/{$post['rt_user']}";    
            } else {
                    $user_url = "https://twitter.com/{$post['orig_user']}";    
            }
            
            $output .= "
                    <div class='marginals-wrapper'>
                    <a class='twitter-user-link' href='{$user_url}'>
                            <div class='marginals-object'>";
                            
            if($post['rt_user_img'] !== '') {
                    $output .= "<img class='avatar rt-avatar' alt='' src='{$post['rt_user_img']}'/>";    
            } else {
                    $output .= "<img class='avatar orig-avatar' alt='' src='{$post['orig_user_img']}'/>";
            }            
            
            $output .= "
                            </div>                
                                    <div class='marginals-body-inner'>";
    
            if ($post['rt_user']) {
                    
                    $output .= "
                            <span class='twitter-screename'>{$post['rt_user']}</span>
                            <span class='twitter-username text-small text-subdued'>@{$post['rt_user_name']}</span>
                    ";
            } else {
                    $output .= "
                            <span class='twitter-screename'>{$post['orig_user_name']}</span>
                            <span class='twitter-username text-small text-subdued'>@{$post['orig_user']}</span>
                    ";
            }                    
            
            $tweet_url = "https://twitter.com/{$post['orig_user']}/status/{$post['tweet_id']}";
            
            $output .= "
    
            </div>
            </a>
            </div>
                    </div>
    
                    <div class='marginals-twitter-icon'>
                            <a class='icon icon-twitter' href='{$tweet_url}' alt='View this tweet on twitter' target='_blank'>
                                    <svg viewBox='0 0 1024 832.054'>
                                            <use xlink:href='{$image_path}/images/icon-twitter.svg#icon'></use>
                                    </svg>
                            </a>
                    </div>
    
            </div>
            ";
            
            $output .= "<div class='tweet-body'>
                    {$post['text']}
            </div>";
            
            if ($post['media_type'] == 'VIDEO') {
                    $output .= "<video style='max-width: 100%;' controls>
                    
                    <source src='{$post['image']}' type='video/mp4'/> 
                    
                    </video>";        
            } elseif((!$post['media_type'] == '')) {
                    $imagedetails = getimagesize($post['image']);
                    $width = $imagedetails[0];
                    $height = $imagedetails[1];
                    $output .= "<img class='post-image' width='{$width}' height='{$height}' src='{$post['image']}'/>";    
            }
            
            if ($post['reply_id'] !== "") {    
                    $tmpid = $post['reply_id'];
                    
                    $reply_tweet = array_filter($reply_data, function ($reply) use ($tmpid) {
                            return ($reply['id'] == $tmpid);
                    });
                    
                    $reply_tweet = array_shift($reply_tweet);
    
                    $reply_tweet_text = Twitter_Autolink::create($reply_tweet['text'])
                            ->setNoFollow(false)
                            ->addLinks();
                    
                    
                    $output .= "
                            <div class='post-wrapper'>
                                    <a class='twitter-user-link' href='https://twitter.com/{$reply_tweet['user']['screen_name']}'>
                                            <div class='user-lockup'>
                                                    <img class='avatar reply-avatar' alt='' src='{$reply_tweet['user']['profile_image_url_https']}'/>
                                                    <div class='user-id'>
                                                            <span class='twitter-screename reply-tweet-screename'>{$reply_tweet['user']['name']}</span>
                                                            <span class='twitter-username reply-tweet-username text-subdued text-small'>@{$reply_tweet['user']['screen_name']}</span>
                                                    </div>
                                            </div>
                                    </a>
                                    
                                    <p class='tweet-body'>{$reply_tweet_text}</p>
                            </div>
                    ";
                    
            }
            
            
    
            
            
            if (strtotime($post['time'] ) > strtotime('-3 days')) {
                    $formatted_date = time_elapsed_string($post['time']); 
            } else {
                    $formatted_date = date("M j, Y", strtotime($post['time']));
            }
            
            
            $favorite_url = "https://twitter.com/intent/like?tweet_id={$post['tweet_id']}";
            
            
            $output .= "
                    <div class='marginals align-items-center'>
                            <div class='marginals-icon'>
                                    <a class='icon icon-heart' href='{$favorite_url}' alt='Like this tweet on Twitter' target='_blank'>
                                            <svg viewBox='0 0 1024 997.425'>
                                                    <use xlink:href='{$image_path}/images/icon-heart.svg#icon'></use>
                                            </svg>
                                    </a>
                            </div>
                            <div class='marginals-body text-right'>
                                    <p class='text-subdued text-small'>{$formatted_date}</p>
                            </div>
    
                    </div>
            
            ";
            
            
    
            $output .= "</div></div>";
    
    }
    
    
    $output .= "</div>";
    
    $output .="
        <script>
            let magicGrid = new MagicGrid({
                container: '#tweetwaterfall-container',
                animate: true,
                gutter: 16,
                static: false,
                items: {$count},
                maxColumns: {$columns},
                useMin: true
            });
            magicGrid.listen();
        </script>
    ";
    
    return $output;
}




function prepare_output() {
    $oauth_access_token = get_option('post_waterfall_oauth_access_token');
    $oauth_access_token_secret = get_option('post_waterfall_oauth_access_token_secret');
    $consumer_key = get_option('post_waterfall_consumer_key');
    $consumer_secret = get_option('post_waterfall_consumer_secret');
    $username = get_option('post_waterfall_username');
    $count = get_option('post_waterfall_count');
    $columns = get_option('post_waterfall_columns');
    $debug = false;
    $time_ago_limit = 3;
    $tweetWaterfallOutput = tweetWaterfall($username, $count, $oauth_access_token, $oauth_access_token_secret, $consumer_key, $consumer_secret, $columns);

    $tweetWaterfallOutputFn = function() use($tweetWaterfallOutput) {
        return $tweetWaterfallOutput;
    };

    add_shortcode('postwaterfall', $tweetWaterfallOutputFn);
    
    
    global $post;
    if( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'postwaterfall') ) {
        
        $plugin_path = plugin_dir_url( __FILE__ );

        wp_enqueue_style('post-waterfall', "{$plugin_path}/css/style.css");
        wp_enqueue_script( 'post-waterfall', "{$plugin_path}/js/magic-grid.min.js");
    }
}
add_action( 'wp_enqueue_scripts', 'prepare_output');

add_filter( 'plugin_action_links_post-waterfall/post-waterfall.php', 'postwaterfall_settings_link' );
function postwaterfall_settings_link( $links ) {
	// Build and escape the URL.
	$url = esc_url( add_query_arg(
		'page',
		'post-waterfall',
		get_admin_url() . 'options-general.php'
	) );
	$settings_link = "<a href='$url'>" . __( 'Settings' ) . '</a>';

	array_push(
		$links,
		$settings_link
	);
	return $links;
}