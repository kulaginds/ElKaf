<?php

$no_display = true;
$access     = 'student';

include(__DIR__.'/../../engine/header.php');
require_once(__DIR__.'/../../engine/modules/users/users.php');
require_once(__DIR__.'/../../engine/modules/disciplines/disciplines.php');
require_once(__DIR__.'/../../engine/modules/documents/documents.php');

$users       = new Users($db, $smarty, $config['user_types'], $config['security']['auth_salt']);
$disciplines = new Disciplines($db, $users);
$documents   = new Documents($db, $auth, $users, $disciplines, $config['documents']['allowed_types'], $config['documents']['upload_dir']);
$document    = null;
$id          = max((int)$_GET['id'], 0);

try {
	$documents->download_file($id);
} catch (Exception $e) {
	$smarty->assign('error', $e->getMessage());
	$no_display = false;
}

$smarty->display('pages/administration/documents/download.tpl');

include(__DIR__.'/../../engine/footer.php');

?>