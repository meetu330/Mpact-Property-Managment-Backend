<?php 
$CI =& get_instance();
$CI->load->library('general');
$user_role_permission_info   = $CI->general->admin_role_permission_info();
?>
<section class="content profile-page">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-4 col-sm-12">
                <h2>Admin
                </h2>
            </div>
            <div class="col-lg-7 col-md-8 col-sm-12">
                <div class="row m-0">
                    <span class="col-xs-7 col-md-3 col-lg-4 left-right-padding pl-0 pr-0 ml-lg-auto col-6">
                        <select name="eStatus" id ="status" class="form-control show-tick mb-0">
                            <option value="">Select Action</option>
                            <?php if(in_array('edit', $user_role_permission_info)) { ?>
                                <option value="Active">Change Status Active</option>
                                <option value="Inactive">Change Status Inactive</option>
                            <?php } ?>
                            <?php if(in_array('delete', $user_role_permission_info)) { ?>
                                <option value="delete_admin">Delete</option>
                            <?php } ?>
                        </select>
                    </span>
                    <div class="input-group col-lg-4 col-6 col-md-4">                
                        <input type="text" class="form-control" id="keyword" name="keyword" placeholder="Search...">
                        <button class="input-group-addon addon-search search"><i class="zmdi zmdi-search"></i></button>
                        <div id="keyword_error" class="error" style="display: none;">Please Enter keyword</div>
                    </div>
                    <ul class="breadcrumb">
                        <?php if(in_array('add', $user_role_permission_info)){ ?>
                            <li class="breadcrumb-item px-4"><a href="javascript:;" class="add"><i class="zmdi zmdi-plus"></i> Add Admin</a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card student-list">
                    <div class="header">
                        <h2><strong>Admin</strong> List</h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-hover m-b-0">
                                <thead>
                                    <tr>  
                                        <th class="che">
                                            <div class="checkbox adcheck">
                                                <input id="selectall" type="checkbox" name="selectall" class="css-checkbox">
                                                <label for="selectall">&nbsp;</label>
                                            </div>
                                        </th>                                     
                                        <th><a id="vName" class="sort" data-column="vName" data-order="ASC" href="#">Name</a></th>
                                        <th><a id="vEmail" class="sort" data-column="vEmail" data-order="ASC" href="#">Email</a></th>
                                        <th><a id="vPhone" class="sort" data-column="vPhone" data-order="ASC" href="#">Phone</a></th>
                                        <th><a id="vCenter" class="sort" data-column="vCenter" data-order="ASC" href="#">Centre</a></th>
                                        <th><a id="dtUpdatedDate" class="sort" data-column="dtUpdatedDate" data-order="ASC" href="#">Modified Date</a></th>
                                        <th><a id="eStatus" class="sort" data-column="eStatus" data-order="ASC" href="#">Status</a></th>
                                        <?php if(in_array('edit', $user_role_permission_info) || in_array('delete', $user_role_permission_info)){ ?>
                                            <th class="actionwidth" style="width: 15%;">Action</th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody class="table-hover" id="table_record"></tbody>
                            </table>
                            <div class="text-center" id="ajax-loader">
                                <img src="<?php echo base_url('assets/admin/images/ajax-loader.gif');?>" width="250px" height="auto"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    $(document).ready(function() {
        $("#ajax-loader").show();

        url = "<?php echo base_url('admin/admin/admin/ajax_listing');?>";

        setTimeout(function(){
            $.ajax({
                url: url,
                type: "POST",
                data:  {}, 
                success: function(response) {
                    $("#table_record").html(response);
                    $("#ajax-loader").hide();
                }
            });
        }, 1000);
    });

    $(document).on('click','.add',function(){
        location.href = "add";
    });

    $(document).on('click','.edit',function(){
        id = $(this).data("id");
        location.href = "edit/"+id;
    });

    $(document).on('click','.change_password',function(){
        id = $(this).data("id");
        location.href = "change_password/"+id;
    });

    $(document).on('click','.sort',function(){
        column = $(this).data("column");
        order = $(this).attr('data-order');

        if(order == "ASC"){
            $(this).attr('data-order','DESC');
        } else{
            $(this).attr('data-order','ASC');
        }

        $("#ajax-loader").show();

        url = "<?php echo base_url('admin/admin/admin/ajax_listing');?>";

        setTimeout(function(){
            $.ajax({
                url: url,
                type: "POST",
                data:  {column:column,order,order,action:'sort'}, 
                success: function(response) {
                    $("#table_record").html(response);
                    $("#ajax-loader").hide();
                }
            });
        }, 1000);
    });

    $(document).on('click','.search',function()
    {
        keyword = $("#keyword").val();

        if(keyword.length == 0){
          $("#keyword_error").show();
          error = true;
           } else {
          $("#keyword_error").hide();
          $("#ajax-loader").show();
          $("#table_record").hide();
        }

        url = "<?php echo base_url('admin/admin/admin/ajax_listing');?>";

        setTimeout(function(){
            $.ajax({
                url: url,
                type: "POST",
                data:  {keyword:keyword,action:'search'}, 
                success: function(response) {
                    $("#table_record").html(response);
                    $("#ajax-loader").hide();
                    $("#table_record").show();
                }
            });
        }, 1000);
    });

    $(document).on('click','.delete',function(){
        swal({
            title: "Are you sure delete this Admin.?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if(willDelete)
            {
                id = $(this).data("id");

                $("#ajax-loader").show();

                url = "<?php echo base_url('admin/admin/admin/ajax_listing');?>";

                setTimeout(function(){
                    $.ajax({
                        url: url,
                        type: "POST",
                        data:  {id:id,action:'delete'}, 
                        success: function(response) {
                            $("#table_record").html(response);
                            $("#ajax-loader").hide();
                        }
                    });
                }, 1000);
            }
        })
    });

    $("#selectall").click(function()
    {
        if(this.checked){
            $('.checkboxall').each(function(){
                $(".checkboxall").prop('checked', true);
            });
        }else{
            $('.checkboxall').each(function(){
                $(".checkboxall").prop('checked', false);
            });
        }
    });

    $(document).on('change','#status',function()
    {
        eStatus = $("#status").val();

        iAdminId = [];
        $("input[name='iAdminId[]']:checked").each( function () {
            iAdminId.push($(this).val());
        });
        
        if(eStatus != "")
        {    
            if(iAdminId != "")
            {
                if(eStatus == "delete_admin")
                {
                    swal({
                        title: "Are you sure delete this Admin.?",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if(willDelete)
                        {
                            $("#table_record").html('');
                            $("#ajax-loader").show();

                            url = "<?php echo base_url('admin/admin/admin/ajax_listing'); ?>";

                            setTimeout(function(){
                                $.ajax({
                                    url: url,
                                    type: "POST",
                                    data:  {iAdminId : iAdminId,action:'status',eStatus:eStatus}, 
                                    success: function(response) {
                                        notification_success('Admin Delete Successfully');
                                        $("#table_record").html(response);
                                        $("#ajax-loader").hide();
                                    }
                                });
                            }, 500);
                        }
                    })
                } else{
                    $("#table_record").html('');
                    $("#ajax-loader").show();

                    url = "<?php echo base_url('admin/admin/admin/ajax_listing'); ?>";

                    setTimeout(function(){
                        $.ajax({
                            url: url,
                            type: "POST",
                            data:  {iAdminId : iAdminId,action:'status',eStatus:eStatus}, 
                            success: function(response) {
                                notification_success('Admin Status Update Successfully');
                                $("#table_record").html(response);
                                $("#ajax-loader").hide();
                            }
                        });
                    }, 500); 
                }
            }else{
                swal({
                  title: "Please Select Admin.",
                })
            }
        }
    });

</script>