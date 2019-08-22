window.onload=()=>{
   
let connection_agent=document.querySelectorAll('.connection_agent');
let connection_agent_selector=$('.connection_agent select');
let agent_type=document.getElementById('type');

if(agent_type.value!=1){
     for(let i=0;i<connection_agent.length;i++){
    if(connection_agent[i].classList.contains('toggle-visible'))
        connection_agent[i].classList.remove('toggle-visible');
     }
}
agent_type.addEventListener('change',(event)=>{
    if(event.target.value==1){
        for(let i=0;i<connection_agent.length;i++){
         if(!connection_agent[i].classList.contains('toggle-visible'))
        {
        connection_agent[i].classList.add('toggle-visible');
        }
        connection_agent_selector[i].value="0";
    }
    console.log();
    }
    else {
        for(let i=0;i<connection_agent.length;i++){
        if(connection_agent[i].classList.contains('toggle-visible'))
        connection_agent[i].classList.remove('toggle-visible');
        }
    }
}); 
};


