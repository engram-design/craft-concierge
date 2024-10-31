<?php

return [
  //
  // Email Messages
  //
  'concierge_user_activated_heading' => 'When someone has their account activated (to user):',
  'concierge_user_activated_subject' => 'Your account has been activated',
  'concierge_user_activated_body' => "Hey {{ user.friendlyName }},\n\n" .
    "Thanks for creating an account with {{ siteName }}. Your account has been activated and is now ready for use.",

  'concierge_moderator_registration_heading' => 'When someone creates an account (to moderator):',
  'concierge_moderator_registration_subject' => 'New registration on {{ siteName }}',
  'concierge_moderator_registration_body' => "Hey,\n\n" .
    "Someone registered on {{ siteName }}. \n\n" .
    "Visit {{ cpUrl('users') }} to review.",

];