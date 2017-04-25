<h1>Добавление студентов в группу</h1>
{if isset($error)}
<p class="error">{$error}</p>
{/if}
<form action="/groups/students/add.php?id={$group.id}" method="POST">
<input type="hidden" name="action" value="add_students">
<ul class="menu mb">
	<li><a href="/groups/students/index.php?id={$group.id}">Cписок студентов</a></li>
</ul>
<table class="table">
	<tr>
		<th><input type="submit" value="Добавить"></th>
		<th>ФИО</th>
	</tr>
{foreach from=$student_list item=student}
	<tr>
		<td>
			<input type="checkbox" name="students[]" value="{$student.id}">
		</td>
		<td>{$student.name}</td>
	</tr>
{foreachelse}
	<tr>
		<td colspan="3">
			<p><i>Студентов нет.</i></p>
		</td>
	</tr>
{/foreach}
	<tr>
		<th><input type="submit" value="Добавить"></th>
		<th>ФИО</th>
	</tr>
</table>
<ul class="menu mb">
	<li><a href="/groups/students/index.php?id={$group.id}">Cписок студентов</a></li>
</ul>
</form>