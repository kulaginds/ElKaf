<?php

$access = 'administrator';

include(__DIR__.'/../../../engine/header.php');
require_once(__DIR__.'/../../../engine/modules/users/users.php');
require_once(__DIR__.'/../../../engine/modules/groups/groups.php');
require_once(__DIR__.'/../../../engine/modules/disciplines/disciplines.php');
require_once(__DIR__.'/../../../engine/modules/schedules/schedules.php');

$users       = new Users($db, $smarty, $config['user_types'], $config['security']['auth_salt']);
$groups      = new Groups($db, $users);
$disciplines = new Disciplines($db, $users);
$schedules   = new Schedules($db, $users, $groups, $disciplines, $config['schedules']['weekdays'], $config['schedules']['couples']);
$couple      = null;
$schedule    = null;
$discipline  = null;
$id          = max((int)$_GET['id'], 0);

try {
	$schedules->handle_actions();
} catch (Exception $e) {
	$smarty->assign('error', $e->getMessage());
}

try {
	$couple     = $schedules->get_couple($id);
	$schedule   = $schedules->get_schedule($couple['schedule_id']);
	$discipline = $disciplines->get_discipline($couple['discipline_id']);
} catch (Exception $e) {
	$smarty->assign('error', $e->getMessage());
}

$smarty->assign('delete_couple', $couple);
$smarty->assign('schedule', $schedule);
$smarty->assign('discipline', $discipline);
$smarty->assign('weekdays', $config['schedules']['weekdays']);
$smarty->assign('weeks', $config['schedules']['weeks']);

$smarty->display('pages/schedules/couples/day/delete.tpl');

include(__DIR__.'/../../../engine/footer.php');

?>