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

  //cargar deshabilitado los botones
  $("#dni, #nombre").attr("readonly", true);

  var Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 5000,
  });

  creardatatable("#example1", -1);

  // seleccion de meses
  $("#meses").change(function () {
    let mes = $("#meses").val();
    let anhio = $("#anhio").val();

    $.ajax({
      type: "POST",
      url: "/recursoshumanos/conremoto/construir_tabla",
      data: { anhio: anhio, mes: mes },
      success: function (res) {
        $("#example1").dataTable().fnDestroy();
        $("#tbdet").html("");
        $("#tbdet").append(res.div);
        creardatatable("#example1", -1);
      },
    });
  });

  // seleccion de año
  $("#anhio").change(function () {
    let mes = $("#meses").val();
    let anhio = $("#anhio").val();

    $.ajax({
      type: "POST",
      url: "/recursoshumanos/conremoto/construir_tabla",
      data: { anhio: anhio, mes: mes },
      success: function (res) {
        $("#example1").dataTable().fnDestroy();
        $("#tbdet").html("");
        $("#tbdet").append(res.div);
        creardatatable("#example1", -1);
      },
    });
  });

  // aprobar horario semanal
  $("#example1 tbody").on("click", "a.aprobar", function () {
    let post = 2; // update
    let id = $(this).attr("id"); // no se usa

    Swal.fire({
      title: "Estas seguro de aprobar el siguiente horario?",
      text: "Favor de confirmar!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#61C250",
      cancelButtonColor: "#ea5455",
      confirmButtonText: "Si, aprobar!", //<i class="fa fa-smile-wink"></i>
      cancelButtonText: "No", //<i class="fa fa-frown"></i>
    }).then((result) => {
      if (result.value) {
        $.ajax({
          type: "POST",
          url: "/recursoshumanos/conremoto/mantenimiento_remoto",
          data: { post: post, id: id },
          success: function (res) {
            // console.log(res);
            // JSON.stringify(console.log(res));
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
  });
});

// crear tabla
function creardatatable(nombretabla, row) {
  var tabla = $(nombretabla).dataTable({
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
    lengthMenu: [[row], ["All"]],
    order: [
      [3, "asc"],
      [6, "asc"],
      [7, "asc"],
      [8, "asc"],
      [9, "asc"],
      [10, "asc"],
    ],
  });
  return tabla;
}