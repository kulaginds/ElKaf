<h1>Добавление преподавателей к дисциплине</h1>
{if isset($error)}
<p class="error">{$error}</p>
{/if}
<form action="/disciplines/teachers/add.php?id={$discipline.id}" method="POST">
<input type="hidden" name="action" value="add_teachers">
<ul class="menu mb">
	<li><a href="/disciplines/teachers/index.php?id={$discipline.id}">Cписок преподавателей</a></li>
</ul>
<table class="table">
	<tr>
		<th><input type="submit" value="Добавить"></th>
		<th>ФИО</th>
		<th>описание</th>
	</tr>
{foreach from=$teacher_list item=teacher}
	<tr>
		<td>
			<input type="checkbox" name="teachers[]" value="{$teacher.id}">
		</td>
		<td>{$teacher.name}</td>
		<td>{$teacher.description}</td>
	</tr>
{foreachelse}
	<tr>
		<td colspan="3">
			<p><i>Преподавателей нет.</i></p>
		</td>
	</tr>
{/foreach}
	<tr>
		<th><input type="submit" value="Добавить"></th>
		<th>ФИО</th>
		<th>описание</th>
	</tr>
</table>
<ul class="menu mb">
	<li><a href="/disciplines/teachers/index.php?id={$discipline.id}">Cписок преподавателей</a></li>
</ul>
</form>