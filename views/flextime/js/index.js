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
  $("#id-flex").attr("readonly", true);

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
      [7, "asc"],
      [1, "asc"],
    ],
    // dom: "Bfrtip",
    lengthMenu: [
      [10, 25, 50, -1],
      [10, 25, 50, "All"],
    ],
  });

  var Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 5000,
  });

  //-------------------- MODAL AGREGAR --------------------//
  // CARGAR MODAL AGREGAR FLEX
  $("#btn-agregar").on("click", function () {
    $("#nombre-flex").val("");
    $("#hora-inicio").val("");
    $("#hora-fin").val("");
    $("#tolerancia").val("");
    $("#id-zona").val("0");
    obtener_local(0);
    $("#modal-agregar").modal("show");
  });

  // FOCO AL MODAL AGREGAR
  $("#modal-agregar").on("shown.bs.modal", function () {
    $("#nombre-flex").focus();
  });

  // CARGAR COMBO LOCAL
  $("#id-zona").on("change", function () {
    let zona = $("#id-zona").val();
    obtener_local(zona);
  });

  // BONTON REGISTRAR
  $("#btn-registrar").on("click", function () {
    let post = 1; // insertar
    let id = 0;
    let nombre = $("#nombre-flex").val();
    let estado = 0;
    let horaini = $("#hora-inicio").val();
    let horafin = $("#hora-fin").val();
    let tolerancia = $("#tolerancia").val();
    let idzona = $("#id-zona").val();
    let idlocal = $("#id-local").val();

    if (nombre == null || nombre == "") {
      Toast.fire({
        icon: "error",
        title: "Nombre para flex time no puede estar vacío..!!",
      });
      $("#nombre-flex").focus();
      return;
    }

    if (idzona == 0 || idzona == null) {
      Toast.fire({
        icon: "error",
        title: "No ha seleccionado ninguna zona...!!",
      });
      $("#id-zona").focus();
      return;
    }

    if (idlocal == 0 || idlocal == null) {
      Toast.fire({
        icon: "error",
        title: "No ha seleccionado ningun local...!!",
      });
      $("#id-local").focus();
      return;
    }

    if (horaini == null || horaini == "") {
      Toast.fire({
        icon: "error",
        title: "No ha ingresado una hora de inicio...",
      });
      $("#hora-inicio").focus();
      return;
    }

    if (horafin == null || horafin == "") {
      Toast.fire({
        icon: "error",
        title: "No ha ingresado una hora de fin...",
      });
      $("#hora-fin").focus();
      return;
    }

    if (tolerancia == null || tolerancia == "") {
      Toast.fire({
        icon: "error",
        title: "No ha ingresado una hora de tolerancia...",
      });
      $("#tolerancia").focus();
      return;
    }

    let horaempieza = parseInt(horaini.replace(":", ""));
    let horatermina = parseInt(horafin.replace(":", ""));

    if (horaempieza > horatermina) {
      Toast.fire({
        icon: "error",
        title: "Hora fin no puede ser menor a la hora de inicio...",
      });
      $("#hora-fin").focus();
      return;
    }

    Swal.fire({
      title: "Estas seguro de guardar el siguiente Flex Time?",
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
          url: "/recursoshumanos/flextime/mantenimiento_flextime",
          data: {
            post: post,
            id: id,
            nombre: nombre,
            estado: estado,
            horaini: horaini,
            horafin: horafin,
            tolerancia: tolerancia,
            idzona: idzona,
            idlocal: idlocal,
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
  });

  // BONTON CANCELAR REGISTRO
  $("#btn-cancelar-agregar").on("click", function () {
    $("#modal-agregar").modal("hide");
  });

  //-------------------- MODAL ACTUALIZAR --------------------//
  // CARGAR MODAL ACTUALIZAR
  $("#example1 tbody").on("click", "a.actualizar", function () {
    var id = $(this).attr("id");

    $.ajax({
      type: "POST",
      url: "/recursoshumanos/flextime/data_local",
      data: { id: id },
      success: function (res) {
        console.log(res.zona);
        console.log(res.local);
        $("#id-flex").val(id);
        $("#nombre-flex1").val(res.nombre);
        $("#hora-inicio1").val(res.horainicio);
        $("#hora-fin1").val(res.horafin);
        $("#tolerancia1").val(res.tolerancia);
        $("#id-estado1").val(res.estado);
        $("#id-zona1").val(res.zona);
        obtener_local_editar(res.zona, res.local);
      },
    });

    $("#modal-editar").modal("show");
  });

  // CARGAR COMBO LOCAL ACTUALIZAR
  $("#id-zona1").on("change", function () {
    let zona = $("#id-zona1").val();
    obtener_local2(zona);
  });

  // FOCO AL MODAL EDITAR
  $("#modal-editar").on("shown.bs.modal", function () {
    $("#nombre-flex1").focus();
  });

  // BONTON GUARDAR CAMBIOS
  $("#btn-actualizar").on("click", function () {
    var post = 2; // update
    let id = $("#id-flex").val();
    let nombre = $("#nombre-flex1").val();
    let horaini = $("#hora-inicio1").val();
    let horafin = $("#hora-fin1").val();
    let tolerancia = $("#tolerancia1").val();
    let estado = $("#id-estado1").val();
    let idzona = $("#id-zona1").val();
    let idlocal = $("#id-local1").val();

    if (nombre == null || nombre == "") {
      Toast.fire({
        icon: "error",
        title: "Nombre para flex time no puede estar vacío..!!",
      });
      $("#nombre-flex").focus();
      return;
    }

    if (idzona == 0 || idzona == null) {
      Toast.fire({
        icon: "error",
        title: "No ha seleccionado ninguna zona...!!",
      });
      $("#id-zona").focus();
      return;
    }

    if (idlocal == 0 || idlocal == null) {
      Toast.fire({
        icon: "error",
        title: "No ha seleccionado ningun local...!!",
      });
      $("#id-local").focus();
      return;
    }

    if (horaini == null || horaini == "") {
      Toast.fire({
        icon: "error",
        title: "No ha ingresado una hora de inicio...",
      });
      $("#hora-inicio").focus();
      return;
    }

    if (horafin == null || horafin == "") {
      Toast.fire({
        icon: "error",
        title: "No ha ingresado una hora de fin...",
      });
      $("#hora-fin").focus();
      return;
    }

    if (tolerancia == null || tolerancia == "") {
      Toast.fire({
        icon: "error",
        title: "No ha ingresado una hora de tolerancia...",
      });
      $("#tolerancia").focus();
      return;
    }

    let horaempieza = parseInt(horaini.replace(":", ""));
    let horatermina = parseInt(horafin.replace(":", ""));

    if (horaempieza > horatermina) {
      Toast.fire({
        icon: "error",
        title: "Hora fin no puede ser menor a la hora de inicio...",
      });
      $("#hora-fin").focus();
      return;
    }
    Swal.fire({
      title: "Estas seguro de actualizar el flex time?",
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
          url: "/recursoshumanos/flextime/mantenimiento_flextime",
          data: {
            post: post,
            id: id,
            nombre: nombre,
            estado: estado,
            horaini: horaini,
            horafin: horafin,
            tolerancia: tolerancia,
            idzona: idzona,
            idlocal: idlocal,
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

  // BONTON CANCELAR REGISTRO
  $("#btn-cancelar-actualizar").on("click", function () {
    $("#modal-editar").modal("hide");
  });
});

// CAMBIAR LOCAL
function obtener_local(zona) {
  if (zona == 0) {
    $("#id-local").html("");
    $("#id-local").append(
      '<option value="0" selected>-- SELECCIONE --</option>'
    );
  } else {
    $.ajax({
      type: "POST",
      url: "/recursoshumanos/flextime/get_local",
      data: { zona: zona },
      success: function (res) {
        $("#id-local").html("");
        $("#id-local").append(res.data);
      },
    });
  }
}

// CAMBIAR LOCAL
function obtener_local2(zona) {
  if (zona == 0) {
    $("#id-local1").html("");
    $("#id-local1").append(
      '<option value="0" selected>-- SELECCIONE --</option>'
    );
  } else {
    $.ajax({
      type: "POST",
      url: "/recursoshumanos/flextime/get_local",
      data: { zona: zona },
      success: function (res) {
        $("#id-local1").html("");
        $("#id-local1").append(res.data);
      },
    });
  }
}

// CAMBIAR LOCAL - EDITAR
function obtener_local_editar(zona, local) {
  if (zona == 0) {
    $("#id-local1").html("");
    $("#id-local1").append(
      '<option value="0" selected>-- SELECCIONE --</option>'
    );
  } else {
    $.ajax({
      type: "POST",
      url: "/recursoshumanos/flextime/get_local",
      data: { zona: zona },
      success: function (res) {
        $("#id-local1").html("");
        $("#id-local1").append(res.data);

        $("#id-local1").val("");
        $("#id-local1").val(local);
      },
    });
  }
}