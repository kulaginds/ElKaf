<?php

$access = 'administrator';

include(__DIR__.'/../../engine/header.php');
require_once(__DIR__.'/../../engine/modules/users/users.php');
require_once(__DIR__.'/../../engine/modules/groups/groups.php');
require_once(__DIR__.'/../../engine/modules/disciplines/disciplines.php');
require_once(__DIR__.'/../../engine/modules/schedules/schedules.php');

$users       = new Users($db, $smarty, $config['user_types'], $config['security']['auth_salt']);
$groups      = new Groups($db, $users);
$disciplines = new Disciplines($db, $users);
$schedules   = new Schedules($db, $users, $groups, $disciplines, $config['schedules']['weekdays'], $config['schedules']['couples']);
$schedule    = null;
$id          = max((int)$_GET['id'], 0);

try {
	$schedules->handle_actions();
} catch (Exception $e) {
	$smarty->assign('error', $e->getMessage());
}

try {
	$schedule = $schedules->get_schedule($id);
} catch (Exception $e) {
	$smarty->assign('error', $e->getMessage());
}

$smarty->assign('delete_schedule', $schedule);

$smarty->display('pages/administration/schedules/delete.tpl');

include(__DIR__.'/../../engine/footer.php');

?>