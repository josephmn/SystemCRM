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

  //CARGAR DESHABILITADO LOS INPUT
  $(
    "#envio_para,#envio_cc,#envio_asunto,#envio_precio,#envio_base,#envio_igv,#envio_total"
  ).attr("readonly", true);

  creardatatable("#example1", -1, 0);

  //Initialize Select2 Elements
  $(".select2").select2();

  //Initialize Select2 Elements
  $(".select2bs4").select2({
    theme: "bootstrap4",
  });

  var Toast = Swal.mixin({
    toast: true,
    position: "top-right",
    showConfirmButton: false,
    timer: 5000,
    timerProgressBar: true,
  });

  // MODAL VENTANA + IMAGEN
  $(".ventana-imagen").on("click", function () {
    let cod = $(this).attr("id");
    mostrar_imagen(cod);
    $("#modal-imagen").modal("show");
  });

  // MODAL VENTANA + IMAGEN + TEXTO
  $(".ventana-imagen-texto").on("click", function () {
    let cod = $(this).attr("id");
    contruir_imagen(cod);
    $("#modal-imagen-texto").modal("show");
  });

  // MODAL PDF
  $(".ventana-pdf").on("click", function () {
    let cod = $(this).attr("id");
    mostrar_pdf(cod);
    $("#modal-pdf").modal("show");
  });

  // MODAL PDF
  $(".ventanaedu-pdf").on("click", function () {
    let cod = $(this).attr("id");
    mostrar_pdf_edu(cod);
    $("#modal-pdf-edu").modal("show");
  });

  var monto_consumido = 0;
  var monto_tope = 0;

  // MODAL ENVIO DE CORREO
  $("#envio_correo").on("click", function () {
    let dia_viernes = "";
    let dia = 0;

    let hour = new Date();
    let corte = hour.getHours();
    // console.log(corte);
    // let minute = new Date();

    $.ajax({
      async: false,
      type: "POST",
      url: "/recursoshumanos/viveverdum/venta_viernes",
      success: function (res) {
        dia_viernes = res;
      },
    });

    // CAMBIAR HORA PARA ENVIO DE CORREO CON PEDIDO PERSONAL
    if (dia_viernes !== "viernes") {
      dia = 0;
    } else {
      if (corte < 16) {
        dia = 1;
      } else {
        dia = 2;
      }
    }

    switch (dia) {
      case 0: // no es viernes
        Swal.fire({
          icon: "info",
          title:
            "Hoy es " + dia_viernes + ", no se pueden pasar pedidos &#128532;",
          html: "Recuerda que los pedidos al personal son los dias <b>VIERNES</b>, hasta las 04:00 pm.",
        });
        break;
      case 1: // viernes
        $.ajax({
          type: "POST",
          url: "/recursoshumanos/viveverdum/obtener_ventas_tope",
          success: function (res) {
            if (res.total == null || res.total == 0) {
              Swal.fire({
                icon: "info",
                title: "Ud. no tiene consumo de su crédito para este mes. &#128521;",
                html:
                  "Recuerda que el tope máximo para llevar producto al mes es de <b>" +
                  res.tope_venta +
                  " soles</b>.",
              });
              cargar_combo(envio_sku);
              $("#modal-pedido").modal("show");
              monto_tope = res.tope_venta;
              monto_consumido = res.total;
            } else if (parseFloat(res.total) > parseFloat(res.tope_venta)) {
              Swal.fire({
                icon: "info",
                title:
                  "Ud. ya utilizo todo el crédito disponible designado al personal, ya no puede comprar &#128546;",
                html:
                  "Recuerda que el tope máximo para llevar producto al mes es de <b>" +
                  res.tope_venta +
                  " soles</b>.",
              });
            } else {
              Swal.fire({
                icon: "info",
                title:
                  "Ud. ya tiene un consumo en este mes de " +
                  res.total +
                  " soles.",
                html:
                  "Recuerda que el tope máximo para llevar producto al mes es de <b>" +
                  res.tope_venta +
                  " soles</b>. Que disfrute su compra! &#128516;",
              });
              cargar_combo(envio_sku);
              $("#modal-pedido").modal("show");
              monto_tope = res.tope_venta;
              monto_consumido = res.total;
            }
          },
        });
        break;
      case 2: // es viernes pero ya paso la hora 04:00 PM
        Swal.fire({
          icon: "info",
          title:
            "Lamento decirte que ya no se pueden pasar los pedidos por hoy &#128546;",
          html: "Recuerda que los pedidos al personal son los dias <b>VIERNES</b>, hasta las 04:00 pm.",
        });
    }
  });

  // OBTENER PRECIO AL SELECCIONAR SKU
  $("#envio_sku").on("change", function () {
    let sku = $("#envio_sku").val();

    $.ajax({
      type: "POST",
      url: "/recursoshumanos/viveverdum/obtener_datossku",
      data: { sku: sku },
      beforeSend: function () {
        $("#envio-agregar").attr("disabled", true);
        $("#btn-enviar").attr("disabled", true);
        $("#carga").html(
          "<span class='spinner-border spinner-border-sm'></span> \
                            <span class='ml-25 align-middle'>Cargando datos, espere por favor...</span>"
        );
        $("#envio_cantidad").attr("readonly", true);
        $("#envio_precio").val("Calculado...");
      },
      success: function (res) {
        if ((res.icase = 0)) {
          Toast.fire({
            icon: "info",
            title:
              "Al parecer el producto no esta habilitado para la venta..!!",
          });
          $("#envio_precio").val("0.00");
          $("#envio-agregar").attr("disabled", false);
          $("#btn-enviar").attr("disabled", false);
          $("#envio_cantidad").attr("readonly", false);
        } else {
          $("#carga").html("");
          $("#envio_precio").val(res.precio);
          $("#envio-agregar").attr("disabled", false);
          $("#btn-enviar").attr("disabled", false);
          $("#envio_cantidad").attr("readonly", false);
          $("#envio_cantidad").focus();
        }
      },
    });
  });

  var countaci = 1;
  var datosaci = [];
  var total = 0;
  // AGREGAR PRODUCTOS A LA TABLA
  $("#envio-agregar").on("click", function () {
    let sku = $("#envio_sku").val();
    let precio = $("#envio_precio").val();
    let cantidad = $("#envio_cantidad").val();

    let subtotal = round(precio * cantidad);

    let index = datosaci.findIndex((item) => item.sku === sku);

    if (cantidad == null || cantidad == "") {
      Toast.fire({
        icon: "info",
        title: "No ha ingresado una cantidad a solicitar ..!!",
      });
      $("#envio_cantidad").focus();
      return;
    }

    if (index == 0) {
      Toast.fire({
        icon: "error",
        title:
          "SKU ya agregado, favor de eliminarlo e ingresarlo nuevamente ..!!",
      });

      // limpiamos campos
      $("#envio_sku").val(null).trigger("change");
      $("#envio_cantidad").val("");
    } else {
      $("#example1").dataTable().fnDestroy();

      let nombre = ShowSelected("envio_sku");
      let longitud = nombre.length;

      let descripcion = nombre.substring(8, longitud);

      let fila =
        "<tr><td class='text-center'>" +
        countaci +
        "</td><td class='text-center'>" +
        sku +
        "</td><td class='text-left'>" +
        descripcion +
        "</td><td class='text-right'>" +
        precio +
        "</td><td class='text-right'>" +
        cantidad +
        "</td><td class='text-right'>" +
        round(subtotal) +
        "</td><td class='text-center'><a id=" +
        countaci +
        " class='btn btn-danger btn-sm text-white delete'><span><i class='fa-solid fa-trash-alt'></i></span></a></td></tr>";

      let btn = document.createElement("tr");
      btn.innerHTML = fila;
      document.getElementById("tablita-aci").appendChild(btn);

      datosaci.push({
        id: countaci,
        sku: sku,
        descripcion: descripcion,
        precio: precio,
        cantidad: cantidad,
        subtotal: subtotal,
      });

      // console.log(datosaci);
      // console.log(JSON.stringify(datosaci));

      countaci = countaci + 1;

      creardatatable("#example1", -1, 0);

      total = round(total + subtotal);
      let divtotal = total;

      let igv = round(divtotal * 0.18);

      // limpiamos campos
      $("#envio_sku").val(null).trigger("change");
      $("#envio_cantidad").val("");
      $("#envio_base").val(divtotal);
      $("#envio_igv").val(igv);
      $("#envio_total").val(round(divtotal + igv));
    }
  });

  // cancelar enviar y limpiar datos
  $("#btn-cancelar-agregar").on("click", function () {
    $("#envio_sku").val(null).trigger("change");
    $("#envio_cantidad").val("");
    $("#example1").DataTable().clear().draw();
    datosaci = [];
    countaci = 0;
    total = 0;
    // console.log(datosaci);
    $("#modal-pedido").modal("hide");
  });

  // close boton modal pedido
  $("#close_pedido").on("click", function () {
    $("#envio_sku").val(null).trigger("change");
    $("#envio_cantidad").val("");
    $("#example1").DataTable().clear().draw();
    datosaci = [];
    countaci = 0;
    total = 0;
    // console.log(datosaci);
    $("#modal-pedido").modal("hide");
  });

  // eliminar sku en tabla
  $("#example1 tbody").on("click", "a.delete", function () {
    let id = $(this).attr("id");

    Swal.fire({
      title: "Estas seguro de eliminar el SKU?",
      text: "Favor de confirmar!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#61C250",
      cancelButtonColor: "#ea5455",
      confirmButtonText: "Si, eliminar!", //<i class="fa fa-smile-wink"></i>
      cancelButtonText: "No", //<i class="fa fa-frown"></i>
    }).then((result) => {
      if (result.value) {
        $("#example1").dataTable().fnDestroy();

        let valor = parseInt(id);
        let index = datosaci.findIndex((item) => item.id === valor);
        datosaci.splice(index, 1);

        $("#tablita-aci").children().remove();

        let myArray = [];
        let contador = 1;
        let base = 0;

        for (const property in datosaci) {
          let sku = datosaci[property].sku;
          let descripcion = datosaci[property].descripcion;
          let precio = datosaci[property].precio;
          let cantidad = datosaci[property].cantidad;
          let subtotal = datosaci[property].subtotal;

          let fila =
            "<tr><td class='text-center'>" +
            contador +
            "</td><td class='text-center'>" +
            sku +
            "</td><td class='text-left'>" +
            descripcion +
            "</td><td class='text-right'>" +
            precio +
            "</td><td class='text-right'>" +
            cantidad +
            "</td><td class='text-right'>" +
            subtotal +
            "</td><td class='text-center'><a id=" +
            contador +
            " class='btn btn-danger btn-sm text-white delete'><span><i class='fa-solid fa-trash-alt'></i></span></a></td></tr>";

          let btn = document.createElement("tr");
          btn.innerHTML = fila;
          document.getElementById("tablita-aci").appendChild(btn);

          myArray.push({
            id: contador,
            sku: sku,
            descripcion: descripcion,
            precio: precio,
            cantidad: cantidad,
            subtotal: subtotal,
          });

          contador = contador + 1;

          base = base + subtotal;
        }

        creardatatable("#example1", -1, 0);

        datosaci.splice(0, datosaci.length);

        datosaci = myArray;
        countaci = contador;

        Toast.fire({
          icon: "success",
          title: "SKU eliminaro correctamente..!!",
        });

        // console.log(datosaci);

        total = base;
        let divtotal = total;

        let igv = round(divtotal * 0.18);

        // limpiamos campos
        $("#envio_sku").val(null).trigger("change");
        $("#envio_cantidad").val("");
        $("#envio_base").val(divtotal);
        $("#envio_igv").val(igv);
        $("#envio_total").val(round(divtotal + igv));
      }
    });
  });

  // enviar correo
  $("#btn-enviar").on("click", function () {
    let envio_para = $("#envio_para").val();
    let envio_cc = ""; //$("#envio_cc").val();
    let envio_asunto = $("#envio_asunto").val();

    let envio_base = $("#envio_base").val();
    let envio_igv = $("#envio_igv").val();
    let envio_total = $("#envio_total").val();

    let monto = parseFloat(monto_consumido) + parseFloat(envio_base);

    if (envio_total < 30) {
      Swal.fire({
        icon: "info",
        title: "Monto mínimo de compra &#128517;",
        html: "Existe un tope mínimo de compra de <b>30 soles</b>, seguro estas llevando menos, favor de revisar tu pedido nuevamente.<br> \
        Gracias!! &#128516;",
      });
      return;
    }

    if (datosaci.length == "" || datosaci.length == null) {
      Toast.fire({
        icon: "error",
        title:
          "No ha seleccionado ningun SKU a enviar, favor de seleccionar uno..!!",
      });
      $("#sku").focus();
      return;
    }

    let titulo = "";

    if (monto_consumido == 0) {
      titulo =
        "La solicitud que esta tratando de enviar, tiene un monto de " +
        monto +
        " soles y esta sobrepasando el monto máximo de consumo.";
    } else {
      titulo =
        "Ud. ya tiene un consumo en este mes de " +
        monto_consumido +
        " soles, sumando a la solicitud que quiere enviar de " +
        envio_base +
        " soles, tiene en total: " +
        monto +
        " soles, esta sobrepasando el monto máximo de consumo.";
    }

    if (monto > parseFloat(monto_tope)) {
      Swal.fire({
        icon: "info",
        title: titulo,
        html:
          "Recuerda que el tope máximo para llevar producto al mes es de <b>" +
          monto_tope +
          " soles</b>. Se sugiere reducir las cantidades para reducir el monto. Gracias!! &#128512;",
      });
      return;
    }

    Swal.fire({
      title: "Estas seguro de enviar el correo con el pedido?",
      text: "Favor de confirmar!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#61C250",
      cancelButtonColor: "#ea5455",
      confirmButtonText: "Si, enviar!", //<i class="fa fa-smile-wink"></i>
      cancelButtonText: "No", //<i class="fa fa-frown"></i>
    }).then((result) => {
      if (result.value) {
        $.ajax({
          type: "POST",
          url: "/recursoshumanos/viveverdum/enviar_correo",
          data: {
            envio_para: envio_para,
            envio_cc: envio_cc,
            envio_asunto: envio_asunto,
            detalle: datosaci,
            envio_base: envio_base,
            envio_igv: envio_igv,
            envio_total: envio_total,
          },
          beforeSend: function () {
            // setting a timeout
            $("#btn-enviar").attr("disabled", "disabled");
            $("#btn-cancelar-agregar").attr("disabled", "disabled");
            $("#envio-agregar").attr("disabled", "disabled");
            $("#btn-enviar").html(
              "<span class='spinner-border spinner-border-sm'></span> \
                              <span class='ml-25 align-middle'>Enviando...</span>"
            );
          },
          success: function (res) {
            // console.log(res.correo);
            if ((res.correo = 1)) {
              Swal.fire({
                icon: "success",
                title: "Correo enviado correctamente",
                text: "Muy pronto sera atendido por nuestro personal de BackOffice",
                timer: 5000,
                timerProgressBar: true,
                showCancelButton: false,
                showConfirmButton: false,
              });
              var id = setInterval(function () {
                location.reload();
                clearInterval(id);
              }, 5000);
              $("#modal-pedido").modal("hide");
            } else {
              Swal.fire({
                icon: "error",
                title: "Error al enviar correo",
                text: "Correo no enviado, intentelo mas tarde..",
                timer: 3000,
                timerProgressBar: true,
                showCancelButton: false,
                showConfirmButton: false,
              });
              var id = setInterval(function () {
                location.reload();
                clearInterval(id);
              }, 3000);
              $("#modal-pedido").modal("hide");
            }
          },
        });
      }
    });
  });
});

