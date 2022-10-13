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

  //Initialize Select2 Elements
  $(".select2").select2();

  //Initialize Select2 Elements
  $(".select2bs4").select2({
    theme: "bootstrap4",
  });

  //cargar bloqueado los botones
  $("#estado,#codigoeps").attr("readonly", true);

  //Datemask dd/mm/yyyy
  $("#fnacimiento,#fingreso").inputmask("dd/mm/yyyy", {
    placeholder: "dd/mm/aaaa",
  });

  // BOTON GUARDAR
  $("#btn_guardar").on("click", function () {
    // llevamos los campos de nombres desde js a php para el insert

    let pertipodoc = $("#tipodocumento").val();
    let perpaterno = $("#paterno").val();
    let permaterno = $("#materno").val();
    let pernombre = $("#nombres").val();
    let peremail = $("#correoempresa").val();
    let peressalud = $("#tieneseguro").val();
    let perdomic = $("#domiciliado").val();
    let perrefzona = $("#correo").val();
    let perdep = $("#departamento").val();
    let perprov = $("#provincia").val();
    let perdist = $("#distrito").val();
    let perttrab = $("#tipotrabajador").val();
    let perregimen = $("#regimen").val();
    let pernivel = $("#niveleducacion").val();
    let perocup = $("#ocupacion").val();
    let perdisc = $("#discapacidad").val();
    let pertcon = $("#tipocontrato").val();
    let perjmax = $("#jornadamax").val();
    let perafeps = $("#afiliadoeps").val();
    let perexqta = $("#exoquinta").val();
    let pertpago = $("#tipopago").val();
    let perafp = $("#afp").val();
    let perarea = $("#area").val();
    let perbanco = $("#bancosueldo").val();
    let perbancocts = $("#bancocts").val();
    let perbruto = $("#sbruto").val();
    let percargo = $("#cargo").val();
    let percond = $("#civil").val();
    let perctaban = $("#cuentasueldo").val();
    let perdir = $("#domicilio_actual").val();
    let perid = $("#dni").val();
    let peremp = $("#empresa").val();
    let perfing = $("#fingreso").val();
    let perfnac = $("#fnacimiento").val();
    let perhijos = $("#hijos").val();
    let permovilidad = $("#movcomercial").val();
    let pernac = $("#pais").val();
    let pernumafp = $("#codafp").val();
    let perruc = $("#celularempresa").val();
    let perruta = $("#comfluapf").val();
    let perseguro = $("#codessalud").val();
    let persub = $("#centrocosto").val();
    let persubarea = $("#subarea").val();
    let persexo = $("#sexo").val();
    let pertipopago = $("#modopago").val();
    let pertlf1 = $("#celular").val();
    let perzonaid = $("#local").val();
    let user10 = $("#puestoconfianza").val(); // puesto de confianza
    let user2 = $("#cuentacts").val(); // cuneta CTS
    let user4 = $("#tiporemunaracion").val(); // tipo remuneracion: 0 (variable), 1 (fijo), 2 (RIA)
    let user5 = $("#cuentacosto").val(); // cuenta de costo
    let user6 = $("#tipojornada").val(); // tipo de jornada
    let MontoQuintaExt = $("#qtaexterna").val();
    let MontoRetenidoQuinta = $("#sueldopercibido").val();
    let movilidadAdmin = $("#movsupeditada").val();
    let periodosueldo = $("#periodosueldo").val();
    let periodoqta = $("#periodoqta").val();

    // validaciones para registro del personal

    var Toast = Swal.mixin({
      toast: true,
      position: "top-end",
      showConfirmButton: false,
      timer: 4000,
    });

    // validar DNI vacío
    if (perid == "" || perid == null) {
      Toast.fire({
        icon: "error",
        title:
          "N° DNI no puede quedar vacío, favor de ingresar el documento de identidad..!!",
      });
      $("#dni").focus();
      return;
    }

    // validar dni no menor a 8 dígitos
    if (perid.length < 8) {
      Toast.fire({
        icon: "error",
        title:
          "N° DNI no puede tener menos de 8 dígitos, favor de ingresar un documento de identidad válido..!!",
      });
      $("#dni").focus();
      return;
    }

    // dni tiene mas de 8 digitos y es DNI -->  debe ser carnet de extranjeria
    if (perid.length > 8 && pertipodoc == 1) {
      Toast.fire({
        icon: "error",
        title:
          "N° Documento excede los 8 dígitos, favor de seleccionar el tipo de documento correcto..!!",
      });
      $("#tipodocumento").focus();
      return;
    }

    // fecha de nacimiento
    if (perfnac == "" || perfnac == null) {
      Toast.fire({
        icon: "error",
        title: "No ha ingresado la fecha de nacimiento..!!",
      });
      $("#fnacimiento").focus();
      return;
    }

    // formato fecha de nacimiento
    if (
      perfnac.includes("d") == true ||
      perfnac.includes("m") == true ||
      perfnac.includes("a") == true
    ) {
      Toast.fire({
        icon: "error",
        title: "Fecha de nacimiento no tiene el formato correcto..!!",
      });
      $("#fnacimiento").focus();
      return;
    }

    // departamento
    if (perdep == 0 || perdep == null) {
      Toast.fire({
        icon: "error",
        title: "No ha seleccionado un departamento..!!",
      });
      $("#departamento").focus();
      return;
    }

    // provincia
    if (perprov == 0 || perprov == null) {
      Toast.fire({
        icon: "error",
        title: "No ha seleccionado la provincia..!!",
      });
      $("#provincia").focus();
      return;
    }

    // distrito
    if (perdist == 0 || perdist == null) {
      Toast.fire({
        icon: "error",
        title: "No ha seleccionado un distrito..!!",
      });
      $("#distrito").focus();
      return;
    }

    // direccion
    if (perdir == "" || perdir == null) {
      Toast.fire({
        icon: "error",
        title: "Dirección no puede quedar vacío..!!",
      });
      $("#domicilio_actual").focus();
      return;
    }

    // codigo essalud
    if (peressalud == 1 && perseguro == "") {
      Toast.fire({
        icon: "error",
        title: "No ha ingresado el código de Essalud, favor de ingresarlo..!!",
      });
      $("#codessalud").focus();
      return;
    }

    // afp -> validar que tenga flujo o saldo si es AFP
    if (perafp != "SNP" && perafp != "SRP" && perruta == 0) {
      Toast.fire({
        icon: "error",
        title:
          "No ha seleccionado si la comision AFP sera por flujo o saldo..!!",
      });
      $("#comfluapf").focus();
      return;
    }

    // codigo afp -> validar el codigo de afp, si esta seleccionado un AFP
    if (perafp != "SNP" && perafp != "SRP" && pernumafp == "") {
      Toast.fire({
        icon: "error",
        title: "No ha ingresado el codigo de afiliación a la AFP..!!",
      });
      $("#codafp").focus();
      return;
    }

    // nivel de educacion
    if (pernivel == 0) {
      Toast.fire({
        icon: "error",
        title: "No ha seleccionado el nivel de educación..!!",
      });
      $("#niveleducacion").focus();
      return;
    }

    // ocupacion
    if (perocup == "000000") {
      Toast.fire({
        icon: "error",
        title: "No has seleccionado la ocupacion..!!",
      });
      $("#ocupacion").focus();
      return;
    }

    // tipo contrato
    if (pertcon == "00") {
      pertcon = "";
    }

    // cuenta de costo
    if (user5 == "------") {
      user5 = "";
    }

    // fecha de ingreso
    if (perfing == "" || perfing == null) {
      Toast.fire({
        icon: "error",
        title: "No ha ingresado la fecha de ingreso..!!",
      });
      $("#fingreso").focus();
      return;
    }

    // formato incorrecto de fecha de ingreso
    if (
      perfing.includes("d") == true ||
      perfing.includes("m") == true ||
      perfing.includes("a") == true
    ) {
      Toast.fire({
        icon: "error",
        title: "Fecha de ingreso del personal no tiene el formato correcto..!!",
      });
      $("#fingreso").focus();
      return;
    }

    // local trabajador
    if (perzonaid == "--" || perzonaid == null) {
      Toast.fire({
        icon: "error",
        title: "No ha ingresado el local del trabajador..!!",
      });
      $("#local").focus();
      return;
    }

    // area del personal
    if (perarea == "00" || perarea == null) {
      Toast.fire({
        icon: "error",
        title: "No ha ingresado el area del trabajador..!!",
      });
      $("#area").focus();
      return;
    }

    // sub area del personal
    if (persubarea == "00" || persubarea == null) {
      Toast.fire({
        icon: "error",
        title: "No ha ingresado el sub area del trabajador..!!",
      });
      $("#subarea").focus();
      return;
    }

    // cargo del trabajador
    if (percargo == "" || percargo == null) {
      Toast.fire({
        icon: "error",
        title: "No ha seleccionado el cargo del trabajador..!!",
      });
      $("#cargo").focus();
      return;
    }

    // tipo remunaracion
    if (user4 == "-" || user4 == null) {
      Toast.fire({
        icon: "error",
        title: "No ha seleccionado el tipo de remuneracion..!!",
      });
      $("#tiporemunaracion").focus();
      return;
    }

    // sueldo bruto
    if (perbruto == "" || perbruto == null) {
      perbruto = 0;
    }

    // sueldo bruto
    if (movilidadAdmin == "" || movilidadAdmin == null) {
      movilidadAdmin = 0;
    }

    // sueldo bruto
    if (permovilidad == "" || permovilidad == null) {
      permovilidad = 0;
    }

    // cuenta sueldo
    if (perbanco == 0 || perbanco == null) {
      perbanco = "";
    }

    // cuenta cts
    if (perbancocts == 0 || perbancocts == null) {
      perbancocts = "";
    }

    // sueldo percibido
    if (MontoRetenidoQuinta == "" || MontoRetenidoQuinta == null) {
      MontoRetenidoQuinta = 0;
    }

    // sueldo percibido
    if (MontoQuintaExt == "" || MontoQuintaExt == null) {
      MontoQuintaExt = 0;
    }

    // console.log(pertipodoc);
    // console.log(perpaterno);
    // console.log(permaterno);
    // console.log(pernombre);
    // console.log(peremail);
    // console.log(peressalud);
    // console.log(perdomic);
    // console.log(perrefzona);
    // console.log(perdep);
    // console.log(perprov);
    // console.log(perdist);
    // console.log(perttrab);
    // console.log(perregimen);
    // console.log(pernivel);
    // console.log(perocup);
    // console.log(perdisc);
    // console.log(pertcon); //si es 00 = ''
    // console.log(perjmax);
    // console.log(perafeps);
    // console.log(perexqta);
    // console.log(pertpago);
    // console.log(perafp);
    // console.log(perarea);
    // console.log(perbanco);
    // console.log(perbancocts);
    // console.log(perbruto);
    // console.log(percargo);
    // console.log(percond);
    // console.log(perctaban);
    // console.log(perdir);
    // console.log(perid);
    // console.log(peremp);
    // console.log(perfing);
    // console.log(perfnac);
    // console.log(perhijos);
    // console.log(permovilidad);
    // console.log(pernac);
    // console.log(pernumafp);
    // console.log(perruc);
    // console.log(perruta);
    // console.log(perseguro);
    // console.log(persub);
    // console.log(persubarea);
    // console.log(persexo);
    // console.log(pertipopago);
    // console.log(pertlf1);
    // console.log(perzonaid);
    // console.log(user10);
    // console.log(user2);
    // console.log(user4);
    // console.log(user5); // si es '------' = ''
    // console.log(user6);
    // console.log(MontoQuintaExt);
    // console.log(MontoRetenidoQuinta);
    // console.log(movilidadAdmin);
    // console.log(periodosueldo);
    // console.log(periodoqta);

    Swal.fire({
      title: "Estas seguro de registrar al nuevo personal al sistema?",
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
          url: "/recursoshumanos/nuevosingresos/mant_personal",
          data: {
            pertipodoc: pertipodoc,
            perpaterno: perpaterno,
            permaterno: permaterno,
            pernombre: pernombre,
            peremail: peremail,
            peressalud: peressalud,
            perdomic: perdomic,
            perrefzona: perrefzona,
            perdep: perdep,
            perprov: perprov,
            perdist: perdist,
            perttrab: perttrab,
            perregimen: perregimen,
            pernivel: pernivel,
            perocup: perocup,
            perdisc: perdisc,
            pertcon: pertcon,
            perjmax: perjmax,
            perafeps: perafeps,
            perexqta: perexqta,
            pertpago: pertpago,
            perafp: perafp,
            perarea: perarea,
            perbanco: perbanco,
            perbancocts: perbancocts,
            perbruto: perbruto,
            percargo: percargo,
            percond: percond,
            perctaban: perctaban,
            perdir: perdir,
            perid: perid,
            peremp: peremp,
            perfing: perfing,
            perfnac: perfnac,
            perhijos: perhijos,
            permovilidad: permovilidad,
            pernac: pernac,
            pernumafp: pernumafp,
            perruc: perruc,
            perruta: perruta,
            perseguro: perseguro,
            persub: persub,
            persubarea: persubarea,
            persexo: persexo,
            pertipopago: pertipopago,
            pertlf1: pertlf1,
            perzonaid: perzonaid,
            user10: user10,
            user2: user2,
            user4: user4,
            user5: user5,
            user6: user6,
            MontoQuintaExt: MontoQuintaExt,
            MontoRetenidoQuinta: MontoRetenidoQuinta,
            movilidadAdmin: movilidadAdmin,
            periodosueldo: periodosueldo,
            periodoqta: periodoqta,
          },
          success: function (res) {
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
              location.href =
                "https://verdum.com/recursoshumanos/nuevosingresos/index";
              clearInterval(id);
            }, res.itimer);
          },
        });
      }
    });
  });
});

