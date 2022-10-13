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
  $("#fferiado,#fferiado1").datetimepicker({
    format: "DD/MM/YYYY",
  });

  var fecha = new Date(); //Fecha actual
  var mes = fecha.getMonth() + 1; //obteniendo mes
  var dia = fecha.getDate(); //obteniendo dia
  var ano = fecha.getFullYear(); //obteniendo año
  if (dia < 10) dia = "0" + dia; //agrega cero si el menor de 10
  if (mes < 10) mes = "0" + mes; //agrega cero si el menor de 10
  document.getElementById("fferiado").value = dia + "/" + mes + "/" + ano;
  document.getElementById("fferiado1").value = dia + "/" + mes + "/" + ano;

  //CARGAR DESHABILITADO LOS INPUT
  $("#id-feriado1").attr("readonly", true);

  creardatatable("#example1", -1, 2);

  var Toast = Swal.mixin({
    toast: true,
    position: "top-right",
    showConfirmButton: false,
    timer: 5000,
    timerProgressBar: true,
  });

  // seleccion de año
  $("#anhio").change(function () {
    let anhio = $("#anhio").val();

    $.ajax({
      type: "POST",
      url: "/recursoshumanos/feriados/construir_tabla",
      data: { anhio: anhio },
      success: function (res) {
        $("#example1").dataTable().fnDestroy();
        $("#tbferiado").html("");
        $("#tbferiado").append(res.div);
        creardatatable("#example1", -1, 2);
      },
    });
  });

  //-------------------- MODAL AGREGAR --------------------//
  // CARGAR MODAL AGREGAR FLEX
  $("#btn-agregar").on("click", function () {
    $("#descripcion").val("");
    $("#fferiado").val("");
    $("#modal-agregar").modal("show");
  });

  // FOCO AL MODAL AGREGAR
  $("#modal-agregar").on("shown.bs.modal", function () {
    $("#descripcion").focus();
  });

  // BONTON REGISTRAR
  $("#btn-registrar").on("click", function () {
    let post = 1; // insertar
    let id = 0;
    let descripcion = $("#descripcion").val();
    let fferiado = $("#fferiado").val();
    let estado = 1; // estado

    if (descripcion == null || descripcion == "") {
      Toast.fire({
        icon: "error",
        title: "Descripcion no puede estar vacío..!!",
      });
      $("#descripcion").focus();
      return;
    }

    // formato fecha inicio
    if (
      fferiado.includes("d") == true ||
      fferiado.includes("m") == true ||
      fferiado.includes("a") == true
    ) {
      Toast.fire({
        icon: "error",
        title: "Fecha feriado no tiene el formato correcto..!!",
      });
      $("#fferiado").focus();
      return;
    }

    Swal.fire({
      title: "Estas seguro de guardar el feriado?",
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
          url: "/recursoshumanos/feriados/mantenimiento_feriado",
          data: {
            post: post,
            id: id,
            descripcion: descripcion,
            fferiado: fferiado,
            estado: estado,
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
  $("#example1 tbody").on("click", "a.editar", function () {
    var id = $(this).attr("id");

    $.ajax({
      type: "POST",
      url: "/recursoshumanos/feriados/get_feriado",
      data: { id: id },
      success: function (res) {
        $("#id-feriado1").val("");
        $("#id-feriado1").val(res.id);
        $("#descripcion1").val("");
        $("#descripcion1").val(res.descripcion);
        $("#fferiado1").val("");
        $("#fferiado1").val(res.fferiado);
        $("#estado1").val("");
        $("#estado1").val(res.estado);
      },
    });

    $("#modal-editar").modal("show");
  });

  // FOCO AL MODAL EDITAR
  $("#modal-editar").on("shown.bs.modal", function () {
    $("#nombre-flex1").focus();
  });

  // BONTON GUARDAR CAMBIOS
  $("#btn-actualizar").on("click", function () {
    let post = 2; // update
    let id = $("#id-feriado1").val();
    let descripcion = $("#descripcion1").val();
    let fferiado = $("#fferiado1").val();
    let estado = $("#estado1").val(); // estado

    if (descripcion == null || descripcion == "") {
      Toast.fire({
        icon: "error",
        title: "Descripcion no puede estar vacío..!!",
      });
      $("#descripcion").focus();
      return;
    }

    // formato fecha inicio
    if (
      fferiado.includes("d") == true ||
      fferiado.includes("m") == true ||
      fferiado.includes("a") == true
    ) {
      Toast.fire({
        icon: "error",
        title: "Fecha feriado no tiene el formato correcto..!!",
      });
      $("#fferiado").focus();
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
          url: "/recursoshumanos/feriados/mantenimiento_feriado",
          data: {
            post: post,
            id: id,
            descripcion: descripcion,
            fferiado: fferiado,
            estado: estado,
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
    lengthMenu: [[row], ["All"]],
    order: [[orden, "asc"]],
  });
  return tabla;
}