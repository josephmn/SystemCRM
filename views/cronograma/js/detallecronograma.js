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

  //Date range picker
  $("#fcorte").datetimepicker({
    format: "DD/MM/YYYY",
  });

  // //Date and time picker
  // $("#fcorte").datetimepicker({ icons: { time: "far fa-clock" } });

  $("#documento_editar,#nombre_editar,#anhio_editar,#vanhio,#vmes,#vnommes").attr(
    "readonly",
    true
  );

  // bsCustomFileInput.init();

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
    order: [[2, "asc"]],
    dom: "Bfrtip",
    lengthMenu: [[15], ["15 rows"]],
    buttons: [
      "excel",
      // "pdf",
      "print",
      {
        extend: "pdfHtml5",
        orientation: "landscape",
        pageSize: "LEGAL",
      },
    ],
  });

  /////////////////////// MODAL EDITAR ///////////////////////
  // CARGAR MODAL EDITAR CRONOGRAMA
  $("#example1 tbody").on("click", "a.editar", function () {
    var id = $(this).attr("id");

    $("#cod_editar").html("");
    $("#cod_editar").html(id);
    $("#documento_editar").val("");
    $("#nombre_editar").val("");
    $("#meses_editar").val("");
    $("#tipo_editar").val("");
    $("#dias_editar").val("");
    $("#anhio_editar").val("");

    $.ajax({
      type: "POST",
      url: "/recursoshumanos/cronograma/buscar_cronograma",
      data: { id: id },
      success: function (res) {
        $("#documento_editar").val(res.dni);
        $("#nombre_editar").val(res.nombre);
        $("#meses_editar").val(res.mes);
        $("#tipo_editar").val(res.tipo);
        $("#dias_editar").val(res.dia);
        $("#anhio_editar").val(res.anhio);
      },
    });

    $("#modal-editar").modal("show");
  });

  // EDITAR CRONOGRAMA
  $("#btn_actualizar").on("click", function () {
    var post = 2; // ACTUALIZAR
    var codigo = $("#cod_editar").text(); // CODIGO VACACION
    var dni = $("#documento_editar").val();
    var mes = $("#meses_editar").val();
    var tipo = $("#tipo_editar").val();
    var dia = $("#dias_editar").val();
    var anhio = $("#anhio_editar").val();

    Swal.fire({
      title: "Estas seguro de actualizar la vacacion programada?",
      text: "Favor de confirmar!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#61C250",
      cancelButtonColor: "#ea5455",
      confirmButtonText: "Si, actualizar!", //<i class="fa fa-smile-wink"></i>
      cancelButtonText: "No", //<i class="fa fa-frown"></i>
    }).then((result) => {
      if (result.value) {
        $.ajax({
          type: "POST",
          url: "/recursoshumanos/cronograma/mantenimiento_cronograma",
          data: {
            post: post,
            codigo: codigo,
            dni: dni,
            mes: mes,
            tipo: tipo,
            dia: dia,
            anhio: anhio,
          },
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
              $("#modal-editar").modal("hide");
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

  // CANCELAR ACTUALIZACION DEL CRONOGRAMA
  $("#btn_cancelar").on("click", function () {
    $("#modal-editar").modal("hide");
  });

  /////////////////////// MODAL ELIMINAR ///////////////////////
  // CARGAR MODAL ELIMINAR CRONOGRAMA
  $("#example1 tbody").on("click", "a.delete", function () {
    let post = 3; // ELIMINAR
    let codigo = $(this).attr("id"); // CODIGO VACACION
    let nombre = $(this).attr("vnombre");
    let dni = "88888888";
    let mes = 0;
    let tipo = 0;
    let dia = 0;
    let anhio = 0;

    Swal.fire({
      title:
        "Estas seguro de eliminar la programacion de vacaciones del personal " +
        nombre +
        "?",
      text: "Favor de confirmar!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#61C250",
      cancelButtonColor: "#ea5455",
      confirmButtonText: "Si, eliminar!", //<i class="fa fa-smile-wink"></i>
      cancelButtonText: "No", //<i class="fa fa-frown"></i>
    }).then((result) => {
      if (result.value) {
        $.ajax({
          type: "POST",
          url: "/recursoshumanos/cronograma/mantenimiento_cronograma",
          data: {
            post: post,
            codigo: codigo,
            dni: dni,
            mes: mes,
            tipo: tipo,
            dia: dia,
            anhio: anhio,
          },
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
              $("#modal-editar").modal("hide");
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

  /////////////////////// CARGAR PAGO DE VACACIONES ///////////////////////
  $("#btncargar").on("click", function () {
    anhio = $("#vanhio").val();
    mes = $("#vmes").val();
    fcorte = $("#fcorte").val();
    nommes = $("#vnommes").val();

    $.ajax({
      type: "POST",
      url: "/recursoshumanos/cronograma/pagolinkmensual",
      data: {
        anhio: anhio,
        mes: mes,
        nommes: nommes,
        fcorte: fcorte,
      },
      success: function (res) {
        location.href = res.vlink;
      },
    });
  });
});

function validaNumericos(evt) {
  var code = evt.which ? evt.which : evt.keyCode;
  if (code == 8) {
    // backspace.
    return true;
  } else if (code >= 48 && code <= 57) {
    // is a number.
    return true;
  } else {
    // other keys.
    return false;
  }
}
