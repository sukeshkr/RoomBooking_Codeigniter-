<?php foreach ($rooms as $row) { ?> 
    <table class="table table-striped table-bordered table-hover">
        <tbody>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"></h4>
        </div>

          <tr>
            <td>Room No.</td>
            <td><?php echo $row->room_no; ?></td>
        </tr>
          <tr>
            <td>Room Location.</td>
            <td><?php echo $row->location; ?></td>
        </tr>
        
        <tr>
            <td>Room Image</td>
            <td>  <img src="<?= CUSTOM_BASE_URL . 'uploads/room/'.$row->room_image; ?>" class="img-responsive" id="previews"></td>
        </tr>
       
    <?php } ?> 
    
</tbody>
</table>





