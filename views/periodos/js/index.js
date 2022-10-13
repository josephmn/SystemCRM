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
  $("#codigo,#periodo,#ycodigo,#yperiodo").attr("readonly", true);

  creardatatable("#example1", 0, "desc", 14); //tabla.- index

  // ACTUALIZAR PERIODO
  $("#example1 tbody").on("click", "a.editar", function () {
    let id = $(this).attr("id");
    let nombre = $(this).attr("nombre");
    let estado = $(this).attr("estado");

    $("#codigo").val("");
    $("#codigo").val(id);
    $("#periodo").val("");
    $("#periodo").val(nombre);
    $("#estado").val("");
    $("#estado").val(estado);

    $("#modal-editar").modal("show");
  });

  // GUARDAR CAMBIOS DE PERIODO
  $("#btnguardar").on("click", function () {
    let post = 2; //update
    let id = $("#codigo").val(); // id solo para eliminar o actualizar
    let periodo = $("#periodo").val();
    let estado = $("#estado").val(); //activo / inactivo

    Swal.fire({
      title: "Estas seguro de actualizar el siguiente periodo?",
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
          url: "/recursoshumanos/periodos/mantenimiento_periodoboleta2",
          data: {
            post: post,
            id: id,
            periodo: periodo,
            estado: estado,
          },
          success: function (res) {
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
            $("#modal-editar").modal("hide");
          },
        });
      }
    });
  });

  $("#modal-editar").on("shown.bs.modal", function () {
    $("#estado").focus();
  });

  $("#btncancelar").on("click", function () {
    $("#modal-editar").modal("hide");
  });

  // AGREGAR PERIODO
  $("#btnagregarperiodo").on("click", function () {
    $("#modal-agregar").modal("show");
  });

  // GUARDAR PERIODO
  $("#xbtnguardar").on("click", function () {
    let post = 1; //insert
    let id = 0; // id solo para eliminar o actualizar
    let periodo = $("#xperiodo").val();
    let estado = 0; //inactivo

    if (periodo == null || periodo == "") {
      Swal.fire({
        icon: "info",
        title: "No ha ingresado periodo a registrar",
        text: "Favor de ingresar un periodo...!!",
        timer: 3000,
        timerProgressBar: true,
        showCancelButton: false,
        showConfirmButton: false,
      });
      return;
    }

    var formData = new FormData();
    let archivo = $("#archivo")[0].files[0];
    formData.append("post", post);
    formData.append("id", id);
    formData.append("periodo", periodo);
    formData.append("estado", estado);
    formData.append("archivo", archivo);

    if (archivo == null || archivo == "") {
      Swal.fire({
        icon: "info",
        title: "No ha seleccionado ningun archivo a cargar",
        text: "Favor de seleccionar uno...!!",
        timer: 3000,
        timerProgressBar: true,
        showCancelButton: false,
        showConfirmButton: false,
      });
      return;
    }

    Swal.fire({
      title: "Estas seguro de registrar el siguiente periodo?",
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
          url: "/recursoshumanos/periodos/mantenimiento_periodoboleta",
          data: formData,
          contentType: false,
          processData: false,
          success: function (res) {
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
          },
        });
      }
    });
  });

  $("#modal-agregar").on("shown.bs.modal", function () {
    $("#periodo").focus();
  });

  $("#xbtncancelar").on("click", function () {
    $("#modal-agregar").modal("hide");
  });

  // ACTUALIZAR FIRMA
  $("#example1 tbody").on("click", "a.imagen", function () {
    let id = $(this).attr("id");
    let nombre = $(this).attr("nombre");

    $("#ycodigo").val("");
    $("#ycodigo").val(id);
    $("#yperiodo").val("");
    $("#yperiodo").val(nombre);

    $("#modal-imagen").modal("show");
  });

  $("#ybtnguardar").on("click", function () {
    let post = 4; //update firma
    let id = $("#ycodigo").val(); // id solo para eliminar o actualizar
    let periodo = $("#yperiodo").val();
    let estado = 0; //inactivo (no se usa)

    var formData = new FormData();
    let archivo = $("#yarchivo")[0].files[0];

    formData.append("post", post);
    formData.append("id", id);
    formData.append("periodo", periodo);
    formData.append("estado", estado);
    formData.append("archivo", archivo);

    if (archivo == null || archivo == "") {
      Swal.fire({
        icon: "info",
        title: "No ha seleccionado ningun archivo a cargar",
        text: "Favor de seleccionar uno...!!",
        timer: 3000,
        timerProgressBar: true,
        showCancelButton: false,
        showConfirmButton: false,
      });
      return;
    }

    Swal.fire({
      title: "Estas seguro de actualizar la firma al periodo " + periodo + "?",
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
          url: "/recursoshumanos/periodos/mantenimiento_periodoboleta",
          data: formData,
          contentType: false,
          processData: false,
          success: function (res) {
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
            $("#modal-imagen").modal("hide");
          },
        });
      }
    });
  });

  $("#ybtncancelar").on("click", function () {
    $("#modal-imagen").modal("hide");
  });

  $("#example1 tbody").on("click", "a.eliminar", function () {
    let post = 3; //delete
    let id = $(this).attr("id");
    let periodo = $(this).attr("nombre");
    let estado = 0; //no se usa para este caso

    Swal.fire({
      title: "Estas seguro de eliminar el periodo "+periodo+"?",
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
          url: "/recursoshumanos/periodos/mantenimiento_periodoboleta2",
          data: {
            post: post,
            id: id,
            periodo: periodo,
            estado: estado,
          },
          success: function (res) {
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
          },
        });
      }
    });
  });
});

// crear tabla
function creardatatable(nombretabla, orden, tipoorden, top) {
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
    //   lengthMenu: [[-1], ["Todos"]],
    lengthMenu: [[top], [top]],
    order: [[orden, tipoorden]],
  });
  return tabla;
}