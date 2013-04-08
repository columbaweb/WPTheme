
<?php global $comment_id, $wpdb; ?>
<div class="comments">
	<?php if ($comments) : ?>
        <a name="comments" id="comment_anchor"></a>
        <h3 class="section-title"><?php _(comments_number('No <span>Comments</span>','1 <span>Comment</span>','% <span>Comments</span>')); ?></h3>
        <ul class="comment-container">
            <?php 
                foreach ($comments as $comment) :
                    if ($comment->comment_parent == 0) :
                        $comment_table = $wpdb->prefix . "ocmx_comment_meta";
                        $comment_meta_sql = "SELECT * FROM $comment_table WHERE commentId = ".$comment->comment_ID." LIMIT 1";
                        $comment_meta = $wpdb->get_row($comment_meta_sql);
                        $comment_type = get_comment_type(); ?>
                        <li class="comment clearfix" id="comment-<?php echo $comment->comment_ID; ?>">
                            <?php if($comment_type == "comment") : ?>
                                <div class="comment-avatar">
                                    <?php echo get_avatar($comment, 80); ?>
                                </div>                                    
                            <?php endif; ?>
                            <div class="comment-post clearfix">
                            	<h4 class="comment-name"><a href="<?php comment_author_url(); ?>" class="commentor_url" rel="nofollow"><?php comment_author(); ?></a></h4>
                                <?php if ($comment->comment_approved == '0') : ?><p>Comment is awaiting moderation.</p><?php else : comment_text();  endif; ?>								
                                <?php if($comment_type == "comment") : ?>
                                    <h5 class="date">
                                        <?php comment_date('d M Y h:m a') ?>
                                        <?php if(($comment_meta->twitter) && $comment_meta->twitter !== "") : ?>(<a href="http://twitter.com/<?php echo $comment_meta->twitter; ?>" class="twitter-link" rel="nofollow">@<?php echo $comment_meta->twitter; ?></a>)<?php endif; ?>
                                    </h5>
                                    <a href="#" class="reply-to-comment" id="reply-<?php echo $comment->comment_ID ?>">Reply</a>
                                <?php endif; ?>                                
                            </div>
                            <?php $comment_id = $comment->comment_ID; ?>
                            <?php if($comment_type == "comment") :
                                fetch_comments($comment_id, $i);
                            endif; ?>
                            <ul id="new-reply-<?php echo $comment->comment_ID; ?>" style="display: none;" class="threaded-comments"></ul>
                            <div style="display: none;" id="form-placement-<?php echo $comment->comment_ID ?>"></div>
                        </li>
                <?php endif; ?>
            <?php endforeach; ?>
            
	        <li id="new_comments"></li>
        </ul>
    <?php else : ?>
        <a name="comments" id="comment_anchor"></a>
        <div id="new_comments"></div>
    <?php endif; ?>
    
    <?php  if ('open' == $post->comment_status) : ?>
        <div id="original_comment_location">
            <?php if ( get_option('comment_registration') && !$user_ID ) : // If registration required and not logged in ?>
                <p>You must be <a href="<?php echo wp_login_url( get_permalink() ); ?>" class="std_link">logged in</a> to post a comment.</p>      
            <?php else : ?>
                <div class="comment-form-content" id="comment_form_container">
                    <h3 class="section-title "><?php _e("Leave a Comment"); ?></h3>
                    <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" class="comment_form" id="commentform"> 
                        <p id="commment-post-alert" class="no_display">Posting your comment...</p>
                        <?php if ($user_ID ) : ?>
                           <div class="logged-in-as">
                               Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php" class="std_link"><?php echo $user_identity; ?></a>.
                               <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account">Logout &raquo;</a>
                           </div>
                        <?php else : ?>
                            <p><input type="text" name="author" id="author" value="<?php if($comment_author != ""){echo $comment_author;}else{_e("Name");}; ?>" size="32" tabindex="1" /></p>
                            <p><input type="text" name="email" id="email" value="<?php if($comment_author_email != ""){echo $comment_author_email;}else{_e("Email");} ?>" size="32" tabindex="2" /></p>
                            <p><input type="text" name="url" id="url" value="<?php if($comment_author_url != ""){echo $comment_author_url;} else{_e("URL");}; ?>" size="32" tabindex="3" /></p>
                        <?php endif; ?>
                        <p><input type="text" name="twitter" id="twitter" value="<?php if($comment_author_twitter != ""){echo $comment_author_twitter;}else{_e("Twitter");}; ?>" size="32" tabindex="4" /></p>
                        <p><textarea name="comment" id="comment" cols="40" rows="10" tabindex="5" class="comment"></textarea></p>
                        <p class="checkbox">
                            <input type="checkbox" id="email_subscribe" name="email_subscribe" />
                            <?php _e("Subscribe to these comments via email"); ?>
                        </p>  
                        <input type="submit" class="submit_button" id="comment_submit" value="<?php _e("Submit Comment"); ?>" name="cmdSubmit" />
                        <input type="hidden" id="comment_post_id" name="comment_post_ID" value="<?php echo $id; ?>" />
                        <input type="hidden" id="comment_parent_id" name="comment_parent_id" value="0" />                         
                        <?php do_action('comment_form', $post->ID); ?>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; // if you delete this the sky will fall on your head ?>
