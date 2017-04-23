<h1>Список пользователей</h1>
{if isset($error)}
<p class="error">{$error}</p>
{/if}
<ul class="menu mb">
	<li>
		<a href="/users/add.php">Добавить нового пользователя</a>
	</li>
</ul>
<table class="table">
	<tr>
		<th>ФИО</th>
		<th>тип</th>
		<th>описание</th>
		<th>действия</th>
	</tr>
{foreach from=$user_list item=user}
	<tr>
		<td>{$user.name}</td>
		<td>{$user.type|replace:$user_types_keys:$user_types_values}</td>
		<td>
		{if empty($user.description)}
			<p class="center"><i>нет</i></p>
		{else}
			{$user.description}
		{/if}
		</td>
		<td>
			<ul class="menu">
				<li><a href="/users/password.php?id={$user.id}">Новый пароль</a></li>
				<li><a href="/users/edit.php?id={$user.id}">Редактировать</a></li>
				<li><a href="/users/delete.php?id={$user.id}">Удалить</a></li>
			</ul>
		</td>
	</tr>
{foreachelse}
	<tr>
		<td colspan="4">
			<p><i>Пользователей нет.</i></p>
		</td>
	</tr>
{/foreach}
</table>
{include file='paginator.tpl' page=$page count=$count limit=$limit}