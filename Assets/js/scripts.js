
function visibilidadPass(passContainer){
  removeChilds(passContainer)
  if(passContainer.getAttribute('value') == 'visible'){
    passContainer.setAttribute('value', 'non-visible')
    passContainer.parentNode.firstElementChild.setAttribute('type', 'text')
    removeChilds(passContainer)
    passContainer.innerHTML = '<i class="fas fa-eye"></i>'
  }else{
    passContainer.setAttribute('value', 'visible')
    passContainer.parentNode.firstElementChild.setAttribute('type', 'password')
    removeChilds(passContainer)
    passContainer.innerHTML = '<i class="fas fa-eye-slash"></i>'
  }
}

function checkLogin(){
  let email = document.getElementById('email').value
  let password = document.getElementById('password').value


  fetch(`../Controlador/cLogin.php?email=${email}&password=${password}`)
    .then(response => {
      console.log(response)
      return response.json();
    })
    .then(data => {
      console.log(data)
      if(data==true){
        window.location.href = "../Controlador/cHome.php"
      }
    })
}

/* ************************************************* */
/* ********     FUNCIONALIDAD BASICA     *********** */
/* ************************************************* */
function removeChilds(e){
  while(e.firstChild){
      e.removeChild(e.firstChild)
  }
}

function removeChildsById(id){
  let e = document.getElementById(id)
  removeChilds(e)
}

function buildModal(title, msg){
  let modalContainer = document.getElementById('modalContainer');
  removeChilds(modalContainer)

  

      let modal = document.createElement('div')
      modal.id = "modal"
      modal.className = "modalContainer";
          let h3Title = document.createElement("h3")
          h3Title.appendChild(document.createTextNode(title))
          modal.appendChild(h3Title)

          let pMsg = document.createElement('p')
          pMsg.appendChild(document.createTextNode(msg))
          modal.appendChild(pMsg)

          let button = document.createElement('button')
          button.classList.add('btn', 'btn-outline-c1L')
          button.innerHTML = '<i class="fas fa-times"></i>'
          button.addEventListener('click', (e)=>{
              removeChilds(modal.parentNode)
          })
          modal.appendChild(button)
      modalContainer.appendChild(modal)
  return modal
}

function buildStdModal(title, msg){
  let modal = buildModal(title, msg)
  modal.classList.add('modal-c1')
}

function buildErrorModal(title, msg){
  let modal = buildModal(title, msg)
  modal.classList.add('modal-error')
}

function buildSucceedModal(title, msg){
  let modal = buildModal(title, msg)
  modal.classList.add('modal-succeed')
}

function verEstanteria(divHueco){
  let numHueco = divHueco.id;
  let idPasillo = divHueco.parentElement.parentElement.id

  window.location.href = `../Controlador/cVerEstanteria.php?idPasillo=${idPasillo}&huecoPasillo=${numHueco}`;
  return;
}

function crearEstanteria(divHueco){
  let numHueco = divHueco.id;
  let idPasillo = divHueco.parentElement.parentElement.id

  window.location.href = `../Vista/vCrearEstanteria.php?idPasillo=${idPasillo}&huecoPasillo=${numHueco}`;
  return;
}

function irAHome(){
  window.location.href = "../Controlador/cHome.php";
}

function showErrorMsg(element, msg){
  element.classList.add('error')
  let pError = element.getElementsByClassName('errorMsg')[0];
  removeChilds(pError);
  pError.appendChild(document.createTextNode(msg))
}

function showInputSucceed(element){
  element.classList.add('succeed')
}

