<h1>Мои дисциплины</h1>
{if isset($error)}
<p class="error">{$error}</p>
{/if}
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
				<li><a href="/teaching/documents/discipline.php?id={$discipline.id}">Документы</a></li>
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