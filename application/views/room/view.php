<?php foreach ($rooms as $row) { ?> 
    <table class="table table-striped table-bordered table-hover">
        <tbody>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><?php echo $row->room_no; ?></h4>
        </div>

        <tr>
            <td>Room number</td>
            <td><?php echo $row->room_no; ?></td>
        </tr>
      
        <tr>
            <td>Rate</td>
            <td><?php echo $row->rate; ?></td>
        </tr>

          <tr>
            <td>location</td>
            <td><?php echo $row->location; ?></td>
        </tr>

        <?php foreach ($images as $image) { ?> 

             <tr>
            <td>Room Images</td>
              <td>  <img src="<?= CUSTOM_BASE_URL . 'uploads/room/'.$image->room_image; ?>" class="img-responsive" id="previews"></td>
        </tr>

    <?php } } ?> 
    
</tbody>
</table>





