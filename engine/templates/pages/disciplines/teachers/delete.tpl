<h1>Удаление преподавателя из дисциплины</h1>
{if isset($error)}
<p class="error">{$error}</p>
{/if}
{if isset($discipline) && isset($teacher)}
<p>Вы уверены, что хотите удалить преподавателя "{$teacher.name}" из дисциплины "{$discipline.name}"?</p>
<ul class="menu mb">
	<li>
		<form action="/disciplines/teachers/delete.php?id={$discipline.id}&teacher_id={$teacher.id}" method="POST">
			<input type="hidden" name="action" value="delete_teacher">
			<input type="submit" value="Да">
		</form>
	</li>
	<li><a href="/disciplines/teachers/index.php?id={$discipline.id}">Нет</a></li>
</ul>
{/if}