$(document).ready(function() {
    /*if(localStorage.getItem("Failure")) {
        toastr.options = {
          "closeButton": false,
          "debug": false,
          "newestOnTop": false,
          "progressBar": false,
          "positionClass": "toast-top-center",
          "preventDuplicates": false,
          "onclick": null,
          "showDuration": "300",
          "hideDuration": "1000",
          "timeOut": "5000",
          "extendedTimeOut": "1000",
          "showEasing": "swing",
          "hideEasing": "linear",
          "showMethod": "fadeIn",
          "hideMethod": "fadeOut"
        }
        toastr.error(localStorage.getItem("Failure"));
        localStorage.clear();
    } else if(localStorage.getItem("Success")) {
        toastr.options = {
          "closeButton": false,
          "debug": false,
          "newestOnTop": false,
          "progressBar": false,
          "positionClass": "toast-top-center",
          "preventDuplicates": false,
          "onclick": null,
          "showDuration": "300",
          "hideDuration": "1000",
          "timeOut": "5000",
          "extendedTimeOut": "1000",
          "showEasing": "swing",
          "hideEasing": "linear",
          "showMethod": "fadeIn",
          "hideMethod": "fadeOut"
        }
        toastr.success(localStorage.getItem("Success"));
        localStorage.clear();
    }*/
    $('.edit').click(function() {
        if($(this).find('span').hasClass("glyphicon-edit")) {
          $(this).find('span').removeClass("glyphicon-edit");
          $(this).find('span').addClass("glyphicon-check");
          var currentTD = $(this).parent('td').parent('tr').find('.editable-col');
          $.each(currentTD, function () {
            $(this).prop('contenteditable', true);
          });
        } else {
          $(this).find('span').removeClass("glyphicon-check");
          $(this).find('span').addClass("glyphicon-edit");
          var currentTD = $(this).parent('td').parent('tr').find('.editable-col');
          $.each(currentTD, function () {
            $(this).prop('contenteditable', false);
          });
          var data = {};
          data['id'] = $(this).parent('td').parent('tr').attr('data-row-id');
          var number = 0;
          var name = $(this).parent('td').parent('tr').find('td[col-index="' + number + '"]');
          if($(name).attr('oldVal') !== name.text()) {
            data['name'] = name.text();
          }
          number = 1;
          var releasedate = $(this).parent('td').parent('tr').find('td[col-index="' + number + '"]');
          if($(releasedate).attr('oldVal') !== releasedate.text()) {
            data['releasedate'] = releasedate.text();
          }
          if($(name).attr('oldVal') !== name.text() || $(releasedate).attr('oldVal') !== releasedate.text()) {
            $.ajax({
              type: "POST",
              url: "/games/update",
              cache: false, //in case of IE8
              data: data,
              complete: function(data) {
                location.reload();
              }
            });
          }
        }
    });
    $('#create').click(function() {
        $.ajax({
            type: "POST",
            url: "/games/create",
            complete: function(data) {
              location.reload();
            }
        });
    });
    $('.remove').click(function() {
        data = {};
        data['id'] = $(this).parent('td').parent('tr').attr('data-row-id');
        $.ajax({
            type: "POST",
            url: "/games/delete",
            cache: false, //in case of IE8
            data: data,
            complete: function(data) {
              location.reload();
            }
        });
    });
});