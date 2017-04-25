<h1>Удаление студента из группы</h1>
{if isset($error)}
<p class="error">{$error}</p>
{/if}
{if isset($group) && isset($student)}
<p>Вы уверены, что хотите удалить студента "{$student.name}" из группы "{$group.name}"?</p>
<ul class="menu mb">
	<li>
		<form action="/groups/students/delete.php?id={$group.id}&student_id={$student.id}" method="POST">
			<input type="hidden" name="action" value="delete_student">
			<input type="submit" value="Да">
		</form>
	</li>
	<li><a href="/groups/students/index.php?id={$group.id}">Нет</a></li>
</ul>
{/if}