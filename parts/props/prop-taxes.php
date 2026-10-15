<?php
$tax_title       = get_post_meta($post->ID, '_prop_tax_title', true);
$tax_desc        = get_post_meta($post->ID, '_prop_tax_desc', true);
$tax_title_display = tnb_format_price($tax_title);
if($tax_desc): ?>
<div class="card block">
    <div class="card-header">

        <?php if($tax_title_display): ?>
            <h3 class="card-header-title"><?php echo sprintf(__('%s Gastos iniciales'), $tax_title_display); ?></h3>
        <?php else: ?>
            <h3 class="card-header-title"><?php echo __('Gastos iniciales') ?></h3>
        <?php endif; ?>
    </div>
    <div class="card-content">
        <?php echo wpautop($tax_desc, true); ?>
    </div>
</div>
<?php endif; ?>

<?php
$tax_month_title       = get_post_meta($post->ID, '_prop_tax_month_title', true);
$tax_month_desc        = get_post_meta($post->ID, '_prop_tax_month_desc', true);
$tax_month_title_display = tnb_format_price($tax_month_title);
if($tax_month_desc): ?>
<div class="card block">
    <div class="card-header">
        <?php if($tax_month_title_display): ?>
            <h3 class="card-header-title"><?php echo sprintf(__('%s Gastos mensuales'), $tax_month_title_display); ?></h3>
        <?php else: ?>
            <h3 class="card-header-title"><?php echo __('Gastos mensuales') ?></h3>
        <?php endif; ?>
    </div>
    <div class="card-content">
        <?php echo wpautop($tax_month_desc, true); ?>
    </div>
</div>
<?php endif; ?>

<?php
//$rent_values       = get_post_meta($post->ID, '_prop_rent', true);
//$rent_values_desc  = $data['_prop_rent_desc'][0];

//pr($data);
//pr($rent_values);

$rent_values       = get_post_meta($post->ID, '_prop_rent', true);
//$rent_values_desc  = get_post_meta($post->ID, '_prop_rent_desc', true);

//pr(array_key_exists('value', $rent_values[0]));
//pr($rent_values);
if($rent_values && array_key_exists('value', $rent_values[0])):
?>
<div class="card block">
    <div class="card-header">
        <h3 class="card-header-title"><?php echo __('Importe') ?></h3>
    </div>
    <div class="card-content">
        <?php /*
        <?php if($rent_values_desc): ?>
            <?php echo wpautop($rent_values_desc) ?>
        <?php endif; ?>
        */ ?>
        <ul class="">
            <?php
            foreach($rent_values as $value):
                $amount = tnb_format_price(array(
                    'currency' => isset($value['currency']) ? $value['currency'] : '',
                    'symbol'   => isset($value['symbol']) ? $value['symbol'] : '',
                    'value'    => isset($value['value']) ? $value['value'] : '',
                ));
                echo sprintf('<li>%s: %s</li>', $value['concept'], $amount ? $amount : '-');
            endforeach;
            ?>
        </ul>
    </div>
</div>
<?php endif; ?>
