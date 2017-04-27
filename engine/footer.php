<?php

// собираю текст из буфера
$content = ob_get_contents();
// чищу буфер
ob_end_clean();

// подключаю текст контента в шаблон
$smarty->assign('content', $content);

if (!isset($no_display) || !$no_display) {
	// рендерю и отображаю страницу
	$smarty->display('basic.tpl');
}

?>