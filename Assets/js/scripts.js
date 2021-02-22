
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

  window.location.href = `../Controlador/cVerEstanteria.php?idPasillo=${idPasillo}&hueco=${numHueco}`;
  return;
}

function crearEstanteria(divHueco){
  let numHueco = divHueco.id;
  let idPasillo = divHueco.parentElement.parentElement.id

  window.location.href = `../Vista/vCrearEstanteria.php?idPasillo=${idPasillo}&hueco=${numHueco}`;
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

let codigoEstanteriaOk = false;
function cambiaCodigoEstanteria(inputCodigo){
  inputCodigo.parentElement.classList.remove('error')
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
    let hueco = document.getElementById('hueco').childNodes[0].textContent
    let obj = {
      codigo: codigo,
      numLejas: numLejas,
      material: material,
      fechaAlta: fechaAlta,
      idPasillo: idPasillo,
      hueco: hueco
    }
    obj = JSON.stringify(obj)

    window.location.href = `../Controlador/cCrearEstanteria.php?obj=${obj}`;
  }else{
    return false;
  }
}

