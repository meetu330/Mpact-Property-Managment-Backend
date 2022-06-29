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
                    <form role="form" method="post" action="<?php echo base_url('admin/setting/setting_add');?>" enctype="multipart/form-data">
                    <div class="body">
                                <div class="row">
                                  <?php foreach ($settings as $setting) { ?>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label> <?php echo $setting->vDesc;?></label>
                                            <input type="text" class="form-control" id="vName" name="vName" value="<?php echo $setting->vValue;?>">
                                        </div>
                                    </div>
                                    <?php }?>
                                    <div class="col-sm-12">
                                      <a href="javascript:;" class="btn btn-primary btn-lg btn-round btn-simple submit">Submit</a>
                                        <button class="btn btn-primary btn-lg btn-round btn-simple cancle">Cancle</button>
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

