<span class="center-block">
{if isset($row['activities'][$act])}
    {if $thirds[$act]['upper'] < $row['activities'][$act]['ave']}
        <i class="fa fa-circle traffic-color-1 fa-2x"></i> 
    {elseif $thirds[$act]['lower'] < $row['activities'][$act]['ave']}
        <i class="fa fa-circle traffic-color-2 fa-2x"></i>
    {else}
        <i class="fa fa-circle traffic-color-3 fa-2x"></i>
    {/if}
    {round($row['activities'][$act]['ave'],1)|regex_replace:'/[.,]0+$/':''}
    
{else}
    <span class="center-block"><i class="fa fa-circle traffic-color-3 fa-2x"></i> 0
{/if}
</span>



{*{$it = $data_selected[$p->id][$q->id]}*}
{*{if $it->value !== ""}*}
{*    <div class="center-block"><i class="fa fa-circle traffic-color-{$it->value} fa-2x"></i></div>*}
{*{/if}*}
{*{foreach $it->options as $o}*}
{*    <small>{$o}</small>*}
{*    {if !($o@last)}<br>{/if}*}
{*{/foreach}*}
{*{if count($it->options) == 0}*}
{*    {foreach $it->options as $o}*}
{*        <small>{$o}</small>*}
{*        {if !($o@last)}<br>{/if}*}
{*    {/foreach}*}
{*{else}*}
{*    {if count($it->texts) > 0}*}
{*        <div style="cursor:pointer" class="text-info"><button tabindex="0" data-toggle="popover" data-trigger="focus" title="{$t['details']['text']}:" data-content="*}
{*        {foreach $it->texts as $ittext}*}
{*            {$ittext}*}
{*            {if !($ittext@last)}; {/if}*}
{*        {/foreach}*}
{*        " class="fa fa-info-circle"></button>*}
{*        </div>*}
{*    {/if}*}
{*{/if}*}
