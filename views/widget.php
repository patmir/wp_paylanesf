<?php
   $options = get_option('paylane_sf_settings');
   $kwoty = isset($options['kwoty']) ?  explode(";", $options['kwoty']) :  array('1.00','2.00','5.00','10.00','20.00','50.00');
   $mid = isset($options['mid']) ? $options['mid'] : '';
   $salt = isset($options['salt']) ? $options['salt'] : '';
   $url = isset($options['url']) ? $options['salt'] : null;
   $submit = isset($options['url']) ? $options['submit'] : "Wspieram";

?>

<div class = "paylane-sf-widget">
<?php foreach($kwoty as $kwota) : ?>
<button class="paylane_sf_amount_button" data-amount="<?= $kwota;?>"><?= $kwota+0;?></button>
<?php endforeach;?>
<form class="paylane-sf-widget-form">
    <button type="submit"><?=$submit?></button>
</form>
</div>