// $(document).ready(function() {
//     $('table.highchart').highchartTable();
//   });

$(function () {
  $("#btncerrarsession").on("click", function () {
    Swal.fire({
      title: "Estas seguro de cerrar sesión?",
      text: "Favor de confirmar!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#61C250",
      cancelButtonColor: "#ea5455",
      confirmButtonText: "Si, cerrar!", //<i class="fa fa-smile-wink"></i>
      cancelButtonText: "No", //<i class="fa fa-frown"></i>
    }).then((result) => {
      if (result.value) {
        $.ajax({
          type: "POST",
          url: "/recursoshumanos/index/logout",
          success: function (res) {
            location.reload();
          },
        });
      }
    });
  });

  $("table.highchart").highchartTable();

  $("#example1").DataTable({
    responsive: true,
    autoWidth: false,
    language: {
      decimal: "",
      emptyTable: "No hay información",
      info: "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
      infoEmpty: "Mostrando 0 to 0 of 0 Entradas",
      infoFiltered: "(Filtrado de _MAX_ total entradas)",
      infoPostFix: "",
      thousands: ",",
      lengthMenu: "Mostrar _MENU_ Entradas",
      loadingRecords: "Cargando...",
      processing: "Procesando...",
      search: "Buscar:",
      zeroRecords: "Sin resultados encontrados",
      paginate: {
        first: "Primero",
        last: "Ultimo",
        next: "Siguiente",
        previous: "Anterior",
      },
    },
    // dom: 'Bfrtip',
    lengthMenu: [
      [6, 14, -1],
      ["6 filas", "14 filas", "Todo"],
    ],
  });

  /*function validacion(){
        if(parseInt($('#sel_civil').val())===0){
            $('#sel_civil').focus();
            return false;
        }
        if(parseInt($('#sel_estados').val())===0){
            $('#sel_estados').focus();
            return false;
        }
        return true;
    }

    $('#btn_filtrar').on('click',function(){
        let civil = $('#sel_civil').val();
        let estados = $('#sel_estados').val();

        if(validacion()){

            $.ajax({
                type:'POST',
                url:'/recursoshumanos/dashboard/show_table',
                data:{civil:civil,estados:estados},
                success:function(resul){

                    

                    $('#tb_datos').html('');
                    $('#tb_datos').html(resul.filas);

                    $("#example1").DataTable();

                }
            });

        }else{
            alert('error en la validacion');
        }
    })*/
});
