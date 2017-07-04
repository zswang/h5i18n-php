<?php

require(__DIR__ . '/../h5i18n.php');

use h5i18n\Languages;

$langs = new Languages();

echo $langs->getLocale() . PHP_EOL;
echo $langs->get("中文<!--{en}English--><!--{jp}日本语-->") . PHP_EOL;
echo $langs->get("中文<!--{en}English--><!--{jp}日本语-->", 'en') . PHP_EOL;