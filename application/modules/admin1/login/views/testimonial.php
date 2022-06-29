<div class="bg-light lter b-b wrapper-md">
    <h1 class="m-n font-thin h3">Testimonials</h1>
</div>
<div class="wrapper-md">
    <div class="panel panel-default">
        <div class="panel-heading">Testimonials List</div>
        <div class="table-responsive">
            <strong class="card-title">
                <button class="btn btn-success add" onclick="add_testimonial()"><i class="glyphicon glyphicon-plus"></i> Add
                    Testimonial
                </button>
                <input type="text" id="keyword" name="keyword">
                <button class="btn btn-success search">
                    <i class="glyphicon glyphicon-plus"></i> Search
                </button>
            </strong>
            <table class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th><a id="vTestimonialBy" class="sort" data-column="vTestimonialBy" data-order="ASC" href="#">Name</a></th>
                    <th>Image</th>
                    <th><a id="iTestimonialOrder" class="sort" data-column="iTestimonialOrder" data-order="ASC" href="#">Order</a></th>
                    <th><a id="dtUpdatedDate" class="sort" data-column="dtUpdatedDate" data-order="ASC" href="#">Modified Date</a></th>
                    <th><a id="eStatus" class="sort" data-column="eStatus" data-order="ASC" href="#">Status</a></th>
                    <th style="width:125px;">Action</th>
                </tr>
                </thead>
                <tbody class="table-hover" id="table_record"></tbody>
            </table>
            <div id="ajax-loader"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#ajax-loader").html('<tr><td style="text-align:center" colspan="9"><img src="../../assets/admin/images/ajax-loader.gif" width="250px" height="auto"/></td></tr>').show();

        setTimeout(function(){
            $.ajax({
                url: "testimonial/ajax_listing",
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
        location.href = "testimonial_add";
    });

    $(document).on('click','.edit',function(){
        id = $(this).data("id");
        location.href = "testimonial_edit/"+id;
    });

    $(document).on('click','.sort',function(){
        column = $(this).data("column");
        order = $(this).attr('data-order');

        if(order == "ASC"){
            $(this).attr('data-order','DESC');
        } else{
            $(this).attr('data-order','ASC');
        }

        $("#ajax-loader").html('<tr><td style="text-align:center" colspan="9"><img src="../../assets/admin/images/ajax-loader.gif" width="250px" height="auto"/></td></tr>').show();

        setTimeout(function(){
            $.ajax({
                url: "testimonial/ajax_listing",
                type: "POST",
                data:  {column:column,order,order,action:'sort'}, 
                success: function(response) {
                    $("#table_record").html(response);
                    $("#ajax-loader").hide();
                }
            });
        }, 1000);
    });

    $(document).on('click','.search',function(){
        keyword = $("#keyword").val();

        $("#ajax-loader").html('<tr><td style="text-align:center" colspan="9"><img src="../../assets/admin/images/ajax-loader.gif" width="250px" height="auto"/></td></tr>').show();

        setTimeout(function(){
            $.ajax({
                url: "testimonial/ajax_listing",
                type: "POST",
                data:  {keyword:keyword,action:'search'}, 
                success: function(response) {
                    $("#table_record").html(response);
                    $("#ajax-loader").hide();
                }
            });
        }, 1000);
    });

    $(document).on('click','.delete',function(){
        if (confirm('Are you sure delete this data?')) {
            id = $(this).data("id");

            $("#ajax-loader").html('<tr><td style="text-align:center" colspan="9"><img src="../../assets/admin/images/ajax-loader.gif" width="250px" height="auto"/></td></tr>').show();

            setTimeout(function(){
                $.ajax({
                    url: "testimonial/ajax_listing",
                    type: "POST",
                    data:  {id:id,action:'delete'}, 
                    success: function(response) {
                        $("#table_record").html(response);
                        $("#ajax-loader").hide();
                    }
                });
            }, 1000);
        }
    });
</script>