    <?php
$CI =& get_instance();
$CI->load->library('general');
?>
<?php if(count($settings) > 0){?>
    <?php foreach ($settings as $setting) { ?>
        <tr>
            <td>
                <?php echo $setting->vName; ?>
            </td>
            <td>
                <?php echo $setting->vDesc; ?>
            </td>
            <td>
                <?php echo $setting->vValue; ?>
            </td>
            <td>
                <?php echo $setting->iSettingOrder;?>
            </td>
            <td>
                <?php echo $setting->eConfigType;?>
            </td>
            <td>
                <?php echo $setting->eDisplayType;?>
            </td>
            <td>
                <?php echo $setting->eSource;?>
            </td>
            <td>
                <?php echo $setting->vSourceValue;?>
            </td>
        </tr>
    <?php }?>
<?php } else {?>
    <tr>
        <td colspan="7"><center>No record found</center></td>
    </tr>
<?php }?>