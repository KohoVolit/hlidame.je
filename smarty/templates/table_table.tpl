<table id="explore-table" class="table table-bordered table-condensed table-hover sortable">
    <thead>
        <tr class="bg-primary">
                <th>
            {foreach $acts as $act}
                <th style="vertical-align:top">
                    <div data-toggle="tooltip" data-trigger="hover" title='{$t["description-{$act}"]}'>
                        {$t[{$act}]} 
                    </div>
                    <div tabindex="0" data-toggle="popover" data-trigger="focus" title="{$t[{$act}]}" data-content='{$t["description-{$act}"]}'
                    {if $act@index > 0.5*count($acts)} data-placement="left"{/if}
                    >
                            <i class="fa fa-info-circle"> </i>
                        
                    </div>
            {/foreach}
    <tbody>
    {foreach $data as $row}
        <tr>
            {include "table_table_first-cell.tpl"}
        {foreach $acts as $key=>$act}
            <td>
                {include "table_table_cell.tpl"}
        {/foreach}
    {/foreach}
 
</table>
