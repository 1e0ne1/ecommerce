

        <div class="col-md-12">
<div class="row">
<h1 class="page-header">
   All Orders

</h1>
</div>

<div class="row">
<table class="table table-hover">
    <thead>

      <tr>
           <th>ID</th>
           <th>Amount</th>
           <th>Transaction ID</th>
           <th>Status</th>
           <th>Order Date</th>
           <th>Buyer Email</th>
           <th>Invoice No.</th>
      </tr>
    </thead>
    <tbody>
        
        <?php get_orders(); ?>

    </tbody>
</table>
</div>