/* CREAR ESTANTERÍA */
let codigoEstanteriaOk = false;
function cambiaCodigoEstanteria(inputCodigo){
  inputCodigo.parentElement.classList.remove('error', 'succeed')
  let codigo = inputCodigo.value;
  if(codigo.substring(0,2) != "ES"){
    codigoEstanteriaOk = false;
    showErrorMsg(inputCodigo.parentElement, "El código de estantería debe empezar por ES");
    return false;
  }
  if(codigo.length != 5){
    codigoEstanteriaOk = false;
    showErrorMsg(inputCodigo.parentElement, "Ejemplo de código: ES001");
    return false;
  }
  for(let i=2; i<5; i++){
    if(isNaN(codigo.substring(i, i+1))){
      codigoEstanteriaOk = false;
      showErrorMsg(inputCodigo.parentElement, "Los últimos 3 caracteres deben ser números. Ej: ES001")
      return false;
    }
  }

  let obj = {
    metodo: "checkCodigoEstanteria",
    cod: codigo
  }
  obj = JSON.stringify(obj)
  fetch(`../Controlador/cAsync.php?obj=${obj}`)
  .then( response => {
    return response.json()
  })
  .then( res => {
    if(res){
      showErrorMsg(inputCodigo.parentElement, "Este código ya está en uso")
      codigoEstanteriaOk = false;
    }else{
      let h2Codigo = document.getElementById('h2Codigo')
      removeChilds(h2Codigo)
      h2Codigo.appendChild(document.createTextNode(codigo))

      codigoEstanteriaOk = true;
    }
  })
}


function cambiaLejasEstanteria(inputLejas){
  inputLejas.parentElement.classList.remove('error')
  let numLejas = inputLejas.value;
  if(numLejas < 1 || numLejas >15){
    console.log("Valor erróneo")
    showErrorMsg(inputLejas.parentElement, "Número de lejas erróneo. 1 a 15 lejas");
    return false;
  }

  let estanteriaDiv = document.getElementById("estanteria");
  removeChilds(estanteriaDiv)

  let leja;
  for(let i=0; i<numLejas; i++){
    leja = document.createElement('div')
    leja.className = "leja"
    estanteriaDiv.appendChild(leja)
  }

  return true;
}

function checkMaterialInput(){
  let input = document.getElementById('material');
  input.parentElement.classList.remove('error')
  console.log("checkMaterial()")
  console.log(input)
  if(input.value != null && input.value != ""){
    return true;
  }else{
    showErrorMsg(input.parentElement, "Este campo no puede estar vacío")
    return false;
  }
}

function checkFechaAltaInput(){
  let input = document.getElementById('fechaAlta')
  input.parentElement.classList.remove('error')
  console.log("checkFechaAlta()")
  console.log(input)
  if(input.value != null && input.value !=""){
    return true;
  }else{
    showErrorMsg(input.parentElement, "Este campo no puede estar vacío")
    return false;
  }
}

function checkFormCrearEstanteria(){
  if(!codigoEstanteriaOk){
    cambiaCodigoEstanteria(document.getElementById('codigo'))
    return false;
  }
  if(
    codigoEstanteriaOk &&
    cambiaLejasEstanteria(document.getElementById("numLejas")) &&
    checkMaterialInput() &&
    checkFechaAltaInput()
  ){
    let codigo = document.getElementById('codigo').value
    let numLejas = document.getElementById('numLejas').value
    let material = document.getElementById('material').value
    let fechaAlta = document.getElementById('fechaAlta').value
    let idPasillo = document.getElementById('idPasillo').childNodes[0].textContent
    let huecoPasillo = document.getElementById('huecoPasillo').childNodes[0].textContent
    let obj = {
      codigo: codigo,
      numLejas: numLejas,
      material: material,
      fechaAlta: fechaAlta,
      idPasillo: idPasillo,
      huecoPasillo: huecoPasillo
    }
    obj = JSON.stringify(obj)

    window.location.href = `../Controlador/cCrearEstanteria.php?obj=${obj}`;
  }else{
    return false;
  }
}

function irAtras(){
  window.history.back();
}

/* vVerEstanteria */

