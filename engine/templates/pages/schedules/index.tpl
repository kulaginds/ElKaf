<h1>Список расписаний</h1>
{if isset($error)}
<p class="error">{$error}</p>
{/if}
<ul class="menu mb">
	<li>
		<a href="/schedules/add.php">Добавить новое расписание</a>
	</li>
</ul>
<table class="table">
	<tr>
		<th>название</th>
		<th>группа</th>
		<th>действия</th>
	</tr>
{foreach from=$schedule_list item=schedule}
	<tr>
		<td>{$schedule.name}</td>
		<td>{$schedule.group}</td>
		<td>
			<ul class="menu">
				<li><a href="/schedules/couples/index.php?id={$schedule.id}">Пары</a></li>
				<li><a href="/schedules/edit.php?id={$schedule.id}">Редактировать</a></li>
				<li><a href="/schedules/delete.php?id={$schedule.id}">Удалить</a></li>
			</ul>
		</td>
	</tr>
{foreachelse}
	<tr>
		<td colspan="3">
			<p><i>Расписаний нет.</i></p>
		</td>
	</tr>
{/foreach}
</table>
{include file='paginator.tpl' page=$page count=$count limit=$limit}