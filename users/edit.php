<?php

$access = 'administrator';

include(__DIR__.'/../engine/header.php');
require_once(__DIR__.'/../engine/modules/users/users.php');

$users = new Users($db, $smarty, $config['user_types'], $config['security']['auth_salt']);
$id    = max((int)$_GET['id'], 0);
$user  = null;

try {
	$users->handle_actions();
} catch (Exception $e) {
	$smarty->assign('error', $e->getMessage());
}

try {
	$user = $users->get_user($id);
} catch (Exception $e) {
	$smarty->assign('error', $e->getMessage());
}

$smarty->assign('user_types', $config['user_types']);
$smarty->assign('edit_user', $user);

$smarty->display('pages/users/edit.tpl');

include(__DIR__.'/../engine/footer.php');

?>