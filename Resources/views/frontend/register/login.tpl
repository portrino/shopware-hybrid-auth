{extends file="parent:frontend/register/login.tpl"}

{* Existing customer *}
{block name='frontend_register_login_form'}

    <div class="port1--hybrid--auth">
        {* generic iterator through provided / configured authsources *}
        {foreach from=$providers item=providerLabel key=providerKey}
            <a class="single--sign--on {$providerKey|lower} btn" href="{url controller=socialUser action=login provider=$providerKey sTarget=$sTarget sTargetAction=$sTargetAction}">
                <span class="fa fa-{$providerKey|lower}"></span>
                {$providerLabel}
            </a>
        {/foreach}
    </div>

    {$smarty.block.parent}
{/block}