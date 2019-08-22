let bic=document.getElementById('bic');
let bank_data=document.getElementById('bank_data');
let equal_post=document.getElementById('equal_post');
let legal_address=document.getElementById('legal_address');
let post_address=document.getElementById('post_address');

//if(equal_post.checked){
//    legal_address.disabled=true;
//}
//equal_post.addEventListener('change',(event)=>{
//    legal_address.disabled=(event.target.checked)?true:false;
//});
post_address.addEventListener('input',(event)=>{
    if(equal_post.checked){
        legal_address.value=event.target.value;
    }
});
bic.addEventListener('change',(event)=>{
    console.log('asdsadas');
     fetch(`http://www.nbrb.by/API/BIC?CdBank=${event.target.value}`).then(res => res.json()).then(data=>{
         if(data)
          bank_data.value=data[0].NmBankShort+","+data[0].AdrBank+" код банка "+event.target.value;
     });
});



