<?php

require_once('config.php');
require_once('tgdb.php');
require('lastheard.php');

error_reporting(E_ERROR);
$tuCurl = curl_init(); 
curl_setopt($tuCurl, CURLOPT_URL, "http://hamcloud.info/status"); 
curl_setopt($tuCurl, CURLOPT_PORT , 8090); 
curl_setopt($tuCurl, CURLOPT_VERBOSE, 0); 
curl_setopt($tuCurl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($tuCurl, CURLOPT_CONNECTTIMEOUT, 5); // 5 seconds timeout

$tuData = curl_exec($tuCurl); 
curl_close($tuCurl);

$data = json_decode($tuData,true);
$callsign = array_keys($data["nodes"]);

echo "<!DOCTYPE html>";
echo "<html lang=\"de\"><head>\r\n";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>";
echo '<link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicons/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicons/favicon-16x16.png">
<link rel="manifest" href="/favicons/manifest.json">
<link rel="mask-icon" href="/favicons/safari-pinned-tab.svg" color="#5bbad5">
<meta name="theme-color" content="#ffffff">';

echo "\r\n<title>SVXLINKREFLECTOR</title>";

$current_style = file_get_contents(STYLECSS);
echo "<style type=\"text/css\">".$current_style."</style></head>\n\r";

if (count($callsign) >= 0){
    echo "<main><table id=\"logtable\" with:80%>\n\r";
    
    if( preg_match('/'.REFRESHSTATUS.'/i', 'SHOW')) {
        echo "<tr><th colspan='7'>SVXReflector-Dashboard -=[ ".date("Y-m-d | H:i:s"." ]=-</th></tr>\n\r");
    }
    echo "<tr><th>Callsign Client</th>\n\r";

    echo '<th class=\'state\'>Client Version</th>'."\n\r";

    if( (PROTO == "SHOW") ) {
    	echo '<th class=\'proto\'>Proto</th>'."\n\r";
    }

    if( (TG == "SHOW") ) {
    	echo "<th>TG</th>\n\r";
    }

    if( (MON == "SHOW") ) {
    	echo "<th>Monitor TG</th>\n\r";
    }

    if( (LOCATION == "SHOW") ) {
    	echo "<th>Location</th>\n\r";
    }

    try {
    for ($i=0; $i<count($callsign, 0); $i++)
    {
	    echo '<tr>';
	    if ( $callsign[$i] == $lastheard_call ) {
	   	echo '<td class="yellow"><div class="tooltip">'.$callsign[$i].'<br>'.$lt_timestamp.'<span class="tooltiptext">'.$data["nodes"][$callsign[$i]]["Sysop"].'</span></div></td>';
	    } else {
	   	echo '<td class="green"><div class="tooltip">'.$callsign[$i].'<span class="tooltiptext">'.$data["nodes"][$callsign[$i]]["Sysop"].'</span></div></td>';
	    }
		if ($data["nodes"][$callsign[$i]]["isTalker"]) {
			echo '<td class=\'tx\'></td>';
		} else { 
			// set alternate info in when not talking
			if ($data["nodes"][$callsign[$i]]["swVer"] != SVXLINKVERSION) {
				echo '<td class=\'darkred_small\'>'.$data["nodes"][$callsign[$i]]["swVer"].'<br /><font color=darkred size=1em>'.SVXLINKVERSION.'</font></td>';
			} else {	
				echo '<td class=\'grey\'>'.$data["nodes"][$callsign[$i]]["swVer"].'</td>';
			}
		}
	  
	   	// show protocoll version
    		if( (PROTO == "SHOW") ) {
			if(preg_match('/2/i',$data["nodes"][$callsign[$i]]["protoVer"]["majorVer"])) {
				echo '<td class=\'grey\'>'.implode(".",$data["nodes"][$callsign[$i]]["protoVer"]).'</td>';
			} else {
				echo '<td class=\'yellow\'>'.implode(".",$data["nodes"][$callsign[$i]]["protoVer"]).'</td>';
			}
		}

		// show talking tg optional with own tg text
    		if( (TG == "SHOW") ) {
                    if($data["nodes"][$callsign[$i]]["isTalker"]) {
			echo '<td class=\'red\'>'.$data["nodes"][$callsign[$i]]["tg"].'</br>'.$tgdb_array[$data["nodes"][$callsign[$i]]["tg"]].'</td>';
			$file = '/home/svxlink/html/svxrdb/lastheard.php';
			touch($file);
		    	$now = date ('d-M H:i', time());
			$talker = '<?php $lastheard_call = "'.$callsign[$i].'"; $lt_timestamp = "'.$now.'"; ?>';
			file_put_contents($file, $talker);
			$lastheard_call = $callsign[$i];
		    } else {
			echo '<td class=\'grey\'>'.$data["nodes"][$callsign[$i]]["tg"].'</td>';
		    }
		}

    		if( (MON == "SHOW") ) {
		    echo '<td class="grey">'.implode(" ",$data["nodes"][$callsign[$i]]["monitoredTGs"]).'</td>';
		}

    		if( (LOCATION == "SHOW") ) {
		   echo '<td class="grey">'.$data["nodes"][$callsign[$i]]["nodeLocation"].'</td>';
		}
		echo "</tr>\n\r";
            } // END NEWLOGFILEDATA FALSE
        }
	catch (MyException $ex)
	{	
	 //print_r($ex);
	}
	}
    echo "</table>\n\r";
if( LEGEND == "EN") {
echo '<pre>
9*# -- Talk group status
90# -- Not implemented yet. Reserved for help.
91# -- Select previous talk group
91[TG]# -- Select talk group TG#
92# -- QSY all active nodes to a talk group assigned by the reflector server
92[TG]# -- QSY all active nodes to TG#
93# -- Follow last QSY
94[TG]# -- Temporarily monitor TG#
<br>
';

}

if( LEGEND == "DE") {
echo '<pre>
9*# -- Sprechgruppen-Status
90# -- Noch nicht implementiert. Reserviert für Hilfefunktion.
91# -- W&auml;hle die vorherige Sprechgruppe
91[TG]# -- W&auml;hlt Sprechgruppe TG#
92# -- QSY alle aktiven Teilnehmer zu einer vom Server bestimmten Sprechgruppe wechseln.
92[TG]# -- QSY aller aktiven Teilnehmer zur TG#
93# -- Wiederhole letztes QSY
94[TG]# -- H&ouml;re tempor&auml;r auf TG#</BR>
';
}

echo '<a rel="license" href="http://creativecommons.org/licenses/by-nc/4.0/"><img alt="Creative Commons Lizenzvertrag" style="border-width:0" src="https://i.creativecommons.org/l/by-nc/4.0/88x31.png" /></a>&nbsp;<a style="font-size: 12px; text-decoration: none" rel="github" href="https://github.com/SkyAndy/svxrdb-server/">get your own Dashboard v'.DBVERSION.'</a>';
?>
