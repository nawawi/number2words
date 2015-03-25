<?php
/**
  * intl.php - Convert currency number to words by using php intl extension
  * Copyright (C) 2013 nawawi jamili <nawawi@rutweb.com>
  *
  * This file is distributed under the terms of the GNU General Public
  * License (GPL). Copies of the GPL can be obtained from:
  * http://www.gnu.org/licenses/gpl.html 
  */

if ( !extension_loaded('intl') ) {
    echo "require php intl extension http://php.net/manual/en/intro.intl.php";
    exit;
}

$GLOBALS['locale'] = array("ms_MY.utf8","ms_MY.iso88591","ms_MY");
$GLOBALS['alias'] = "ms_MY";

function setlang() {
    putenv("LANGUAGE=".$GLOBALS['alias']);
    $lang = setlocale(LC_ALL, $GLOBALS['locale']);
    putenv("LANG=".$lang);
}

function nombor($num) {
    $num = preg_replace("/(\,)+/", '', $num);

    $n = "dan";
    $c = "sen";
    $o = "sahaja";

    $r = new NumberFormatter($GLOBALS['alias'], NumberFormatter::SPELLOUT);
    if ( preg_match("/^(\d+)\.(\d+)$/", $num, $mm) ) {
        $t1 = $r->format($mm[1]);
        $t2 = $r->format($mm[2]);
        $t = "{$t1} {$n} {$t2} {$c} {$o}";
    } else {
        $t = $r->format($num);
        $t .= " {$o}";
    }
    $t = preg_replace("/\-/"," ", $t);
    return strtoupper($t);
}

// comment, to disable language translation
setlang();
?>
<html>
<head>
<title>number</title>
</head>
<body>
<form method="get" action="intl.php">
<input type="text" name="nombor"><input type="submit" value="Submit">
</form>
<?php

if ( isset($_GET['nombor']) ) {
    echo nombor($_GET['nombor'])."<br>";
}
?>
</body>
</html>
