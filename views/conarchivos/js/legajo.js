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

  //Initialize Select2 Elements
  $(".select2").select2();

  //Initialize Select2 Elements
  $(".select2bs4").select2({
    theme: "bootstrap4",
  });

  // inactivar input
  $("#id-archivo-actualizar").attr("readonly", true);

  // tabla
  creardatatable("#example1", 20, 0);

  var Toast = Swal.mixin({
    toast: true,
    position: "top-right",
    showConfirmButton: false,
    timer: 5000,
    timerProgressBar: true,
  });

  var arr = [];
  // seleccion de semanas
  $(".select2").change(function () {
    arr = $(this).val();
    // console.log(arr);
  });

  // cargar modal para insertar nuevo archivo
  $("#btn-agregar").on("click", function () {
    $("#nombre-archivo").val("");
    $("#carpeta-archivo").val("");
    $("#estado-archivo").val(1);

    arr = [""];
    $("#file-archivo").val(null).trigger("change");

    $("#cantidad-archivo").val(0);
    $("#tamanio-archivo").val("");

    $("#modal-agregar").modal("show");
  });

  $("#modal-agregar").on("shown.bs.modal", function () {
    $("#nombre-archivo").focus();
  });

  // agregar a tabla de documentos globales
  $("#btn-registrar").on("click", function () {
    let post = 1; // insertar
    let id = 0; // no se usa id para insertar
    let nombre = $("#nombre-archivo").val();
    let carpeta = $("#carpeta-archivo").val();
    let modulo = $("#modulo-archivo").val();
    let estado = $("#estado-archivo").val();
    let cantidad = $("#cantidad-archivo").val();
    let tipoarchivo = $("#file-archivo").val();
    let tamanio = $("#tamanio-archivo").val();

    if (nombre == null || nombre == "") {
      Toast.fire({
        icon: "error",
        title: "Favor de ingresar un nombre..!!",
      });
      $("#nombre-archivo-actualizar").focus();
      return;
    }

    if (carpeta == null || carpeta == "") {
      Toast.fire({
        icon: "error",
        title:
          "Favor de ingresar un nombre de carpeta para guardar los archivos..!!",
      });
      $("#carpeta-archivo").focus();
      return;
    }

    if (arr.length == "" || arr.length == null) {
      Toast.fire({
        icon: "error",
        title: "Favor ingresar al menos un tipo de archivo a cargar..!!",
      });
      $("#file-archivo").focus();
      return;
    }

    if (tamanio == null || tamanio == 0 || tamanio == 0.0) {
      Toast.fire({
        icon: "error",
        title: "Favor de ingresar un tamaño en Mb para la carga de archivo..!!",
      });
      $("#tamanio-archivo").focus();
      return;
    }

    Swal.fire({
      title: "Estas seguro de registrar el tipo de archivo?",
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
          url: "/recursoshumanos/conarchivos/mantenimiento_archivos_legajo",
          data: {
            post: post,
            id: id,
            nombre: nombre,
            carpeta: carpeta,
            modulo: modulo,
            estado: estado,
            cantidad: cantidad,
            tipoarchivo: tipoarchivo,
            tamanio: tamanio,
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

  // boton cancelar agregar
  $("#btn-cancelar-agregar").on("click", function () {
    $("#nombre-archivo").val("");
    $("#carpeta-archivo").val("");
    $("#estado-archivo").val(1);

    arr = [""];
    $("#file-archivo").val(null).trigger("change");

    $("#cantidad-archivo").val(0);
    $("#tamanio-archivo").val("");

    $("#modal-agregar").modal("hide");
  });

  // obtener datos para actualizar tipo de archivo para legajo
  $("#example1 tbody").on("click", "a.editar-data", function () {
    let cod = $(this).attr("id");

    $.ajax({
      type: "POST",
      url: "/recursoshumanos/conarchivos/obtener_archivolegajo",
      data: { cod: cod },
      success: function (res) {
        $("#id-archivo-actualizar").val("");
        $("#id-archivo-actualizar").val(cod);
        $("#nombre-archivo-actualizar").val("");
        $("#nombre-archivo-actualizar").val(res.v_nombre);
        $("#carpeta-archivo-actualizar").val("");
        $("#carpeta-archivo-actualizar").val(res.v_carpeta);
        $("#estado-archivo-actualizar").val("");
        $("#estado-archivo-actualizar").val(res.i_estado);

        $("#file-archivo-actualizar").val(res.v_type_archivo);
        $("#file-archivo-actualizar").select2(res.v_type_archivo);

        arr = res.v_type_archivo;

        $("#cantidad-archivo-actualizar").val("");
        $("#cantidad-archivo-actualizar").val(res.i_cantidad);
        $("#tamanio-archivo-actualizar").val("");
        $("#tamanio-archivo-actualizar").val(res.f_size);
      },
    });

    $("#modal-editar").modal("show");
  });

  $("#modal-editar").on("shown.bs.modal", function () {
    $("#nombre-archivo-actualizar").focus();
  });

  // actualizar tabla de documentos globales
  $("#btn-actualizar").on("click", function () {
    let post = 2; // update
    let id = $("#id-archivo-actualizar").val();
    let nombre = $("#nombre-archivo-actualizar").val();
    let carpeta = $("#carpeta-archivo-actualizar").val();
    let modulo = $("#modulo-archivo-actualizar").val();
    let estado = $("#estado-archivo-actualizar").val();
    let cantidad = $("#cantidad-archivo-actualizar").val();
    let tipoarchivo = $("#file-archivo-actualizar").val();
    let tamanio = $("#tamanio-archivo-actualizar").val();

    if (nombre == null || nombre == "") {
      Toast.fire({
        icon: "error",
        title: "Favor de ingresar un nombre..!!",
      });
      $("#nombre-archivo-actualizar").focus();
      return;
    }

    if (carpeta == null || carpeta == "") {
      Toast.fire({
        icon: "error",
        title:
          "Favor de ingresar un nombre de carpeta para guardar los archivos..!!",
      });
      $("#carpeta-archivo-actualizar").focus();
      return;
    }

    if (arr.length == "" || arr.length == null) {
      Toast.fire({
        icon: "error",
        title: "Favor ingresar al menos un tipo de archivo a cargar..!!",
      });
      $("#file-archivo-actualizar").focus();
      return;
    }

    if (tamanio == null || tamanio == 0 || tamanio == 0.0) {
      Toast.fire({
        icon: "error",
        title: "Favor de ingresar un tamaño en Mb para la carga de archivo..!!",
      });
      $("#tamanio-archivo-actualizar").focus();
      return;
    }

    Swal.fire({
      title: "Estas seguro de actualizar el tipo de archivo?",
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
          url: "/recursoshumanos/conarchivos/mantenimiento_archivos_legajo",
          data: {
            post: post,
            id: id,
            nombre: nombre,
            carpeta: carpeta,
            modulo: modulo,
            estado: estado,
            cantidad: cantidad,
            tipoarchivo: tipoarchivo,
            tamanio: tamanio,
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

  // boton cancelar actualizar
  $("#btn-cancelar-actualizar").on("click", function () {
    $("#modal-editar").modal("hide");
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
    lengthMenu: [[row], [row]],
    order: [[orden, "asc"]],
  });
  return tabla;
}
