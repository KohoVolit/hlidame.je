<div class="modal fade" id="choose-show-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="{$t['close']}"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">{$t['choose_show']}</h4>
      </div>
      
      <div class="modal-body">
        

            <h3>{$t['choose_show']}</h3>
            <table class="table table-hover">
                <tbody>
                    <tr><td class="col-sm-6">
                        <h4><input type="radio" name="show" value="people"
                        {if ($show == 'people')}
                            checked
                        {/if}
                        > {$t['people']}</h4>
                        <td class="col-sm-6">
                         <h4><input type="radio" name="show" value="countries" 
                        {if ($show == 'countries')}
                            checked
                        {/if}> {$t['countries']}</h4>
                    <tr><td class="col-sm-6">
                         <h4><input type="radio" name="show" value="groups" {if ($show == 'groups')}
                            checked
                        {/if}> {$t['groups']}</h4>
                        <td class="col-sm-6">
                         <h4><input type="radio" name="show" value="parties" {if ($show == 'parties')}
                            checked
                        {/if}> {$t['parties']}  </h4> 
                </tbody>
            </table>                     
           
                
            <div class="row">
                <div class="col-sm-2"></div>
                <div class="col-sm-8">
                    <input type="submit" value="{$t['explore']}" class="btn btn-success btn-block btn-lg">
                </div>
            </div>
                

      </div>

    </div>
  </div>
</div>
