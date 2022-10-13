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
  $("#anhio,#semana,#descripcion,#idlocal,#localdescr,#dni,#nombres").attr(
    "readonly",
    true
  );

  //PARA CARGAR LA TABLA
  // $("#example").DataTable({});

  // $(document).ready(function () {
  var oTable = $("#example").dataTable({
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
    lengthMenu: [
      [10, 25, 50, -1],
      ["10 filas", "25 filas", "50 filas", "Todo"],
    ],
    stateSave: true,
  });

  var allPages = oTable.fnGetNodes();

  $("body").on("click", "#selectAll", function () {
    if ($(this).hasClass("allChecked")) {
      $("input[id='cbx1']", allPages).prop("checked", false);
    } else {
      $("input[id='cbx1']", allPages).prop("checked", true);
    }
    $(this).toggleClass("allChecked");
  });
  // });

  //PARA CARGAR LA TABLA2
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
    // lengthMenu: [
    //   [10, 25, 50, -1],
    //   ["10 filas", "25 filas", "50 filas", "Todo"],
    // ],
    lengthMenu: [[15], ["15 rows"]],
    buttons: [
      "excel",
      "pdf",
      "print",
      {
        extend: "pdfHtml5",
        orientation: "landscape",
        pageSize: "LEGAL",
      },
    ],
  });
  // $(document).on("click", "input[id='cbx1']:checkbox", getCheckedBox);
  // getCheckedBox();

  // function getCheckedBox() {
  //   var checkedBox = $.map($("input[id='cbx1']:checkbox:checked"),function (val, i) {return val.value;});
  //   // console.clear();
  //   console.log(checkedBox);
  // }

  //-------------------- MODAL AGREGAR --------------------//
  // CARGAR MODAL AGREGAR
  $("#btnasignarhora").on("click", function () {
    if ($("input[id='cbx1']:checked").length > 0) {
      $("#modal-agregar").modal("show");
    } else {
      Swal.fire({
        icon: "info",
        title: "No ha seleccionado ningun personal...",
        text: "Favor de seleccionado uno!",
        timer: 3000,
        timerProgressBar: true,
      });
    }
  });

  // BOTON REGISTRAR REGISTROS
  $("#btn-registrar").on("click", function () {
    var post = 1;
    var check = [];
    var dias = [];
    var semama = $("#semana").val();
    var anhio = $("#anhio").val();
    var horaini = $("#hora-inicio").val();
    var horafin = $("#hora-fin").val();
    var tolerancia = $("#tolerancia").val();
    var local = $("#idlocal").val();

    // $('[name="checks[]"]').click(function () {
    //   if (horaini == null || horaini == "" || horaini.length < 3) {
    //     Swal.fire({
    //       icon: "info",
    //       title: "No ha ingresado una hora de inicio...",
    //       text: "Favor de ingresar una hora válida!",
    //       timer: 3000,
    //       timerProgressBar: true,
    //     });
    //     $(
    //       "#lunesbox,#martesbox,#miercolesbox,#juevesbox,#viernesbox,#sabadobox,#domingobox"
    //     ).prop("checked", false);
    //     $("#hora-inicio").prop("required", true);
    //   } else if (horafin == null || horafin == "" || horafin.length < 3) {
    //     Swal.fire({
    //       icon: "info",
    //       title: "No ha ingresado una hora fin...",
    //       text: "Favor de ingresar una hora fin válida!",
    //       timer: 3000,
    //       timerProgressBar: true,
    //     });
    //     $(
    //       "#lunesbox,#martesbox,#miercolesbox,#juevesbox,#viernesbox,#sabadobox,#domingobox"
    //     ).prop("checked", false);
    //     $("#hora-fin").prop("required", true);
    //   } else if (
    //     tolerancia == null ||
    //     tolerancia == "" ||
    //     tolerancia.length < 3
    //   ) {
    //     Swal.fire({
    //       icon: "info",
    //       title: "Si no existe toleranciaaaa...",
    //       text: "Favor de ingresar ceros (00:00)!",
    //       timer: 3000,
    //       timerProgressBar: true,
    //     });
    //     $(
    //       "#lunesbox,#martesbox,#miercolesbox,#juevesbox,#viernesbox,#sabadobox,#domingobox"
    //     ).prop("checked", false);
    //   }
    // });

    if (horaini == null || horaini == "" || horaini.length < 3) {
      $("#hora-inicio").prop("required", true);
      Swal.fire({
        icon: "info",
        title: "Hora inicio no válida...",
        text: "Favor de ingresar una hora válida!",
        timer: 3000,
        timerProgressBar: true,
      });
    } else if (horafin == null || horafin == "" || horafin.length < 3) {
      $("#hora-fin").prop("required", true);
      Swal.fire({
        icon: "info",
        title: "Hora fin no válida...",
        text: "Favor de ingresar una hora fin válida!",
        timer: 3000,
        timerProgressBar: true,
      });
    } else if (
      tolerancia == null ||
      tolerancia == "" ||
      tolerancia.length < 3
    ) {
      Swal.fire({
        icon: "info",
        title: "Si no existe tolerancia...",
        text: "Favor de ingresar ceros (00:00)!",
        timer: 3000,
        timerProgressBar: true,
      });
    } else {
      $("input:checkbox[id='cbx1']:checked").each(function () {
        check.push($(this).val());
      });
      console.log(check);

      var checkboxes = document.querySelectorAll('[name="checks[]"]:checked');
      for (var i = 0; i < checkboxes.length; i++) {
        dias.push(checkboxes[i].value);
      }
      // console.log(dias);

      Swal.fire({
        title: "Estas seguro de registrar los datos?",
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
            url: "/recursoshumanos/turnos/insertar_horarios",
            data: {
              post: post,
              check: check,
              dias: dias,
              semama: semama,
              anhio: anhio,
              horaini: horaini,
              horafin: horafin,
              tolerancia: tolerancia,
              local: local,
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
    }
  });

  // BOTON CANCELAR REGISTRO
  $("#btn-cancelar").on("click", function () {
    $("#modal-agregar").modal("hide");
  });

  //-------------------- MODAL ELIMINAR --------------------//
  // CARGAR MODAL AGREGAR
  $("#example1 tbody").on("click", "a.delete", function () {
    let post = 2;
    let nombre = $(this).attr("vnombre");
    let check = $(this).attr("vdni");
    let dias = "";
    let semama = $("#semana").val();
    let anhio = $("#anhio").val();
    let horaini = "";
    let horafin = "";
    let tolerancia = "";
    let local = $("#idlocal").val();

    Swal.fire({
      title: "Estas seguro de eliminar el turno de " + nombre + "?",
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
          url: "/recursoshumanos/turnos/eliminar_horarios",
          data: {
            post: post,
            check: check,
            dias: dias,
            semama: semama,
            anhio: anhio,
            horaini: horaini,
            horafin: horafin,
            tolerancia: tolerancia,
            local: local,
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