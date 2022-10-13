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

//-------------------- MODAL CARGAR DATOS --------------------//
// CARGAR MODAL
$("#example1 tbody").on("click", "a.actualizar", function () {
  $("#modal-actualizar").modal("show");
  var n = 0;
  var l = document.getElementById("number");
  window.setInterval(function () {
    l.innerHTML = n;
    n++;
  }, 2000);
});