</div>
<?php 
	/*****************************/
	/* Threaded Replies Function */
	function fetch_comments($comment_id, $i)
		{		
			global $wpdb;
			require('wp-load.php');
			$sql = "SELECT * FROM $wpdb->comments WHERE comment_parent = ".$comment_id;
			$child_comments =  $wpdb->get_results($sql);				
			$parent_comment = get_comment($comment_id);
			$thread_count = 0;
			if(count($child_comments) !== 0) :
?>
			<ul class="threaded-comments clearfix">
				<?php
                    foreach($child_comments as $sub_comment) :
                        $thread_count++;
                        $this_comment = get_comment($sub_comment->comment_ID);
                        $comment_table = $wpdb->prefix . "ocmx_comment_meta";
                        $sub_comment_meta_sql = "SELECT * FROM $comment_table WHERE commentId = ".$sub_comment->comment_ID." LIMIT 1";
                        $sub_comment_meta = $wpdb->get_row($sub_comment_meta_sql);
                ?>
                    <li class="comment clearfix" id="comment-<?php echo $sub_comment->comment_ID; ?>">
                        <div class="comment-post">
                        	<h4 class="comment-name">
                            	<?php if($sub_comment->comment_author_url != "http://" && $sub_comment->comment_author_url != "") : ?>
                                   <a class="comment url" href="<?php echo $sub_comment->comment_author_url; ?>" rel="nofollow"> <?php echo $sub_comment->comment_author; ?></a>
                                <?php else : ?>
                                     <?php echo $sub_comment->comment_author; ?>
                                <?php endif; ?>
                             </h4>
                            <?php if ($sub_comment->comment_approved == '0') : ?>
                                <p><?php _e("Comment is awaiting moderation."); ?></p>
                            <?php else :
                                $use_comment = apply_filters('wp_texturize', $this_comment->comment_content);
                                $use_comment = str_replace("\n", "<br>", $use_comment);
                                echo "<p>".$use_comment."</p>";
                            endif; ?>
                            <h5 class="date">
                                <?php echo date('d M Y h:m a', strtotime($sub_comment->comment_date)); ?>
                            	<?php if($sub_comment_meta->twitter !== "") : ?>(<a href="http://twitter.com/<?php echo $sub_comment_meta->twitter; ?>"  class="twitter-link" rel="nofollow">@<?php echo $sub_comment_meta->twitter; ?></a>)<?php endif; ?>
                            </h5>
                        </div>
                    </li>
                <?php
                    endforeach;
                ?>
			</ul>
<?php
			endif;
		}
?>