function addCaja(divLeja){
  let estanteria = parseInt(document.getElementsByClassName('estanteria')[0].id);
  let huecoEstanteria = parseInt(divLeja.id.substring(2))+1;

  window.location.href = `../Vista/vCrearCaja.php?idEstanteria=${estanteria}&huecoEstanteria=${huecoEstanteria}`
  return;
}

function verCaja(divLeja){
  let estanteria = parseInt(document.getElementsByClassName('estanteria')[0].id);
  let leja = parseInt(divLeja.id);
  let idCaja = parseInt(divLeja.firstElementChild.id);

  window.location.href = `../Controlador/cVerCaja.php?idEstanteria=${estanteria}&leja=${leja}&idCaja=${idCaja}`
  return;
}

/* CREAR CAJA */

let codigoCajaOk = false;
function cambiaCodigoCaja(inputCodigo){
  inputCodigo.parentElement.classList.remove('error')
  let codigo = inputCodigo.value;
  if(codigo.substring(0,2) != "CA"){
    codigoCajaOk = false;
    showErrorMsg(inputCodigo.parentElement, "El código de caja debe empezar por CA");
    return false;
  }
  if(codigo.length != 5){
    codigoCajaOk = false;
    showErrorMsg(inputCodigo.parentElement, "Ejemplo de código: CA001");
    return false;
  }
  for(let i=2; i<5; i++){
    if(isNaN(codigo.substring(i, i+1))){
      codigoCajaOk = false;
      showErrorMsg(inputCodigo.parentElement, "Los últimos 3 caracteres deben ser números. Ej: CA001")
      return false;
    }
  }

  let obj = {
    metodo: "checkCodigoCaja",
    cod: codigo
  }
  obj = JSON.stringify(obj)
  fetch(`../Controlador/cAsync.php?obj=${obj}`)
  .then( response => {
    return response.json()
  })
  .then( res => {
    if(res){
      showErrorMsg(inputCodigo.parentElement, "Este código ya está en uso")
      codigoCajaOk = false;
    }else{
      let codigoCaja = document.getElementById('codigoCaja')
      removeChilds(codigoCaja)
      codigoCaja.appendChild(document.createTextNode(codigo))

      codigoCajaOk = true;
    }
  })
  return true;
}

function checkSimpleString(divInput){
  divInput.parentElement.classList.remove('error')
  let material = divInput.value
  if(material == "" || material == null){
    showErrorMsg(divInput.parentElement, `Este campo no puede estar vacío`)
    return false;
  }
  for(let i=0; i<material.length; i++){
    let l = material[i]
    if(l == "'" || l == '"' || l == "/" || l == "="){
      showErrorMsg(divInput.parentElement, `No se permiten caracteres extraños ( ' , " , = , / )`)
      return false
    }
  }  
  return true;
}

function cambiaColorCaja(value){
  document.getElementById('box-right').setAttribute('fill', value)
  document.getElementById('box-left').setAttribute('fill', value)
  document.getElementById('box-top').setAttribute('fill', value)
  
  return true;
}


function checkMedidaCaja(divInput){
  divInput.parentElement.classList.remove('error')
  let medida = parseInt(divInput.value)
  if(medida == "" || medida == null || isNaN(medida)){
    showErrorMsg(divInput.parentElement, `Este campo no puede estar vacío`)
    return false;
  }
  if(medida <= 0){
    showErrorMsg(divInput.parentElement, `No puede ser el tamaño igual o inferior a 0`)
    return false;
  }
  if(medida > 500){
    showErrorMsg(divInput.parentElement, `Tamaño máximo 500cm`)
    return false;
  }
  return true;

}

