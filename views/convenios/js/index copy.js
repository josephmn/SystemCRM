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

  var Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 5000,
  });

  //CARGAR DESHABILITADO COMBO
  $("#estado-imagen-convenio").attr("disabled", true);

  //CARGAR DESHABILITADO LOS INPUT
  $("#finicio-imagen-convenio,#letraid,#convenioid").attr("readonly", true);

  //Date range picker
  $("#finicio-imagen-convenio, #ffin-imagen-convenio").datetimepicker({
    format: "DD/MM/YYYY",
  });

  var fecha = new Date(); //Fecha actual
  var mes = fecha.getMonth() + 1; //obteniendo mes
  var dia = fecha.getDate(); //obteniendo dia
  var ano = fecha.getFullYear(); //obteniendo año
  if (dia < 10) dia = "0" + dia; //agrega cero si el menor de 10
  if (mes < 10) mes = "0" + mes; //agrega cero si el menor de 10
  document.getElementById("finicio-imagen-convenio").value =
    dia + "/" + mes + "/" + ano;
  document.getElementById("ffin-imagen-convenio").value =
    dia + "/" + mes + "/" + ano;

  creardatatable("#example", 10, 0);
  creardatatable("#tbventa", 10, 0);
  creardatatable("#tbconvenios", 10, 0);
  creardatatable("#tbconveniosedu", 10, 0);

  //-------------------- MODAL AGREGAR IMAGEN --------------------//

  //#region "MODAL AGREGAR IMAGEN"

  // show modal
  $("#btnimgconvenios").on("click", function () {
    $("#modal-agregar-convenio-img").modal("show");
  });

  // imagen tarjeta
  $("#imagen-tarjeta").on("change", function () {
    let imagen = document.getElementById("preview-imagen-tarjeta");
    let input = document.getElementById("imagen-tarjeta");
    let archivos = input.files;

    let extensiones = input.value.substring(
      input.value.lastIndexOf("."),
      input.value.lenght
    );

    if (!archivos || !archivos.length) {
      imagen.src =
        "https://verdum.com/recursoshumanos/public/dist/img/beneficios/convenios/tarjeta-no-disponible.jpg";
      input.value = "";
    } else if (
      input.getAttribute("accept").split(",").indexOf(extensiones) < 0
    ) {
      alert("Debes seleccionar una imagen");
      input.value = "";
    } else {
      let imagenUrl = URL.createObjectURL(archivos[0]);
      imagen.src = imagenUrl;
    }
  });

  // imagen ventana
  $("#imagen-ventana").on("change", function () {
    let imagen = document.getElementById("preview-imagen-ventana");
    let input = document.getElementById("imagen-ventana");
    let archivos = input.files;

    let extensiones = input.value.substring(
      input.value.lastIndexOf("."),
      input.value.lenght
    );

    if (!archivos || !archivos.length) {
      imagen.src =
        "https://verdum.com/recursoshumanos/public/dist/img/beneficios/convenios/ventana-no-disponible.jpg";
      input.value = "";
    } else if (
      input.getAttribute("accept").split(",").indexOf(extensiones) < 0
    ) {
      alert("Debes seleccionar una imagen");
      input.value = "";
    } else {
      let imagenUrl = URL.createObjectURL(archivos[0]);
      imagen.src = imagenUrl;
    }
  });

  // guardar convenio imagen
  $("#btnagregar-convenio-imagen").on("click", function () {
    let post = 1; //insert
    let condicion = $("#condicion-imagen-convenio").val();
    let nombre = $("#nombre-imagen-convenio").val();
    let estado = $("#estado-imagen-convenio").val();
    let fechainicio = $("#finicio-imagen-convenio").val();
    let fechafin = $("#ffin-imagen-convenio").val();

    if (condicion == 0 || condicion == null) {
      Toast.fire({
        icon: "error",
        title:
          "No ha seleccionado una condicion de visualización, favor de seleccionar uno..!!",
      });
      $("#condicion-imagen-convenio").focus();
      return;
    }

    if (nombre == 0 || nombre == null) {
      Toast.fire({
        icon: "error",
        title:
          "No ha ingresado un nombre para el conveion, se sugiere sea el mismo nombre del patrocinador..!!",
      });
      $("#nombre-imagen-convenio").focus();
      return;
    }

    // fecha fin
    if (fechafin == "" || fechafin == null) {
      Toast.fire({
        icon: "error",
        title: "No ha ingresado la fecha fin del convenio..!!",
      });
      $("#ffin-imagen-convenio").focus();
      return;
    }

    // formato fecha fin
    if (
      fechafin.includes("d") == true ||
      fechafin.includes("m") == true ||
      fechafin.includes("a") == true
    ) {
      Toast.fire({
        icon: "error",
        title: "Fecha fin del convenio no tiene el formato correcto..!!",
      });
      $("#ffin-imagen-convenio").focus();
      return;
    }

    let input_tarjeta = document.getElementById("imagen-tarjeta");
    let archivo_tarjeta = input_tarjeta.files;

    if (!archivo_tarjeta || !archivo_tarjeta.length) {
      Toast.fire({
        icon: "error",
        title: "No ha seleccionado una imagen para la tarjeta..!!",
      });
      return;
    }

    let input_ventana = document.getElementById("imagen-ventana");
    let archivo_ventana = input_ventana.files;

    if (!archivo_ventana || !archivo_ventana.length) {
      Toast.fire({
        icon: "error",
        title: "No ha seleccionado una imagen para la ventana..!!",
      });
      return;
    }

    let formData = new FormData();
    let file_tarjeta = $("#imagen-tarjeta")[0].files[0];
    let file_ventana = $("#imagen-ventana")[0].files[0];

    formData.append("post", post);
    formData.append("condicion", condicion);
    formData.append("nombre", nombre);
    formData.append("estado", estado);
    formData.append("finicio", fechainicio);
    formData.append("ffin", fechafin);
    formData.append("tarjeta", file_tarjeta);
    formData.append("ventana", file_ventana);

    Swal.fire({
      title: "Estas seguro de guardar los datos para el convenio?",
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
          url: "/recursoshumanos/anuncios/mantenimiento_convenio",
          data: formData,
          contentType: false,
          processData: false,
          beforeSend: function () {
            // setting a timeout
            $("#btnagregar-convenio-imagen").attr("disabled", "disabled");
            $("#btncancelar-convenio-imagen").attr("disabled", "disabled");
            $("#btnagregar-convenio-imagen").html(
              "<span class='spinner-border spinner-border-sm'></span> \
                                <span class='ml-25 align-middle'>GUARDANDO...</span>"
            );
          },
          success: function (res) {
            // console.log(res);
            // JSON.stringify(console.log(res));
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
              $("#modal-agregar-convenio-img").modal("hide");
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
              $("#btnagregar-convenio-imagen").attr("disabled", false);
              $("#btncancelar-convenio-imagen").prop("disabled", false);
              $("#btnagregar-convenio-imagen").html("GUARDAR");
            }
          },
        });
      }
    });
  });

  // cancelar convenio imagen
  $("#btncancelar-convenio-imagen").on("click", function () {
    $("#modal-agregar-convenio-img").modal("hide");
  });

  //#endregion

  // $("#imagen1").on("change", function () {
  //   let imagen = document.getElementById("preview1");
  //   let input = document.getElementById("imagen1");
  //   let archivos = input.files;

  //   let extensiones = input.value.substring(
  //     input.value.lastIndexOf("."),
  //     input.value.lenght
  //   );

  //   if (!archivos || !archivos.length) {
  //     imagen.src = "";
  //     input.value = "";
  //   } else if (
  //     input.getAttribute("accept").split(",").indexOf(extensiones) < 0
  //   ) {
  //     alert("Debes seleccionar una imagen");
  //     input.value = "";
  //   } else {
  //     $("#imagen-convenio").css("display", "block");
  //     let imagenUrl = URL.createObjectURL(archivos[0]);
  //     imagen.src = imagenUrl;
  //   }
  // });

  $("#condicion-convenio").on("change", function () {
    let index = $("#condicion-convenio").val();

    if (index == 0) {
      $("#archivo-convenio").css("display", "none");
      $("#imagen-convenio").css("display", "none");
    } else if (index == 1) {
      $("#archivo-convenio").css("display", "block");
      // $("#imagen-convenio").css("display", "block");
    } else if (index == 2) {
      $("#archivo-convenio").css("display", "block");
      // $("#imagen-convenio").css("display", "block");
    } else if (index == 3) {
      $("#archivo-convenio").css("display", "block");
      $("#imagen-convenio").css("display", "block");
    } else if (index == 4) {
      $("#archivo-convenio").css("display", "block");
      $("#imagen-convenio").css("display", "none");
    } else if (index == 5) {
      $("#archivo-convenio").css("display", "block");
      $("#imagen-convenio").css("display", "none");
    }
  });

  // condicion tarjeta
  $("#condicion-imagen-convenio").on("change", function () {
    let index = $("#condicion-imagen-convenio").val();

    if (index == 0) {
      $("#tarjeta-imagen-convenio").css("display", "none");
      $("#imagen-tarjeta-convenio").css("display", "none");
      $("#ventana-imagen-convenio").css("display", "none");
      $("#imagen-ventana-convenio").css("display", "none");
    } else if (index == 1) {
      $("#archivo-convenio").css("display", "block");
      // $("#imagen-convenio").css("display", "block");
    } else if (index == 2) {
      $("#archivo-convenio").css("display", "block");
      // $("#imagen-convenio").css("display", "block");
    } else if (index == 3) {
      $("#archivo-convenio").css("display", "block");
      $("#imagen-convenio").css("display", "block");
    } else if (index == 4) {
      $("#archivo-convenio").css("display", "block");
      $("#imagen-convenio").css("display", "none");
    } else if (index == 5) {
      $("#archivo-convenio").css("display", "block");
      $("#imagen-convenio").css("display", "none");
    }
  });

  //-------------------- MODAL ACTUALIZAR --------------------//

  //#endregion "MODAL ACTUALIZAR CONVENIO IMAGEN"

  // SHOW MODAL
  $("#tbconvenios tbody").on("click", "a.act-convenio", function () {
    var cod = $(this).attr("id");
    $("#convenioid").val(cod);
    $("#modal-editar-convenio").modal("show");
  });

  var count_imagen = 1;
  var datos_imagen = [];

  $("#btn-refresh").on("click", function () {
    let idcon = $("#convenioid").val(); //id del convenio
    let texto = $("#letrastext").val();
    let size = $("#letrasize").val();
    let color = $("#letracolor").val();
    let angle = $("#letraangle").val();
    let x = $("#letrax").val();
    let y = $("#letray").val();

    $.ajax({
      type: "POST",
      url: "/recursoshumanos/anuncios/imagen_refresh",
      data: {
        idcon: idcon,
        texto: texto,
        size: size,
        color: color,
        angle: angle,
        x: x,
        y: y,
      },
      success: function (res) {
        $("#draw-img").html("");
        $("#draw-img").append(res.div);
        destroy_imagen(res.imagen);
      },
    });
  });

  $("#btn-agregar-disenio").on("click", function () {
    $("#example").dataTable().fnDestroy();

    let idcon = $("#convenioid").val();
    let texto = $("#letrastext").val();
    let size = $("#letrasize").val();

    let color = $("#letracolor").val();

    let angle = $("#letraangle").val();
    let x = $("#letrax").val();
    let y = $("#letray").val();

    let datos = [texto, size, angle, color, x, y];
    console.log(datos);

    // construimos la fila
    let fila =
      "<tr> \
      <td class='text-center'>" +
      count_imagen +
      "</td> \
      <td class='text-center'>" +
      idcon +
      "</td> \
      <td class='text-left'>" +
      texto +
      "</td> \
      <td class='text-center'>" +
      size +
      "</td> \
      <td class='text-center' style= 'background-color:rgb(196,196,196); color:" +
      color +
      ";'><i class='fas fa-square'></i>&nbsp;" +
      color +
      "</td> \
      <td class='text-center'>" +
      angle +
      "</td> \
      <td class='text-center'>" +
      x +
      "</td> \
      <td class='text-center'>" +
      y +
      "</td> \
      <td><a id=" +
      count_imagen +
      " href='#' class='btn btn-kimbo btn-sm text-white editar-data'><i class='fas fa-edit'></i></a></td> \
      <td><a id=" +
      count_imagen +
      " href='#' class='btn btn-danger btn-sm text-white delete-data'><i class='fas fa-trash-can'></i></a></td> \
    </tr>";

    // insertamos la fila contruida en la tabla
    let btn = document.createElement("tr");
    btn.innerHTML = fila;
    document.getElementById("tbdatosimg").appendChild(btn);

    datos_imagen.push({
      id: count_imagen,
      texto: texto,
      size: size,
      angle: angle,
      color: color,
      positionx: x,
      positiony: y,
    });

    count_imagen = count_imagen + 1;

    console.log(datos_imagen);

    creardatatable("#example", 10, 0);

    Toast.fire({
      icon: "success",
      title: "Se agregó correctamente..!!",
    });
  });

  $("#example tbody").on("click", "a.delete-data", function () {
    let id = $(this).attr("id");
    console.log(id);
    // $("#idtabla").html("");
    // $("#idtabla").html(id);

    // $("#modal-eliminar").modal("show");
  });

  //#region
});

