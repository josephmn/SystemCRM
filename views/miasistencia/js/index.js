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