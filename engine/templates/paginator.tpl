{if $count > $limit}
{assign var='first_page' value=1}
{assign var='last_page' value=$count/$limit}
<ul class="menu paginator">
{if $page > $first_page}
	{if $page-1 == $first_page}
	<li><a href="?"><< Предыдущая</a></li>
	{else}
	<li><a href="?page={$page-1}"><< Предыдущая</a></li>
	{/if}
{/if}
{if $page < $last_page}
	<li><a href="?page={$page+1}">Следующая >></a></li>
{/if}
</ul>
{/if}