$(function () {
  // cargar input deshabilitados
  $("#codigo1").attr("readonly", true);

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

  creardatatable("#example1", 10, 0, "desc");
  creardatatable("#tbcumple", -1, 0, "desc");

  var Toast = Swal.mixin({
    toast: true,
    position: "top-right",
    showConfirmButton: false,
    timer: 5000,
    timerProgressBar: true,
  });

  //CARGAR DESHABILITADO COMBO
  $("#estado-imagen-cumple").attr("disabled", true);

  //CARGAR DESHABILITADO LOS INPUT
  $("#letraid,#cumpleid,#id-imagen-cumple1").attr("readonly", true);

  //-------------------- MODAL AGREGAR --------------------//
  // CARGAR MODAL AGREGAR
  $("#btn-agregar").on("click", function () {
    $("#modal-agregar").modal("show");
  });

  $("#modal-agregar").on("shown.bs.modal", function () {
    $("#titulo").focus();
  });

  // BOTON REGISTRAR
  $("#btn-registrar").on("click", function () {
    let post = 1; //insert
    let id = 0; // no se usa para el insert
    let color = $("#color").val();
    let titulo = $("#titulo").val();
    let mensaje = $("#mensaje").val();
    let descripcion = $("#descripcion").val();
    let modulo = $("#modulo").val();

    if (color == "" || color == null) {
      Toast.fire({
        icon: "error",
        title: "No ha seleccionado ningun color, favor de seleccionar uno..!!",
      });
      $("#color").focus();
      return;
    }

    if (titulo == "" || titulo == null) {
      Toast.fire({
        icon: "error",
        title: "Título no puede quedar vacío, favor de ingresar..!!",
      });
      $("#titulo").focus();
      return;
    }

    if (mensaje == "" || mensaje == null) {
      Toast.fire({
        icon: "error",
        title: "Mensaje no puede quedar vacío, favor de ingresar..!!",
      });
      $("#mensaje").focus();
      return;
    }

    if (descripcion == "" || descripcion == null) {
      descripcion = "";
    }

    if (modulo == 0 || modulo == null) {
      modulo = "";
    }

    Swal.fire({
      title: "Estas seguro de registrar la notificación?",
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
          url: "/recursoshumanos/notificaciones/mantenimiento_notificaciones",
          data: {
            post: post,
            id: id,
            color: color,
            titulo: titulo,
            mensaje: mensaje,
            descripcion: descripcion,
            modulo: modulo,
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
  });

  // BOTON CANCELAR REGISTRO
  $("#btn-cancelar-agregar").on("click", function () {
    $("#modal-agregar").modal("hide");
  });

  //-------------------- MODAL ACTUALIZAR --------------------//
  // CARGAR MODAL ACTUALIZAR
  $("#example1 tbody").on("click", "a.editar", function () {
    let id = $(this).attr("id");

    $.ajax({
      type: "POST",
      url: "/recursoshumanos/notificaciones/get_notificaciones",
      data: { id: id },
      success: function (res) {
        $("#codigo1").val("");
        $("#codigo1").val(id);
        $("#color1").val("");
        $("#color1").val(res.color);
        $("#titulo1").val("");
        $("#titulo1").val(res.titulo);
        $("#mensaje1").val("");
        $("#mensaje1").val(res.mensaje);
        $("#descripcion1").val("");
        $("#descripcion1").val(res.descripcion);
        $("#modulo1").val("");
        $("#modulo1").val(res.modulo);
      },
    });

    $("#modal-editar").modal("show");
  });

  // BOTON GUARDAR CAMBIOS
  $("#btn-actualizar").on("click", function () {
    let post = 2; //actualizar
    let id = $("#codigo1").val();
    let color = $("#color1").val();
    let titulo = $("#titulo1").val();
    let mensaje = $("#mensaje1").val();
    let descripcion = $("#descripcion1").val();
    let modulo = $("#modulo1").val();

    if (color == "" || color == null) {
      Toast.fire({
        icon: "error",
        title: "No ha seleccionado ningun color, favor de seleccionar uno..!!",
      });
      $("#color").focus();
      return;
    }

    if (titulo == "" || titulo == null) {
      Toast.fire({
        icon: "error",
        title: "Título no puede quedar vacío, favor de ingresar..!!",
      });
      $("#titulo").focus();
      return;
    }

    if (mensaje == "" || mensaje == null) {
      Toast.fire({
        icon: "error",
        title: "Mensaje no puede quedar vacío, favor de ingresar..!!",
      });
      $("#mensaje").focus();
      return;
    }

    if (descripcion == "" || descripcion == null) {
      descripcion = "";
    }

    if (modulo == 0 || modulo == null) {
      modulo = "";
    }

    Swal.fire({
      title: "Estas seguro de actualizar la notificación?",
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
          url: "/recursoshumanos/notificaciones/mantenimiento_notificaciones",
          data: {
            post: post,
            id: id,
            color: color,
            titulo: titulo,
            mensaje: mensaje,
            descripcion: descripcion,
            modulo: modulo,
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
  });

  // BOTON CANCELAR REGISTRO
  $("#btn-cancelar-actualizar").on("click", function () {
    $("#modal-editar").modal("hide");
  });

  //-------------------- MODAL ELIMINAR --------------------//
  $("#example1 tbody").on("click", "a.eliminar", function () {
    let post = 3; //eliminar
    let id = $(this).attr("id");
    let color = "";
    let titulo = "";
    let mensaje = "";
    let descripcion = "";
    let modulo = "";

    Swal.fire({
      title: "Estas seguro de eliminar la notificación con código: " + id + "?",
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
          url: "/recursoshumanos/notificaciones/mantenimiento_notificaciones",
          data: {
            post: post,
            id: id,
            color: color,
            titulo: titulo,
            mensaje: mensaje,
            descripcion: descripcion,
            modulo: modulo,
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

  //-------------------- MODAL DESPLEGAR --------------------//
  $("#example1 tbody").on("click", "a.desplegar", function () {
    let post = 4; //desplegar
    let id = $(this).attr("id");
    let color = "";
    let titulo = "";
    let mensaje = "";
    let descripcion = "";
    let modulo = "";

    Swal.fire({
      title: "Estas seguro de desplegar la notificación para todo el personal?",
      text: "Favor de confirmar!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#61C250",
      cancelButtonColor: "#ea5455",
      confirmButtonText: "Si, desplegar!",
      cancelButtonText: "No",
    }).then((result) => {
      if (result.value) {
        $.ajax({
          type: "POST",
          url: "/recursoshumanos/notificaciones/mantenimiento_notificaciones",
          data: {
            post: post,
            id: id,
            color: color,
            titulo: titulo,
            mensaje: mensaje,
            descripcion: descripcion,
            modulo: modulo,
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

  /* ********************************************************************************** */
  /* MODAL AGREGAR IMAGEN */

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
        url: "/recursoshumanos/notificaciones/link_img",
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

  // show modal
  $("#btnimgcumple").on("click", function () {
    $("#modal-agregar-cumple-img").modal("show");
  });

  // guardar cumple imagen
  $("#btnagregar-cumple-imagen").on("click", function () {
    let post = 1; //insert
    let id = 0;
    let condicion = $("#condicion-imagen-cumple").val();
    let nombre = $("#nombre-imagen-cumple").val();
    let estado = $("#estado-imagen-cumple").val();

    if (condicion == 0 || condicion == null) {
      Toast.fire({
        icon: "error",
        title:
          "No ha seleccionado una condicion de visualización, favor de seleccionar uno..!!",
      });
      $("#condicion-imagen-cumple").focus();
      return;
    }

    if (nombre == 0 || nombre == null) {
      Toast.fire({
        icon: "error",
        title:
          "No ha ingresado un nombre para el formato, se sugiere sea el mismo nombre del formato..!!",
      });
      $("#nombre-imagen-cumple").focus();
      return;
    }

    let formData = new FormData();
    let file_ventana = $("#imagen-ventana")[0].files[0];

    formData.append("post", post);
    formData.append("id", id);
    formData.append("condicion", condicion);
    formData.append("nombre", nombre);
    formData.append("estado", estado);
    formData.append("ventana", file_ventana);

    Swal.fire({
      title: "Estas seguro de guardar los datos para el formato?",
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
          url: "/recursoshumanos/notificaciones/mantenimiento_cumple_img",
          data: formData,
          contentType: false,
          processData: false,
          beforeSend: function () {
            // setting a timeout
            $("#btnagregar-cumple-imagen").attr("disabled", "disabled");
            $("#btncancelar-cumple-imagen").attr("disabled", "disabled");
            $("#btnagregar-cumple-imagen").html(
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
              $("#modal-agregar-cumple-img").modal("hide");
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
              $("#btnagregar-cumple-imagen").attr("disabled", false);
              $("#btncancelar-cumple-imagen").prop("disabled", false);
              $("#btnagregar-cumple-imagen").html("GUARDAR");
            }
          },
        });
      }
    });
  });

  // eliminar convenio
  $("#tbcumple tbody").on("click", "a.del-cumple", function () {
    let post = 3; //delete
    let id = $(this).attr("id");
    let condicion = 0;
    let nombre = $(this).attr("nombre");
    let estado = 0;

    let formData = new FormData();
    let file_ventana = "";

    formData.append("post", post);
    formData.append("id", id);
    formData.append("condicion", condicion);
    formData.append("nombre", nombre);
    formData.append("estado", estado);
    formData.append("ventana", file_ventana);

    Swal.fire({
      title: "Estas seguro de eliminar el formato de '" + nombre + "' ?",
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
          url: "/recursoshumanos/notificaciones/mantenimiento_cumple_img_datos",
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

  // cancelar cumple imagen
  $("#btncancelar-cumple-imagen").on("click", function () {
    limpiar_campos_datos_img();
    let ventana = document.getElementById("preview-imagen-ventana");
    $.ajax({
      type: "POST",
      url: "/recursoshumanos/notificaciones/link_img",
      success: function (res) {
        ventana.src = res.vventana;
      },
    });
    $("#modal-agregar-cumple-img").modal("hide");
  });

  $("#tbcumple tbody").on("click", "a.act-cumple", function () {
    let cod = $(this).attr("id");
    $("#cumpleid").val(cod);
    tabla_disenio(cod);
    contruir_imagen(cod);
    $("#modal-editar-cumple").modal("show");
  });

  // REFRESH IMAGEN PARA VISUALIZAR CAMBIOS
  $("#btn-refresh").on("click", function () {
    let idcon = $("#cumpleid").val(); //id del cumple
    let texto = $("#letrastext").val();
    let size = $("#letrasize").val();
    let color = $("#letracolor").val();
    let angle = $("#letraangle").val();
    let x = $("#letrax").val();
    let y = $("#letray").val();
    let aling = $("#textalign").val();
    let font = $("#textfont").val();

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
      url: "/recursoshumanos/notificaciones/imagen_refresh",
      data: {
        idcon: idcon,
        texto: texto,
        size: size,
        color: color,
        angle: angle,
        x: x,
        y: y,
        aling: aling,
        font: font,
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

    let idcon = $("#cumpleid").val();
    let texto = $("#letrastext").val();
    let size = $("#letrasize").val();
    let color = $("#letracolor").val();
    let angle = $("#letraangle").val();
    let x = $("#letrax").val();
    let y = $("#letray").val();
    let align = $("#textalign").val();
    let font = $("#textfont").val();

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
          url: "/recursoshumanos/notificaciones/guardar_disenio",
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
            align: align,
            font: font,
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

  // EDITAR DISEÑO DE LA BASE DE DATOS
  $("#example tbody").on("click", "a.editar-data", function () {
    let id = $(this).attr("id"); // se usa

    $.ajax({
      type: "POST",
      url: "/recursoshumanos/notificaciones/obtenerdatos_disenio",
      data: { id: id },
      success: function (res) {
        limpiar_campos_disenio();
        $("#letraid").val(res.id);
        $("#cumpleid").val(res.icumple);
        $("#letrastext").val(res.vtexto);
        $("#letrasize").val(res.itamanio);
        $("#letracolor").val(res.vcolor);
        $("#letraangle").val(res.iangulo);
        $("#letrax").val(res.iposicionx);
        $("#letray").val(res.iposiciony);
        $("#textalign").val(res.ialineacion);
        $("#textfont").val(res.vfuente);
      },
    });
  });

  // ELIMINAR DISEÑO DE LA BASE DE DATOS
  $("#example tbody").on("click", "a.delete-data", function () {
    let post = 3; // delete
    let id = $(this).attr("id"); // no se usa
    let idcon = $("#cumpleid").val();
    let texto = "";
    let size = 0;
    let color = "#000000";
    let angle = 0;
    let x = 0;
    let y = 0;
    let align = 0;

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
          url: "/recursoshumanos/notificaciones/guardar_disenio",
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
            align: align,
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

  // CERRAR MODAL / CANCELAR Y LIMPIAR CAMPOS
  $("#btn-cancelar-disenio").on("click", function () {
    limpiar_campos_disenio();
    $("#modal-editar-cumple").modal("hide");
  });

  // LIMPIAR CAMPOS DE EDICION
  $("#btn-limpiar-disenio").on("click", function () {
    limpiar_campos_disenio();
  });

  $(".modal-global").on("click", function () {
    $("#modal-variable-global").modal("show");
  });

  $("#btn-cancelar-global").on("click", function () {
    $("#modal-variable-global").modal("hide");
  });

  //#region "MODAL ACTUALIZAR DATOS + IMAGENES"

  // show modal
  $("#tbcumple tbody").on("click", "a.act-datos", function () {
    let cod = $(this).attr("id");

    $.ajax({
      type: "POST",
      url: "/recursoshumanos/notificaciones/obtenerdatos",
      data: { id: cod },
      success: function (res) {
        $("#id-imagen-cumple1").val(res.id);
        $("#condicion-imagen-cumple1").val(res.condicion);
        $("#nombre-imagen-cumple1").val(res.nombre);
        $("#estado-imagen-cumple1").val(res.estado);
        $("#draw-ventana1").html("");
        $("#draw-ventana1").append(res.ventana);
      },
    });

    $("#modal-editar-cumple-img").modal("show");
  });

  // guardar cambios en datos + imagen
  $("#btnagregar-cumple-imagen1").on("click", function () {
    let post = 2; //update
    let id = $("#id-imagen-cumple1").val(); //update
    let condicion = $("#condicion-imagen-cumple1").val();
    let nombre = $("#nombre-imagen-cumple1").val();
    let estado = $("#estado-imagen-cumple1").val();

    if (condicion == 0 || condicion == null) {
      Toast.fire({
        icon: "error",
        title:
          "No ha seleccionado una condicion de visualización, favor de seleccionar uno..!!",
      });
      $("#condicion-imagen-cumple1").focus();
      return;
    }

    if (nombre == 0 || nombre == null) {
      Toast.fire({
        icon: "error",
        title:
          "No ha ingresado un nombre para el formato, se sugiere sea el mismo nombre del formato..!!",
      });
      $("#nombre-imagen-cumple1").focus();
      return;
    }

    let formData = new FormData();
    let file_ventana = $("#imagen-ventana1")[0].files[0];

    formData.append("post", post);
    formData.append("id", id);
    formData.append("condicion", condicion);
    formData.append("nombre", nombre);
    formData.append("estado", estado);
    formData.append("ventana", file_ventana);

    Swal.fire({
      title: "Estas seguro de actualizar los datos para el formato?",
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
          url: "/recursoshumanos/notificaciones/mantenimiento_cumple_img_datos",
          data: formData,
          contentType: false,
          processData: false,
          beforeSend: function () {
            // setting a timeout
            $("#btnagregar-cumple-imagen1").attr("disabled", "disabled");
            $("#btncancelar-cumple-imagen1").attr("disabled", "disabled");
            $("#btnagregar-cumple-imagen1").html(
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
              $("#modal-editar-cumple-img").modal("hide");
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
              $("#btnagregar-cumple-imagen1").attr("disabled", false);
              $("#btncancelar-cumple-imagen1").prop("disabled", false);
              $("#btnagregar-cumple-imagen1").html("GUARDAR");
            }
          },
        });
      }
    });
  });

  // cancelar cumple imagen
  $("#btncancelar-cumple-imagen1").on("click", function () {
    limpiar_campos_datos();
    $("#modal-editar-cumple-img").modal("hide");
  });

  //#endregion
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
  $("#condicion-imagen-cumple").val("0");
  $("#nombre-imagen-cumple").val("");
  $("#estado-imagen-cumple").val("0");
  $("#imagen-tarjeta").val("");
  $("#imagen-ventana").val("");
}

function tabla_disenio(id) {
  $.ajax({
    type: "POST",
    url: "/recursoshumanos/notificaciones/tabla_disenio",
    data: { id: id },
    success: function (res) {
      $("#example").dataTable().fnDestroy();
      $("#tbdisenioimg").html("");
      $("#tbdisenioimg").append(res.tabla);
      creardatatable("#example", 5, 0);
    },
  });
}

function contruir_imagen(id) {
  $.ajax({
    type: "POST",
    url: "/recursoshumanos/notificaciones/obtenerimg_cumple",
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

function destroy_imagen($nombre) {
  $.ajax({
    type: "POST",
    url: "/recursoshumanos/notificaciones/reshacer_imagen",
    data: { nombre: $nombre },
    // success: function (res) {
    //   console.log(res);
    // },
  });
}

// funcion para limpiar campos disenio
function limpiar_campos_disenio() {
  $("#letraid").val("");
  $("#letrastext").val("");
  $("#letrasize").val("10");
  $("#letracolor").val("#000000");
  $("#letraangle").val("0");
  $("#letrax").val("0");
  $("#letray").val("0");
}

// funcion para limpiar campos datos
function limpiar_campos_datos() {
  $("#condicion-imagen-cumple1").val("0");
  $("#nombre-imagen-cumple1").val("");
  $("#estado-imagen-cumple1").val("0");
  $("#imagen-ventana1").val("");
}

// CONTADOR DE CARACTERES PARA TEXTAREA
function caracteres_descripcion() {
  var total = 1200;
  setTimeout(function () {
    var valor = document.getElementById("descripcion");
    var cantidad = valor.value.length;
    document.getElementById("res").innerHTML =
      "<p><b>" +
      cantidad +
      " caractere/s, te quedan " +
      (total - cantidad) +
      "</b></p>";
  }, 10);
}

// crear tabla
function creardatatable(nombretabla, row, corden, orden) {
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
    lengthMenu: [[row], ["10"]],
    order: [[corden, orden]],
  });
  return tabla;
}
