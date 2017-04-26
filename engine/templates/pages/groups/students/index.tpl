<h1>Список студентов группы "{$group.name}"</h1>
{if isset($error)}
<p class="error">{$error}</p>
{/if}
<ul class="menu mb">
	<li>
		<a href="/groups/index.php">Список групп</a>
	</li>
	<li>
		<a href="/groups/students/add.php?id={$group.id}">Добавить студентов в групппу</a>
	</li>
</ul>
<table class="table">
	<tr>
		<th>ФИО</th>
		<th>действия</th>
	</tr>
{foreach from=$student_list item=student}
	<tr>
		<td>{$student.name}</td>
		<td>
			<ul class="menu">
				<li><a href="/groups/students/delete.php?id={$group.id}&student_id={$student.id}">Удалить</a></li>
			</ul>
		</td>
	</tr>
{foreachelse}
	<tr>
		<td colspan="4">
			<p><i>У группы нет студентов.</i></p>
		</td>
	</tr>
{/foreach}
</table>
{include file='paginator.tpl' page=$page count=$count limit=$limit}