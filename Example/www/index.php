<?php

//Include
require '../libs/LeftingDev/start-class.php';

//Start Engine
$LeftingDev = new LeftingDev();
$LeftingDev->start("../app/Page/","../app/Theme/default", "/accueil");
$LeftingDev->EmulatePage();

?>