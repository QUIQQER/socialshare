![QUIQQER Social Share](bin/images/Readme.jpg)

Social share Plugin
========
Die Erweiterung ermöglicht das Hinzufügen von verschiedenen social share Buttons (u.a. Facebook, Twitter, Google, Whatsapp).
Der Head-Bereich wird um neue meta Tags erweitert (Open Graph und Schema.org).

Package name:

    quiqqer/socialshare


Features
--------

- Different themen
- Icons and label may be disabled
- Extends the site head area
- Additional site settings (titel, author, site typ, etc.)


Installation
------------

The package name is: quiqqer/socialshare


Contribute
----------

- Project: https://dev.quiqqer.com/quiqqer/socialshare
- Issue Tracker: https://dev.quiqqer.com/quiqqer/socialshare/issues
- Source Code: https://dev.quiqqer.com/quiqqer/socialshare/tree/master


Support
-------

If you have found a bug or want to make improvements,
then you can write an e-mail to support@pcsg.de.

License
-------

GPL

Entwickler
--------
```php
<?php

// Create and assign control
$Social = new QUI\Socialshare\Controls\Socialshare();
$Engine->assign('Socials', $Social->create());

// Create one social share button directly via Manager
$Facebook = QUI\Socialshare\Manager::getSocial('Facebook');
$Engine->assign('Facebook', $Facebook)

?>
```