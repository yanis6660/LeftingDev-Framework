<?php

function getTheme($theme, $auto, $type){
	if ($auto == true) {
		include $GLOBALS['dirTheme'].'/'.$theme.'.view';
	}else{
		include $GLOBALS['dirTheme'].'/'.$theme;
	}
}

?>