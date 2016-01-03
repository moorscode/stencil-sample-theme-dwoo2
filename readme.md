# Stencil sample theme: Dwoo 2

This sample theme is used to illustrate the bare minimum functionality a Stencil theme needs to operate.
The directory setup in this theme has been made to keep the structure clean and clear.

*Keep in mind that the code has been written to be compatible with PHP 5.2 - removing small functions in favor of anonymous functions can make it even more compact.*

## Stencil

Since WordPress does not allow Stencil to be in the plugin directory, the best place to put the framework is inside a theme.
All sample themes now contain the core plugin and the implementation(s) they might require.

All you need is to install a sample theme to have full functionality.

## Functions

### get_stencil()

Use `get_stencil();` to get the Stencil object. With this object you can set variables and control advanced features.

### include_stencil_controller( $file )

Use `include_stencil_controller( $filename );` to load controllers in your `router/router.php`.
This function is child-theme safe and will find the proper controller in your `controllers` folder or the parent theme's `controllers` folder.

You can compare this with the WordPress `get_template_part()` method.

### get_stencil_handler()

Whenever you need lean Stencil object (without handling the flow of the current page) you can request a handler using `get_stencil_handler();`.
This is especially useful on AJAX requests where you only want to render a part of a view to dynamically update parts of your page.

    <?php

    $handler = get_stencil_handler();
    $handler->set( 'my_variable', $some_value );
    $html = $handler->fetch( 'snippets/some_div_snippet' );

    echo $html;

    ?>

## Controllers

Because of the template engine, we transformed WordPress to a more MCV (Model, View, Controller) approach.
WordPress serves as the Model provider, holding all the data. The template engine provides the views. The only thing that remains is the 'Controller' part.

Controllers are pieces of code that fetch the required Models (posts) and combines other logic to set all the variables a view needs.
The controllers are generally placed inside the `controllers` folder.

You can override the name of this folder by using the `stencil:path-controllers` filter.

If you prefer you can also do all of this in your `functions.php` or any other file you load via your `functions.php`.

## router/router.php

To keep a clear idea of what controllers are loaded for what pages, the `routers/router.php` has been created.
This file is meant to connect actions to the loading of controllers.

To see all hooks Stencil offers, please read the extended documentation on the [Stencil repository](https://github.com/moorscode/stencil).

## PHP files

By default only `index.php` is Stencil enabled.
If you have a theme you want to convert to Stencil but don't want to do it all at once, you can keep all 'legacy' files like they are.
For files that you have converted, simply remove the file so WordPress does not load it.

Though if you want to keep the files but don't want WordPress to load them, you can set the following filter to `true`:

    add_filter( 'stencil:template_index_only', '__return_true' );

This way all template requests are handled by your `index.php`, effectively making all request run through your template engine.

## Assets directory

To keep everything nicely organised we suggest that you consider using the `assets` directory for static files like css, js or images.
When you use `get_template_directory_uri();` or `get_stylesheet_directory_uri();` this path is automatically added to it.

If you prefer to use another directory name use the `stencil:assets_path` filter.

If you want to disable this functionality completely, use the following code:

    add_filter( 'stencil:assets_path', '__return_false' );

## Views

WordPress uses a hierarchy to determine what php file is loaded for a request. In Stencil we tried to keep this structure in mind but extend it a little aswel.

(insert tree hierarchy here)

You can always look up the logic behind the view options in the files located inside the `plugins/stencil/classes/stencil/hierarchy/` files.

### Override the options

If this is not sufficient for you, you can easily override or extend the views that will be displayed for a certain request.

For example, to use the `single/my_fancy_single_view` view for all single pages, use the following code:

    <?php

    $stencil = get_stencil();
    $stencil->set_hierarchy( 'single', array( 'single/my_fancy_single_view' ) );

    ?>

## Permalinks

Stencil can automatically redirect all singular pages to their permalink version if another URL is requested.
You can do this by using the following code:

    <?php

    add_filter( 'stencil:force_permalink', '__return_true' );

    ?>

