<h1>Удаление расписания</h1>
{if isset($error)}
<p class="error">{$error}</p>
{/if}
{if isset($delete_schedule)}
<p>Вы уверены, что хотите удалить расписание "{$delete_schedule.name}"?</p>
<ul class="menu mb">
	<li>
		<form action="/administration/schedules/delete.php?id={$delete_schedule.id}" method="POST">
			<input type="hidden" name="action" value="delete">
			<input type="submit" value="Да">
		</form>
	</li>
	<li><a href="/administration/schedules/index.php">Нет</a></li>
</ul>
{/if}