function checkFormCrearCaja(){
  let todoOk = true;
  if(!codigoCajaOk){
    cambiaCodigoCaja(document.getElementById('codigo'))
    todoOk = false;
  }
  if(!checkSimpleString(document.getElementById('material'))){todoOk=false}
  if(!checkMedidaCaja(document.getElementById('alto'))){todoOk=false}
  if(!checkMedidaCaja(document.getElementById('ancho'))){todoOk=false}
  if(!checkMedidaCaja(document.getElementById('largo'))){todoOk=false}
  if(!checkSimpleString(document.getElementById('contenido'))){todoOk=false}
  if(!checkFechaAltaInput()){todoOk=false}

  if(todoOk){
    let codigo = document.getElementById('codigo').value
    let material = document.getElementById('material').value
    let color = document.getElementById('color').value.substring(1)
    let alto = document.getElementById('alto').value
    let ancho = document.getElementById('ancho').value
    let largo = document.getElementById('largo').value
    let contenido = document.getElementById('contenido').value
    let fechaAlta = document.getElementById('fechaAlta').value
    let idEstanteria = document.getElementById('idEstanteria').value
    let huecoEstanteria = document.getElementById('huecoEstanteria').textContent
    let obj = {
      codigo: codigo,
      material: material,
      color: color,
      alto: alto,
      ancho: ancho,
      largo: largo,
      contenido:contenido,
      fechaAlta: fechaAlta,
      idEstanteria: parseInt(idEstanteria),
      huecoEstanteria: parseInt(huecoEstanteria)
    }
    obj = JSON.stringify(obj)

    window.location.href = `../Controlador/cCrearCaja.php?obj=${obj}`;
  }else{
    return false;
  }
}

function verInventario(){
  window.location.href = `../Controlador/cVerInventario.php`;
}

/* SALIDA DE CAJAS */
function salidaDeCajas(){
  window.location.href = '../Vista/vSalidaCajas.php';
}

