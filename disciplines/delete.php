<?php

include(__DIR__.'/../engine/header.php');
require_once(__DIR__.'/../engine/modules/users/users.php');
require_once(__DIR__.'/../engine/modules/disciplines/disciplines.php');

$users       = new Users($db, $smarty, $config['user_types'], $config['security']['auth_salt']);
$disciplines = new Disciplines($db, $smarty, $users);
$discipline  = null;
$id          = max((int)$_GET['id'], 0);

try {
	$disciplines->handle_actions();
} catch (Exception $e) {
	$smarty->assign('error', $e->getMessage());
}

try {
	$discipline = $disciplines->get_discipline($id);
} catch (Exception $e) {
	$smarty->assign('error', $e->getMessage());
}

$smarty->assign('delete_discipline', $discipline);

$smarty->display('pages/disciplines/delete.tpl');

include(__DIR__.'/../engine/footer.php');

?>