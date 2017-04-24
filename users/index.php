<?php

include(__DIR__.'/../engine/header.php');
require_once(__DIR__.'/../engine/modules/users/users.php');

$users     = new Users($db, $smarty, $config['user_types'], $config['security']['auth_salt']);
$user_list = null;

try {
	$user_list = $users->get_user_list();
} catch (Exception $e) {
	$smarty->assign('error', $e->getMessage());
}

$smarty->assign('user_types_keys', array_keys($config['user_types']));
$smarty->assign('user_types_values', array_values($config['user_types']));
$smarty->assign('user_list', $user_list);
$smarty->assign('page', $users->page);
$smarty->assign('count', $users->user_list_count);
$smarty->assign('limit', $users->user_list_limit);

$smarty->display('pages/users/index.tpl');

include(__DIR__.'/../engine/footer.php');

?>