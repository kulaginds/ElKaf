<?php

$access = 'administrator';

include(__DIR__.'/../../../engine/header.php');
require_once(__DIR__.'/../../../engine/modules/users/users.php');
require_once(__DIR__.'/../../../engine/modules/disciplines/disciplines.php');
require_once(__DIR__.'/../../../engine/modules/documents/documents.php');

$users       = new Users($db, $smarty, $config['user_types'], $config['security']['auth_salt']);
$disciplines = new Disciplines($db, $users);
$documents   = new Documents($db, $users, $disciplines, $config['documents']['allowed_types'], $config['documents']['upload_dir']);
$document    = null;
$author      = null;
$id          = max((int)$_GET['id'], 0);
$author_id   = max((int)$_GET['author_id'], 0);

try {
	$documents->handle_actions();
} catch (Exception $e) {
	$smarty->assign('error', $e->getMessage());
}

try {
	$document = $documents->get_document($id);
	$author   = $users->get_author($author_id);
} catch (Exception $e) {
	$smarty->assign('error', $e->getMessage());
}

$smarty->assign('document', $document);
$smarty->assign('author', $author);

$smarty->display('pages/administration/documents/authors/delete.tpl');

include(__DIR__.'/../../../engine/footer.php');

?>