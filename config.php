<?php

date_default_timezone_set('Europe/Berlin'); // http://php.net/manual/de/timezones.europe.php

// set to SHOW for see refreshtime statusline
define("REFRESHSTATUS", "SHOW");

// You own style
define("STYLECSS", "style_normal.css");

/* set to DE Deutsch to EN for English languange
set NO legend not showing */
define("LEGEND", "DE");

// set showing monitoring talkgroup yes(SHOW) or not(SHOWNO)
define("MON", "SHOW");

// set showing talkgroup yes(SHOW) or not (SHOWNO)
define("TG", "SHOW");

// set location info yes(SHOW) or not (SHOWNO)
define("LOCATION", "SHOW");

//do not change this values
define("CLIENTLIST", "CALL");
define("DBVERSION", "20191223.1526" );
$lastheard_call = "CALL";
$clients[] = array();
// ----
?>
