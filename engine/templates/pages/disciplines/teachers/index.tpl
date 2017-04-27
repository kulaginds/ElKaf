<h1>Список преподавателей дисциплины "{$discipline.name}"</h1>
{if isset($error)}
<p class="error">{$error}</p>
{/if}
<ul class="menu mb">
	<li>
		<a href="/disciplines/index.php">Список дисциплин</a>
	</li>
	<li>
		<a href="/disciplines/teachers/add.php?id={$discipline.id}">Добавить преподаватей к дисциплине</a>
	</li>
</ul>
<table class="table">
	<tr>
		<th>ФИО</th>
		<th>описание</th>
		<th>действия</th>
	</tr>
{foreach from=$teacher_list item=teacher}
	<tr>
		<td>{$teacher.name}</td>
		<td>
		{if empty($teacher.description)}
			<p class="center"><i>нет</i></p>
		{else}
			{$teacher.description}
		{/if}
		</td>
		<td>
			<ul class="menu">
				<li><a href="/disciplines/teachers/delete.php?id={$discipline.id}&teacher_id={$teacher.id}">Удалить</a></li>
			</ul>
		</td>
	</tr>
{foreachelse}
	<tr>
		<td colspan="4">
			<p><i>У дисциплины нет преподавателей.</i></p>
		</td>
	</tr>
{/foreach}
</table>
{include file='paginator.tpl' page=$page count=$count limit=$limit}