// function convertToRGB(hex) {
//   var aRgbHex = hex.match(/.{1,2}/g);
//   var aRgb = [
//     parseInt(aRgbHex[0], 16),
//     parseInt(aRgbHex[1], 16),
//     parseInt(aRgbHex[2], 16),
//   ];
//   return aRgb;
// }

function destroy_imagen($nombre) {
  $.ajax({
    type: "POST",
    url: "/recursoshumanos/anuncios/reshacer_imagen",
    data: { nombre: $nombre },
    success: function (res) {
      console.log(res);
    },
  });
}

//-------------------- MODAL AGREGAR --------------------//
// CARGAR MODAL AGREGAR
$("#btnconvenios").on("click", function () {
  $("#modal-agregar-convenio").modal("show");
});

// BONTON REGISTRAR CONVENIO
$("#btn-registrar").on("click", function () {
  var id = 1; // insertar
  var local = 0;
  var nombre = $("#nombre-local").val();
  var idzona = $("#id-zona").val();
  var estado = 0;
  var abrev = $("#abrev").val();
  var horaini = $("#hora-inicio").val();
  var horafin = $("#hora-fin").val();
  var tolerancia = $("#tolerancia").val();
  var tipoasistencia = $("#tipo-asistencia").val();

  if (nombre == null || nombre == "") {
    Swal.fire({
      icon: "info",
      title: "Nombre de local no puede estar vacío...",
      text: "Registre un nombre!",
      timer: 3000,
    });
  } else if (idzona == 0 || idzona == null) {
    Swal.fire({
      icon: "info",
      title: "No ha seleccionado ninguna zona...",
      text: "Favor de seleccionar una zona válida!",
      timer: 3000,
    });
  } else if (abrev == null || abrev == "" || abrev.length < 2) {
    Swal.fire({
      icon: "info",
      title: "No ha ingresado una abreviatura al local...",
      text: "Favor de ingresar uno válido!",
      timer: 3000,
    });
  } else if (abrev.length < 3) {
    Swal.fire({
      icon: "info",
      title: "Longitud incorrecta para abreviatura...",
      text: "Favor de ingresar 3 digitos!",
      timer: 3000,
    });
  } else if (horaini == null || horaini == "") {
    Swal.fire({
      icon: "info",
      title: "No ha ingresado una hora de inicio...",
      text: "Favor de ingresar una hora válido!",
      timer: 3000,
    });
  } else if (horafin == null || horafin == "") {
    Swal.fire({
      icon: "info",
      title: "No ha ingresado una hora de fin...",
      text: "Favor de ingresar una hora válido!",
      timer: 3000,
    });
  } else if (tolerancia == null || tolerancia == "") {
    Swal.fire({
      icon: "info",
      title: "No ha ingresado una hora de tolerancia...",
      text: "Favor de ingresar una hora válido!",
      timer: 3000,
    });
  } else {
    Swal.fire({
      title: "Estas seguro de registrar los datos?",
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
          url: "/recursoshumanos/local/mantenimiento_local",
          data: {
            id: id,
            local: local,
            nombre: nombre,
            idzona: idzona,
            estado: estado,
            abrev: abrev,
            horaini: horaini,
            horafin: horafin,
            tolerancia: tolerancia,
            tipoasistencia: tipoasistencia,
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

// BONTON GUARDAR CAMBIOS
$("#btn-actualizar").on("click", function () {
  var id = 2;
  var local = $("#id-local-actualizar").val();
  var nombre = $("#nombre-local-actualizar").val();
  var idzona = $("#id-zona-actualizar").val();
  var estado = $("#estado-local-actualizar").val();
  var abrev = $("#abrev-local-actualizar").val();
  var horaini = $("#hora-inicio-actualizar").val();
  var horafin = $("#hora-fin-actualizar").val();
  var tolerancia = $("#tolerancia-actualizar").val();
  var tipoasistencia = $("#tipo-asistencia-actualizar").val();

  if (nombre == null || nombre == "") {
    Swal.fire({
      icon: "info",
      title: "Nombre de local no puede estar vacío...",
      text: "Registre un nombre!",
      timer: 3000,
    });
  } else if (idzona == 0 || idzona == null) {
    Swal.fire({
      icon: "info",
      title: "No ha seleccionado ninguna zona...",
      text: "Favor de seleccionar una zona válida!",
      timer: 3000,
    });
  } else if (estado == 0 || estado == null) {
    Swal.fire({
      icon: "info",
      title: "No ha seleccionado ningun estado...",
      text: "Favor de seleccionar un estado válido!",
      timer: 3000,
    });
  } else if (abrev == null || abrev == "") {
    Swal.fire({
      icon: "info",
      title: "No ha ingresado una abreviatura al local...",
      text: "Favor de ingresar uno válido!",
      timer: 3000,
    });
  } else if (abrev.length < 3) {
    Swal.fire({
      icon: "info",
      title: "Longitud incorrecta para abreviatura...",
      text: "Favor de ingresar 3 digitos!",
      timer: 3000,
    });
  } else if (horaini == null || horaini == "") {
    Swal.fire({
      icon: "info",
      title: "No ha ingresado una hora de inicio...",
      text: "Favor de ingresar una hora válido!",
      timer: 3000,
    });
  } else if (horafin == null || horafin == "") {
    Swal.fire({
      icon: "info",
      title: "No ha ingresado una hora de fin...",
      text: "Favor de ingresar una hora válido!",
      timer: 3000,
    });
  } else if (tolerancia == null || tolerancia == "") {
    Swal.fire({
      icon: "info",
      title: "No ha ingresado una hora de tolerancia...",
      text: "Favor de ingresar una hora válido!",
      timer: 3000,
    });
  } else {
    Swal.fire({
      title: "Estas seguro de actualizar los datos?",
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
          url: "/recursoshumanos/local/mantenimiento_local",
          data: {
            id: id,
            local: local,
            nombre: nombre,
            idzona: idzona,
            estado: estado,
            abrev: abrev,
            horaini: horaini,
            horafin: horafin,
            tolerancia: tolerancia,
            tipoasistencia: tipoasistencia,
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

// BONTON CANCELAR REGISTRO
$("#btn-cancelar-actualizar").on("click", function () {
  $("#modal-editar").modal("hide");
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
    lengthMenu: [[row], [row]],
    order: [[orden, "asc"]],
  });
  return tabla;
}

// padres
function navegacionmenu(string) {
  $.ajax({
    type: "POST",
    url: "/recursoshumanos/dashboard/cambiarsession",
    data: { string: string },
  });
  var dato = ""; //cerrado
  $.ajax({
    type: "POST",
    url: "/recursoshumanos/dashboard/cambiaropen",
    data: { string: dato },
  });
}

// hijos
function clicksub(string) {
  $.ajax({
    type: "POST",
    url: "/recursoshumanos/dashboard/cambiarsessionsub",
    data: { string: string },
  });
  var dato = "menu-open"; //cerrado
  $.ajax({
    type: "POST",
    url: "/recursoshumanos/dashboard/cambiaropen",
    data: { string: dato },
  });
}
