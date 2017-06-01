{extends file="parent:frontend/account/profile.tpl"}

{block name='frontend_account_profile_profile_form'}
    {$smarty.block.parent}

    {if $isSocialRegistered eq 1}
        <div class="alert is--warning is--rounded">
            <div class="alert--icon">
                <i class="icon--element icon--warning"></i>
            </div>
            <div class="alert--content">
                <ul class="alert--list">
                    <li class="list--entry is--first">
                        {s name="HintSocialRegisterd" namespace="frontend/account/profile"}example text{/s}
                    </li>
                </ul>
            </div>
        </div>
    {/if}

{/block}