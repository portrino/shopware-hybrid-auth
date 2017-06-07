{extends file="parent:frontend/index/index.tpl"}

{* Shop header *}
{block name='frontend_index_navigation'}
    <header class="header-main">
        {* Include the top bar navigation *}
        {block name='frontend_index_top_bar_container'}{/block}

        {block name='frontend_index_header_navigation'}
            <div class="container header--navigation">

                {* Logo container *}
                {block name='frontend_index_logo_container'}
                    {include file="frontend/index/logo-container.tpl"}
                {/block}

                {* Shop navigation *}
                {block name='frontend_index_shop_navigation'}{/block}

                {block name='frontend_index_container_ajax_cart'}{/block}
            </div>
        {/block}
    </header>

    {* Maincategories navigation top *}
    {block name='frontend_index_navigation_categories_top'}{/block}
{/block}


{block name='frontend_index_content'}

    <h1>{s name='ForbiddenHeader' namespace="frontend/typo3login/forbidden"}Sie haben leider nicht die erforderlichen Rechte diese Seite zu nutzen.{/s}</h1>
    <p>{s name='ForbiddenDescription' namespace="frontend/typo3login/forbidden"}Dies ist eine interne Seite und kann nur von autorisierten Nutzern eingesehen werden. Sie haben leider nicht die erforderlichen Rechte diese Seite zu nutzen. Vielen Dank für Ihr Verständnis.{/s}</p>
{/block}

{* removes content right and left *}
{block name='frontend_index_content_right'}{/block}
{block name='frontend_index_content_left'}{/block}
{block name='frontend_index_emotion_loading_overlay'}{/block}

{* removes Breadcrumb *}
{block name='frontend_index_breadcrumb'}{/block}

{* removes last seen articles *}
{block name='frontend_index_left_last_articles'}{/block}

{* removes footer *}
{block name="frontend_index_footer"}{/block}

{* removes body inline *}
{block name='frontend_index_body_inline'}{/block}

{* removes js *}
{block name="frontend_index_header_javascript"}{/block}
{block name="frontend_index_header_javascript_jquery_lib"}{/block}
{block name="frontend_index_header_javascript_jquery"}{/block}