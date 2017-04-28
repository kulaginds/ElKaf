<?php

$access = 'administrator';

include(__DIR__.'/../../engine/header.php');
require_once(__DIR__.'/../../engine/modules/users/users.php');
require_once(__DIR__.'/../../engine/modules/disciplines/disciplines.php');

$users       = new Users($db, $smarty, $config['user_types'], $config['security']['auth_salt']);
$disciplines = new Disciplines($db, $users);

try {
	$disciplines->handle_actions();
} catch (Exception $e) {
	$smarty->assign('error', $e->getMessage());
}

$smarty->assign('name', $disciplines->name);
$smarty->assign('description', $disciplines->description);
$smarty->assign('literature', $disciplines->literature);

$smarty->display('pages/administration/disciplines/add.tpl');

include(__DIR__.'/../../engine/footer.php');

?>