<?php
/*
YesWiki action "testsendmail"

TODO:
- redirect after POST

GPL v2 licence summary:

Copyright 2018 Cyrille GIQUELLO

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
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/
global $wiki ;

// includes/email.inc.php
require_once( __DIR__.'/../../../includes/email.inc.php' );

error_log( print_r($_POST, true) );

if( isset($_POST['testsendmail_email']) )
{
    $mail_receiver = trim($_POST['testsendmail_email']) ;
    if( $mail_receiver == '' )
    {
        echo '<div class="alert alert-danger">'. 'Le destinataire n\'est pas valide.' .'</div>';
    }

    $pieces = parse_url($wiki->GetConfigValue('base_url'));
    $domain = isset($pieces['host']) ? $pieces['host'] : '';
    $mail_sender = $wiki->GetConfigValue('email_from', 'noreply@' . $domain);

    $name_sender = 'Wiki' ;
    $subject = 'test envoi email' ;
    $message_txt = 'test envoi email' ;
    $message_html = '<html><body><p>test envoi email</p></body></html>' ;
    $result = send_mail( $mail_sender, $name_sender, $mail_receiver, $subject, $message_txt, $message_html );
    if( ! $result )
        echo '<div class="alert alert-danger">'. 'Echec envoi email.' .'</div>';
}
?>

<div class="row">

<p>configuration email_from: <?php echo $wiki->GetConfigValue('email_from', 'null' ) ?></p>

<?php  echo $wiki->FormOpen('', '', 'post', 'form-inline'); ?>
<p>subject: <input name="testsendmail_subject" type="text" value="test envoi email" /></p>
<p>email: <input name="testsendmail_email" type="email" /></p>
<button type="submit">send</button>
</form>
<p>&nbsp;</p>
</div>
