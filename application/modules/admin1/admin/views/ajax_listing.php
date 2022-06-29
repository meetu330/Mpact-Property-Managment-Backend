<?php
$CI =& get_instance();
$CI->load->library('general');
$user_role_permission_info   = $CI->general->admin_role_permission_info();
?>
<?php if(count($data) > 0){?>
    <?php foreach ($data as $value) { ?>
        <tr>
            <td>
                <div class="checkbox">
                    <input id="<?php echo $value->iAdminId;?>" type="checkbox" name="iAdminId[]" class="checkboxall" value="<?php echo $value->iAdminId;?>">
                    <label for="<?php echo $value->iAdminId;?>">&nbsp;</label>
                </div>
            </td>
            <td>
                <?php echo $value->vName;?>
            </td>
            <td>
                <?php echo $value->vEmail;?>
            </td>
            <td>
                <?php echo $value->vPhone;?>
            </td>
            <td>
                <?php 
                    if(!empty($value->vCenter))
                        echo $value->vCenter;
                    else
                        echo "N/A";
                ?>
            </td>
            <td>
                <?php echo $CI->general->date_format($value->dtUpdatedDate);?>
            </td>
            <td>
                <?php echo $value->eStatus;?>
            </td>
            <?php if(in_array('edit', $user_role_permission_info) || in_array('delete', $user_role_permission_info)) { ?>
            <td>
                <?php if(in_array('edit', $user_role_permission_info)){ ?>
                    <button class="edit" data-id="<?php echo $value->iAdminId;?>">
                        <i class="zmdi zmdi-edit"></i>
                    </button>
                    <?php if($value->iAdminId != 1){?>
                        <button class="change_password" title="Change Password" data-id="<?php echo $value->iAdminId;?>">
                            <i class="zmdi zmdi-lock"></i>
                        </button>
                    <?php } ?>
                <?php } ?>
                <?php if(in_array('delete', $user_role_permission_info)){ ?>
                    <button class="zmdi-remove delete" data-id="<?php echo $value->iAdminId;?>">
                        <i class="zmdi zmdi-delete"></i>
                    </button>
                <?php } ?>
            </td>
            <?php } ?>
        </tr>
    <?php }?>
    <tr>
        <td colspan="9" align="center">
            <?php echo $paging;?>
        </td>
    </tr>

<?php } else {?>
    <tr>
        <td colspan="7"><center>No record found</center></td>
    </tr>
<?php }?>

                                    