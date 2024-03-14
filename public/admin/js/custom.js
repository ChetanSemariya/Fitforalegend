$(document).ready(function(){
    // Check admin password is correct or not
    $('#current_pwd').keyup(function(){
        var current_pwd = $('#current_pwd').val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/check_current_password',
            data:{current_pwd:current_pwd},
            success:function(resp){
                if(resp=="false"){
                    $("#verifyCurrentPwd").html("Current Password is Incorrect!");
                }else if(resp =="true"){
                    $("#verifyCurrentPwd").html("Current Password is Correct!");
                }
            },error:function(){
                alert("Error");
            }
        });
    });

    // Update Cms page Status
    $(document).on("click", ".updateCmsPageStatus", function(){
        // here i is the children of link tag a and active-inactive status is our attribute
        var status = $(this).children("i").attr("status");
        var page_id = $(this).attr("page_id");
        // alert(page_id);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url : '/admin/update-cms-pages-status',
            data:{status:status, page_id:page_id},
            success:function(resp){
                if(resp['status'] ==0){
                    $("#page-"+page_id).html("<i class='fas fa-toggle-off' style='color:grey' status='Inactive'></i>")
                }else if(resp['status'] ==1){
                    $("#page-"+page_id).html("<i class='fas fa-toggle-on' style='color:#3f6ed3' status='Active'></i>");
                }
            },error:function(){
                alert('Error');
            }
        });
    });

    // Update Category Status
    $(document).on("click", ".updateCategoryStatus", function(){
        // here i is the children of link tag a and active-inactive status is our attribute
        var status = $(this).children("i").attr("status");
        var category_id = $(this).attr("category_id");
        // alert(category_id);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url : '/admin/update-category-status',
            data:{status:status, category_id:category_id},
            success:function(resp){
                if(resp['status'] ==0){
                    $("#category-"+category_id).html("<i class='fas fa-toggle-off' style='color:grey' status='Inactive'></i>")
                }else if(resp['status'] ==1){
                    $("#category-"+category_id).html("<i class='fas fa-toggle-on' style='color:#3f6ed3' status='Active'></i>");
                }
            },error:function(){
                alert('Error');
            }
        });
    });

    // Update Product Status
    $(document).on("click", ".updateproductStatus", function(){
        // here i is the children of link tag a and active-inactive status is our attribute
        var status = $(this).children("i").attr("status");
        var product_id = $(this).attr("product_id");
        // alert(category_id);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url : '/admin/update-product-status',
            data:{status:status, product_id:product_id},
            success:function(resp){
                if(resp['status'] ==0){
                    $("#product-"+product_id).html("<i class='fas fa-toggle-off' style='color:grey' status='Inactive'></i>")
                }else if(resp['status'] ==1){
                    $("#product-"+product_id).html("<i class='fas fa-toggle-on' style='color:#3f6ed3' status='Active'></i>");
                }
            },error:function(){
                alert('Error');
            }
        });
    });

    // Update Subadmin Status
    $(document).on("click", ".updateSubadminStatus", function(){
        // here i is the children of link tag a and active-inactive status is our attribute
        var status = $(this).children("i").attr("status");
        var subadmin_id = $(this).attr("subadmin_id");
        // alert(status);
        // alert(subadmin_id);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url : '/admin/update-subadmin-status',
            data:{status:status, subadmin_id:subadmin_id},
            success:function(resp){
                if(resp['status'] ==0){
                    $("#subadmin-"+subadmin_id).html("<i class='fas fa-toggle-off' style='color:grey' status='Inactive'></i>")
                }else if(resp['status'] ==1){
                    $("#subadmin-"+subadmin_id).html("<i class='fas fa-toggle-on' style='color:#3f6ed3' status='Active'></i>");
                }
            },error:function(){
                alert('Error');
            }
        });
    });

    // Update Product Attribute Status
    $(document).on("click", ".updateAttributeStatus", function(){
        // here i is the children of link tag a and active-inactive status is our attribute
        var status = $(this).children("i").attr("status");
        var attribute_id = $(this).attr("attribute_id");
        // alert(status);
        // alert(attribute_id);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url : '/admin/update-attribute-status',
            data:{status:status, attribute_id:attribute_id},
            success:function(resp){
                if(resp['status'] ==0){
                    $("#attribute-"+attribute_id).html("<i class='fas fa-toggle-off' style='color:grey' status='Inactive'></i>")
                }else if(resp['status'] ==1){
                    $("#attribute-"+attribute_id).html("<i class='fas fa-toggle-on' style='color:#3f6ed3' status='Active'></i>");
                }
            },error:function(){
                alert('Error');
            }
        });
    });

    // Update Brand Status
    $(document).on("click", ".updateBrandStatus", function(){
        // here i is the children of link tag a and active-inactive status is our attribute
        var status = $(this).children("i").attr("status");
        var brand_id = $(this).attr("brand_id");
        // alert(status);
        // alert(brand_id);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url : '/admin/update-brand-status',
            data:{status:status, brand_id:brand_id},
            success:function(resp){
                if(resp['status'] ==0){
                    $("#brand-"+brand_id).html("<i class='fas fa-toggle-off' style='color:grey' status='Inactive'></i>")
                }else if(resp['status'] ==1){
                    $("#brand-"+brand_id).html("<i class='fas fa-toggle-on' style='color:#3f6ed3' status='Active'></i>");
                }
            },error:function(){
                alert('Error');
            }
        });
    });

    // Update Banner Status
    $(document).on("click", ".updateBannerStatus", function(){
        // here i is the children of link tag a and active-inactive status is our attribute
        var status = $(this).children("i").attr("status");
        var banner_id = $(this).attr("banner_id");
        // alert(status);
        // alert(brand_id);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url : '/admin/update-banner-status',
            data:{status:status, banner_id:banner_id},
            success:function(resp){
                if(resp['status'] ==0){
                    $("#banner-"+banner_id).html("<i class='fas fa-toggle-off' style='color:grey' status='Inactive'></i>")
                }else if(resp['status'] ==1){
                    $("#banner-"+banner_id).html("<i class='fas fa-toggle-on' style='color:#3f6ed3' status='Active'></i>");
                }
            },error:function(){
                alert('Error');
            }
        });
    });

    // confirm the simple delete of CMS Page using Ajax
    // $(document).on("click", ".confirmDelete", function(){
    //     var name = $(this).attr('name');
    //     // alert(name);
    //     if(confirm('Are You Sure to delete this '+name+'?')){
    //         return true;
    //     }else{
    //         return false;
    //     }
    // });

    // Using Sweet Alert library
    $(document).on("click", ".confirmDelete", function(){
        var record = $(this).attr('record');
        var recordid = $(this).attr('recordid');
        // alert(recordid);
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
          }).then((result) => {
            if (result.isConfirmed) {
              Swal.fire({
                title: "Deleted!",
                text: "Your file has been deleted.",
                icon: "success"
              });
              window.location.href ="/admin/delete-"+record+"/"+recordid;
            }
        });
    });

    // Add Product Attributes script 
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '<div><input type="text" name="size[]" style="width:120px;" placeholder="Size"/>&nbsp;<input type="text" name="sku[]" style="width:120px;" placeholder="SKU"/>&nbsp;<input type="text" name="price[]" style="width:120px;" placeholder="Price"/>&nbsp;<input type="text" name="stock[]" style="width:120px;" placeholder="Stock"/><a href="javascript:void(0);" class="remove_button">Remove</a></div>'; //New input field html 
    var x = 1; //Initial field counter is 1
    
    // Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increase field counter
            $(wrapper).append(fieldHTML); //Add field html
        }else{
            alert('A maximum of '+maxField+' fields are allowed to be added. ');
        }
    });
    
    // Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrease field counter
    });
});