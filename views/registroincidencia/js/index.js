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

  //Date range picker
  $("#finicio, #ffin").datetimepicker({
    format: "DD/MM/YYYY",
  });

  var fecha = new Date(); //Fecha actual
  var mes = fecha.getMonth() + 1; //obteniendo mes
  var dia = fecha.getDate(); //obteniendo dia
  var ano = fecha.getFullYear(); //obteniendo año
  if (dia < 10) dia = "0" + dia; //agrega cero si el menor de 10
  if (mes < 10) mes = "0" + mes; //agrega cero si el menor de 10
  document.getElementById("finiciodate").value = dia + "/" + mes + "/" + ano;
  document.getElementById("ffindate").value = dia + "/" + mes + "/" + ano;

  $("#example1,#example2").DataTable({
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
    dom: "Bfrtip",
    lengthMenu: [[10], ["10 rows"]],
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

  $.ajax({
    type: "POST",
    url: "/recursoshumanos/registrovacaciones/alert",
    success: function (res) {
      switch (res.icase) {
        case 1:
          Swal.fire({
            icon: res.vicon,
            title: res.vtitle,
            text: res.vtext,
            timer: 8000,
          });
          break;
      }
    },
  });
});

$.ajax({
  type: "POST",
  url: "/recursoshumanos/registrovacaciones/toasts",
  data: { mensaje: (mensaje = 3) },
  success: function (res) {
    switch (res.id) {
      case 1:
        var id = setInterval(function () {
          $(document).Toasts("create", {
            class: res.class,
            title: res.title,
            subtitle: res.subtitle,
            body: res.body,
            autohide: true,
            delay: 6000,
          });
          clearInterval(id);
        }, 2000);
        break;
    }
  },
});

// CARGAR MODAL ELIMINAR INCIDENCIA
$("#example2 tbody").on("click", "a.delete", function () {
  var id = $(this).attr("id");

  $("#codincidencia").html("");
  $("#codincidencia").html(id);
  $("#modal-eliminar").modal("show");
  // $('#cod').html('');
  // $('#cod').html(id);
  // $('#modal-edit-asistencia').modal('show');
});

// ELIMINAR INCIDENCIA
$("#btn_si").on("click", function () {
  var codigo = $("#codincidencia").text(); // CODIGO ASISTENCIA

  $.ajax({
    type: "POST",
    url: "/recursoshumanos/registroincidencia/eliminar_incidencia",
    data: { codigo: codigo },
    success: function (res) {
      // alert(res.data);
      switch (res.data) {
        case 0:
          $("#mensaje-eliminar").html(
            "<div class='alert alert-danger'>Error al eliminar</div>"
          );
          setInterval(function () {
            $("#mensaje-eliminar").html("");
            $("#modal-eliminar").modal("hide");
          }, 3000);
          break;
        case 1:
          $("#mensaje-eliminar").html(
            "<div class='alert alert-success'>Eliminado correctamente</div>"
          );
          setInterval(function () {
            $("#mensaje-eliminar").html("");
            $("#modal-eliminar").modal("hide");
          }, 3000);
          location.reload();
          break;
      }
    },
  });
});

// CANCELAR ELIMINACION DE INCIDENCIA
$("#btn_no").on("click", function () {
  $("#modal-eliminar").modal("hide");
});

// MODAL INCIDENCIA
$("#example1 tbody").on("click", "a.edit", function () {
  //cargar deshabilitado los botones
  $("#diferencia_hora").attr("readonly", true);
  $("#fecha_incidencia").attr("readonly", true);

  var id = $(this).attr("id");

  // PARA EL ID
  $("#cod").html("");
  $("#cod").html(id);

  //CARGAR COMBO TIPO SUSTENTO
  $.ajax({
    method: "POST",
    url: "/recursoshumanos/registroincidencia/cargarcombosustento",
    success: function (res) {
      // PARA LLENAR EL COMBO
      $("#estado").html("");
      $("#estado").append(res.filas);
    },
  });

  // PARA BLANQUEAR EL COMENTARIO DE SUSTENTO
  $("#comentario").val("");

  // PARA DIFERENCIA DE HORA AL INPUT
  $.ajax({
    method: "POST",
    data: { id: id },
    url: "/recursoshumanos/registroincidencia/diferenciahora",
    success: function (res) {
      // alert(res.dato);
      // alert(res.fecha);

      // PARA EL ID
      $("#fecha_incidencia").val("");
      $("#fecha_incidencia").val(res.fecha);

      // PARA BLANQUEAR EL COMENTARIO DE SUSTENTO
      $("#diferencia_hora").val("");
      $("#diferencia_hora").val(res.dato);
    },
  });

  // CARGAR MODAL
  $("#modal-incidencia").modal("show");

  // $('#cod').html('');
  // $('#cod').html(id);
  // $('#modal-edit-asistencia').modal('show');
});

// REGISTRAR INCIDENCIA
$("#btn_registrar").on("click", function () {
  var codigo = $("#cod").text(); // CODIGO ASISTENCIA
  var dni = $("#dni").val(); // DNI - PERSONAL SESSION
  var tipo_sustento = $("#estado").val(); // TIPO SUSTENTO
  var fecha_incidencia = $("#fecha_incidencia").val(); // FECHA DE INCIDENCIA
  var comentario = $("#comentario").val(); // COMENTARIO
  var diferencia_hora = $("#diferencia_hora").val(); // DIFERENCIA DE HORA
  var usuario = $("#dni").val(); // USUARIO REGISTRA

  if ($("#estado").val() == 0) {
    $("#mensaje").html(
      "&nbsp;<div class='alert alert-warning'>seleccion tipo sustento</div>"
    );
    $("#tipo_sustento").focus();
    setInterval(function () {
      $("#mensaje").html("");
    }, 3000);
  } else if ($("#comentario").val() == "") {
    $("#mensaje").html(
      "&nbsp;<div class='alert alert-warning'>comentario vacío</div>"
    );
    $("#comentario").focus();
    setInterval(function () {
      $("#mensaje").html("");
    }, 3000);
  } else {
    $.ajax({
      type: "POST",
      url: "/recursoshumanos/registroincidencia/registrar_incidencia",
      data: {
        codigo: codigo,
        dni: dni,
        tipo_sustento: tipo_sustento,
        fecha_incidencia: fecha_incidencia,
        comentario: comentario,
        diferencia_hora: diferencia_hora,
        usuario: usuario,
      },
      success: function (res) {
        // alert(res.data);
        switch (res.data) {
          case 0:
            $("#mensaje").html(
              "<div class='alert alert-danger'>Error al registrar</div>"
            );
            setInterval(function () {
              $("#mensaje").html("");
              $("#modal-incidencia").modal("hide");
            }, 3000);
            break;
          case 1:
            $("#mensaje").html(
              "<div class='alert alert-success'>Registrado correctamente</div>"
            );
            setInterval(function () {
              $("#mensaje").html("");
              $("#modal-incidencia").modal("hide");
            }, 3000);
            location.reload();
            break;
        }
      },
    });
  }
});
