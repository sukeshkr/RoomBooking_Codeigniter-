<?php foreach ($rooms as $row) { ?> 

      <form role="form" method="post" enctype="multipart/form-data" action="<?php echo base_url() ?>Check_out/checkout_put">


    <table class="table table-striped table-bordered table-hover">
        <tbody>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"></h4>
        </div>

          <tr>
            <td>Total Amount</td>
            <td><?php echo $row->totalamt; ?></td>
        </tr>
          <tr>
            <td>Service Charge</td>
            <td><?php echo $row->service_amt; ?></td>
        </tr>
          <tr>
            <td>Advanced Amount</td>
            <td><?php echo $row->advanced_amt; ?></td>
        </tr>

            <div class="col-md-4">
              <div class="form-group">
                  <label>Payment Type</label>
                  <select class="form-control" name="payment_type">
                   <option selected value="cash payment">Cash Payment</option>
                   <option value="online payment">Online Payment</option>
                   <option value="card payment">Card Payment</option>
                  </select>
              </div>
          </div>
        
        <tr>
            <td>Total Balance</td>
           <td><?php echo $row->balanceamt + $row->service_amt; ?></td>
        </tr>
       
  <input type="hidden"  name="check_in_id"  value="<?= $row->id; ?>">

  <input type="hidden"  name="service_amt"  value="<?= $row->service_amt; ?>">

  <input type="hidden"  name="total_amt"  value="<?= $row->totalamt; ?>">

 <input type="submit"  name="submit" class="btn btn-primary" value="Submit">

  <?php } ?> 

 </form>
    
</tbody>
</table>





