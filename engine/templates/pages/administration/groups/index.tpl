<h1>Список групп</h1>
{if isset($error)}
<p class="error">{$error}</p>
{/if}
<ul class="menu mb">
	<li>
		<a href="/administration/groups/add.php">Добавить новую группу</a>
	</li>
</ul>
<table class="table">
	<tr>
		<th>название</th>
		<th>действия</th>
	</tr>
{foreach from=$group_list item=group}
	<tr>
		<td>{$group.name}</td>
		<td>
			<ul class="menu">
				<li><a href="/administration/groups/students/index.php?id={$group.id}">Студенты</a></li>
				<li><a href="/administration/groups/edit.php?id={$group.id}">Редактировать</a></li>
				<li><a href="/administration/groups/delete.php?id={$group.id}">Удалить</a></li>
			</ul>
		</td>
	</tr>
{foreachelse}
	<tr>
		<td colspan="2">
			<p><i>Групп нет.</i></p>
		</td>
	</tr>
{/foreach}
</table>
{include file='paginator.tpl' page=$page count=$count limit=$limit}