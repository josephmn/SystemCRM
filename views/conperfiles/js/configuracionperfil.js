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

  //cargar deshabilitado los input
  $("#codigo,#postulante").attr("readonly", true);

  creardatatable("#example1", 0); //tabla1.- index

  var codperfil = 0; //variable global para actualizacion

  $("#btnagregar").on("click", function () {
    codperfil = $(this).attr("name");
    combomenu(codperfil);
    combosubmenu(0, 0);
    $("#modal-editar").modal("show");
  });

  $("#modal-editar").on("shown.bs.modal", function () {
    $("#menu").focus();
  });

  $("#btnguardar").on("click", function () {
    let post = 1; //insert
    let xperfil = codperfil;
    let menu = $("#menu").val();
    let submenu = $("#submenu").val();
    let tipo = 0;

    Swal.fire({
      title: "Estas seguro de guardar la siguiente configuración?",
      text: "Esta acción afectara a todos los usuario del perfil!",
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
          url: "/recursoshumanos/conperfiles/mantenimiento_accesos",
          data: {
            post: post,
            perfil: xperfil,
            menu: menu,
            submenu: submenu,
            tipo: tipo,
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
              $("#modal-editar").modal("hide");
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

  $("#btncancelar").on("click", function () {
    $("#modal-editar").modal("hide");
  });

  // PARA LISTAR MENÚ
  $("#menu").change(function () {
    let menu = $("#menu").val();
    $.ajax({
      type: "POST",
      url: "/recursoshumanos/conperfiles/combosubmenu",
      data: { codperfil: codperfil, menu: menu },
      success: function (res) {
        $("#submenu").html("");
        $("#submenu").append(res.data);
      },
    });
  });

  // PARA ELIMINAR SUBMENÚ
  $("#example2 tbody").on("click", "a.delete", function () {
    let post = 3; //delete
    let xperfil = $(this).attr("perfil"); //id del perfil
    let menu = $(this).attr("menu");
    let submenu = $(this).attr("id"); //id del submenu
    let tipo = 2; // para sub menu

    Swal.fire({
      title: "Estas seguro de eliminar el acceso a este sub menú?",
      text: "Esta acción afectara a todos con este perfil...!",
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
          url: "/recursoshumanos/conperfiles/mantenimiento_accesos",
          data: {
            post: post,
            perfil: xperfil,
            menu: menu,
            submenu: submenu,
            tipo: tipo,
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
              $("#modal-editar").modal("hide");
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

  // PARA ELIMINAR MENÚ
  $("#example1 tbody").on("click", "a.deletemenu", function () {
    let post = 3; //delete
    let xperfil = $(this).attr("perfil"); //id del perfil
    let menu = $(this).attr("id"); //id del menu
    let submenu = 0;
    let tipo = 1; // para menu

    Swal.fire({
      title: "Estas seguro de eliminar el acceso a este menú?",
      text: "Esta acción afectara a todos con este perfil...!",
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
          url: "/recursoshumanos/conperfiles/mantenimiento_accesos",
          data: {
            post: post,
            perfil: xperfil,
            menu: menu,
            submenu: submenu,
            tipo: tipo,
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
              $("#modal-editar").modal("hide");
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

// crear combo menu
function combomenu(perfil) {
  $.ajax({
    type: "POST",
    url: "/recursoshumanos/conperfiles/combomenu",
    data: { perfil: perfil },
    success: function (res) {
      $("#menu").html("");
      $("#menu").append(res.data);
    },
  });
}

// crear combo submenu
function combosubmenu(codperfil, menu) {
  $.ajax({
    type: "POST",
    url: "/recursoshumanos/conperfiles/combosubmenu",
    data: { codperfil: codperfil, menu: menu },
    success: function (res) {
      $("#submenu").html("");
      $("#submenu").append(res.data);
    },
  });
}

$(document).ready(function () {
  var groupColumn = 1;
  var table = $("#example2").DataTable({
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
    columnDefs: [{ visible: false, targets: groupColumn }],
    order: [[groupColumn, "asc"]],
    displayLength: [100],
    drawCallback: function (settings) {
      var api = this.api();
      var rows = api.rows({ page: "current" }).nodes();
      var last = null;

      api
        .column(groupColumn, { page: "current" })
        .data()
        .each(function (group, i) {
          if (last !== group) {
            $(rows)
              .eq(i)
              .before(
                '<tr class="group"><td colspan="3">' + group + "</td></tr>"
              );

            last = group;
          }
        });
    },
  });

  // Order by the grouping
  $("#example1 tbody").on("click", "tr.group", function () {
    var currentOrder = table.order()[0];
    if (currentOrder[0] === groupColumn && currentOrder[1] === "asc") {
      table.order([groupColumn, "desc"]).draw();
    } else {
      table.order([groupColumn, "asc"]).draw();
    }
  });
}); //tabla.- tabla index

// crear tabla
function creardatatable(nombretabla, orden) {
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
    lengthMenu: [[-1], ["Todos"]],
    order: [[orden, "asc"]],
  });
  return tabla;
}