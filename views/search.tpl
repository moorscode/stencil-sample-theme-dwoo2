{extends file='index.tpl'}

{block name="main"}
	<h1>Zoekresultaten</h1>

	{if $results}
		{foreach from=$results item=post}
			{assign permalink $post->get_permalink()}
			<h2><a href="{$permalink}">{$post->get_title()}</a></h2>
			{$post->get_content()}
			<p align="right"><a href="{$permalink}">Ga naar de pagina &raquo;</a></p>
		{/foreach}
	{else}
		<p>Er zijn geen resultaten gevonden.</p>
	{/if}
{/block}