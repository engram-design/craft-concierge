# Configuration
Create a `concierge.php` file under your `/config` directory with the following options available to you. You can also use multi-environment options to change these per environment.

The below shows the defaults already used by Concierge, so you don't need to add these options unless you want to modify the values.

```php
<?php

return [
    '*' => [
        'accountActivationEmailEnabled' => false,
        'moderatorRegistrationEmailEnabled' => false,
        'moderatorUserGroup' => '',
    ]
];
```

## Configuration options
- `accountActivationEmailEnabled` - Whether to send an email to the user when their account is activated.
- `moderatorRegistrationEmailEnabled` - Whether to send an email to moderators when a user has registered.
- `accountActivationEmailEnabled` - The user group (UID) for moderators. Each user in this group will receive moderator emails.


## Control Panel
You can also manage configuration settings through the Control Panel by visiting Settings → Concierge.
