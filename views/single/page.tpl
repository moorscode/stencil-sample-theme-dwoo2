{extends file='index.tpl'}

{block name="main"}
	<section role="main" class="main">
	<h1>{$post->get_title()}</h1>
	{$post->get_content()}
	</section>
{/block}