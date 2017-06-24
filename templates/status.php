<?php if($data->hasStatus()){
    $status = $data->getStatus();
    if(isset($status['error'])): ?>
        <div class="alert alert-warning"><?= $status['status']; ?></div>
    <?php else: ?>
        <div class="alert alert-success"><?= $status['status']; ?></div>
    <?php endif;
}?>