<h1>Документы дисциплины "{$discipline.name}"</h1>
{if isset($error)}
<p class="error">{$error}</p>
{/if}
<ul class="menu mb">
	<li>
		<a href="/teaching/documents/add.php?id={$discipline.id}">Добавить новый документ</a>
	</li>
</ul>
<table class="table">
	<tr>
		<th>название</th>
		<th>размер</th>
		<th>действия</th>
	</tr>
{foreach from=$document_list item=document}
	<tr>
		<td>{$document.name}</td>
		<td>{$document.size|filesize}</td>
		<td>
			<ul class="menu">
				<li><a href="/teaching/documents/download.php?id={$document.id}">Скачать</a></li>
			</ul>
		</td>
	</tr>
{foreachelse}
	<tr>
		<td colspan="4">
			<p><i>Документов нет.</i></p>
		</td>
	</tr>
{/foreach}
</table>
{include file='paginator.tpl' page=$page count=$count limit=$limit}