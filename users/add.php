<?php

$access = 'administrator';

include(__DIR__.'/../engine/header.php');
require_once(__DIR__.'/../engine/modules/users/users.php');

$users = new Users($db, $smarty, $config['user_types'], $config['security']['auth_salt']);

try {
	$users->handle_actions();
} catch (Exception $e) {
	$smarty->assign('error', $e->getMessage());
}

$smarty->assign('user_types', $config['user_types']);
$smarty->assign('name', $users->name);
$smarty->assign('type', $users->type);
$smarty->assign('description', $users->description);

$smarty->display('pages/users/add.tpl');

include(__DIR__.'/../engine/footer.php');

?>