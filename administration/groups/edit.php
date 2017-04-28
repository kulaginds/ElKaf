<?php

$access = 'administrator';

include(__DIR__.'/../../engine/header.php');
require_once(__DIR__.'/../../engine/modules/users/users.php');
require_once(__DIR__.'/../../engine/modules/groups/groups.php');

$users  = new Users($db, $smarty, $config['user_types'], $config['security']['auth_salt']);
$groups = new Groups($db, $users);
$id     = max((int)$_GET['id'], 0);
$group  = null;

try {
	$groups->handle_actions();
} catch (Exception $e) {
	$smarty->assign('error', $e->getMessage());
}

try {
	$group = $groups->get_group($id);
} catch (Exception $e) {
	$smarty->assign('error', $e->getMessage());
}

$smarty->assign('edit_group', $group);

$smarty->display('pages/administration/groups/edit.tpl');

include(__DIR__.'/../../engine/footer.php');

?>