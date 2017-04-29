<h1>Дисциплины кафедры</h1>
{if isset($error)}
<p class="error">{$error}</p>
{/if}
{foreach from=$discipline_list item=discipline}
<table class="table">
	<tr>
		<th width="100">название</th>
		<td>
			<a href="/dormitory/disciplines/info.php?id={$discipline.id}">
				{$discipline.name}
			</a>
		</td>
	</tr>
</table>
{foreachelse}
<p>Дисциплин нет.</p>
{/foreach}
{include file='paginator.tpl' page=$page count=$count limit=$limit}