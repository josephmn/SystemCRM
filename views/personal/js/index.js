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

  //CARGAR DESHABILITADO LOS INPUT DEL MODAL
  $("#dni,#nombres,#apellidos").attr("readonly", true);

  $("#flex").on("change", function () {
    let flex = $("#flex").val();
    if (flex == 1) {
      $("#turno").val(0);
    }
  });

  $("#turno").on("change", function () {
    let turno = $("#turno").val();
    if (turno == 1) {
      $("#flex").val(0);
    }
  });

  // cambia trabajo remoto
  $("#remoto").on("change", function () {
    let remoto = $("#remoto").val();
    if (remoto == 1) {
      $("#marcacion").val(1);
    } else {
      $("#marcacion").val(0);
    }
  });

  // cambia trabajo remoto
  $("#marcacion").on("change", function () {
    let marcacion = $("#marcacion").val();
    if (marcacion == 1) {
      $("#remoto").val(1);
    } else {
      $("#remoto").val(0);
    }
  });

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
      searchPanes: {
        clearMessage: "Borrar todo",
        collapse: {
          0: "Paneles de búsqueda",
          _: "Paneles de búsqueda (%d)",
        },
        count: "{total}",
        countFiltered: "{shown} ({total})",
        emptyPanes: "Sin paneles de búsqueda",
        loadMessage: "Cargando paneles de búsqueda",
        title: "Filtros Activos - %d",
      },
      // buttons: {
      //   print: "Imprimir",
      // },
    },

    searchPanes: {
      cascadePanes: true,
      columns: [4, 5, 6, 8, 9],
    },
    dom: "Plfrtip",

    // buttons: [
    //   // "searchPanes",
    //   // {
    //   //   columns: [1, 3, 5],
    //   //   dom: "Plfrtip",
    //   // },
    //   "excel",
    //   // "pdf",
    //   "print",
    //   {
    //     extend: "pdfHtml5",
    //     orientation: "landscape",
    //     pageSize: "LEGAL",
    //   },
    // ],
    // dom: "Bfrtip",

    lengthMenu: [[25], ["25"]],
  });

  //-------------------- MODAL ACTUALIZAR PERSONAL --------------------//
  // CARGAR MODAL ACTUALIZAR
  $("#example1 tbody").on("click", "a.actualizar", function () {
    var dni = $(this).attr("id");

    function local($zona, $local) {
      $.ajax({
        type: "POST",
        url: "/recursoshumanos/personal/cargar_local",
        data: { zona: $zona },
        success: function (res) {
          $("#local").html("");
          $("#local").append(res.data);

          $("#local").val("");
          $("#local").val($local);
        },
      });
    }

    $.ajax({
      type: "POST",
      url: "/recursoshumanos/personal/buscar_personal",
      data: { dni: dni },
      success: function (res) {
        $("#dni").val("");
        $("#dni").val(res.vdni);
        $("#nombres").val("");
        $("#nombres").val(res.vnombres);
        $("#apellidos").val("");
        $("#apellidos").val(res.vapellidos);

        $("#zona").val("");
        $("#zona").val(res.izona);

        //LLENAR 2DO COMBO ANIDADO
        local(res.izona, res.ilocal);

        $("#grupoarea").val("");
        $("#grupoarea").val(res.iarea);

        $("#grupocargo").val("");
        $("#grupocargo").val(res.icargo);

        $("#turno").val("");
        $("#turno").val(res.iturno);

        $("#flex").val("");
        $("#flex").val(res.iflex);

        $("#remoto").val("");
        $("#remoto").val(res.iremoto);

        $("#marcacion").val("");
        $("#marcacion").val(res.imarcacion);

        $("#venta").val("");
        $("#venta").val(res.iventa);
      },
    });

    $("#modal-editar").modal("show");
  });

  //FUNCION AL CAMBIAR DE ZONA
  $("#zona").change(function () {
    var zona = $("#zona").val();
    $.ajax({
      type: "POST",
      url: "/recursoshumanos/personal/cargar_local",
      data: { zona: zona },
      success: function (res) {
        $("#local").html("");
        $("#local").append(res.data);
      },
    });
  });

  // GUARDA O ACTUALIZAR DATOS
  $("#btnguardar").on("click", function () {
    var dni = $("#dni").val();
    var zona = $("#zona").val();
    var local = $("#local").val();
    var area = $("#grupoarea").val();
    var cargo = $("#grupocargo").val();
    var turno = $("#turno").val();
    var flex = $("#flex").val();
    var remoto = $("#remoto").val();
    var marcacion = $("#marcacion").val();
    var venta = $("#venta").val();

    if (zona == 0 || zona == "") {
      $("#zona").focus();
      Swal.fire({
        icon: "info",
        title: "Seleccione una zona...",
        text: "Campo debe estar seleccionado!",
        timer: 4000,
      });
    } else if (local == 0 || local == "") {
      $("#local").focus();
      Swal.fire({
        icon: "info",
        title: "Seleccione un local...",
        text: "Campo debe estar seleccionado!",
        timer: 4000,
      });
    } else if (area == 0 || area == "") {
      $("#grupoarea").focus();
      Swal.fire({
        icon: "info",
        title: "Seleccione un grupo de area...",
        text: "Campo debe estar seleccionado!",
        timer: 4000,
      });
    } else if (cargo == 0 || cargo == "") {
      $("#grupocargo").focus();
      Swal.fire({
        icon: "info",
        title: "Seleccione un grupo de cargo...",
        text: "Campo debe estar seleccionado!",
        timer: 4000,
      });
    } else {
      Swal.fire({
        title: "Estas seguro de guardar los datos?",
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
            url: "/recursoshumanos/personal/mantenimientoindicador",
            data: {
              dni: dni,
              zona: zona,
              local: local,
              area: area,
              cargo: cargo,
              turno: turno,
              flex: flex,
              remoto: remoto,
              marcacion: marcacion,
              venta: venta,
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
    }
  });

  // CANCELAR ELIMINACION DE INCIDENCIA
  $("#btncancelar").on("click", function () {
    $("#modal-editar").modal("hide");
  });
});