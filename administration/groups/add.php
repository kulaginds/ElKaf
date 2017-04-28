<?php

$access = 'administrator';

include(__DIR__.'/../../engine/header.php');
require_once(__DIR__.'/../../engine/modules/users/users.php');
require_once(__DIR__.'/../../engine/modules/groups/groups.php');

$users  = new Users($db, $smarty, $config['user_types'], $config['security']['auth_salt']);
$groups = new Groups($db, $users);

try {
	$groups->handle_actions();
} catch (Exception $e) {
	$smarty->assign('error', $e->getMessage());
}

$smarty->assign('name', $groups->name);

$smarty->display('pages/administration/groups/add.tpl');

include(__DIR__.'/../../engine/footer.php');

?>