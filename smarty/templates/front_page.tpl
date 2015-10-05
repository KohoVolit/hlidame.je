{extends file='main.tpl'}
{block name=body}
    <h1>{$t['fp_title']}</h1>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-4">
            <a href="ep/">
                <div style="text-align:center;">
                    <img width="300" height="225" src="images/ep.jpg" alt="{$t['european_parliament']}" class="fp-image img-rounded text-center">
                </div>
                <h3 class="text-center">{$t['european_parliament']}</h3>
            </a>
        </div>
        <div class="col-md-4">
            <a href="council/">
                <div style="text-align:center;">
                    <img width="300" height="225" src="images/council.jpg" alt="{$t['council']}" class="fp-image img-rounded text-center">
                </div>
                <h3 class="text-center">{$t['council']}</h3>
            </a>
        </div>
    </div>
{/block}