// redondeo a dos decimales
function round(num) {
  var m = Number((Math.abs(num) * 100).toPrecision(15));
  return (Math.round(m) / 100) * Math.sign(num);
}

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

// obtener texto del select
function ShowSelected(dato) {
  /* Para obtener el texto */
  var combo = document.getElementById(dato);
  return (selected = combo.options[combo.selectedIndex].text);
}

// SOLO NÚMEROS
function solonumero(event) {
  var regex = new RegExp("^[0-9]+$");
  var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
  if (!regex.test(key)) {
    event.preventDefault();
    return false;
  }
}

// CONSTRUCTOR DE COMBO PARA SELECCIONAR SKU PARA VENTA
function cargar_combo(id) {
  $.ajax({
    type: "POST",
    url: "/recursoshumanos/viveverdum/combo_sku",
    success: function (res) {
      $(id).html("");
      $(id).append(res);
    },
  });
}

// CONSTRUCTOR DE VENTANA + IMAGEN
function mostrar_imagen(id) {
  $.ajax({
    type: "POST",
    url: "/recursoshumanos/viveverdum/obtenerimg",
    data: { id: id },
    success: function (res) {
      $("#get-img").html("");
      $("#get-img").append(res.div);
    },
  });
}

// CONSTRUCTOR DE VENTANA + IMAGEN + TEXTO
function contruir_imagen(id) {
  $.ajax({
    type: "POST",
    url: "/recursoshumanos/viveverdum/obtenerimg_convenio",
    data: { id: id },
    success: function (res) {
      $("#draw-img").html("");
      $("#draw-img").append(res.div);
      let id = setInterval(function () {
        clearInterval(id);
        destroy_imagen(res.imagen);
      }, 2000);
    },
  });
}

// CONSTRUCTOR DE VENTANA + PDF
function mostrar_pdf(id) {
  $.ajax({
    type: "POST",
    url: "/recursoshumanos/viveverdum/obtenerpdf",
    data: { id: id },
    success: function (res) {
      $("#get-pdf").html("");
      $("#get-pdf").append(res.div);
    },
  });
}

// CONSTRUCTOR DE VENTANA + PDF EDUCATIVO
function mostrar_pdf_edu(id) {
  $.ajax({
    type: "POST",
    url: "/recursoshumanos/viveverdum/obtenerpdf_edu",
    data: { id: id },
    success: function (res) {
      $("#get-pdf-edu").html("");
      $("#get-pdf-edu").append(res.div);
    },
  });
}

function destroy_imagen($nombre) {
  $.ajax({
    type: "POST",
    url: "/recursoshumanos/viveverdum/deshacer_imagen",
    data: { nombre: $nombre },
    // success: function (res) {
    //   console.log(res);
    // },
  });
}