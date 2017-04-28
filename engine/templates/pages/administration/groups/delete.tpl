<h1>Удаление группы</h1>
{if isset($error)}
<p class="error">{$error}</p>
{/if}
{if isset($delete_group)}
<p>Вы уверены, что хотите удалить группу "{$delete_group.name}"?</p>
<ul class="menu mb">
	<li>
		<form action="/administration/groups/delete.php?id={$delete_group.id}" method="POST">
			<input type="hidden" name="action" value="delete">
			<input type="submit" value="Да">
		</form>
	</li>
	<li><a href="/administration/groups/index.php">Нет</a></li>
</ul>
{/if}