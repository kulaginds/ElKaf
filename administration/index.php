<?php

$access = 'administrator';

include(__DIR__.'/../engine/header.php');

$smarty->display('pages/administration/index.tpl');

include(__DIR__.'/../engine/footer.php');

?>