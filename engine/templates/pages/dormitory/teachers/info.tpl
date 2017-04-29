{if isset($teacher)}
<h1>Информация о преподавателе {$teacher.name}</h1>
{else}
<h1>Информация о преподавателе</h1>
{/if}
{if isset($error)}
<p class="error">{$error}</p>
{/if}
{if isset($teacher)}
<h2>Дисциплины</h2>
<table class="table">
	<tr>
		<th>название</th>
	</tr>
{foreach from=$discipline_list item=discipline}
	<tr>
		<td>
			<a href="/dormitory/disciplines/info.php?id={$discipline.id}">
				{$discipline.name}
			</a>
		</td>
	</tr>
{foreachelse}
	<tr>
		<td>Преподаватель не ведёт дисциплины.</td>
	</tr>
{/foreach}
</table>

<h2>Документы</h2>
<table class="table">
	<tr>
		<th>дисциплина</th>
		<th>название</th>
		<th>размер</th>
		<th>действия</th>
	</tr>
{foreach from=$document_list item=document}
	<tr>
		<td>
			<a href="/dormitory/disciplines/info.php?id={$document.discipline_id}">
				{$document.discipline}
			</a>
		</td>
		<td>{$document.name}</td>
		<td>{$document.size|filesize}</td>
		<td>
			<ul class="menu">
				<li><a href="/dormitory/documents/download.php?id={$document.id}">Скачать</a></li>
			</ul>
		</td>
	</tr>
{foreachelse}
	<tr>
		<td colspan="4">Нет документов.</td>
	</tr>
{/foreach}
</table>
{/if}