
Social share Plugin
========
Die Erweiterung ermöglicht das Hinzufügen von verschiedenen social share Buttons (u.a. Facebook, Twitter, Google, Whatsapp).
Der Head-Bereich wird um neue meta Tags erweitert (Open Graph und Schema.org).

Paketname:

    quiqqer/socialshare


Features
--------
- verschiedene Themen (_Einstellungen_ --> _"Dein Projekt"_ --> _Social share_)
- Icons und Text ausschaltbar
- erweitert den Head-Bereich der Internetseite
- Zusätzliche Seiteneinstellungen (_Titel_, _Autor_, _Seitenbild_, usw.)
- als Brick verfügbar

Installation
------------

Der Paketname ist: quiqqer/socialshare


Mitwirken
----------

- Project: https://dev.quiqqer.com/quiqqer/socialshare
- Issue Tracker: https://dev.quiqqer.com/quiqqer/socialshare/issues
- Source Code: https://dev.quiqqer.com/quiqqer/socialshare/tree/master


Support
-------

Falls Sie ein Fehler gefunden haben, oder Verbesserungen wünschen,
dann können Sie gerne an support@pcsg.de eine E-Mail schreiben.


Lizenz
-------


Entwickler
--------
```php
<?php

// Control erstellen und zuweisen
$Social = new QUI\Socialshare\Controls\Socialshare();
$Engine->assign('Socials', $Social->create());

// ein einzelner Share Button -> direkt über Manager
$Facebook = QUI\Socialshare\Manager::getSocial('Facebook');
$Engine->assign('Facebook', $Facebook)


?>
```