window.onload=()=>{
let name_accrual=document.getElementById('name_accrual');
let units=document.getElementById('units');
let quantity=document.getElementById('quantity');
let price=document.getElementById('price');

name_accrual.addEventListener('change',(event)=>{
    units.value=event.target.value;
});
quantity.addEventListener('input',(event)=>{
    getResult();
});
price.addEventListener('input',(event)=>{
    getResult();
});
function getResult(){
    if(quantity.value && price.value){
       document.getElementById('sum').value=sum=skipNan(parseFloat(quantity.value*price.value).toFixed(2));
       document.getElementById('vat').value=vat=skipNan(parseFloat(document.getElementById('sum').value*0.2).toFixed(2));
       document.getElementById('sum_with_vat').value=skipNan((+sum)+(+vat));
    }   
}
function skipNan(res){
    return (isNaN(res)|| !res)?'':res;
}
}
