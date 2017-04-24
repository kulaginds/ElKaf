<h1>Список дисциплин</h1>
{if isset($error)}
<p class="error">{$error}</p>
{/if}
<ul class="menu mb">
	<li>
		<a href="/disciplines/add.php">Добавить новую дисциплину</a>
	</li>
</ul>
<table class="table">
	<tr>
		<th>название</th>
		<th>описание</th>
		<th>литература</th>
		<th>действия</th>
	</tr>
{foreach from=$discipline_list item=discipline}
	<tr>
		<td>{$discipline.name}</td>
		<td>
		{if empty($discipline.description)}
			<p class="center"><i>нет</i></p>
		{else}
			{$discipline.description}
		{/if}
		</td>
		<td>
		{if empty($discipline.literature)}
			<p class="center"><i>нет</i></p>
		{else}
			{$discipline.literature}
		{/if}
		</td>
		<td>
			<ul class="menu">
				<li><a href="/disciplines/teachers/index.php?id={$discipline.id}">Преподаватели</a></li>
				<li><a href="/disciplines/edit.php?id={$discipline.id}">Редактировать</a></li>
				<li><a href="/disciplines/delete.php?id={$discipline.id}">Удалить</a></li>
			</ul>
		</td>
	</tr>
{foreachelse}
	<tr>
		<td colspan="4">
			<p><i>Дисциплин нет.</i></p>
		</td>
	</tr>
{/foreach}
</table>
{include file='paginator.tpl' page=$page count=$count limit=$limit}