<?php

include(__DIR__.'/../engine/header.php');

function step1() {
	global $db;

	$sql = __DIR__.'/elkaf.sql';

	echo '<h1>Шаг 1: установка структуры базы данных</h1>';

	if (!is_file($sql)) {
		echo '<p class="error">Отсутствует необходимый для установки файл <i>/install/elkaf.sql</i>.</p>';
		return;
	}

	$sql = file_get_contents($sql);

	if ($db->multi_query($sql)) {
		echo '<p>Создание структуры завершено. Перейти ко <a href="/install/index.php?step=2">второму шагу</a>.</p>';
	} else {
		echo '<p class="error">Не удалось создать структуру БД.</p>';
	}
}

function step2() {
	echo '<h1>Шаг 2: добавление администратора</h1>';
	echo '<form action="/install/index.php?step=3" method="POST">';
	echo '<label>ФИО администратора: <input type="text" name="name"></label><br>';
	echo '<label>Пароль администратора: <input type="password" name="password"></label><br>';
	echo '<ul class="menu mb">';
	echo '<li><input type="submit" value="Далее"></li>';
	echo '</ul>';
	echo '</form>';
}

function step3() {
	global $db, $config;

	if (!array_key_exists('name', $_POST) || empty($_POST['name']) || !array_key_exists('password', $_POST) || empty($_POST['password'])) {
		error_step();
		return;
	}

	echo '<h1>Финиш</h1>';

	$name          = trim(htmlspecialchars($_POST['name']));
	$password      = trim(htmlspecialchars($_POST['password']));
	$password_hash = md5($config['security']['auth_salt'].$password);

	$stmt = $db->prepare('INSERT INTO user(name, password_hash, type) VALUES(?, ?, \'administrator\')');
	$stmt->bind_param('ss', $name, $password_hash);

	if ($stmt->execute()) {
		echo '<p>Установка успешно завершена!</p>';
		echo '<p><b>Пожалуйста</b>, удалите папку <i>/install/</i>.</p>';
	} else {
		echo '<p class="error">Не удалось добавить администратора.</p>';
	}
}

function greeting_step() {
	echo '<h1>Установка программной системы</h1>';
	echo '<p>Для запуска установки нажмите <a href="/install/index.php?step=1">пуск</a>.</p>';
}

function error_step() {
	echo '<h1>Ошибка</h1>';
	echo '<p class="error">Неизвестный шаг.</p>';
}

if (array_key_exists('step', $_GET) && !empty($_GET['step'])) {
	switch ($_GET['step']) {
		case '1':
			step1();
			break;
		case '2':
			step2();
			break;
		case '3':
			step3();
			break;
		
		default:
			step1();
			break;
	}
} else {
	greeting_step();
}

include(__DIR__.'/../engine/footer.php');

?>