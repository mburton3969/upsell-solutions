<!-- Modal HTML -->
<div id="imageUploadModal" class="modal fade">
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">
			<div class="modal-header" style="background:#1D05FB;">
				<div class="icon-box">
					<i class="material-icons">add_photo_alternate</i>
				</div>
				<button type="button" id="close-img-modal" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body text-center">
				<h4>Add Product Image:</h4>	
				<!--<img src="https://via.placeholder.com/350x150" id="img_preview" style="width:100%;" />-->
				<!--<button class="btn btn-primary" data-dismiss="modal" style="background:blue;"><span>Select Image From File</span> <i class="material-icons">image_search</i></button>-->
				<form id="img-form" action="assets/php/upload-product-img.php" method="POST" enctype="multipart/form-data">
          <input type="file" id="img-file" name="img-file" style="display:none;" onchange="uploadProdImg(this);" />
        </form>
        <button class="btn btn-primary" onclick="document.getElementById('img-file').click();" style="background:green;">
            <span>Select Image From File</span> 
            <i class="material-icons">cloud_upload</i>
          </button>
			</div>
		</div>
	</div>
</div> 