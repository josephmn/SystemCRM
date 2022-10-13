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
  
  //PARA CARGAR LA TABLA
  $("#example1").DataTable({
    lengthChange: true,
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
    order: [
      [0, "desc"],
      [1, "desc"],
    ],
    lengthMenu: [
      [10, 25, 50, -1],
      ["10 filas", "25 filas", "50 filas", "Todo"],
    ],
  });

  var fecha = new Date(); //Fecha actual
  var ano = fecha.getFullYear(); //obteniendo año

  //-------------------- MODAL AGREGAR --------------------//
  // CARGAR MODAL AGREGAR
  $("#btn-agregar").on("click", function () {
    $("#modal-agregar").modal("show");
  });

  // BONTON REGISTRAR
  $("#btn-registrar").on("click", function () {
    var id = 1; // insertar
    var semana = $("#semana").val();
    var local = $("#local").val();
    var anhio = ano;

    if (local == 0 || local == "") {
      $("#local").focus();
      Swal.fire({
        icon: "info",
        title: "Seleccione un local...",
        text: "Campo debe estar seleccionado!",
        timer: 3000,
        timerProgressBar: true,
        showCancelButton: false,
        showConfirmButton: false,
      });
    } else {
      Swal.fire({
        title: "Estas seguro de registrar los datos?",
        text: "Favor de confirmar!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#61C250",
        cancelButtonColor: "#ea5455",
        confirmButtonText: "Si, registrar!", //<i class="fa fa-smile-wink"></i>
        cancelButtonText: "No", //<i class="fa fa-frown"></i>
      }).then((result) => {
        if (result.value) {
          $.ajax({
            type: "POST",
            url: "/recursoshumanos/turnos/mantenimiento_turnos",
            data: { id: id, semana: semana, local: local, anhio: anhio },
            success: function (res) {
              if (res.icase < 4) {
                Swal.fire({
                  icon: res.vicon,
                  title: res.vtitle,
                  text: res.vtext,
                  timer: res.itimer,
                  timerProgressBar: res.vprogressbar,
                  showCancelButton: false,
                  showConfirmButton: false,
                });
                $("#modal-agregar").modal("hide");
                var id = setInterval(function () {
                  location.reload();
                  clearInterval(id);
                }, res.itimer);
              } else {
                Swal.fire({
                  icon: res.vicon,
                  title: res.vtitle,
                  text: res.vtext,
                  timer: res.itimer,
                  timerProgressBar: res.vprogressbar,
                  showCancelButton: false,
                  showConfirmButton: false,
                });
              }
            },
          });
        }
      });
    }
  });

  // BONTON CANCELAR REGISTRO
  $("#btn-cancelar-agregar").on("click", function () {
    $("#modal-agregar").modal("hide");
  });

  // var table = $('#example1').DataTable();

  // $('#example1 tbody')
  //     .on( 'mouseenter', 'td', function () {
  //         var colIdx = table.cell(this).index().column;

  //         $( table.cells().nodes() ).removeClass( 'highlight' );
  //         $( table.column( colIdx ).nodes() ).addClass( 'highlight' );
  //     } );

  // $('a.toggle-vis').on( 'click', function (e) {
  //     e.preventDefault();

  //     // Get the column API object
  //     var column = table.column( $(this).attr('data-column') );

  //     // Toggle the visibility
  //     column.visible( ! column.visible() );
  // } );

  // $("#example2").DataTable({
  //     // lengthChange: true,
  //     responsive: true,
  //     // autoWidth: false,
  //   });
});