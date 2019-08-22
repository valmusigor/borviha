$(function(){
    //console.log($("input[type='radio'][name='AddJur[person_org]:checked']").val());
//     $.pjax.reload( "#view-original-data", // контейнер, в котором надо обновить данные.
//        {url: "/agent/load",
//        timeout: 0,
//        data: {
//           'person_org': $('#person_org input').val() // данные, которые отправляются на сервер.
//        },
//        replace: false,
//    });
  $('#person_org input').on('change', function(){
    $.pjax.reload( "#view-original-data", // контейнер, в котором надо обновить данные.
        {url: "/agent/load",
        timeout: 0,
        data: {
           'person_org': $(this).val() // данные, которые отправляются на сервер.
        },
        replace: false,
    });
  }); 
});   


