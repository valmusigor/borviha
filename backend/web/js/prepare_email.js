//$(document).ready(function (){
//    var selectedItems = [];
//
//    $('input[name=selection_all]').click(function (){
//        selectedItems = selectedItems.concat($('.grid-view').yiiGridView('getSelectedRows'));
//        // select all rows on page 1, go to page 2 and select all rows.
//        // All rows on page 1 and 2 will be selected.
//        console.log(selectedItems); 
//    })
//});
let choose_invoice_id=[];
function addItems(item_id, checked){
    let position = choose_invoice_id.indexOf(+item_id);
    if(checked && position== -1 ){
    choose_invoice_id.push(+item_id);
}
    else {
       if ( ~position ) choose_invoice_id.splice(position, 1);
    }
//var pick_id = getUrlVars()["id"];
//// alert(checked);
//if(checked){
//    $.ajax({
//    url: 'index.php',
//    method: 'get',
//    dataType: 'text',
//    data: {r:'picked-items/add', item:item_id, pick:pick_id}
//    }).done(function(){alert('added')}).error(function(){alert('there was a problem...!')});
//}
//else{
//    $.ajax({
//    url: 'index.php',
//    method: 'get',
//    dataType: 'text',
//    data: {r:'picked-items/deselect', item:item_id, pick:pick_id}
//    }).done(function(){alert('deselected')}).error(function(){alert('there was a problem...!')});        
//}}
console.log(choose_invoice_id);
}
function sendMail(){
  //  console.log(JSON.stringify(choose_invoice_id));
//    fetch('/invoice/send?choose_invoice='+JSON.stringify({choose_invoice:choose_invoice_id}), {
//        method: 'GET', // *GET, POST, PUT, DELETE, etc.
//        mode: 'cors', // no-cors, cors, *same-origin
//        cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
//        credentials: 'same-origin', // include, *same-origin, omit
//        headers: {
//            'Content-Type': 'application/json',
//            // 'Content-Type': 'application/x-www-form-urlencoded',
//        },
////        redirect: 'follow', // manual, *follow, error
////        referrer: 'no-referrer', // no-referrer, *client
//        body: JSON.stringify({choose_invoice:choose_invoice_id}), // тип данных в body должен соответвовать значению заголовка "Content-Type"
//    })
    fetch('/invoice/send', {
        method: 'POST', // *GET, POST, PUT, DELETE, etc.
//        mode: 'cors', // no-cors, cors, *same-origin
//        cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
        credentials: 'same-origin', // include, *same-origin, omit
        headers: {
//            'Accept': 'application/json',
            'Content-Type': 'application/json',
            // 'Content-Type': 'application/x-www-form-urlencoded',
        },
//        redirect: 'follow', // manual, *follow, error
////        referrer: 'no-referrer', // no-referrer, *client
        body: JSON.stringify({choose_invoice:choose_invoice_id}), // тип данных в body должен соответвовать значению заголовка "Content-Type"
    })
    .then(response => response.json())
    .then(data => console.log(JSON.stringify(data))) // JSON-строка полученная после вызова `response.json()`
    .catch(error => console.log(error)); // парсит JSON ответ в Javascript объект
}
window.onload=()=>{
    let selection_all= document.getElementsByName('selection_all');
    selection_all[0].addEventListener('change',(event)=>{
        choose_invoice_id.splice(0,choose_invoice_id.length);
        if(event.target.checked){
            console.log('i am these');
        choose_invoice_id= choose_invoice_id.concat($('.grid-view').yiiGridView('getSelectedRows'));
        // select all rows on page 1, go to page 2 and select all rows.
        // All rows on page 1 and 2 will be selected.
        console.log($('.grid-view').yiiGridView('getSelectedRows'));
    }
    });  
};


