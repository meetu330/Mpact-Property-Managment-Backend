<?php
$CI =& get_instance();
$CI->load->library('general');
?>
<?php if(count($testimonials) > 0){?>
    <?php foreach ($testimonials as $testimonial) { ?>
        <tr>
            <td>
                <?php echo $testimonial->vTestimonialBy; ?>
            </td>
            <td align="center">
                <?php
                $image = base_url('assets/admin/images/avatar.png');
                if($testimonial->vTestimonialByImage != ""){
                    $image = base_url('assets/uploads/testimonials/'.$testimonial->vTestimonialByImage);
                }
                ?>
                <img src="<?php echo $image;?>" width="100px" height="auto"/>
            </td>
            <td>
                <?php echo $testimonial->iTestimonialOrder;?>
            </td>
            <td>
                <?php echo $CI->general->date_time_format($testimonial->dtUpdatedDate);?>
            </td>
            <td>
                <?php echo $testimonial->eStatus;?>
            </td>
            <td>
                <button class="btn btn-warning edit" data-id="<?php echo $testimonial->iTestimonialId;?>">
                    <i class="glyphicon glyphicon-pencil"></i>
                </button>
                <button class="btn btn-danger delete" data-id="<?php echo $testimonial->iTestimonialId;?>">
                    <i class="glyphicon glyphicon-remove"></i>
                </button>
            </td>
        </tr>
    <?php }?>
<?php } else {?>
    <tr>
        <td colspan="7"><center>No record found</center></td>
    </tr>
<?php }?>