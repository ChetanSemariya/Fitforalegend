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
});