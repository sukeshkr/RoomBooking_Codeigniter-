<?php foreach ($customer as $row) { ?> 
    <table class="table table-striped table-bordered table-hover">
        <tbody>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <tr>
            <td>Name</td>
            <td><?php echo $row->name; ?></td>
        </tr>

          <tr>
            <td>Joining Date</td>
            <td><?php echo $row->joining_date; ?></td>
        </tr>
      
        <tr>
            <td>Phone</td>
            <td><?php echo $row->phone; ?></td>
        </tr>

          <tr>
            <td>Alternate Phone</td>
            <td><?php echo $row->phone1; ?></td>
        </tr>
          <tr>
            <td>Email</td>
            <td><?php echo $row->email; ?></td>
        </tr>
          <tr>
            <td>Location</td>
            <td><?php echo $row->location; ?></td>
        </tr>
          <tr>
            <td>State</td>
            <td><?php echo $row->state; ?></td>
        </tr>
        <tr>
            <td>Country</td>
            <td><?php echo $row->country; ?></td>
        </tr>
         <tr>
            <td>Address</td>
            <td><?php echo $row->address; ?></td>
        </tr>

        <tr>
            <td>Reference</td>
            <td><?php echo $row->reference; ?></td>
        </tr>
        <tr>
            <td>ID Proof Type</td>
            <td><?php echo $row->id_proof_type; ?></td>
        </tr>
        <tr>
            <td>ID Proof No</td>
            <td><?php echo $row->id_proof_no; ?></td>
        </tr>

         <tr>
            <td>ID Proof Image</td>
            <td>  <img src="<?= CUSTOM_BASE_URL . 'uploads/news/crop/'.$row->prof_image; ?>" class="img-responsive" id="previews"></td>
        </tr>
    <?php } ?> 
    
</tbody>
</table>





