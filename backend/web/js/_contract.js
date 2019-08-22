window.onload = () =>{
let clicker= document.querySelectorAll('.clicker');
for(let i=0;i<clicker.length;i++)
    clicker[i].addEventListener('click',()=>{
    let elem=document.querySelectorAll('.description_contract')[i];
    elem.classList.toggle('toggle-visible');});
};



