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

  //CARGAR DESHABILITADO LOS INPUT
  $("#id-zona-actualizar").attr("readonly", true);

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
    // dom: "Bfrtip",
    lengthMenu: [
      [10, 25, 50, -1],
      [10, 25, 50, "All"],
    ],
    // buttons: [
    //   "excel",
    //   // "pdf",
    //   "print",
    //   {
    //     extend: "pdfHtml5",
    //     orientation: "landscape",
    //     pageSize: "LEGAL",
    //   },
    // ],
  });
});

// SOLO LETRAS
function sololetras(event) {
  var regex = new RegExp("^[a-zA-Z ]+$");
  var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
  if (!regex.test(key)) {
    event.preventDefault();
    return false;
  }
}

//-------------------- MODAL AGREGAR --------------------//
// CARGAR MODAL AGREGAR
$("#btn-agregar").on("click", function () {
  $("#nombre-zona").val("");
  $("#modal-agregar").modal("show");
});

// BOTON REGISTRAR
$("#btn-registrar").on("click", function () {
  var id = 1;
  var zona = 0;
  var nombre = $("#nombre-zona").val();
  var estado = 0;

  if (nombre == null || nombre == "") {
    Swal.fire({
      icon: "info",
      title: "Nombre de zona no puede estar vacío...",
      text: "Registre un nombre!",
      timer: 3000,
    });
  } else {
    Swal.fire({
      title: "Estas seguro de registrar la zona?",
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
          url: "/recursoshumanos/zona/mantenimiento_zona",
          data: { id: id, zona: zona, nombre: nombre, estado: estado },
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

// BOTON CANCELAR REGISTRO
$("#btn-cancelar-agregar").on("click", function () {
  $("#modal-agregar").modal("hide");
});

//-------------------- MODAL ACTUALIZAR --------------------//
// CARGAR MODAL ACTUALIZAR
$("#example1 tbody").on("click", "a.actualizar", function () {
  var cod = $(this).attr("id");

  $.ajax({
    type: "POST",
    url: "/recursoshumanos/zona/get_zona",
    data: { cod: cod },
    success: function (res) {
      $("#id-zona-actualizar").val("");
      $("#id-zona-actualizar").val(cod);

      $("#nombre-zona-actualizar").val("");
      $("#nombre-zona-actualizar").val(res.nombre);
      $("#estado-zona-actualizar").val("");
      $("#estado-zona-actualizar").val(res.estado);
    },
  });

  $("#modal-editar").modal("show");
});

// BOTON GUARDAR CAMBIOS
$("#btn-actualizar").on("click", function () {
  var id = 2; //actualizar
  var zona = $("#id-zona-actualizar").val();
  var nombre = $("#nombre-zona-actualizar").val();
  var estado = $("#estado-zona-actualizar").val();

  if (nombre == null || nombre == "") {
    Swal.fire({
      icon: "info",
      title: "Nombre zona no puede estar vacío...",
      text: "Registre un nombre!",
      timer: 3000,
    });
  }
  // else if (estado == 0 || estado == null) {
  //   Swal.fire({
  //     icon: "info",
  //     title: "No ha seleccionado ningun estado...",
  //     text: "Favor de seleccionar un estado válido!",
  //     timer: 3000,
  //   });
  // }
  else {
    Swal.fire({
      title: "Estas seguro de actualizar la zona?",
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
          url: "/recursoshumanos/zona/mantenimiento_zona",
          data: { id: id, zona: zona, nombre: nombre, estado: estado },
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
  }
});

// BOTON CANCELAR REGISTRO
$("#btn-cancelar-actualizar").on("click", function () {
  $("#modal-editar").modal("hide");
});