
const menu = document.querySelector(".nav_links");


function toogle(){

   menu.classList.toggle("open");
}


function verificarContra() {

    const formulario = document.querySelector("form");

    if (!formulario.checkValidity()) {
        return false;
    }

    const mensajeCorreo = document.getElementById("mensajeCorreo");
    if (mensajeCorreo.textContent == "Este correo ya existe") {
            alert("El correo que quieres registrar ya está en uso");
        return false;
    }


    const pass1 = document.getElementById("pass").value;
    const pass2 = document.getElementById("pass2").value;

    if (pass1 !== pass2) {

        alert("Las contraseñas no coinciden");
        return false;

    }
  
}

function validarPass(){
    const pass1 = document.getElementById("pass").value;
    const pass2 = document.getElementById("pass2").value;
    const mensaje = document.getElementById("mensaje");

    if(pass2.length == 0){
        mensaje.textContent = "";
        return;
    }

    if(pass1 == pass2){
        mensaje.textContent = "Las contraseñas coinciden";
        mensaje.style.color = "green";
    } else{
        mensaje.textContent = "Las contraseñas no coinciden";
        mensaje.style.color = "red";
    }
}


function toggleBenefit(btn) {
  const hiddenIncluido = btn.nextElementSibling;

  if (btn.classList.contains('on')) {
    btn.classList.remove('on');
    btn.classList.add('off');
    btn.textContent   = '✗';
    hiddenIncluido.value = 0;
  } else {
    btn.classList.remove('off');
    btn.classList.add('on');
    btn.textContent   = '✓';
    hiddenIncluido.value = 1;
  }
  updatePreview();
}

function addBenefit() {

   

  const list = document.getElementById('benefits-list');
  const row  = document.createElement('div');

  row.className = 'Benefit_Row';

     
    if (fiveRows()) {
        return;
    }
  
  row.innerHTML = `
    <input type="hidden" name="pivot_id[]" value="nuevo">
    <input type="hidden" name="beneficio_id[]" value="nuevo">
    <button type="button" class="Toggle_Benefit on" onclick="toggleBenefit(this)">✓</button>
    <input type="hidden" name="incluido[]" value="1">
    <input class="Input_Benefit" name="texto[]" type="text" value="Nuevo beneficio" oninput="updatePreview()">
    <button type="button" class="Remove_Btn" onclick="this.closest('.Benefit_Row').remove(); updatePreview();">x</button>
  `;

  list.appendChild(row);
  updatePreview();
}

function updatePreview() {
document.getElementById('prev-price').textContent = '$' + parseFloat(document.getElementById('precio').value).toFixed(2);
  document.getElementById('prev-desc').textContent  = document.getElementById('desc').value;

  const container = document.getElementById('prev-benefits');
  container.innerHTML = '';

const rows = document.querySelectorAll('#benefits-list .Benefit_Row:not([style*="display: none"])');
  rows.forEach(function(row) {
    const btn   = row.querySelector('.Toggle_Benefit');
    const texto = row.querySelector('input[type="text"]').value;

    const div = document.createElement('div');
    const img = document.createElement('img');
    const p   = document.createElement('p');
    p.textContent = texto;

    if (btn && btn.classList.contains('on')) {
      div.className = 'Beneficio';
      img.src       = './recursos/check.png';
      img.className = 'Palomita';
    } else {
      div.className = 'No_Beneficio';
      img.src       = './recursos/cruz.png';
      img.className = 'Cruz';
    }

    div.appendChild(img);
    div.appendChild(p);
    container.appendChild(div);
  });
}


function fiveRows(){
    const rows = document.querySelectorAll('#benefits-list .Benefit_Row:not([style*="display: none"])');
    const mensaje = document.getElementById("mensaje");

    if (rows.length >= 5) {
        mensaje.textContent = "No puedes agregar más de 5 beneficios";
        setTimeout(() => {
            mensaje.textContent = "";
        }, 3000);
        return true;
    } else {
        mensaje.textContent = "";
    }
}


function marcarEliminar(btn) {
    const row = btn.closest('.Benefit_Row');
    const pivotId = row.querySelector('input[name="pivot_id[]"]').value;
    const inputEliminar = row.querySelector('.eliminar-id');
    
    inputEliminar.value = pivotId;
    row.style.display = 'none';
    fiveRows(document.querySelectorAll('#benefits-list .Benefit_Row:not([style*="display: none"])').length);
    updatePreview();
}


function verificarCorreo(){

    let correo = document.getElementById("correo").value;

    if(correo.length <10){
        return;
    }

    fetch("./db/verificarCorreo.php?correo=" + correo)

    .then(function(respuesta){

        return respuesta.text();

    })

    .then(function(resultado){

        let mensaje = document.getElementById("mensajeCorreo");

        if(resultado == "existe"){

            mensaje.textContent = "Este correo ya existe";
            mensaje.style.color = "red";
        }
        else{

            mensaje.textContent = "Correo disponible";
            mensaje.style.color = "green";

        }

    });

}

function verificarMembresia() {

    fetch("./db/verificarMembresia.php")

    .then(res => res.text())
    .then(resultado => {

    

        if(resultado == "existe"){
            alert("Ya tienes una membresía activa");
            return false;
        } else {
            document.querySelector("form").submit();
             alert("Hiciste tu pago con éxito");
        }

    });

 
}


const fechaInput = document.getElementById("fecha");
if (fechaInput) {
    const ayer = new Date();
    ayer.setDate(ayer.getDate() - 1);
    fechaInput.max = ayer.toISOString().split('T')[0];
}