<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">
    <i class="fa fa-trash" aria-hidden="true"></i>
        <h4 class="modal-title" >Are you sure want to delete ?</h4>
         <?php $career_id = $this->input->post('rowid'); ?>
           <form method="post" action="<?php echo base_url() ?>Room_type/delete">
              <input name="id" type="hidden" value="<?php echo $career_id;?>">
              <input type="submit"  name="delete"   class="btn confirm-btn" value="Delete">
              <input type="button"   class="btn confirm-btn" data-dismiss="modal" value="Cancel">
            </form>  
</div>

        