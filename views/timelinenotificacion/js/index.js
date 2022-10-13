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

  $(".timeline-footer").on("click", "a.revisar", function () {
    let id = $(this).attr("id");

    $.ajax({
      type: "POST",
      url: "/recursoshumanos/timelinenotificacion/actualizar_notificacion",
      data: { id: id },
      success: function (res) {
        console.log('success');
      },
    });
  });
});
