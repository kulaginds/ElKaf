<?php

$anon_page = true;

include(__DIR__.'/engine/header.php');

$smarty->display('pages/index.tpl');

include(__DIR__.'/engine/footer.php');

?>