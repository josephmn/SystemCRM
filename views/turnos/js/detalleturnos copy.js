$(function () {
  //cargar deshabilitado los botones
  $("#controlador,#semana,#descripcion,#idlocal,#localdescr").attr(
    "readonly",
    true
  );

  //PARA CARGAR LA TABLA
  $("#example").DataTable({
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
    //   dom: "Bfrtip",
    lengthMenu: [
      [10, 25, 50, -1],
      ["10 filas", "25 filas", "50 filas", "Todo"],
    ],
    // lengthMenu: [ [-1], ["Todo"]],
    //   buttons: [
    //     "excel",
    //     // "pdf",
    //     "print",
    //     {
    //       extend: "pdfHtml5",
    //       orientation: "landscape",
    //       pageSize: "LEGAL",
    //     },
    //   ],
    // order: [[1, "desc"]],
  });

  var data = [];
  $("#lunesbox,#martesbox,#miercolesbox,#juevesbox,#viernesbox,#sabadobox,#domingobox").on("change", function () {
    var horainicio = $("#hora-inicio").val();
    var horafin = $("#hora-fin").val();

    if (horainicio == null || horainicio == "") {
      Swal.fire({
        icon: "info",
        title: "No ha ingresado una hora de inicio...",
        text: "Favor de ingresar una hora válida!",
        timer: 3000,
        timerProgressBar: true,
      });
      $(
        "#lunesbox,#martesbox,#miercolesbox,#juevesbox,#viernesbox,#sabadobox,#domingobox"
      ).prop("checked", false);
      $("#hora-inicio").prop("required", true);
    } else if (horafin == null || horafin == "") {
      Swal.fire({
        icon: "info",
        title: "No ha ingresado una hora fin...",
        text: "Favor de ingresar una hora fin válida!",
        timer: 3000,
        timerProgressBar: true,
      });
      $(
        "#lunesbox,#martesbox,#miercolesbox,#juevesbox,#viernesbox,#sabadobox,#domingobox"
      ).prop("checked", false);
      $("#hora-fin").prop("required", true);
    } else {
      if ($(this).is(":checked")) {
        var checked = 1;
        var valor = $(this).val();
        console.log(
          "Checkbox " +
            $(this).prop("id") +
            " (" +
            $(this).val() +
            ") => Seleccionado"
        );
      } else {
        var checked = 0;
        var valor = $(this).val();
        console.log(
          "Checkbox " +
            $(this).prop("id") +
            " (" +
            $(this).val() +
            ") => Deseleccionado"
        );
      }
    }

    // if (checked == 0) {
    //   var checked1 = 1;
    // } else {
    //   var checked1 = 0;
    // }

    // var index = cod.indexOf(valor + "/" + checked1); // 1/0
    // //alert(valor.substring(valor.indexOf("/")+1,valor.length));

    // if (index > -1) {
    //   cod.splice(index, 1);
    // } else {
    //   cod.push(valor + "/" + checked);
    // }
  });

  var semana = $("#semana").val();
  var descrsemana = $("#descripcion").val();

  var cod = new Array();
  $('#example tr').each(function () {
      // var separator = "/"
      var id = $(this).find('td').eq(0).html();
      var dni = $(this).find('td').eq(2).html();

      if (id === undefined) {
        
      }
      else {
        nuevoarray = new Array();
        nuevoarray['i_num_semana'] = parseInt(semana);
        nuevoarray['v_descripcion'] = descrsemana;
        nuevoarray['v_dni'] = dni;

        cod.push(nuevoarray);
      }
  });

  console.log(cod);


  $("input[id='cbx1']").on("change", function () {
    if ($("#controlador").val() == 1) {
      if ($(this).is(":checked")) {
        var checked = 1;
        var valor = $(this).val();
        console.log(
          "Checkbox " +
            $(this).prop("id") +
            " (" +
            $(this).val() +
            ") => Seleccionado"
        );
      } else {
        var checked = 0;
        var valor = $(this).val();
        console.log(
          "Checkbox " +
            $(this).prop("id") +
            " (" +
            $(this).val() +
            ") => Deseleccionado"
        );
      }
    }

    if (checked == 0) {
      var checked1 = 1;
    } else {
      var checked1 = 0;
    }

    var index = cod.indexOf(valor + "/" + checked1); // 1/0
    //alert(valor.substring(valor.indexOf("/")+1,valor.length));

    if (index > -1) {
      cod.splice(index, 1);
    } else {
      cod.push(valor + "/" + checked);
    }
    console.log(cod);
  });

  // cuando se redibuja la tabla
  $("#example")
    .on("draw.dt", function () {
      $("#controlador").val("2");

      $("input[id='cbx1']").on("change", function () {
        if ($(this).is(":checked")) {
          var checked = 1;
          var valor = $(this).val();
          console.log(
            "Checkbox " +
              $(this).prop("id") +
              " (" +
              $(this).val() +
              ") => Seleccionado"
          );
        } else {
          var checked = 0;
          var valor = $(this).val();
          console.log(
            "Checkbox " +
              $(this).prop("id") +
              " (" +
              $(this).val() +
              ") => Deseleccionado"
          );
        }

        if (checked == 0) {
          var checked1 = 1;
        } else {
          var checked1 = 0;
        }

        var index = cod.indexOf(valor + "/" + checked1); // 1/0
        //alert(valor.substring(valor.indexOf("/")+1,valor.length));

        if (index > -1) {
          cod.splice(index, 1);
        } else {
          cod.push(valor + "/" + checked);
        }
      });
    })
    .DataTable();

  //-------------------- MODAL AGREGAR --------------------//
  // CARGAR MODAL AGREGAR
  $("#btnasignarhora").on("click", function () {
    if ($("input[id='cbx1']:checked").length > 0) {
      // var array = [];
      // var checkboxes = document.querySelectorAll("input[id='cbx1']:checked");
      // for (var i = 0; i < checkboxes.length; i++) {
      //   array.push(checkboxes[i].value);
      // }
      // // alert(JSON.stringify(array));
      // console.log(array);
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

  // BONTON CANCELAR REGISTRO
  $("#btn-cancelar").on("click", function () {
    $("#modal-agregar").modal("hide");
  });

  // $("#btnactualizar").on("click", function () {
  //   if (cod.length > 0) {
  //     var id_grupo = $("#id_grupo").val();
  //     var codigo = "" + cod + "";
  //     // alert(cod);
  //     // alert(id_grupo);
  //     $.ajax({
  //       type: "POST",
  //       url: "/recursoshumanos/asignargrupos/actualizar_grupo",
  //       data: { codigo: codigo, id_grupo: id_grupo },
  //       success: function (res) {
  //         // alert(res.data)

  //         switch (res.data) {
  //           case 0:
  //             $("#mensaje-actualizar").html(
  //               "<div class='alert alert-danger'>ERROR AL ACTUALIZAR, COMUNIQUESE CON SISTEMAS</div>"
  //             );
  //             var id = setInterval(function () {
  //               $("#mensaje-actualizar").html("");
  //               clearInterval(id);
  //             }, 2000);
  //             break;
  //           case 1:
  //             $("#mensaje-actualizar").html(
  //               "<div class='alert alert-success'>ACTUALIZADO CORRECTAMENTE</div>"
  //             );
  //             var id = setInterval(function () {
  //               $("#mensaje-actualizar").html("");
  //               clearInterval(id);
  //             }, 2000);
  //             location.reload();
  //             break;
  //         }
  //       },
  //     });
  //   } else {
  //     $("#mensaje-actualizar").html(
  //       "<div class='alert alert-warning'>NO SE HA SELECCIONADO NINGUN PERSONAL</div>"
  //     );
  //     var id = setInterval(function () {
  //       $("#mensaje-actualizar").html("");
  //       clearInterval(id);
  //     }, 2000);
  //   }
  // });
});
