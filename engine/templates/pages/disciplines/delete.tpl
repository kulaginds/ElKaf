<h1>Удаление дисциплины</h1>
{if isset($error)}
<p class="error">{$error}</p>
{/if}
{if isset($delete_discipline)}
<p>Вы уверены, что хотите удалить дисциплину "{$delete_discipline.name}"?</p>
<ul class="menu mb">
	<li>
		<form action="/disciplines/delete.php?id={$delete_discipline.id}" method="POST">
			<input type="hidden" name="action" value="delete">
			<input type="submit" value="Да">
		</form>
	</li>
	<li><a href="/disciplines/index.php">Нет</a></li>
</ul>
{/if}