function cambiaCodigoCajaSalida(inputCodigo){
  inputCodigo.parentElement.classList.remove('error', 'succeed')
  let codigo = inputCodigo.value;
  if(codigo.substring(0,2) != "CA"){
    codigoCajaOk = false;
    showErrorMsg(inputCodigo.parentElement, "El código de caja debe empezar por CA");
    return false;
  }
  if(codigo.length != 5){
    codigoCajaOk = false;
    showErrorMsg(inputCodigo.parentElement, "Ejemplo de código: CA001");
    return false;
  }
  for(let i=2; i<5; i++){
    if(isNaN(codigo.substring(i, i+1))){
      codigoCajaOk = false;
      showErrorMsg(inputCodigo.parentElement, "Los últimos 3 caracteres deben ser números. Ej: CA001")
      return false;
    }
  }

  let obj = {
    metodo: "checkCodigoCajaSalida",
    cod: codigo
  }
  obj = JSON.stringify(obj)
  fetch(`../Controlador/cAsync.php?obj=${obj}`)
  .then( response => {
    return response.json()
  })
  .then( caja => {
    codigoCajaSalida = true;
    console.log(caja)
    if(caja){
      showInputSucceed(inputCodigo.parentElement)
      let cajaDiv = document.getElementById('cajaDiv')
      cajaDiv.innerHTML = `<div class="datosCaja">
      <div class="datosHeader">
        <h5 class="caja-color">Color</h5>
        <h5 class="caja-alto">Alto</h5>
        <h5 class="caja-ancho">Ancho</h5>
        <h5 class="caja-largo">Largo</h5>
        <h5 class="caja-material">Material</h5>
        <h5 class="caja-contenido">Contenido</h5>
      </div>
      <div class="datosBody">
        <div class="caja-color">
          <svg style="width: 40px; height:40px" i:rulerorigin="0 0" overflow="visible" i:vieworigin="129.9341 392.8721" i:pagebounds="0 595.2764 841.8896 0" enable-background="new 0 0 188.873 223.338" xml:space="preserve" viewBox="0 0 188.873 223.338">
            <polygon id="box-right" fill="" points="188.87 54.608 188.55 168.73 94.582 223.34 94.905 109.22" i:knockout="Off"></polygon>
            <polygon fill="rgba(0,0,0,.45)" points="188.87 54.608 188.55 168.73 94.582 223.34 94.905 109.22" i:knockout="Off"></polygon>
            <polygon id="box-left" fill="" points="94.905 109.22 94.582 223.34 0 168.73 0.323 54.608" i:knockout="Off"></polygon>
            <polygon fill="rgba(0,0,0,.3)" points="94.905 109.22 94.582 223.34 0 168.73 0.323 54.608" i:knockout="Off"></polygon>
            <polygon id="box-top" fill="" points="188.87 54.608 94.905 109.22 0.323 54.608 94.291 0" i:knockout="Off"></polygon>
            <line y2="82.781" x1="47.769" i:knockout="Off" x2="141.84" stroke="#72512F" y1="27.226" stroke-width="2" fill="none"></line>
            <polygon fill="rgb(225, 137, 78)" points="146.65 79.052 129.72 89.216 35.138 34.608 52.068 24.445" i:knockout="Off"></polygon>
            <polygon fill="rgb(225, 137, 78)" points="146.76 78.939 146.75 109.15 129.52 119.46 129.53 89.252" i:knockout="Off"></polygon>
            <polygon fill="rgba(0,0,0,.3)" points="146.76 78.939 146.75 109.15 129.52 119.46 129.53 89.252" i:knockout="Off"></polygon>
          </svg>
        </div>
        <h5 id="cajaAlto" class="caja-alto"></h5>
        <h5 id="cajaAncho"class="caja-ancho"></h5>
        <h5 id="cajaLargo" class="caja-largo"></h5>
        <h5 id="cajaMaterial" class="caja-material"></h5>
        <h5 id="cajaContenido" class="caja-contenido"></h5>
      </div>
    </div>`

    let svgRight = document.getElementById('box-right')
    svgRight.setAttribute('fill',`#${caja.color}`)
    let svgLeft = document.getElementById('box-left')
    svgLeft.setAttribute('fill',`#${caja.color}`)
    let svgTop = document.getElementById('box-top')
    svgTop.setAttribute('fill',`#${caja.color}`)

    let cajaAlto = document.getElementById('cajaAlto')
    cajaAlto.appendChild(document.createTextNode(caja.alto))
    let cajaAncho = document.getElementById('cajaAncho')
    cajaAncho.appendChild(document.createTextNode(caja.ancho))
    let cajaLargo = document.getElementById('cajaLargo')
    cajaLargo.appendChild(document.createTextNode(caja.largo))
    let cajaMaterial = document.getElementById('cajaMaterial')
    cajaMaterial.appendChild(document.createTextNode(caja.material))
    let cajaContenido = document.getElementById('cajaContenido')
    cajaContenido.appendChild(document.createTextNode(caja.contenido))

    }else{
      codigoCajaSalida = false;
      showErrorMsg(inputCodigo.parentElement, "No hay ninguna caja con ese código")
    }
  })
}

function checkCheckboxChecked(checkbox){
  checkbox.parentElement.classList.remove('error')
  if(checkbox.checked){
    return true;
  }else{
    showErrorMsg(checkbox.parentElement, "Este campo debe estar seleccionado")
    return false;
  }
}

var codigoCajaSalida = false;
function checkFormSalirCaja(){
  let codigo = document.getElementById('codigo');
  let salidaConfirmada = checkCheckboxChecked(document.getElementById('checkbox'))

  console.log(`Codigo: ${codigo}`)
  console.log(`SalidaConfirmada: ${salidaConfirmada}`)
  if(codigoCajaSalida && salidaConfirmada){
    let objJSON = {
      codigo: codigo.value
    }
    objJSON = JSON.stringify(objJSON)
    window.location.href = `../Controlador/cSalidaCajas.php?objJSON=${objJSON}`;
  }else{
    cambiaCodigoCajaSalida(codigo)
    checkCheckboxChecked(document.getElementById('checkbox'))
  }
}