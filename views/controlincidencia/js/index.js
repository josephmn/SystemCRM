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

  $("#example2").DataTable({
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
    lengthMenu: [[25], ["25 rows"]],
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
});

////////////////  APROBAR INCIDENCIA ///////////////////

// CARGAR MODAL APROBAR INCIDENCIA
$("#example2 tbody").on("click", "a.aprobar", function () {
  var id = $(this).attr("id");

  $("#codincidencia_aprobar").html("");
  $("#codincidencia_aprobar").html(id);
  $("#modal-aprobar").modal("show");
});

// BOTON SI APROBAR
$("#btn_si_aprobar").on("click", function () {
  var codigo = $("#codincidencia_aprobar").text(); // CODIGO ASISTENCIA
  var dni = $("#dni").val(); // DNI DEL JEFE QUE APRUEBA
  var indice = 1; // APROBAR

  $.ajax({
    type: "POST",
    url: "/recursoshumanos/controlincidencia/gestion_incidencia",
    data: { codigo: codigo, dni: dni, indice: indice },
    success: function (res) {
      // alert(res.data);
      switch (res.data) {
        case 0:
          $("#mensaje-eliminar").html(
            "<div class='alert alert-danger'>Error al aprobar</div>"
          );
          setInterval(function () {
            $("#mensaje-eliminar").html("");
            $("#modal-eliminar").modal("hide");
          }, 3000);
          break;
        case 1:
          $("#mensaje-eliminar").html(
            "<div class='alert alert-success'>Aprobado correctamente</div>"
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

// BOTON NO APROBAR
$("#btn_no_aprobar").on("click", function () {
  $("#modal-aprobar").modal("hide");
});

////////////////  DESAPROBAR INCIDENCIA ///////////////////

// CARGAR MODAL DESAPROBAR INCIDENCIA
$("#example2 tbody").on("click", "a.desaprobar", function () {
  var cod = $(this).attr("id");

  $("#codincidencia_desaprobar").html("");
  $("#codincidencia_desaprobar").html(cod);
  $("#modal-desaprobar").modal("show");
});

// BOTON SI DESAPROBAR
$("#btn_si_desaprobar").on("click", function () {
  var codigo = $("#codincidencia_desaprobar").text(); // CODIGO ASISTENCIA
  var dni = $("#dni").val(); // DNI DEL JEFE QUE DESAPRUEBA
  var indice = 2; // DESAPROBAR

  $.ajax({
    type: "POST",
    url: "/recursoshumanos/controlincidencia/gestion_incidencia",
    data: { codigo: codigo, dni: dni, indice: indice },
    success: function (res) {
      // alert(res.data);
      switch (res.data) {
        case 0:
          $("#mensaje-eliminar").html(
            "<div class='alert alert-danger'>Error al desaprobar</div>"
          );
          setInterval(function () {
            $("#mensaje-eliminar").html("");
            $("#modal-eliminar").modal("hide");
          }, 3000);
          break;
        case 1:
          $("#mensaje-eliminar").html(
            "<div class='alert alert-success'>Desaprobado correctamente</div>"
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

// BOTON NO DESAPROBAR
$("#btn_no_desaprobar").on("click", function () {
  $("#modal-desaprobar").modal("hide");
});
