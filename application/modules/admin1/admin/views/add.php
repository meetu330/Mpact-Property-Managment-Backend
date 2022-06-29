<section class="content profile-page">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>Admins
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
                        <h2><strong><?php echo ($data->iAdminId) ? 'Edit' : 'Add'; ?> </strong> Admin </h2>
                    </div>
                    <form role="form" id="frm1" name="frm1" method="post" action="<?php echo base_url('admin/admin/add');?>" enctype="multipart/form-data">
                      <input type="hidden" id="id" name="id" value="<?php echo $data->iAdminId;?>">
                      <div class="body">
                          <div class="clearfix">
                            <div class="row">
                              <div class="col-lg-6 col-md-6">
                                  <div class="form-group">
                                      <label>Name</label>
                                      <input type="text" class="form-control" id="vName" name="vName" value="<?php echo $data->vName;?>" placeholder="Enter Name">
                                      <div id="vName_error" class="error" style="display: none;">Please Enter Name</div>
                                  </div>
                              </div>
                              <div class="col-lg-6 col-md-6">
                                  <div class="form-group">
                                      <label>Email</label>
                                      <input type="text" class="form-control" id="vEmail" name="vEmail" value="<?php echo $data->vEmail;?>" placeholder="Enter Email">
                                      <div id="vEmail_error" class="error" style="display: none;">Please Enter Email</div>
                                      <div id="vEmail_valid_error" class="error" style="display: none;">Please Enter Valid Email</div>
                                      <div id="vEmail_unique_error" class="error" style="display: none;">Please Enter Different Email</div>
                                  </div>
                              </div>
                              <div class="col-lg-6 col-md-6">
                                  <div class="form-group">
                                  <label>Role</label>
                                    <select name="iRoleId" id="iRoleId" class="form-control show-tick">
                                      <option value="none">Select Role</option>
                                      <?php foreach ($role as $key => $value) { ?>
                                        <option <?php echo ($value->iRoleId == $data->iRoleId) ? 'selected' : '';?> value="<?php echo $value->iRoleId; ?>"><?php echo $value->vTitle; ?></option>
                                      <?php } ?>
                                    </select>
                                    <div id="iRoleId_error" class="error" style="display: none;">Please Select Role</div>
                                  </div>
                              </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label>Center</label>
                                        <select name="iCenterId" class="form-control show-tick">
                                            <option value="">Select Centre</option>
                                            <?php foreach ($center as $key => $value) { ?>
                                                <option <?php echo ($value->iCenterId == $data->iCenterId) ? 'selected' : '';?> value="<?php echo $value->iCenterId; ?>"><?php echo $value->vCenterName; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                    <?php if(!isset($data->iAdminId)){?>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input type="password" class="form-control" id="vPassword" name="vPassword" value="" maxlength="6" placeholder="Enter Password">
                                                <div id="vPassword_error" class="error" style="display: none;">Please Enter Password</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>Confirm Password</label>
                                                <input type="password" class="form-control" id="vPassword2" name="vPassword2" value="" maxlength="6" placeholder="Enter Confirm Password">
                                                <div id="vPassword2_error" class="error" style="display: none;">Please Enter Confirm Password</div>
                                                <div class="error" id="vPassword2_same_error" style="display: none;">Password should match</div>
                                            </div>
                                        </div>
                                    <?php }?>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label>Phone Number</label>
                                            <input type="text" class="form-control" id="vPhone" name="vPhone" value="<?php echo $data->vPhone;?>" placeholder="Enter Phone Number">
                                        </div>
                                    </div>

                                    <?php if(isset($data->iAdminId)){?>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>IP Address: </label>
                                                <input type="text" class="form-control" id="vIPAddress" name="vIPAddress" value="<?php echo $data->vIPAddress;?>" placeholder="Enter Ip Address" readonly>
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <div class="col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>Upload Image</label>
                                            <input ui-jq="filestyle" type="file" id="image" name='image' data-icon="false" data-classbutton="btn btn-default" data-classinput="form-control inline v-middle input-s" tabindex="-1" style="position: absolute; clip: rect(0px, 0px, 0px, 0px);">
                                            <div class="bootstrap-filestyle input-group">
                                                <input type="text" class="form-control " disabled=""> 
                                                <span class="group-span-filestyle input-group-btn" tabindex="0">  <label for="image" class="btn btn-default m-0">
                                                    <span class="glyphicon glyphicon-folder-open"></span> Choose file
                                                </label>
                                            </span>
                                        </div>
                                        <br/>
                                        <div>
                                            <?php
                                            $image = base_url('assets/admin/images/avatar.png');
                                            if($data->vImage != ""){
                                                $image = base_url('assets/uploads/admin/'.$data->vImage);
                                            }
                                            ?>
                                            <img id="img" src="<?php echo $image;?>" width="100px" height="auto"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="eStatus" class="form-control show-tick">
                                            <option <?php echo ($data->eStatus == 'Active') ? 'selected' : '';?> value="active">Active</option>
                                            <option <?php echo ($data->eStatus == 'Inactive') ? 'selected' : '';?> value="inactive">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <a href="javascript:;" class="btn btn-raised btn-round btn-primary submit mr-2">Submit</a>
                                    <button type="button" class="btn btn-raised btn-round cancel">Cancel</button>
                                </div>
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
        location.href = "<?php echo base_url('admin/admin/admin');?>";
        return true;
    });

    $(document).on('change','#image',function(){
        if (this.files && this.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#img').attr('src', e.target.result);
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    $(document).on('click','.submit',function(){

      iAdminId = $("#id").val();
      
      vName       = $("#vName").val();
      iRoleId     = $("#iRoleId").val();
      vEmail      = $("#vEmail").val();
      vPassword   = $("#vPassword").val();
      vPassword2  = $("#vPassword2").val();

      var error = false;

      if(iRoleId == "none"){
        $("#iRoleId_error").show();
        error = true;
      } else{
        $("#iRoleId_error").hide();
      }

        if(vName.length == 0){
            $("#vName_error").show();
            error = true;
        } else{
            $("#vName_error").hide();
        }

        if(vEmail.length == 0){
            $("#vEmail_error").show();
            $("#vEmail_unique_error").hide();
            $("#vEmail_valid_error").hide();
            error = true;
        } else{
            if(iAdminId != "")
                data = {iAdminId:iAdminId, vEmail:vEmail};
            else
                data = {vEmail:vEmail};

            if(validateEmail(vEmail))
            {
                $("#vEmail_valid_error").hide();
                $.ajax({
                    url: "<?php echo base_url('admin/admin/admin/check_unique_email');?>",
                    type: "POST",
                    data:  data, 
                    success: function(response) {
                        if(response == 1){
                            $("#vEmail_unique_error").show();
                            $("#vEmail_error").hide();
                            error = true;
                        } else {
                            $("#vEmail_unique_error").hide();
                            $("#vEmail_error").hide();
                        }
                    }
                });
            } else {
                $("#vEmail_valid_error").show();
                $("#vEmail_error").hide();
                $("#vEmail_unique_error").hide();
                error = true;
            }
        }

        if(iAdminId == ""){
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

    function validateEmail(sEmail) {
        var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (filter.test(sEmail)) {
            return true;
        }
        else {
            return false;
        }
    }
</script>