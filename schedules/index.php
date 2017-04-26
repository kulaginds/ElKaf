<?php

$access = 'administrator';

include(__DIR__.'/../engine/header.php');
require_once(__DIR__.'/../engine/modules/users/users.php');
require_once(__DIR__.'/../engine/modules/groups/groups.php');
require_once(__DIR__.'/../engine/modules/disciplines/disciplines.php');
require_once(__DIR__.'/../engine/modules/schedules/schedules.php');

$users         = new Users($db, $smarty, $config['user_types'], $config['security']['auth_salt']);
$groups        = new Groups($db, $users);
$disciplines   = new Disciplines($db, $users);
$schedules     = new Schedules($db, $users, $groups, $disciplines, $config['schedules']['weekdays'], $config['schedules']['couples']);
$schedule_list = null;

try {
	$schedule_list = $schedules->get_schedule_list();
} catch (Exception $e) {
	$smarty->assign('error', $e->getMessage());
}

$smarty->assign('schedule_list', $schedule_list);
$smarty->assign('page', $schedules->page);
$smarty->assign('count', $schedules->schedule_list_count);
$smarty->assign('limit', $schedules->schedule_list_limit);

$smarty->display('pages/schedules/index.tpl');

include(__DIR__.'/../engine/footer.php');

?>