// SOLO LETRAS
function sololetras(event) {
  var regex = new RegExp("^[a-zA-Z ]+$");
  var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
  if (!regex.test(key)) {
    event.preventDefault();
    return false;
  }
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

// PARA NUMERO DE CUENTAS
function paracuentas(event) {
  var regex = new RegExp("^[0-9-]+$");
  var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
  if (!regex.test(key)) {
    event.preventDefault();
    return false;
  }
}

// ALPHANUMÉRICO Y ESPACIOS
function soloalphayespa(event) {
  var regex = new RegExp("^[a-zA-Z0-9 ]+$");
  var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
  if (!regex.test(key)) {
    event.preventDefault();
    return false;
  }
}

// PARA LISTAR LAS PROVINCIAS
$("#departamento").change(function () {
  var departamento = $("#departamento").val();
  $.ajax({
    type: "POST",
    url: "/recursoshumanos/nuevosingresos/cargar_provincia",
    data: { departamento: departamento },
    success: function (res) {
      // alert(res.data);
      $("#provincia").html("");
      $("#provincia").append(res.data);

      $("#distrito").html("");
      $("#distrito").append(
        "<option value='0' selected>-- SELECCIONE --</option>"
      );
    },
  });
});

// PARA LISTAR LOS DISTRITOS
$("#provincia").change(function () {
  var provincia = $("#provincia").val();
  $.ajax({
    type: "POST",
    url: "/recursoshumanos/nuevosingresos/cargar_distritos",
    data: { provincia: provincia },
    success: function (res) {
      // alert(res.data);
      $("#distrito").html("");
      $("#distrito").append(res.data);
    },
  });
});

// HABILITAR CODIGO ESSALUD
$("#tieneseguro").change(function () {
  if ($(this).val() == 0) {
    $("#codessalud").attr("readonly", true);
  } else {
    $("#codessalud").attr("readonly", false);
  }
});

// HABILITAR COMISION / FLUJO Y CODIGO AFP
$("#afp").change(function () {
  if ($(this).val() == "") {
    $("#codafp").attr("readonly", true);
    $("#codafp").val("");
    $("#comfluapf").val("0");
    $("#comfluapf").prop("disabled", true);
  } else if ($(this).val() == "SNP" || $(this).val() == "SRP") {
    $("#codafp").attr("readonly", true);
    $("#codafp").val("");
    $("#comfluapf").val("0");
    $("#comfluapf").prop("disabled", true);
  } else {
    $("#codafp").attr("readonly", false);
    $("#comfluapf").prop("disabled", false);
  }
});

// HABILITAR CODIGO ESSALUD
$("#afiliadoeps").change(function () {
  if ($(this).val() == 0) {
    $("#codigoeps").attr("readonly", true);
    $("#codigoeps").val("");
  } else {
    $("#codigoeps").attr("readonly", false);
  }
});

// PARA LISTAR SUB AREA
$("#area").change(function () {
  var area = $("#area").val();
  $.ajax({
    type: "POST",
    url: "/recursoshumanos/nuevosingresos/cargar_subarea",
    data: { area: area },
    success: function (res) {
      // alert(res.data);
      $("#subarea").html("");
      $("#subarea").append(res.data);
    },
  });
});
