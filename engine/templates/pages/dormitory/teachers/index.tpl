<h1>Преподаватели кафедры</h1>
{foreach from=$teacher_list item=teacher}
<table class="table">
	<tr>
		<th width="100">ФИО:</th>
		<td>
			<a href="/dormitory/teachers/info.php?id={$teacher.id}">
				{$teacher.name}
			</a>
		</td>
	</tr>
	<tr>
		<th>описание:</th>
		<td>{$teacher.description}</td>
	</tr>
</table>
{foreachelse}
<p>Преподавателей нет.</p>
{/foreach}