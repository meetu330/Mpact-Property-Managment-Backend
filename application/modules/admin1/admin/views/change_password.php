<section class="content profile-page">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>Admin
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
                        <h2><strong>Change Password</strong></h2>
                    </div>
                    <form role="form" id="frm1" method="post" action="<?php echo base_url('admin/admin/change_password');?>" enctype="multipart/form-data">
                    <input type="hidden" id="id" name="id" value="<?php echo $id;?>">
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control" id="vPassword" name="vPassword" value="" placeholder="Enter Password">
                                    <div id="vPassword_error" class="error" style="display: none;">Please Enter Password</div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <input type="password" class="form-control" id="vPassword2" name="vPassword2" value="" placeholder="Enter Confirm Password">
                                    <div id="vPassword2_error" class="error" style="display: none;">Please Enter Confirm Password</div>
                                    <div class="error" id="vPassword2_same_error" style="display: none;">Password should match</div>
                                </div>
                            </div>
                      </div>
                        <!-- <div class="row clearfix">
                            <div class="col-sm-12">
                              <a class="btn btn-raised btn-round submit">Submit</a>
                              <button type="button" class="btn btn-raised btn-round cancel">Cancel</button>
                            </div>
                        </div> -->
                        <div class="col-sm-12 pl-0">
                          <a href="javascript:;" class="btn btn-raised btn-round btn-primary submit mr-2">Submit</a>
                          <button type="button" class="btn btn-raised btn-round cancel">Cancel</button>
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
        location.href = "<?php echo base_url('admin/admin/admin');?>";
        return true;
    });

    $(document).on('click','.submit',function(){
    
    vPassword     = $("#vPassword").val();
    vPassword2    = $("#vPassword2").val();

    var error = false;
    
      if(vPassword.length == 0){
          $("#vPassword_error").show();
          error = true;
        } else{
            $("#vPassword_error").hide();
        }

        if(vPassword2.length == 0){
            $("#vPassword2_error").show();
            error = true;
        } else{
            $("#vPassword2_error").hide();
        }

       if(vPassword.length != 0 &&  vPassword2.length !=0)
       {
          if(vPassword != vPassword2){
            $("#vPassword2_same_error").show();
            return false;
          } else{
            $("#vPassword2_same_error").hide();
          }
        }else{
          $("#vPassword2_same_error").hide();
        }
   
    setTimeout(function(){
      if(error == true){
        return false;
      } else {
        $("#frm1").submit();
        return true;
      }
    }, 1000);
  });
</script>