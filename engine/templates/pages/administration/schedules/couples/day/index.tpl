<h1>Пары расписания "{$schedule.name}" на {$weekdays.$weekday_index}, {$weeks.$week}</h1>
{if isset($error)}
<p class="error">{$error}</p>
{/if}
<ul class="menu mb">
	<li>
		<a href="/administration/schedules/index.php">Список расписаний</a>
	</li>
	<li>
		<a href="/administration/schedules/couples/index.php?id={$schedule.id}&week={$week}">Список пар</a>
	</li>
</ul>
<table class="table">
	<tr>
		<th>время</th>
		<th colspan="4">
			{$weekdays.$weekday_index}
		</th>
	</tr>
{foreach from=$couple_list key=couple_index item=couple}
	<tr>
		<td>{"<hr>"|implode:$couples.$couple_index}</td>
		{if !empty($couple)}
		<td>
			{$couple.discipline}
		</td>
		<td>
			{$couple.teacher}
		</td>
		<td>
		{if empty($couple.auditory)}
			<p>-</p>
		{else}
			{$couple.auditory}
		</td>
		{/if}
		<td>
			<ul class="menu">
				<li><a href="/administration/schedules/couples/day/edit.php?id={$couple.id}">Редактировать</a></li>
				<li><a href="/administration/schedules/couples/day/delete.php?id={$couple.id}">Удалить</a></li>
			</ul>
		</td>
		{else}
		<td colspan="4">
			<a href="/administration/schedules/couples/day/add.php?id={$schedule.id}&week={$week}&weekday_index={$weekday_index}&couple_index={$couple_index}">Добавить пару</a>
		</td>
		{/if}
	</tr>
{foreachelse}
	<tr>
		<td colspan="5">
			<p><i>Нет пар.</i></p>
		</td>
	</tr>
{/foreach}
</table>