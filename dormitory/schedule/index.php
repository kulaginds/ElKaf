<?php

$access = 'student';

include(__DIR__.'/../../engine/header.php');
require_once(__DIR__.'/../../engine/modules/users/users.php');
require_once(__DIR__.'/../../engine/modules/groups/groups.php');
require_once(__DIR__.'/../../engine/modules/disciplines/disciplines.php');
require_once(__DIR__.'/../../engine/modules/schedules/schedules.php');

$users               = new Users($db, $smarty, $config['user_types'], $config['security']['auth_salt']);
$groups              = new Groups($db, $users);
$disciplines         = new Disciplines($db, $users);
$schedules           = new Schedules($db, $users, $groups, $disciplines, $config['schedules']['weekdays'], $config['schedules']['couples']);
$schedule            = null;
$week                = array_keys($config['schedules']['weeks'])[0];
$couple_weekday_list = null;

if (array_key_exists('week', $_GET) && in_array($_GET['week'], array_keys($config['schedules']['weeks']))) {
	$week = trim(htmlspecialchars($_GET['week']));
}

try {
	$schedule            = $schedules->get_student_schedule($auth->get_user()['id']);
	$couple_weekday_list = $schedules->get_couple_weekday_list($schedule['id'], $week);
} catch (Exception $e) {
	$smarty->assign('error', $e->getMessage());
}

$smarty->assign('weeks', $config['schedules']['weeks']);
$smarty->assign('week', $week);
$smarty->assign('weekdays', $config['schedules']['weekdays']);
$smarty->assign('couple_weekday_list', $couple_weekday_list);
$smarty->assign('couples', $config['schedules']['couples']);

$smarty->display('pages/dormitory/schedule/index.tpl');

include(__DIR__.'/../../engine/footer.php');

?>