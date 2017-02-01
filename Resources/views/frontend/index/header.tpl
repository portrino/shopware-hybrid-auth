{extends file="parent:frontend/index/header.tpl"}

{block name="frontend_index_header_css_screen" append}

    {assign var="includeFontAwesome" value="{config namespace="Port1HybridAuth" name="general_include_fontawesome"}"}

    {* Include FontAwesome via CDN if enabled in configuration *}
    {if $includeFontAwesome eq 1}
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    {/if}

{/block}