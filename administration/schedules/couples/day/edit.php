<?php

$access = 'administrator';

include(__DIR__.'/../../../../engine/header.php');
require_once(__DIR__.'/../../../../engine/modules/users/users.php');
require_once(__DIR__.'/../../../../engine/modules/groups/groups.php');
require_once(__DIR__.'/../../../../engine/modules/disciplines/disciplines.php');
require_once(__DIR__.'/../../../../engine/modules/schedules/schedules.php');

$users           = new Users($db, $smarty, $config['user_types'], $config['security']['auth_salt']);
$groups          = new Groups($db, $users);
$disciplines     = new Disciplines($db, $users);
$schedules       = new Schedules($db, $users, $groups, $disciplines, $config['schedules']['weekdays'], $config['schedules']['couples']);
$id              = max((int)$_GET['id'], 0);
$schedule        = null;
$couple          = null;
$discipline_list = null;
$teacher_list    = null;

try {
	$schedules->handle_actions();
} catch (Exception $e) {
	$smarty->assign('error', $e->getMessage());
}

try {
	$couple          = $schedules->get_couple($id);
	$schedule        = $schedules->get_schedule($couple['schedule_id']);
	$discipline_list = $disciplines->get_discipline_list();
	$teacher_list    = $users->get_teacher_list();
} catch (Exception $e) {
	$smarty->assign('error', $e->getMessage());
}

$smarty->assign('edit_couple', $couple);
$smarty->assign('schedule', $schedule);
$smarty->assign('discipline_list', $discipline_list);
$smarty->assign('teacher_list', $teacher_list);
$smarty->assign('weekdays', $config['schedules']['weekdays']);
$smarty->assign('weeks', $config['schedules']['weeks']);

$smarty->display('pages/administration/schedules/couples/day/edit.tpl');

include(__DIR__.'/../../../../engine/footer.php');

?>