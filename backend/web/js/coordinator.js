$(function(){
  let area_click=document.querySelectorAll('.area_click');
  let point=document.getElementById('point');
  initCanvas();
  for(let i=0;i<area_click.length;i++)
  {
    area_click[i].addEventListener('mouseover',(event)=>{
    let hoveredElement = event.target;
    let coordStr = event.target.getAttribute('coords');
     drawPoly(coordStr);
  });
  area_click[i].addEventListener('mouseout',(event)=>{
    clearCanvas();
  });
  }
  $('#floor').on('change', function(){
    $.pjax.reload( "#coordinate-map", // контейнер, в котором надо обновить данные.
        {
        url: "/coord/load",
        timeout: 0,
        data: {
           'floor': $(this).val() // данные, которые отправляются на сервер.
        },
        replace: false,
    });
  }); 
  point.addEventListener('input',()=>{clearCanvas();});
//  for(let i=0;i<area_click.length;i++)
//  area_click[i].addEventListener('click',(event)=>{
//      event.preventDefault();
//        $.pjax.reload( "#coord-create", // контейнер, в котором надо обновить данные.
//        {
//        url: '/coord/edit',
//        push: false,
//        timeout: 5000,
//        data: {
//           'id': event.target.id // данные, которые отправляются на сервер.
//        },
//        replace: false,
//        push: false,
//    });
//  });
function clearCanvas(){
    let canvas = byId('myCanvas');
    hdc.clearRect(0, 0, canvas.width, canvas.height);
    drawChoosen();
}
function initCanvas(){
  let img = byId('floor-image');
  let x,y, w,h;
  x = img.offsetLeft;
  y = img.offsetTop;
  w = img.clientWidth;
  h = img.clientHeight;

    // move the canvas, so it's contained by the same parent as the image
  let imgParent = img.parentNode;
  let can = byId('myCanvas');
  imgParent.appendChild(can);

  // place the canvas in front of the image
  can.style.zIndex = 1;

  // position it over the image
  can.style.left = x+'px';
  can.style.top = y+'px';

    // make same size as the image
    can.setAttribute('width', w+'px');
    can.setAttribute('height', h+'px');

    // get it's context
    hdc = can.getContext('2d');
    hdc.lineWidth = 2;
    drawChoosen();
    // set the 'default' values for the colour/width of fill/stroke operations
    hdc.fillStyle = 'blue';
    hdc.strokeStyle = 'blue';
    
    
    
}
function drawChoosen(){
    hdc.fillStyle = 'red';
    hdc.strokeStyle = 'red';
    drawPoly(point.value);
    hdc.fillStyle = 'blue';
    hdc.strokeStyle = 'blue';
}
function drawPoly(coOrdStr)
{
    let mCoords = coOrdStr.split(',');
    let i, n;
    n = mCoords.length;

    hdc.beginPath();
    hdc.moveTo(mCoords[0], mCoords[1]);
    for (i=2; i<n; i+=2)
    {
        hdc.lineTo(mCoords[i], mCoords[i+1]);
    }
    hdc.lineTo(mCoords[0], mCoords[1]);
    hdc.stroke();
}
function byId(e){return document.getElementById(e);}
});   

