<h1>Удаление пользователя</h1>
<p>Вы уверены, что хотите удалить пользователя {$delete_user.name}?</p>
<ul class="menu mb">
	<li>
		<form action="/users/delete.php?id={$delete_user.id}" method="POST">
			<input type="hidden" name="action" value="delete">
			<input type="submit" value="Да">
		</form>
	</li>
	<li><a href="/users/index.php">Нет</a></li>
</ul>