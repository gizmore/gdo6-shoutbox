<?php
return [
    'gdo_shoutbox' => 'Shoutbox',
    'shout_text' => 'Message',
    
    'cfg_shout_guests' => 'Allow guests to shout?',
    'cfg_shout_sidebar' => 'Show shoutbox link in left sidebar?',
    'cfg_shout_mails' => 'Moderate via Email?',
    'cfg_shout_sidebar_box' => 'Even show shoutbox in left sidebar?',
    'cfg_shout_captcha_guests' => 'Captcha for guests?',
    'cfg_shout_captcha_member' => 'Captcha for members?',
    'cfg_shout_boxsize' => 'Number of Shouts in slim box',
    'cfg_shout_cooldown_guests' => 'Time between shouts for guests.',
    'cfg_shout_cooldown_member' => 'Time between shouts for members.',

    # Box
    'list_shoutbox_box' => '%s Messages',
    
    # Table
    
    # Delete
    'ft_shoutbox_delete' => 'Delete Shout',
    'msg_shout_deleted' => 'The shoutbox entry has been deleted.',
    
    # Add
    'ft_shoutbox_add' => 'Shout!',
    'err_shout_cooldown' => 'You have shouted recently. Please wait %s.',
    'msg_shouted' => 'Your text has been added to the shoutbox.',
    'mail_subj_shoutbox' => '%s: New shoutbox entry',
    'mail_body_shoutbox' => '
Hello %s,

There has been made a new shout in the %s shoutbox.

From: %s
Text: %s

You can quickly delete the shout via this url: %s.

Kind Regards,
%2$s System
',    
];
