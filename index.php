<?php

include(__DIR__.'/engine/header.php');

if ($auth->is_auth()) {
	$url = $config['user_sections'][$auth->get_user()['type']];
	
	if (!empty($url)) {
		header('Location: '.$url);
		die();
	}
}

$smarty->display('pages/index.tpl');

include(__DIR__.'/engine/footer.php');

?>