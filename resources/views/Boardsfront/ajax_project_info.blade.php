<p class="in_pro_info">
    <span class="_in_left"> Transaction:  </span><span class="_in_right"> <?php echo $project->transaction == 0 ? "Buyer" : "Seller"; ?> </span>
</p>
<p class="in_pro_info">    
    <span class="_in_left"> Amount:  </span><span class="_in_right"> $<?php echo $project->transaction_amount > 0 ? number_format($project->transaction_amount, 2) : "0.00"; ?> </span>
</p>
<?php
if ($project->transaction_type > 0) {
    $transactions = DB::table('transactions')
            ->where('id', $project->transaction_type)
            ->first();
    ?>

    <p class="in_pro_info">    
        <span class="_in_left"> Type:  </span><span class="_in_right"> <?php echo $transactions->type ? $transactions->type : "N/A"; ?> </span>
    </p>

    <?php
}
?>