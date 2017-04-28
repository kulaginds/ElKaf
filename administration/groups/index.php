<?php

$access = 'administrator';

include(__DIR__.'/../../engine/header.php');
require_once(__DIR__.'/../../engine/modules/users/users.php');
require_once(__DIR__.'/../../engine/modules/groups/groups.php');

$users      = new Users($db, $smarty, $config['user_types'], $config['security']['auth_salt']);
$groups     = new Groups($db, $users);
$group_list = null;

try {
	$group_list = $groups->get_group_list();
} catch (Exception $e) {
	$smarty->assign('error', $e->getMessage());
}

$smarty->assign('group_list', $group_list);
$smarty->assign('page', $groups->page);
$smarty->assign('count', $groups->group_list_count);
$smarty->assign('limit', $groups->group_list_limit);

$smarty->display('pages/administration/groups/index.tpl');

include(__DIR__.'/../../engine/footer.php');

?>