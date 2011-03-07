<?php
/*

Plugin Name: Make lotsa posts
Description: Generate a lot(100 as of now) of lorem ipsum posts using loripsum.net API calls.
Version:0.1
Author: Mihai Chereji
*/

function make_lotsa_posts()
{
	if(get_option('made_lotsa_posts') != true){
		for($j = 0; $j <= 99; $j++)
		{
			$param_array = array('decorate','link','ul','ol','dl','bq','code','headers');
			$paragraph_no = mt_rand(1,10);
			$lengths = array('short','medium','long','verylong');
			$length = mt_rand(1,4);
			$params = decbin(mt_rand(0,256));
			$api_link = 'http://loripsum.net/api/' . $paragraph_no . '/' . $lengths[$length] . '/';
			for($i = 0; $i <= 7;$i++)
			{
					$param_bin[$i] = $params[$i];
					if($param_bin[$i])
							$api_link .= $param_array[$i] . '/';

			}

			$random =  file_get_contents($api_link);
			$words = explode(' ',strip_tags($random));
			$title_length = mt_rand(1,10);
			$title_start = mt_rand(0,count($words) - $title_length);
			$title = '';
			for($i = 1; $i<= $title_length;$i++)
			{
					$title .= $words[$title_start + $i - 1] . ' ';
			}
			
//			echo $random;
			if(current_user_can('edit_posts')){
				global $current_user;
				$info = get_currentuserinfo();

				$params = array(
						'post_title' => $title,
						'post_content' => $random,
						'post_status' => 'publish',
						'post_type' => 'post',
						'post_author' => $info->user_ID
						);

				wp_insert_post($params,true);
			}
		}
		update_option('made_lotsa_posts',true);
	}
}

add_action('init','make_lotsa_posts');
?>
