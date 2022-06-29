<section class="content profile-page">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>Settings
                </h2>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Edit Setting </strong></h2>
                    </div>
                    <form role="form" method="post" action="<?php echo base_url('admin/setting/setting_edit');?>" enctype="multipart/form-data">
                      <input type="hidden" id="mode" name="mode" value="<?php echo $mode;?>">
                        <div class="body">
                            <div class="row">
                              <?php foreach ($settings as $setting) { ?>
                                  <div class="col-sm-12">
                                      <div class="form-group">
                                          
                                          <?php if($setting->eDisplayType == 'text'){?>
                                          <label class="setting_label"> <?php echo $setting->vDesc;?></label>
                                          <input type="text" class="form-control" id="<?php echo $setting->vName;?>" name="<?php echo $setting->vName;?>" value="<?php echo $setting->vValue;?>">
                                        <?php } else if($setting->eDisplayType == 'textarea'){?>
                                          <label class="setting_label"> <?php echo $setting->vDesc;?></label>
                                          <textarea class="form-control" id="<?php echo $setting->vName;?>" name="<?php echo $setting->vName;?>"><?php echo $setting->vValue;?></textarea>
                                        <?php } else if($setting->eDisplayType == 'checkbox'){?>
                                          <input type="checkbox" class="form-control setting_checkbox" id="<?php echo $setting->vName;?>" name="<?php echo $setting->vName;?>" value="Y">
                                          <label class="setting_label"> <?php echo $setting->vDesc;?></label>
                                        <?php } else if($setting->eDisplayType == 'selectbox'){?>
                                          <?php
                                          $select = explode(",", $setting->vSourceValue);
                                          ?>
                                          <label class="setting_label"> <?php echo $setting->vDesc;?></label>
                                          <select class="form-control show-tick" id="<?php echo $setting->vName;?>" name="<?php echo $setting->vName;?>">
                                            <?php foreach ($select as $key => $value) {?>
                                              <option value="<?php echo $value;?>" <?php echo ($value == $setting->vValue) ? 'selected' : '';?>><?php echo $value;?></option>
                                            <?php }?>
                                          </select>
                                        <?php } else if($setting->eDisplayType == 'file'){?>
                                          <label class="setting_label"> <?php echo $setting->vDesc;?></label>
                                          <input type="file" class="form-control" id="<?php echo $setting->vName;?>" name="<?php echo $setting->vName;?>">
                                          <?php
                                          if($setting->vValue != ""){
                                            if ($setting->vName == "TESTIMONIAL_IMAGE") {
                                              $image = base_url('assets/uploads/testimonial/'.$setting->vValue);
                                            }else{
                                              $image = base_url('assets/uploads/logo/'.$setting->vValue);
                                            }
                                          ?>
                                            <img id="img" src="<?php echo $image;?>" width="100px" height="auto"/>
                                          <?php }?>                          
                                        <?php }?>
                                      </div>
                                  </div>
                              <?php }?>
                              <div class="col-sm-12">
                                  <button type="submit" class="btn btn-primary btn-round mr-2">Submit</button>
                                  <button type="button" class="btn btn-raised btn-round  cancle cancel">Cancel</button>
                              </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    $(document).on('click','.cancel',function(){
        location.href = "<?php echo base_url('admin/setting/setting');?>";
        return true;
    });
</script>

