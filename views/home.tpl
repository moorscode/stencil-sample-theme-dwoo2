<html>
<head>
  {$wp_head}
</head>

<body>

{foreach from=$posts item=post}
  <section>
    <h2>{$post->get_title()}</h2>
    {$post->get_excerpt()}

    <p><a href="{$post->get_permalink()}">read more</a></p>
  </section>
{/foreach}

{$wp_footer}
</body>
</html>
