<?php

include(__DIR__.'/../engine/header.php');
require_once(__DIR__.'/../engine/modules/users/users.php');

try {
	$users = new Users($db, $smarty, $config['user_types'], $config['security']['auth_salt']);

	$smarty->assign('user_types', $config['user_types']);

	$id   = max((int)$_GET['id'], 0);
	$user = $users->get_user($id);

	$smarty->assign('edit_user', $user);
} catch (Exception $e) {
	$smarty->assign('error', $e->getMessage());
}

$smarty->display('pages/users/password.tpl');

include(__DIR__.'/../engine/footer.php');

?>