<?php foreach ($service as $row) { ?> 
    <table class="table table-striped table-bordered table-hover">
        <tbody>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><?php echo $row->service_name; ?></h4>
        </div>

          <tr>
            <td>Description</td>
            <td><?php echo $row->rate; ?></td>
        </tr>
    <?php } ?> 
    
</tbody>
</table>





