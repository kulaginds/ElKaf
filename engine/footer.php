<?php

$content = ob_get_contents();
ob_end_clean();

$smarty->assign('content', $content);
$smarty->display('basic.tpl');

?>