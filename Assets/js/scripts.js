
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



