<?php
function getExecuted($executed, $auto , $dir = '../app/Executed/'){
	if ($auto == true) {
		include $dir.$executed.'.executed';
	}else{
		include $dir.$executed;
	}
}
?>