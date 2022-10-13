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
    position: "top-right",
    showConfirmButton: false,
    timer: 5000,
    timerProgressBar: true,
  });

  //CARGAR DESHABILITADO COMBO
  $(
    "#estado-imagen-convenio,#estado-pdf-convenio,#id-pdf-convenio1,#estado-pdf-convenioedu"
  ).attr("disabled", true);

  //CARGAR DESHABILITADO LOS INPUT
  $("#letraid,#convenioid,#id-imagen-convenio1,#id-pdf-convenioedu1").attr(
    "readonly",
    true
  );

  //Date range picker
  $(
    "#finicio-imagen-convenio, #ffin-imagen-convenio, #finicio-imagen-convenio1, #ffin-imagen-convenio1, #finicio-pdf-convenio, #ffin-pdf-convenio, #finicio-pdf-convenio1, #ffin-pdf-convenio1, #finicio-pdf-convenioedu, #ffin-pdf-convenioedu, #finicio-pdf-convenioedu1, #ffin-pdf-convenioedu1"
  ).datetimepicker({
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
  document.getElementById("finicio-pdf-convenio").value =
    dia + "/" + mes + "/" + ano;
  document.getElementById("ffin-pdf-convenio").value =
    dia + "/" + mes + "/" + ano;
  document.getElementById("finicio-pdf-convenioedu").value =
    dia + "/" + mes + "/" + ano;
  document.getElementById("ffin-pdf-convenioedu").value =
    dia + "/" + mes + "/" + ano;

  creardatatable("#example", 3, 0);
  creardatatable("#tbventa", 10, 0);
  creardatatable("#tbconvenios", 10, 0);
  creardatatable("#tbconveniosedu", 10, 0);

  //-------------------- MODAL AGREGAR IMAGEN --------------------//

  //#region "MODAL AGREGAR IMAGEN - CONVENIO"

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
      $.ajax({
        type: "POST",
        url: "/recursoshumanos/convenios/link_img",
        success: function (res) {
          imagen.src = res.vtarjeta;
        },
      });
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
      $.ajax({
        type: "POST",
        url: "/recursoshumanos/convenios/link_img",
        success: function (res) {
          imagen.src = res.vventana;
        },
      });
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
    let id = 0;
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
          "No ha ingresado un nombre para el convenio, se sugiere sea el mismo nombre del patrocinador..!!",
      });
      $("#nombre-imagen-convenio").focus();
      return;
    }

    // fecha inicio
    if (fechainicio == "" || fechainicio == null) {
      Toast.fire({
        icon: "error",
        title: "No ha ingresado la fecha de inicio del convenio..!!",
      });
      $("#finicio-imagen-convenio").focus();
      return;
    }

    // formato fecha inicio
    if (
      fechainicio.includes("d") == true ||
      fechainicio.includes("m") == true ||
      fechainicio.includes("a") == true
    ) {
      Toast.fire({
        icon: "error",
        title: "Fecha inicio del convenio no tiene el formato correcto..!!",
      });
      $("#finicio-imagen-convenio").focus();
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
    formData.append("id", id);
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
          url: "/recursoshumanos/convenios/mantenimiento_convenio_img",
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

  // cerrar modal y limpiar la data
  $("#close-modal-agregar").on("click", function () {
    limpiar_campos_datos_img();
    let tarjeta = document.getElementById("preview-imagen-tarjeta");
    $.ajax({
      type: "POST",
      url: "/recursoshumanos/convenios/link_img",
      success: function (res) {
        tarjeta.src = res.vtarjeta;
      },
    });
    let ventana = document.getElementById("preview-imagen-ventana");
    $.ajax({
      type: "POST",
      url: "/recursoshumanos/convenios/link_img",
      success: function (res) {
        ventana.src = res.vventana;
      },
    });
    $("#modal-agregar-convenio-img").modal("hide");
  });

  // cancelar convenio imagen
  $("#btncancelar-convenio-imagen").on("click", function () {
    limpiar_campos_datos_img();
    let tarjeta = document.getElementById("preview-imagen-tarjeta");
    $.ajax({
      type: "POST",
      url: "/recursoshumanos/convenios/link_img",
      success: function (res) {
        tarjeta.src = res.vtarjeta;
      },
    });
    let ventana = document.getElementById("preview-imagen-ventana");
    $.ajax({
      type: "POST",
      url: "/recursoshumanos/convenios/link_img",
      success: function (res) {
        ventana.src = res.vventana;
      },
    });
    $("#modal-agregar-convenio-img").modal("hide");
  });

  //#endregion

  //-------------------- MODAL ACTUALIZAR DATOS + IMAGEN --------------------//

  //#region "MODAL ACTUALIZAR DATOS + IMAGENES"

  // show modal
  $("#tbconvenios tbody").on("click", "a.act-datos", function () {
    let cod = $(this).attr("id");

    $.ajax({
      type: "POST",
      url: "/recursoshumanos/convenios/obtenerdatos",
      data: { id: cod },
      success: function (res) {
        $("#id-imagen-convenio1").val(res.id);
        $("#condicion-imagen-convenio1").val(res.condicion);
        $("#nombre-imagen-convenio1").val(res.nombre);
        $("#estado-imagen-convenio1").val(res.estado);
        $("#finicio-imagen-convenio1").val(res.finicio);
        $("#ffin-imagen-convenio1").val(res.ffin);
        $("#imagen-tarjeta1").val("");
        $("#draw-tarjeta1").html("");
        $("#draw-tarjeta1").append(res.tarjeta);
        $("#draw-ventana1").html("");
        $("#draw-ventana1").append(res.ventana);
      },
    });

    $("#modal-editar-convenio-img").modal("show");
  });

  // imagen tarjeta nueva
  $("#imagen-tarjeta1").on("change", function () {
    let imagen = document.getElementById("ruta-imagen-tarjeta1");
    let input = document.getElementById("imagen-tarjeta1");
    let archivos = input.files;

    let extensiones = input.value.substring(
      input.value.lastIndexOf("."),
      input.value.lenght
    );

    if (!archivos || !archivos.length) {
      $.ajax({
        type: "POST",
        url: "/recursoshumanos/convenios/link_img",
        success: function (res) {
          imagen.src = res.vtarjeta;
        },
      });
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

  // imagen ventana nueva
  $("#imagen-ventana1").on("change", function () {
    let imagen = document.getElementById("ruta-imagen-ventana1");
    let input = document.getElementById("imagen-ventana1");
    let archivos = input.files;

    let extensiones = input.value.substring(
      input.value.lastIndexOf("."),
      input.value.lenght
    );

    if (!archivos || !archivos.length) {
      $.ajax({
        type: "POST",
        url: "/recursoshumanos/convenios/link_img",
        success: function (res) {
          imagen.src = res.vventana;
        },
      });
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

  // eliminar convenio
  $("#tbconvenios tbody").on("click", "a.del-convenio", function () {
    let post = 3; //delete
    let id = $(this).attr("id");
    let condicion = 0;
    let nombre = $(this).attr("nombre");
    let estado = 0;
    let fechainicio = "";
    let fechafin = "";

    let formData = new FormData();
    let file_tarjeta = "";
    let file_ventana = "";

    formData.append("post", post);
    formData.append("id", id);
    formData.append("condicion", condicion);
    formData.append("nombre", nombre);
    formData.append("estado", estado);
    formData.append("finicio", fechainicio);
    formData.append("ffin", fechafin);
    formData.append("tarjeta", file_tarjeta);
    formData.append("ventana", file_ventana);

    Swal.fire({
      title: "Estas seguro de eliminar el convenio de '" + nombre + "' ?",
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
          url: "/recursoshumanos/convenios/mantenimiento_convenio_img_datos",
          data: formData,
          contentType: false,
          processData: false,
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

  // guardar cambios en datos + imagen
  $("#btnagregar-convenio-imagen1").on("click", function () {
    let post = 2; //update
    let id = $("#id-imagen-convenio1").val(); //update
    let condicion = $("#condicion-imagen-convenio1").val();
    let nombre = $("#nombre-imagen-convenio1").val();
    let estado = $("#estado-imagen-convenio1").val();
    let fechainicio = $("#finicio-imagen-convenio1").val();
    let fechafin = $("#ffin-imagen-convenio1").val();

    if (condicion == 0 || condicion == null) {
      Toast.fire({
        icon: "error",
        title:
          "No ha seleccionado una condicion de visualización, favor de seleccionar uno..!!",
      });
      $("#condicion-imagen-convenio1").focus();
      return;
    }

    if (nombre == 0 || nombre == null) {
      Toast.fire({
        icon: "error",
        title:
          "No ha ingresado un nombre para el convenio, se sugiere sea el mismo nombre del patrocinador..!!",
      });
      $("#nombre-imagen-convenio1").focus();
      return;
    }

    // fecha inicio
    if (fechainicio == "" || fechainicio == null) {
      Toast.fire({
        icon: "error",
        title: "No ha ingresado la fecha de inicio del convenio..!!",
      });
      $("#finicio-imagen-convenio1").focus();
      return;
    }

    // formato fecha inicio
    if (
      fechainicio.includes("d") == true ||
      fechainicio.includes("m") == true ||
      fechainicio.includes("a") == true
    ) {
      Toast.fire({
        icon: "error",
        title: "Fecha inicio del convenio no tiene el formato correcto..!!",
      });
      $("#finicio-imagen-convenio1").focus();
      return;
    }

    // fecha fin
    if (fechafin == "" || fechafin == null) {
      Toast.fire({
        icon: "error",
        title: "No ha ingresado la fecha fin del convenio..!!",
      });
      $("#ffin-imagen-convenio1").focus();
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
      $("#ffin-imagen-convenio1").focus();
      return;
    }
    /*
    let input_tarjeta = document.getElementById("imagen-tarjeta1");
    let archivo_tarjeta = input_tarjeta.files;

    if (!archivo_tarjeta || !archivo_tarjeta.length) {
      Toast.fire({
        icon: "error",
        title: "No ha seleccionado una imagen para la tarjeta..!!",
      });
      return;
    }

    let input_ventana = document.getElementById("imagen-ventana1");
    let archivo_ventana = input_ventana.files;

    if (!archivo_ventana || !archivo_ventana.length) {
      Toast.fire({
        icon: "error",
        title: "No ha seleccionado una imagen para la ventana..!!",
      });
      return;
    }
    */
    let formData = new FormData();
    let file_tarjeta = $("#imagen-tarjeta1")[0].files[0];
    let file_ventana = $("#imagen-ventana1")[0].files[0];

    formData.append("post", post);
    formData.append("id", id);
    formData.append("condicion", condicion);
    formData.append("nombre", nombre);
    formData.append("estado", estado);
    formData.append("finicio", fechainicio);
    formData.append("ffin", fechafin);
    formData.append("tarjeta", file_tarjeta);
    formData.append("ventana", file_ventana);

    Swal.fire({
      title: "Estas seguro de actualizar los datos para el convenio?",
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
          url: "/recursoshumanos/convenios/mantenimiento_convenio_img_datos",
          data: formData,
          contentType: false,
          processData: false,
          beforeSend: function () {
            // setting a timeout
            $("#btnagregar-convenio-imagen1").attr("disabled", "disabled");
            $("#btncancelar-convenio-imagen1").attr("disabled", "disabled");
            $("#btnagregar-convenio-imagen1").html(
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
              $("#modal-editar-convenio-img").modal("hide");
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
              $("#btnagregar-convenio-imagen1").attr("disabled", false);
              $("#btncancelar-convenio-imagen1").prop("disabled", false);
              $("#btnagregar-convenio-imagen1").html("GUARDAR");
            }
          },
        });
      }
    });
  });

  // cancelar convenio imagen
  $("#btncancelar-convenio-imagen1").on("click", function () {
    limpiar_campos_datos();
    $("#modal-editar-convenio-img").modal("hide");
  });

  // CERRAR MODAL Y LIMPIAR CAMPOS
  $("#close-modal-datos").on("click", function () {
    limpiar_campos_datos();
  });

  //#endregion

  //-------------------- MODAL ACTUALIZAR IMAGEN --------------------//

  //#region "MODAL ACTUALIZAR IMAGEN"

  // SHOW MODAL
  $("#tbconvenios tbody").on("click", "a.act-convenio", function () {
    let cod = $(this).attr("id");
    $("#convenioid").val(cod);
    tabla_disenio(cod);
    contruir_imagen(cod);
    $("#modal-editar-convenio").modal("show");
  });

  // REFRESH IMAGEN PARA VISUALIZAR CAMBIOS
  $("#btn-refresh").on("click", function () {
    let idcon = $("#convenioid").val(); //id del convenio
    let texto = $("#letrastext").val();
    let size = $("#letrasize").val();
    let color = $("#letracolor").val();
    let angle = $("#letraangle").val();
    let x = $("#letrax").val();
    let y = $("#letray").val();

    if (texto == "" || texto == null) {
      Toast.fire({
        icon: "error",
        title:
          "No se puede visualizar por que no ha ingresado ningun texto..!!",
      });
      $("#letrastext").focus();
      return;
    }

    $.ajax({
      type: "POST",
      url: "/recursoshumanos/convenios/imagen_refresh",
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
        let id = setInterval(function () {
          clearInterval(id);
          destroy_imagen(res.imagen);
        }, 2000);
      },
    });
  });

  // GUARDA DISEÑO EN LA BASE DE DATOS
  $("#btn-agregar-disenio").on("click", function () {
    let dato = $("#letraid").val();

    if (dato == "" || dato == null) {
      var post = 1; // insert
      var id = 0; // no se usa
    } else {
      var post = 2; // update
      var id = dato; // se usa
    }

    let idcon = $("#convenioid").val();
    let texto = $("#letrastext").val();
    let size = $("#letrasize").val();
    let color = $("#letracolor").val();
    let angle = $("#letraangle").val();
    let x = $("#letrax").val();
    let y = $("#letray").val();

    if (texto == "" || texto == null) {
      Toast.fire({
        icon: "error",
        title: "No se puede guardar, no ha ingresado un texto..!!",
      });
      $("#letrastext").focus();
      return;
    }

    Swal.fire({
      title: "Estas seguro de guardar el diseño?",
      text: "Favor de confirmar!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#61C250",
      cancelButtonColor: "#ea5455",
      confirmButtonText: "Si, guardar!",
      cancelButtonText: "No",
    }).then((result) => {
      if (result.value) {
        $.ajax({
          type: "POST",
          url: "/recursoshumanos/convenios/guardar_disenio",
          data: {
            post: post,
            id: id,
            idcon: idcon,
            texto: texto,
            size: size,
            color: color,
            angle: angle,
            x: x,
            y: y,
          },
          beforeSend: function () {
            // setting a timeout
            $("#btn-agregar-disenio").attr("disabled", "disabled");
            $("#btn-cancelar-disenio").attr("disabled", "disabled");
            $("#btn-agregar-disenio").html(
              "<span class='spinner-border spinner-border-sm'></span> \
                                <span class='ml-25 align-middle'>Guardando...</span>"
            );
          },
          success: function (res) {
            Toast.fire({
              icon: res.vicon,
              title: res.vtitle,
            });
            tabla_disenio(idcon);
            contruir_imagen(idcon);
            $("#btn-agregar-disenio").attr("disabled", false);
            $("#btn-cancelar-disenio").prop("disabled", false);
            $("#btn-agregar-disenio").html("Guardar diseño");
            limpiar_campos_disenio();
          },
        });
      }
    });
  });

  // ELIMINAR DISEÑO DE LA BASE DE DATOS
  $("#example tbody").on("click", "a.delete-data", function () {
    let post = 3; // delete
    let id = $(this).attr("id"); // no se usa
    let idcon = $("#convenioid").val();
    let texto = "";
    let size = 0;
    let color = "#000000";
    let angle = 0;
    let x = 0;
    let y = 0;

    Swal.fire({
      title: "Estas seguro de eliminar el diseño?",
      text: "Favor de confirmar!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#61C250",
      cancelButtonColor: "#ea5455",
      confirmButtonText: "Si, eliminar!",
      cancelButtonText: "No",
    }).then((result) => {
      if (result.value) {
        $.ajax({
          type: "POST",
          url: "/recursoshumanos/convenios/guardar_disenio",
          data: {
            post: post,
            id: id,
            idcon: idcon,
            texto: texto,
            size: size,
            color: color,
            angle: angle,
            x: x,
            y: y,
          },
          success: function (res) {
            Toast.fire({
              icon: res.vicon,
              title: res.vtitle,
            });
            tabla_disenio(idcon);
            contruir_imagen(idcon);
          },
        });
      }
    });
  });

  // EDITAR DISEÑO DE LA BASE DE DATOS
  $("#example tbody").on("click", "a.editar-data", function () {
    let id = $(this).attr("id"); // se usa

    $.ajax({
      type: "POST",
      url: "/recursoshumanos/convenios/obtenerdatos_disenio",
      data: { id: id },
      success: function (res) {
        limpiar_campos_disenio();
        $("#letraid").val(res.id);
        $("#convenioid").val(res.iconvenio);
        $("#letrastext").val(res.vtexto);
        $("#letrasize").val(res.itamanio);
        $("#letracolor").val(res.vcolor);
        $("#letraangle").val(res.iangulo);
        $("#letrax").val(res.iposicionx);
        $("#letray").val(res.iposiciony);
      },
    });
  });

  // CERRAR MODAL Y LIMPIAR CAMPOS
  $("#close-modal-disenio").on("click", function () {
    limpiar_campos_disenio();
  });

  // LIMPIAR CAMPOS DE EDICION
  $("#btn-limpiar-disenio").on("click", function () {
    limpiar_campos_disenio();
  });

  // CERRAR MODAL / CANCELAR Y LIMPIAR CAMPOS
  $("#btn-cancelar-disenio").on("click", function () {
    limpiar_campos_disenio();
    $("#modal-editar-convenio").modal("hide");
  });

  //#endregion

  //-------------------- MODAL AGREGAR PDF --------------------//

  //#region "MODAL AGREGAR PDF - CONVENIO"

  // show modal
  $("#btnpdfconvenios").on("click", function () {
    $("#modal-agregar-convenio-pdf").modal("show");
  });

  // imagen tarjeta para pdf
  $("#pdf-tarjeta").on("change", function () {
    let imagen = document.getElementById("preview-pdf-tarjeta");
    let input = document.getElementById("pdf-tarjeta");
    let archivos = input.files;

    let extensiones = input.value.substring(
      input.value.lastIndexOf("."),
      input.value.lenght
    );

    if (!archivos || !archivos.length) {
      $.ajax({
        type: "POST",
        url: "/recursoshumanos/convenios/link_img",
        success: function (res) {
          imagen.src = res.vtarjeta;
        },
      });
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

  // guardar convenio pdf
  $("#btnagregar-convenio-pdf").on("click", function () {
    let post = 1; //insert
    let id = 0;
    let condicion = $("#condicion-pdf-convenio").val();
    let nombre = $("#nombre-pdf-convenio").val();
    let estado = $("#estado-pdf-convenio").val();
    let fechainicio = $("#finicio-pdf-convenio").val();
    let fechafin = $("#ffin-pdf-convenio").val();

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

    // fecha inicio
    if (fechainicio == "" || fechainicio == null) {
      Toast.fire({
        icon: "error",
        title: "No ha ingresado la fecha de inicio del convenio..!!",
      });
      $("#finicio-imagen-convenio").focus();
      return;
    }

    // formato fecha inicio
    if (
      fechainicio.includes("d") == true ||
      fechainicio.includes("m") == true ||
      fechainicio.includes("a") == true
    ) {
      Toast.fire({
        icon: "error",
        title: "Fecha inicio del convenio no tiene el formato correcto..!!",
      });
      $("#finicio-imagen-convenio").focus();
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

    let input_tarjeta = document.getElementById("pdf-tarjeta");
    let archivo_tarjeta = input_tarjeta.files;

    if (!archivo_tarjeta || !archivo_tarjeta.length) {
      Toast.fire({
        icon: "error",
        title: "No ha seleccionado una imagen para la tarjeta..!!",
      });
      return;
    }

    let input_ventana = document.getElementById("pdf-ventana");
    let archivo_ventana = input_ventana.files;

    if (!archivo_ventana || !archivo_ventana.length) {
      Toast.fire({
        icon: "error",
        title: "No ha seleccionado un pdf para la ventana..!!",
      });
      return;
    }

    let formData = new FormData();
    let file_tarjeta = $("#pdf-tarjeta")[0].files[0];
    let file_ventana = $("#pdf-ventana")[0].files[0];

    formData.append("post", post);
    formData.append("id", id);
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
          url: "/recursoshumanos/convenios/mantenimiento_convenio_pdf",
          data: formData,
          contentType: false,
          processData: false,
          beforeSend: function () {
            // setting a timeout
            $("#btnagregar-convenio-pdf").attr("disabled", "disabled");
            $("#btncancelar-convenio-pdf").attr("disabled", "disabled");
            $("#btnagregar-convenio-pdf").html(
              "<span class='spinner-border spinner-border-sm'></span> \
                                <span class='ml-25 align-middle'>GUARDANDO...</span>"
            );
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
              $("#btnagregar-convenio-pdf").attr("disabled", false);
              $("#btncancelar-convenio-pdf").prop("disabled", false);
              $("#btnagregar-convenio-pdf").html("GUARDAR");
            }
          },
        });
      }
    });
  });

  // cancelar convenio imagen
  $("#btncancelar-convenio-pdf").on("click", function () {
    limpiar_campos_datos_pdf();
    let imagen = document.getElementById("preview-pdf-tarjeta");
    $.ajax({
      type: "POST",
      url: "/recursoshumanos/convenios/link_img",
      success: function (res) {
        imagen.src = res.vtarjeta;
      },
    });
    $("#modal-agregar-convenio-pdf").modal("hide");
  });

  // CERRAR MODAL Y LIMPIAR CAMPOS
  $("#close-modal-pdf").on("click", function () {
    limpiar_campos_datos_pdf();
    let imagen = document.getElementById("preview-pdf-tarjeta");
    $.ajax({
      type: "POST",
      url: "/recursoshumanos/convenios/link_img",
      success: function (res) {
        imagen.src = res.vtarjeta;
      },
    });
    $("#modal-agregar-convenio-pdf").modal("hide");
  });

  //#endregion

  //-------------------- MODAL ACTUALIZAR PDF --------------------//

  //#region "MODAL ACTUALIZAR DATOS + IMAGENES"

  // show modal
  $("#tbconvenios tbody").on("click", "a.act-datos-pdf", function () {
    let cod = $(this).attr("id");

    $.ajax({
      type: "POST",
      url: "/recursoshumanos/convenios/obtenerdatos_pdf",
      data: { id: cod },
      success: function (res) {
        $("#id-pdf-convenio1").val(res.id);
        $("#condicion-pdf-convenio1").val(res.condicion);
        $("#nombre-pdf-convenio1").val(res.nombre);
        $("#estado-pdf-convenio1").val(res.estado);
        $("#finicio-pdf-convenio1").val(res.finicio);
        $("#ffin-pdf-convenio1").val(res.ffin);
        $("#pdf-tarjeta1").val("");
        $("#draw-pdf-tarjeta1").html("");
        $("#draw-pdf-tarjeta1").append(res.tarjeta);
        $("#pdf-ventana1").val("");
      },
    });

    $("#modal-editar-convenio-pdf").modal("show");
  });

  // imagen tarjeta nueva
  $("#pdf-tarjeta1").on("change", function () {
    let imagen = document.getElementById("preview-pdf-tarjeta1");
    let input = document.getElementById("pdf-tarjeta1");
    let archivos = input.files;

    let extensiones = input.value.substring(
      input.value.lastIndexOf("."),
      input.value.lenght
    );

    if (!archivos || !archivos.length) {
      $.ajax({
        type: "POST",
        url: "/recursoshumanos/convenios/link_img",
        success: function (res) {
          imagen.src = res.vtarjeta;
        },
      });
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

  // guardar cambios en datos + imagen
  $("#btnagregar-convenio-pdf1").on("click", function () {
    let post = 2; //update
    let id = $("#id-pdf-convenio1").val(); //update
    let condicion = $("#condicion-pdf-convenio1").val();
    let nombre = $("#nombre-pdf-convenio1").val();
    let estado = $("#estado-pdf-convenio1").val();
    let fechainicio = $("#finicio-pdf-convenio1").val();
    let fechafin = $("#ffin-pdf-convenio1").val();

    if (condicion == 0 || condicion == null) {
      Toast.fire({
        icon: "error",
        title:
          "No ha seleccionado una condicion de visualización, favor de seleccionar uno..!!",
      });
      $("#condicion-pdf-convenio1").focus();
      return;
    }

    if (nombre == 0 || nombre == null) {
      Toast.fire({
        icon: "error",
        title:
          "No ha ingresado un nombre para el conveion, se sugiere sea el mismo nombre del patrocinador..!!",
      });
      $("#nombre-pdf-convenio1").focus();
      return;
    }

    // fecha inicio
    if (fechainicio == "" || fechainicio == null) {
      Toast.fire({
        icon: "error",
        title: "No ha ingresado la fecha de inicio del convenio..!!",
      });
      $("#finicio-pdf-convenio1").focus();
      return;
    }

    // formato fecha inicio
    if (
      fechainicio.includes("d") == true ||
      fechainicio.includes("m") == true ||
      fechainicio.includes("a") == true
    ) {
      Toast.fire({
        icon: "error",
        title: "Fecha inicio del convenio no tiene el formato correcto..!!",
      });
      $("#finicio-pdf-convenio1").focus();
      return;
    }

    // fecha fin
    if (fechafin == "" || fechafin == null) {
      Toast.fire({
        icon: "error",
        title: "No ha ingresado la fecha fin del convenio..!!",
      });
      $("#ffin-pdf-convenio1").focus();
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
      $("#ffin-pdf-convenio1").focus();
      return;
    }
    /*
    let input_tarjeta = document.getElementById("pdf-tarjeta1");
    let archivo_tarjeta = input_tarjeta.files;

    if (!archivo_tarjeta || !archivo_tarjeta.length) {
      Toast.fire({
        icon: "error",
        title: "No ha seleccionado una imagen para la tarjeta..!!",
      });
      return;
    }
    
    let input_ventana = document.getElementById("pdf-ventana1");
    let archivo_ventana = input_ventana.files;

    if (!archivo_ventana || !archivo_ventana.length) {
      Toast.fire({
        icon: "error",
        title: "No ha seleccionado una imagen para la ventana..!!",
      });
      return;
    }
    */
    let formData = new FormData();
    let file_tarjeta = $("#pdf-tarjeta1")[0].files[0];
    let file_ventana = $("#pdf-ventana1")[0].files[0];

    formData.append("post", post);
    formData.append("id", id);
    formData.append("condicion", condicion);
    formData.append("nombre", nombre);
    formData.append("estado", estado);
    formData.append("finicio", fechainicio);
    formData.append("ffin", fechafin);
    formData.append("tarjeta", file_tarjeta);
    formData.append("ventana", file_ventana);

    Swal.fire({
      title: "Estas seguro de actualizar los datos para el convenio?",
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
          url: "/recursoshumanos/convenios/mantenimiento_convenio_pdf_datos",
          data: formData,
          contentType: false,
          processData: false,
          beforeSend: function () {
            // setting a timeout
            $("#btnagregar-convenio-pdf1").attr("disabled", "disabled");
            $("#btncancelar-convenio-pdf1").attr("disabled", "disabled");
            $("#btnagregar-convenio-pdf1").html(
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
              $("#modal-editar-convenio-pdf").modal("hide");
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
              $("#btnagregar-convenio-pdf1").attr("disabled", false);
              $("#btncancelar-convenio-pdf1").prop("disabled", false);
              $("#btnagregar-convenio-pdf1").html("GUARDAR");
            }
          },
        });
      }
    });
  });

  // cancelar convenio pdf
  $("#btncancelar-convenio-pdf1").on("click", function () {
    limpiar_campos_pdf_datos();
    $("#modal-editar-convenio-pdf").modal("hide");
  });

  // CERRAR MODAL Y LIMPIAR CAMPOS
  $("#close-modal-pdf-datos").on("click", function () {
    limpiar_campos_pdf_datos();
  });

  //#endregion

  //-------------------- MODAL AGREGAR PDF EDUCATIVO --------------------//

  //#region "MODAL AGREGAR PDF - CONVENIO"

  // show modal
  $("#btnpdfconveniosedu").on("click", function () {
    $("#modal-agregar-convenioedu-pdf").modal("show");
  });

  // imagen tarjeta para pdf
  $("#pdf-tarjeta-edu").on("change", function () {
    let imagen = document.getElementById("preview-pdf-tarjeta-edu");
    let input = document.getElementById("pdf-tarjeta-edu");
    let archivos = input.files;

    let extensiones = input.value.substring(
      input.value.lastIndexOf("."),
      input.value.lenght
    );

    if (!archivos || !archivos.length) {
      $.ajax({
        type: "POST",
        url: "/recursoshumanos/convenios/link_img",
        success: function (res) {
          imagen.src = res.vtarjeta;
        },
      });
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

  // guardar convenio pdf
  $("#btnagregar-convenioedu-pdf").on("click", function () {
    let post = 1; //insert
    let id = 0;
    let condicion = $("#condicion-pdf-convenioedu").val();
    let nombre = $("#nombre-pdf-convenioedu").val();
    let estado = $("#estado-pdf-convenioedu").val();
    let fechainicio = $("#finicio-pdf-convenioedu").val();
    let fechafin = $("#ffin-pdf-convenioedu").val();

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

    // fecha inicio
    if (fechainicio == "" || fechainicio == null) {
      Toast.fire({
        icon: "error",
        title: "No ha ingresado la fecha de inicio del convenio..!!",
      });
      $("#finicio-imagen-convenio").focus();
      return;
    }

    // formato fecha inicio
    if (
      fechainicio.includes("d") == true ||
      fechainicio.includes("m") == true ||
      fechainicio.includes("a") == true
    ) {
      Toast.fire({
        icon: "error",
        title: "Fecha inicio del convenio no tiene el formato correcto..!!",
      });
      $("#finicio-imagen-convenio").focus();
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

    let input_tarjeta = document.getElementById("pdf-tarjeta-edu");
    let archivo_tarjeta = input_tarjeta.files;

    if (!archivo_tarjeta || !archivo_tarjeta.length) {
      Toast.fire({
        icon: "error",
        title: "No ha seleccionado una imagen para la tarjeta..!!",
      });
      return;
    }

    let input_ventana = document.getElementById("pdf-ventana-edu");
    let archivo_ventana = input_ventana.files;

    if (!archivo_ventana || !archivo_ventana.length) {
      Toast.fire({
        icon: "error",
        title: "No ha seleccionado un pdf para la ventana..!!",
      });
      return;
    }

    let formData = new FormData();
    let file_tarjeta = $("#pdf-tarjeta-edu")[0].files[0];
    let file_ventana = $("#pdf-ventana-edu")[0].files[0];

    formData.append("post", post);
    formData.append("id", id);
    formData.append("condicion", condicion);
    formData.append("nombre", nombre);
    formData.append("estado", estado);
    formData.append("finicio", fechainicio);
    formData.append("ffin", fechafin);
    formData.append("tarjeta", file_tarjeta);
    formData.append("ventana", file_ventana);

    Swal.fire({
      title: "Estas seguro de guardar los datos para el convenio educativo?",
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
          url: "/recursoshumanos/convenios/mantenimiento_convenioedu_pdf",
          data: formData,
          contentType: false,
          processData: false,
          beforeSend: function () {
            // setting a timeout
            $("#btnagregar-convenioedu-pdf").attr("disabled", "disabled");
            $("#btncancelar-convenioedu-pdf").attr("disabled", "disabled");
            $("#btnagregar-convenioedu-pdf").html(
              "<span class='spinner-border spinner-border-sm'></span> \
                                <span class='ml-25 align-middle'>GUARDANDO...</span>"
            );
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
              $("#modal-agregar-convenioedu-pdf").modal("hide");
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
              $("#btnagregar-convenioedu-pdf").attr("disabled", false);
              $("#btncancelar-convenioedu-pdf").prop("disabled", false);
              $("#btnagregar-convenioedu-pdf").html("GUARDAR");
            }
          },
        });
      }
    });
  });

  // cancelar convenio imagen
  $("#btncancelar-convenioedu-pdf").on("click", function () {
    limpiar_campos_datos_pdf_edu();
    let imagen = document.getElementById("preview-pdf-tarjeta-edu");
    $.ajax({
      type: "POST",
      url: "/recursoshumanos/convenios/link_img",
      success: function (res) {
        imagen.src = res.vtarjeta;
      },
    });
    $("#modal-agregar-convenioedu-pdf").modal("hide");
  });

  // CERRAR MODAL Y LIMPIAR CAMPOS
  $("#close-modaledu-pdf").on("click", function () {
    limpiar_campos_datos_pdf_edu();
    let imagen = document.getElementById("preview-pdf-tarjeta-edu");
    $.ajax({
      type: "POST",
      url: "/recursoshumanos/convenios/link_img",
      success: function (res) {
        imagen.src = res.vtarjeta;
      },
    });
    $("#modal-agregar-convenioedu-pdf").modal("hide");
  });

  //#endregion

  //-------------------- MODAL ACTUALIZAR PDF EDUCATIVO --------------------//

  //#region "MODAL ACTUALIZAR DATOS + PDF"

  // show modal
  $("#tbconveniosedu tbody").on("click", "a.actedu-datos-pdf", function () {
    let cod = $(this).attr("id");

    $.ajax({
      type: "POST",
      url: "/recursoshumanos/convenios/obtenerdatos_pdf_edu",
      data: { id: cod },
      success: function (res) {
        $("#id-pdf-convenioedu1").val(res.id);
        $("#condicion-pdf-convenioedu1").val(res.condicion);
        $("#nombre-pdf-convenioedu1").val(res.nombre);
        $("#estado-pdf-convenioedu1").val(res.estado);
        $("#finicio-pdf-convenioedu1").val(res.finicio);
        $("#ffin-pdf-convenioedu1").val(res.ffin);
        $("#pdf-tarjeta-edu1").val("");
        $("#draw-pdf-tarjeta-edu1").html("");
        $("#draw-pdf-tarjeta-edu1").append(res.tarjeta);
        $("#pdf-ventana-edu1").val("");
      },
    });

    $("#modal-editar-convenioedu-pdf").modal("show");
  });

  // pdf tarjeta nueva
  $("#pdf-tarjeta-edu1").on("change", function () {
    let imagen = document.getElementById("preview-pdf-tarjeta-edu1");
    let input = document.getElementById("pdf-tarjeta-edu1");
    let archivos = input.files;

    let extensiones = input.value.substring(
      input.value.lastIndexOf("."),
      input.value.lenght
    );

    if (!archivos || !archivos.length) {
      $.ajax({
        type: "POST",
        url: "/recursoshumanos/convenios/link_img",
        success: function (res) {
          imagen.src = res.vtarjeta;
        },
      });
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

  // guardar cambios en datos + imagen
  $("#btnagregar-convenioedu-pdf1").on("click", function () {
    let post = 2; //update
    let id = $("#id-pdf-convenioedu1").val(); //update
    let condicion = $("#condicion-pdf-convenioedu1").val();
    let nombre = $("#nombre-pdf-convenioedu1").val();
    let estado = $("#estado-pdf-convenioedu1").val();
    let fechainicio = $("#finicio-pdf-convenioedu1").val();
    let fechafin = $("#ffin-pdf-convenioedu1").val();

    if (condicion == 0 || condicion == null) {
      Toast.fire({
        icon: "error",
        title:
          "No ha seleccionado una condicion de visualización, favor de seleccionar uno..!!",
      });
      $("#condicion-pdf-convenio1").focus();
      return;
    }

    if (nombre == 0 || nombre == null) {
      Toast.fire({
        icon: "error",
        title:
          "No ha ingresado un nombre para el conveion, se sugiere sea el mismo nombre del patrocinador..!!",
      });
      $("#nombre-pdf-convenio1").focus();
      return;
    }

    // fecha inicio
    if (fechainicio == "" || fechainicio == null) {
      Toast.fire({
        icon: "error",
        title: "No ha ingresado la fecha de inicio del convenio..!!",
      });
      $("#finicio-pdf-convenio1").focus();
      return;
    }

    // formato fecha inicio
    if (
      fechainicio.includes("d") == true ||
      fechainicio.includes("m") == true ||
      fechainicio.includes("a") == true
    ) {
      Toast.fire({
        icon: "error",
        title: "Fecha inicio del convenio no tiene el formato correcto..!!",
      });
      $("#finicio-pdf-convenio1").focus();
      return;
    }

    // fecha fin
    if (fechafin == "" || fechafin == null) {
      Toast.fire({
        icon: "error",
        title: "No ha ingresado la fecha fin del convenio..!!",
      });
      $("#ffin-pdf-convenio1").focus();
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
      $("#ffin-pdf-convenio1").focus();
      return;
    }
    /*
    let input_tarjeta = document.getElementById("pdf-tarjeta1");
    let archivo_tarjeta = input_tarjeta.files;

    if (!archivo_tarjeta || !archivo_tarjeta.length) {
      Toast.fire({
        icon: "error",
        title: "No ha seleccionado una imagen para la tarjeta..!!",
      });
      return;
    }
    
    let input_ventana = document.getElementById("pdf-ventana1");
    let archivo_ventana = input_ventana.files;

    if (!archivo_ventana || !archivo_ventana.length) {
      Toast.fire({
        icon: "error",
        title: "No ha seleccionado una imagen para la ventana..!!",
      });
      return;
    }
    */
    let formData = new FormData();
    let file_tarjeta = $("#pdf-tarjeta-edu1")[0].files[0];
    let file_ventana = $("#pdf-ventana-edu1")[0].files[0];

    formData.append("post", post);
    formData.append("id", id);
    formData.append("condicion", condicion);
    formData.append("nombre", nombre);
    formData.append("estado", estado);
    formData.append("finicio", fechainicio);
    formData.append("ffin", fechafin);
    formData.append("tarjeta", file_tarjeta);
    formData.append("ventana", file_ventana);

    Swal.fire({
      title: "Estas seguro de actualizar los datos para el convenio educativo?",
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
          url: "/recursoshumanos/convenios/mantenimiento_convenioedu_pdf_datos",
          data: formData,
          contentType: false,
          processData: false,
          beforeSend: function () {
            // setting a timeout
            $("#btnagregar-convenioedu-pdf1").attr("disabled", "disabled");
            $("#btncancelar-convenioedu-pdf1").attr("disabled", "disabled");
            $("#btnagregar-convenioedu-pdf1").html(
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
              $("#modal-editar-convenioedu-pdf").modal("hide");
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
              $("#btnagregar-convenioedu-pdf1").attr("disabled", false);
              $("#btncancelar-convenioedu-pdf1").prop("disabled", false);
              $("#btnagregar-convenioedu-pdf1").html("GUARDAR");
            }
          },
        });
      }
    });
  });

  // eliminar convenio
  $("#tbconveniosedu tbody").on("click", "a.deledu-convenio", function () {
    let post = 3; //delete
    let id = $(this).attr("id");
    let condicion = 0;
    let nombre = $(this).attr("nombre");
    let estado = 0;
    let fechainicio = "";
    let fechafin = "";

    let formData = new FormData();
    let file_tarjeta = "";
    let file_ventana = "";

    formData.append("post", post);
    formData.append("id", id);
    formData.append("condicion", condicion);
    formData.append("nombre", nombre);
    formData.append("estado", estado);
    formData.append("finicio", fechainicio);
    formData.append("ffin", fechafin);
    formData.append("tarjeta", file_tarjeta);
    formData.append("ventana", file_ventana);

    Swal.fire({
      title: "Estas seguro de eliminar el convenio educativo de '" + nombre + "' ?",
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
          url: "/recursoshumanos/convenios/mantenimiento_convenioedu_pdf_datos",
          data: formData,
          contentType: false,
          processData: false,
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

  // cancelar convenio pdf
  $("#btncancelar-convenioedu-pdf1").on("click", function () {
    limpiar_campos_pdf_datos_edu();
    $("#modal-editar-convenioedu-pdf").modal("hide");
  });

  // CERRAR MODAL Y LIMPIAR CAMPOS
  $("#close-modaledu-pdf-datos").on("click", function () {
    limpiar_campos_pdf_datos_edu();
  });

  //#endregion

  $(".modal-global").on("click", function () {
    $("#modal-variable-global").modal("show");
  });

  $("#btn-cancelar-global").on("click", function () {
    $("#modal-variable-global").modal("hide");
  });
});

var fecha = new Date(); //Fecha actual
var mes = fecha.getMonth() + 1; //obteniendo mes
var dia = fecha.getDate(); //obteniendo dia
var ano = fecha.getFullYear(); //obteniendo año
if (dia < 10) dia = "0" + dia; //agrega cero si el menor de 10
if (mes < 10) mes = "0" + mes; //agrega cero si el menor de 10
var hoy = dia + "/" + mes + "/" + ano;

// funcion limpiar campos agregar imagen
function limpiar_campos_datos_img() {
  $("#condicion-imagen-convenio").val("0");
  $("#nombre-imagen-convenio").val("");
  $("#estado-imagen-convenio").val("0");
  // $("#finicio-imagen-convenio").val(hoy);
  // $("#ffin-imagen-convenio").val(hoy);
  $("#imagen-tarjeta").val("");
  $("#imagen-ventana").val("");
}

// funcion limpiar campos agregar pdf
function limpiar_campos_datos_pdf() {
  $("#condicion-pdf-convenio").val("0");
  $("#nombre-pdf-convenio").val("");
  $("#estado-pdf-convenio").val("0");
  // $("#finicio-pdf-convenio").val(hoy);
  // $("#ffin-pdf-convenio").val(hoy);
  $("#pdf-tarjeta").val("");
  $("#pdf-ventana").val("");
}

// funcion para limpiar campos disenio
function limpiar_campos_disenio() {
  $("#letraid").val("");
  // $("#convenioid").val("");
  $("#letrastext").val("");
  $("#letrasize").val("10");
  $("#letracolor").val("#000000");
  $("#letraangle").val("0");
  $("#letrax").val("0");
  $("#letray").val("0");
}

// funcion para limpiar campos datos
function limpiar_campos_datos() {
  $("#condicion-imagen-convenio1").val("0");
  $("#nombre-imagen-convenio1").val("");
  $("#estado-imagen-convenio1").val("0");
  // $("#finicio-imagen-convenio1").val(hoy);
  // $("#ffin-imagen-convenio1").val(hoy);
  $("#imagen-tarjeta1").val("");
  $("#imagen-ventana1").val("");
}

// funcion para limpiar campos datos pdf
function limpiar_campos_pdf_datos() {
  $("#condicion-pdf-convenio1").val("0");
  $("#nombre-pdf-convenio1").val("");
  $("#estado-pdf-convenio1").val("0");
  // $("#finicio-pdf-convenio1").val(hoy);
  // $("#ffin-pdf-convenio1").val(hoy);
  $("#pdf-tarjeta1").val("");
  $("#pdf-ventana1").val("");
}

// funcion limpiar campos agregar pdf educativos
function limpiar_campos_datos_pdf_edu() {
  $("#condicion-pdf-convenioedu").val("0");
  $("#nombre-pdf-convenioedu").val("");
  $("#estado-pdf-convenioedu").val("0");
  // $("#finicio-pdf-convenioedu").val(hoy);
  // $("#ffin-pdf-convenioedu").val(hoy);
  $("#pdf-tarjeta-edu").val("");
  $("#pdf-ventana-edu").val("");
}

// funcion para limpiar campos datos pdf educativos
function limpiar_campos_pdf_datos_edu() {
  $("#condicion-pdf-convenioedu1").val("0");
  $("#nombre-pdf-convenioedu1").val("");
  $("#estado-pdf-convenioedu1").val("0");
  // $("#finicio-pdf-convenioedu1").val(hoy);
  // $("#ffin-pdf-convenioedu1").val(hoy);
  $("#pdf-tarjeta-edu1").val("");
  $("#pdf-ventana-edu1").val("");
}

function contruir_imagen(id) {
  $.ajax({
    type: "POST",
    url: "/recursoshumanos/convenios/obtenerimg_convenio",
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

function tabla_disenio(id) {
  $.ajax({
    type: "POST",
    url: "/recursoshumanos/convenios/tabla_disenio",
    data: { id: id },
    success: function (res) {
      $("#example").dataTable().fnDestroy();
      $("#tbdisenioimg").html("");
      $("#tbdisenioimg").append(res.tabla);
      creardatatable("#example", 3, 0);
    },
  });
}

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
    url: "/recursoshumanos/convenios/reshacer_imagen",
    data: { nombre: $nombre },
    // success: function (res) {
    //   console.log(res);
    // },
  });
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
    lengthMenu: [[row], [row]],
    order: [[orden, "asc"]],
  });
  return tabla;
}