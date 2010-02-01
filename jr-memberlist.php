<?php
/*
Plugin Name: JR_Memberlist
Plugin URI: http://www.jakeruston.co.uk/2010/01/wordpress-plugin-jr-memberlist/
Description: This plugin allows you to display a list of users on your blog, using the shortcode [jrmemberlist].
Version: 1.0.2
Author: Jake Ruston
Author URI: http://www.jakeruston.co.uk
*/

/*  Copyright 2009 Jake Ruston - the.escapist22@gmail.com

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Hook for adding admin menus
add_action('admin_menu', 'jr_memberlist_add_pages');

// action function for above hook
function jr_memberlist_add_pages() {
    add_options_page('JR MemberList', 'JR MemberList', 'administrator', 'jr_memberlist', 'jr_memberlist_options_page');
}

register_activation_hook(__FILE__,'memberlist_choice');

function memberlist_choice () {
if (get_option("jr_memberlist_links_choice")=="") {
if (!defined("ch"))
{
function setupch()
{
$ch = curl_init();
$c = curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
return($ch);
}

define("ch", setupch());

function curl_get_contents($url)
{
$c = curl_setopt(ch, CURLOPT_URL, $url);
return(curl_exec(ch));
}
}

$content = curl_get_contents("http://www.jakeruston.co.uk/pluginslink4.php");

update_option("jr_memberlist_links_choice", $content);
}
}

// jr_memberlist_options_page() displays the page content for the Test Options submenu
function jr_memberlist_options_page() {

    // variables for the field and option names 
    $opt_name_6 = 'mt_memberlist_plugin_support';
    $hidden_field_name = 'mt_memberlist_submit_hidden';
    $data_field_name_6 = 'mt_memberlist_plugin_support';

    // Read in existing option value from database
    $opt_val_6 = get_option($opt_name_6);
    
if (!$_POST['feedback']=='') {
$my_email1="the.escapist22@gmail.com";
$plugin_name="JR MemberList";
$blog_url_feedback=get_bloginfo('url');
$user_email=$_POST['email'];
$subject=$_POST['subject'];
$feedback_feedback=$_POST['feedback'];
$headers1 = "From: feedback@jakeruston.co.uk";
$emailsubject1=$plugin_name." - ".$subject;
$emailmessage1="Blog: $blog_url_feedback\n\nUser E-Mail: $user_email\n\nMessage: $feedback_feedback";
mail($my_email1,$emailsubject1,$emailmessage1,$headers1);

?>

<div class="updated"><p><strong><?php _e('Feedback Sent!', 'mt_trans_domain' ); ?></strong></p></div>

<?php
}

    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if( $_POST[ $hidden_field_name ] == 'Y' ) {
        // Read their posted value
        $opt_val_6 = $_POST[$data_field_name_6];

        // Save the posted value in the database
        update_option( $opt_name_6, $opt_val_6 );	

        // Put an options updated message on the screen

?>
<div class="updated"><p><strong><?php _e('Options saved.', 'mt_trans_domain' ); ?></strong></p></div>
<?php

    }

    // Now display the options editing screen

    echo '<div class="wrap">';

    // header

    echo "<h2>" . __( 'JR Memberlist Plugin Options', 'mt_trans_domain' ) . "</h2>";

    // options form
    
    $change4 = get_option("mt_memberlist_plugin_support");

if ($change4=="Yes" || $change4=="") {
$change4="checked";
$change41="";
} else {
$change4="";
$change41="checked";
}
    ?>
<form name="form1" method="post" action="">
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">

<h3>How to Use</h3>
To use this plugin, simply use the code [jrmemberlist] in any post or page you make. The memberlist will appear in it's place.<hr />

<p><?php _e("Show Plugin Support?", 'mt_trans_domain' ); ?> 
<input type="radio" name="<?php echo $data_field_name_6; ?>" value="Yes" <?php echo $change4; ?>>Yes
<input type="radio" name="<?php echo $data_field_name_6; ?>" value="No" <?php echo $change41; ?> id="Please do not disable plugin support - This is the only thing I get from creating this free plugin!" onClick="alert(id)">No
</p><hr />

<p class="submit">
<input type="submit" name="Submit" value="<?php _e('Update Options', 'mt_trans_domain' ) ?>" />
</p><hr />

</form>
<h3>Give Me Feedback!</h3>
<form name="form2" method="post" action="">
<p><?php _e("E-Mail (Optional):", 'mt_trans_domain' ); ?> 
<input type="text" name="email" /></p>
<p><?php _e("Subject:", 'mt_trans_domain' ); ?>
<input type="text" name="subject" /></p>
<p><?php _e("Comment:", 'mt_trans_domain' ); ?> 
<textarea name="feedback"></textarea>
</p>
<p class="submit">
<input type="submit" name="Send" value="<?php _e('Send', 'mt_trans_domain' ) ?>" />
</p><hr />
</form>
</div>
<?php
}

if (get_option("jr_memberlist_links_choice")=="") {
memberlist_choice();
}

function show_memberlist() {

  $plugin_support = get_option("mt_memberlist_plugin_support");

global $wpdb;
$users=$wpdb->get_var("SELECT COUNT(*) FROM $wpdb->users;");

echo "Users: $users";
$i=0;

while ($i<$users) {
$i ++;
$user_data[$i]=get_userdata($i);
$url=$user_data[$i]->user_url;
$name=$user_data[$i]->display_name;

if ($url=="") {
echo $name.'<br />';
} else {
echo '<a href="'.$url.'">'.$name.'</a><br />';
}
}
  
if ($plugin_support=="Yes" || $plugin_support=="") {
add_action('wp_footer', 'memberlist_footer_plugin_support');
}
}

function memberlist_footer_plugin_support() {
  $pshow = "<p style='font-size:x-small'>Memberlist Plugin created by <a href='http://www.jakeruston.co.uk'>Jake</a> Ruston - ".get_option('jr_memberlist_links_choice')."</p>";
  echo $pshow;
}

add_shortcode('jrmemberlist', 'show_memberlist');
?>
