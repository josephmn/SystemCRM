$(function(){

    $("#dni").on('input', function (evt) {
        $(this).val($(this).val().replace(/[^0-9]/, ''));
    });

    $('#email').attr('disabled',true);
    
    $('#dni').on('blur',function(){
        var dni = $(this).val();
       $.ajax({
            type:'POST',
            url:'/recursoshumanos/index/validar_dni',
            data:{dni:dni},
            success:function(res){
                switch(res){
                    case "0":
                        $('#email').attr('disabled',false);
                        break;
                    case "1":
                        $('#email').attr('disabled',true);
                        $('.msj').html("<div class='alert alert-warning'>Usted esta activo en el sistema</div>");
                        setTimeout(function(){
                            $('.msj').html("");
                        },3000);
                        break;
                    case "2":
                        $('#email').attr('disabled',true);
                        $('.msj').html("<div class='alert alert-warning'>El DNI no existe en el sistema</div>");
                        setTimeout(function(){
                            $('.msj').html("");
                        },3000);
                        break;
                    case "3":
                        $('#email').attr('disabled',true);
                        $('.msj').html("<div class='alert alert-warning'>Ingrese un DNI</div>");
                        setTimeout(function(){
                            $('.msj').html("");
                        },3000);
                        break;
                }
            }
       });
    });

    $('#btn_registrar').on('click',function(){
        var dni = $('#dni').val();
        var email = $('#email').val();

        $.ajax({
            type:'POST',
            url:'/recursoshumanos/index/send_email',
            data:{dni:dni,email:email},
            beforeSend:function(){

            },
            success:function(res){
                alert(res.estado);
                /*switch(res.estado){
                    case "0":
                        $('#modal-activacion').modal('show');
                        break;
                    case "1":
                        $('.msj').html("<div class='alert alert-danger'>Error al enviar el email</div>");
                        setTimeout(function(){
                            $('.msj').html("");
                        },3000);
                        break;
                }*/
            }
        });
    })

});