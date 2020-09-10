<!-- Modal HTML -->
<div id="syncTagsModal" class="modal fade">
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">
			<div class="modal-header" style="background:#1D05FB;color:#FFF;">
				Product Tag Sync:
				<button type="button" id="close-img-modal" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
        <div id="sync-tag-loader" style="text-align:center;margin-top:20px;display:none;">
          <img src="global/imgs/spinner.gif" style="width:10%;margin:auto;" />
        </div>
        <div id="sync-progress" style="margin-top:20px;display:none;">
          <h4 style="text-align:center;">Syncing Product Tags with Shopify...</h4>
          <br><br>
          <div class="progress progress-lg">
            <div id="sync-progress-bar" class="progress-bar progress-bar-primary" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0/49</div>
          </div>
          <br>
          <h4 style="color:red;"><u>Errors:</u></h4>
          <ol id="sync_error_list" style="margin-left:30px;color:#FFF;">
            
          </ol>
        </div>
			</div>
		</div>
	</div>
</div> 