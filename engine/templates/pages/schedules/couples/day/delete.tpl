<h1>Удаление пары</h1>
{if isset($error)}
<p class="error">{$error}</p>
{/if}
{if isset($delete_couple)}
<p>Вы уверены, что хотите удалить пару "{$discipline.name}" в расписании "{$schedule.name}" на {$weekdays[$delete_couple.weekday_index]}, {$weeks[$delete_couple.week]}?</p>
<ul class="menu mb">
	<li>
		<form action="/schedules/couples/day/delete.php?id={$delete_couple.id}" method="POST">
			<input type="hidden" name="action" value="delete_couple">
			<input type="submit" value="Да">
		</form>
	</li>
	<li><a href="/schedules/couples/day/index.php?id={$schedule.id}&week={$delete_couple.week}&weekday_index={$delete_couple.weekday_index}">Нет</a></li>
</ul>
{/if}