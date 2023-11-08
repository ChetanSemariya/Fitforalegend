$(document).ready(function(){
    // Check admin password is correct or not
    $('#current_pwd').keyup(function(){
        var current_pwd = $('#current_pwd').val();
        $.ajax({
            type:'post',
            url:'/admin/check_current_password',
            data:{current_pwd:current_pwd},
            success:function(resp){
                 if(resp=="false"){
                    
                 }
            },error:function(){
                alert("Error");
            }
        })
    });
})