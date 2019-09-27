function roleEditFunction(elem){

    var x = elem.id;

    $.ajax({

        type: "POST",
        dataType: 'json',
        data: {role_id: x},
        url: "../getRoleDetails",         
        success: function(data){            
            
            $('#roleID').val(data['id']);
            $('#roleEdit').val(data['role']);
            $('#descEdit').val(data['description']);
            $("#editRoleModal").modal('show');

        }                        

    });
}