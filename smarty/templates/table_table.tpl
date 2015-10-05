<table id="explore-table" class="table table-bordered table-condensed table-hover sortable">
    <thead>
        <tr class="bg-primary">
                <th>
            {foreach $acts as $act}
                <th style="vertical-align:top">{$t[{$act}]}
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
