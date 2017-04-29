{if isset($discipline)}
<h1>Информация о дисциплине {$discipline.name}</h1>
{else}
<h1>Информация о дисциплине</h1>
{/if}
{if isset($error)}
<p class="error">{$error}</p>
{/if}
{if isset($discipline)}
<h2>Описание</h2>
{if !empty($discipline.description)}
{$discipline.description}
{else}
<p><i>Нет описания.</i></p>
{/if}

<h2>Литература</h2>
{if !empty($discipline.literature)}
{$discipline.literature}
{else}
<p><i>Нет литературы.</i></p>
{/if}

<h2>Документы</h2>
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
				<li><a href="/dormitory/documents/download.php?id={$document.id}">Скачать</a></li>
			</ul>
		</td>
	</tr>
{foreachelse}
	<tr>
		<td colspan="3">Нет документов.</td>
	</tr>
{/foreach}
</table>
{/if}