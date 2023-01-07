
      <form role="form" method="post" enctype="multipart/form-data" action="<?php echo base_url() ?>daybook/payment_put" onSubmit="return validForm()">

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Payment Summary</h4>
        </div>
        
        <?php foreach ($daybook as $row) { ?> 

        <div class="col-md-6">
            <div class="form-group">
                <label>Balance Amount</label>
                <input id="bal_amt" readonly type="text"  maxlength="50" class="form-control" name="balance" value="<?= $row->balance;?>">
            </div>
        </div>

        
          <div class="col-md-6">
            <div class="form-group">
                <label>Payment Amount</label>
                <input id="pay_amt" type="text"  maxlength="50" class="form-control" name="payment" value="">
                 <p style="color:red;" class="help-block error-info" id="err-msg"></p>
            </div>
        </div>
    
      
      <input type="hidden"  name="id"  value="<?= $row->id;?>">

       <input type="hidden"  name="total_amt"  value="<?= $row->total_amt;?>">

       <input type="hidden"  name="old_payment"  value="<?= $row->payment  ;?>">

    <div class="col-md-12">
        <div class="form-group">

            <input type="submit"  name="submit" class="btn btn-primary" value="Submit">

        </div>
    </div>
    

  <?php } ?> 

 </form>
 

<script type="text/javascript">

function validForm(sel) {

  var bal_amt = $('#bal_amt').val();  

  var pay_amt = $('#pay_amt').val(); 

  if (pay_amt > bal_amt) { 

    document.getElementById("err-msg").innerHTML = 'Payment Amount is grater than balance amount';

    return false;
  } 
  else{

    document.getElementById("err-msg").innerHTML = '';

    return true;
  }

}

</script>





