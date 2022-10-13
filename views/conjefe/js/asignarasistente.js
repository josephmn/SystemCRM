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

  //cargar deshabilitado los input
  $("#dni,#nombre,#dnijefe,#nombrejefe,#nombreasistente").attr(
    "readonly",
    true
  );

  creardatatable("#example1", 10, 2); //tabla.- index

  // modal agregar
  $("#btnagregar").on("click", function () {
    let dnijefe = $("#dni").val();
    let nombrejefe = $("#nombre").val();

    $("#dnijefe").val(dnijefe);
    $("#nombrejefe").val(nombrejefe);
    $("#dniasistente").val("");
    $("#nombreasistente").val("");
    $("#modal-agregar").modal("show");
  });

  $("#modal-agregar").on("shown.bs.modal", function () {
    $("#dniasistente").focus();
  });

  // guardar cambios
  $("#btnguardar").on("click", function () {
    let post = 1; // referencial
    let dnijefe = $("#dnijefe").val(); //dni del jefe
    let nombrejefe = $("#nombrejefe").val(); //dni del asistente
    let dniasistente = $("#dniasistente").val(); //dni del asistente
    let nombreasistente = $("#nombreasistente").val(); //dni del asistente

    if (nombreasistente == "" || nombreasistente == null) {
      Swal.fire({
        icon: "error",
        title: "Favor de ingresar un DNI válido a asignar",
        text: "No se puede guardar!",
        timer: 3000,
        timerProgressBar: res.vprogressbar,
        showCancelButton: false,
        showConfirmButton: false,
      });
      return;
    }

    Swal.fire({
      title:
        "Estas seguro de asignar a " +
        nombreasistente +
        " como asistente de " +
        nombrejefe +
        "?",
      text: "Favor de confirmar!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#61C250",
      cancelButtonColor: "#ea5455",
      confirmButtonText: "Si, guardar!", //<i class="fa fa-smile-wink"></i>
      cancelButtonText: "No", //<i class="fa fa-frown"></i>
    }).then((result) => {
      if (result.value) {
        $.ajax({
          type: "POST",
          url: "/recursoshumanos/conjefe/mantenimiento_asistentes",
          data: {
            post: post,
            dnijefe: dnijefe,
            dniasistente: dniasistente,
          },
          success: function (res) {
            if (res.icase != 4) {
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
              $("#modal-agregar").modal("hide");
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

  $("#btncancelar").on("click", function () {
    $("#modal-agregar").modal("hide");
  });

  // BOTON DE VALIDAR DNI
  $("#btnvalidar").on("click", function () {
    var doc = $("#dniasistente").val();

    $.ajax({
      type: "POST",
      url: "/recursoshumanos/cronograma/validar_documento",
      data: { doc: doc },
      success: function (res) {
        switch (res.dato) {
          case 0:
            Swal.fire({
              icon: "error",
              title: "DNI no existe o personal a cesado",
              text: "Favor de verificar en el sistema!",
              timer: 3000,
              timerProgressBar: true,
              showCancelButton: false,
              showConfirmButton: false,
            });
            $("#nombreasistente").val("");
            break;
          case 1:
            Swal.fire({
              icon: "success",
              title: "DNI correcto",
              timer: 1000,
              timerProgressBar: true,
              showCancelButton: false,
              showConfirmButton: false,
            });
            $("#nombreasistente").val(res.nombre);
            break;
        }
      },
    });
  });

  // ELIMINAR A PERSONAL
  $("#example1 tbody").on("click", "a.eliminar", function () {
    let post = 3; // quitar no elimina registro
    let dnijefe = "";
    let dniasistente = $(this).attr("id");
    let nombreasistente = $(this).attr("nomasis");

    Swal.fire({
      title:
        "Estas seguro de quitar a " +
        nombreasistente +
        " del grupo de asistentes?",
      text: "Favor de confirmar!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#61C250",
      cancelButtonColor: "#ea5455",
      confirmButtonText: "Si, quitar!", //<i class="fa fa-smile-wink"></i>
      cancelButtonText: "No", //<i class="fa fa-frown"></i>
    }).then((result) => {
      if (result.value) {
        $.ajax({
          type: "POST",
          url: "/recursoshumanos/conjefe/mantenimiento_asistentes",
          data: {
            post: post,
            dnijefe: dnijefe,
            dniasistente: dniasistente,
          },
          success: function (res) {
            if (res.icase != 4) {
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
function creardatatable(nombretabla, row, orden) {
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
    order: [[orden, "asc"]],
    lengthMenu: [
      [25, 50, 100, -1],
      [25, 50, 100, "All"],
    ],
    dom: "Bfrtip",
    buttons: [
      "excel",
      //"pdf",
      "print",
      {
        extend: "pdfHtml5",
        orientation: "landscape",
        pageSize: "LEGAL",
      }, //pdf
    ],
  });
  return tabla;
}

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