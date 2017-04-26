<?php

$access = 'administrator';

include(__DIR__.'/../../../engine/header.php');
require_once(__DIR__.'/../../../engine/modules/users/users.php');
require_once(__DIR__.'/../../../engine/modules/groups/groups.php');
require_once(__DIR__.'/../../../engine/modules/disciplines/disciplines.php');
require_once(__DIR__.'/../../../engine/modules/schedules/schedules.php');

$users           = new Users($db, $smarty, $config['user_types'], $config['security']['auth_salt']);
$groups          = new Groups($db, $users);
$disciplines     = new Disciplines($db, $users);
$schedules       = new Schedules($db, $users, $groups, $disciplines, $config['schedules']['weekdays'], $config['schedules']['couples']);
$schedule        = null;
$discipline_list = null;
$teacher_list    = null;
$id              = max((int)$_GET['id'], 0);
$week            = array_keys($config['schedules']['weeks'])[0];
$weekday_index   = max((int)$_GET['weekday_index'], 0);
$couple_index    = max((int)$_GET['couple_index'], 0);

if (array_key_exists('week', $_GET) && in_array($_GET['week'], array_keys($config['schedules']['weeks']))) {
	$week = trim(htmlspecialchars($_GET['week']));
}

if (!in_array($_GET['weekday_index'], array_keys($config['schedules']['weekdays']))) {
	$weekday_index = 0;
}

if (!in_array($_GET['couple_index'], array_keys($config['schedules']['couples']))) {
	$couple_index = 0;
}

try {
	$schedules->handle_actions();
} catch (Exception $e) {
	$smarty->assign('error', $e->getMessage());
}

try {
	$schedule        = $schedules->get_schedule($id);
	$discipline_list = $disciplines->get_discipline_list();
	$teacher_list    = $users->get_teacher_list();
} catch (Exception $e) {
	$smarty->assign('error', $e->getMessage());
}

$smarty->assign('schedule', $schedule);
$smarty->assign('discipline_list', $discipline_list);
$smarty->assign('teacher_list', $teacher_list);
$smarty->assign('weekdays', $config['schedules']['weekdays']);
$smarty->assign('weekday_index', $weekday_index);
$smarty->assign('couple_index', $couple_index);
$smarty->assign('weeks', $config['schedules']['weeks']);
$smarty->assign('week', $week);

$smarty->assign('discipline', $schedules->discipline);
$smarty->assign('teacher', $schedules->teacher);
$smarty->assign('auditory', $schedules->auditory);

$smarty->display('pages/schedules/couples/day/add.tpl');

include(__DIR__.'/../../../engine/footer.php');

?>