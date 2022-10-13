// var dias = Array();
// var dias = $('[name="checks[]"]:checked').map(function () {return this.value;}).get();
// //dias.push(arr);
// // console.clear();
// console.log(dias);
  
  // var data = [];
  // $("#lunesbox,#martesbox,#miercolesbox,#juevesbox,#viernesbox,#sabadobox,#domingobox").on("change", function () {

  //   var horainicio = $("#hora-inicio").val();
  //   var horafin = $("#hora-fin").val();

  //   if (horainicio == null || horainicio == "") {
  //     Swal.fire({
  //       icon: "info",
  //       title: "No ha ingresado una hora de inicio...",
  //       text: "Favor de ingresar una hora válida!",
  //       timer: 3000,
  //       timerProgressBar: true,
  //     });
  //     $("#lunesbox,#martesbox,#miercolesbox,#juevesbox,#viernesbox,#sabadobox,#domingobox").prop("checked", false);
  //     $("#hora-inicio").prop("required", true);
  //   } else if (horafin == null || horafin == "") {
  //     Swal.fire({
  //       icon: "info",
  //       title: "No ha ingresado una hora fin...",
  //       text: "Favor de ingresar una hora fin válida!",
  //       timer: 3000,
  //       timerProgressBar: true,
  //     });
  //     $("#lunesbox,#martesbox,#miercolesbox,#juevesbox,#viernesbox,#sabadobox,#domingobox").prop("checked", false);
  //     $("#hora-fin").prop("required", true);
  //   } else {
  //     if ($(this).is(":checked")) {
  //       var checked = 1;
  //       var valor = $(this).val();
  //       console.log("Checkbox " +$(this).prop("id") +" (" +$(this).val() +") => Seleccionado"
  //       );
  //     } else {
  //       var checked = 0;
  //       var valor = $(this).val();
  //       console.log("Checkbox " +$(this).prop("id") +" (" +$(this).val() +") => Deseleccionado"
  //       );
  //     }
  //   }

  //   // if (checked == 0) {
  //   //   var checked1 = 1;
  //   // } else {
  //   //   var checked1 = 0;
  //   // }

  //   // var index = cod.indexOf(valor + "/" + checked1); // 1/0
  //   // //alert(valor.substring(valor.indexOf("/")+1,valor.length));

  //   // if (index > -1) {
  //   //   cod.splice(index, 1);
  //   // } else {
  //   //   cod.push(valor + "/" + checked);
  //   // }
  // });
  
  
  // $("input[id='cbx1']").on("change", function () {
  //   // var id = $(this).find("#example td").eq(0).html();
  //   // var dni = $(this).find("#example td").eq(2).html();
  //   var dni = $(this).find("td").eq(2).text();

  //   if ($("#controlador").val() == 1) {
  //     if ($(this).is(":checked")) {
  //       var checked = 1;
  //       var valor = $(this).val();
  //       console.log(
  //         "Checkbox " +
  //           $(this).prop("id") +
  //           " (" +
  //           $(this).val() +
  //           ") => Seleccionado"
  //       );
  //     } else {
  //       var checked = 0;
  //       var valor = $(this).val();
  //       console.log(
  //         "Checkbox " +
  //           $(this).prop("id") +
  //           " (" +
  //           $(this).val() +
  //           ") => Deseleccionado"
  //       );
  //     }
  //   }

  //   nuevoarray = new Array();
  //   nuevoarray["i_num_semana"] = parseInt(semana);
  //   nuevoarray["v_descripcion"] = descrsemana;
  //   nuevoarray["v_dni"] = dni;

  //   cod.push(nuevoarray);

  //   // if (checked == 0) {
  //   //   var checked1 = 1;
  //   // } else {
  //   //   var checked1 = 0;
  //   // }

  //   // var index = cod.indexOf(valor + "/" + checked1); // 1/0
  //   // //alert(valor.substring(valor.indexOf("/")+1,valor.length));

  //   // if (index > -1) {
  //   //   cod.splice(index, 1);
  //   // } else {
  //   //   cod.push(valor + "/" + checked);
  //   // }
  //   console.log(cod);
  // });
  
  
  
  //// version 1
  // $("input[id='cbx1']").change(function () {
  //   if ($(this).is(":checked")) {$("input[id='cbx1']").not(this).prop("checked", false);

  //     nuevoarray = new Array();

  //     var tr = $(this).closest("tr");
  //     var id = $(tr).find("td").eq(0).text();
  //     var dni = $(tr).find("td").eq(1).text();

  //     nuevoarray['i_num_semana'] = parseInt(semana);
  //     nuevoarray['v_descripcion'] = descrsemana;
  //     nuevoarray['v_dni'] = dni;

  //     cod.push(nuevoarray);

  //     console.log(cod);

  //     // console.log(
  //     //   "reservacion: " +id +" - nombre: " + dni
  //     // );

  //   }
  // });

  //// version 2
  // $('#example tr').each(function () {
  //     // var separator = "/"
  //     var id = $(this).find('td').eq(0).html();
  //     var dni = $(this).find('td').eq(2).html();

  //     if (id === undefined) {

  //     }
  //     else {
  //       nuevoarray = new Array();
  //       nuevoarray['i_num_semana'] = parseInt(semana);
  //       nuevoarray['v_descripcion'] = descrsemana;
  //       nuevoarray['v_dni'] = dni;

  //       cod.push(nuevoarray);
  //     }
  // });


  /// VERSION 3

//   var array = [];
//   var checkboxes = document.querySelectorAll("input[id='cbx1']:checked");
//   for (var i = 0; i < checkboxes.length; i++) {
//     array.push(checkboxes[i].value);
//   }
//   // alert(JSON.stringify(array));
//   console.log(array);