const divNoteForm = document.getElementById("noteFormContainer");
const divError = document.getElementById("error");
const divSuccess = document.getElementById("success");
const noteBtn = document.getElementById("addNoteBtn");

const formNotas = document.getElementById("noteForm");
const noteTitle = document.getElementById("noteTitle");
const noteContent = document.getElementById("noteContent");
const noteImage = document.getElementById("noteImage");

//DOM del template
const notesContainer = document.getElementById("notesContainer");
const noteTemplate = document.getElementById("noteTemplate");

divNoteForm.style.display = "none";


//Función para mostrar el formulario
function habilitarForm() {
  if (divNoteForm.style.display === "none") {
    divNoteForm.style.display = "block";
  } else {
    divNoteForm.style.display = "none";
  }
}

noteBtn.addEventListener("click", habilitarForm);

//Funciones para cargar las notas del servidor y mostrarlas por pantalla
async function cargarNotas() {
  const url = "../src/notas.php";
  const res = await fetch(url);
  const json = await res.json();

  if (json.code != 0) {
    divError.innerText = json.message;
    divError.style.display = "block";
    divError.classList.add("errorFade");

    setTimeout(() => {
      divError.style.display = "none";
    }, 3000);
  } else {
    mostrarNotas(json.notas);
  }
}

function mostrarNotas(notas) {
  notesContainer.innerHTML = "";

  if (notas.length === 0) {
    notesContainer.innerHTML = `
    <div class="col-12 no-notes">
        <div class="text-center text-muted">
            <i class="bi bi-journal-x display-4"></i>
            <p class="mt-3">No tienes notas. ¡Crea una nueva!</p>
        </div>
    </div>
    `;
    return;
  }

  notas.forEach((nota) => {
    const notaEl = document.importNode(noteTemplate.content, true);

    const tituloEl = notaEl.querySelector(".note-title");
    const contenidoEl = notaEl.querySelector(".note-content");
    const fechaEl = notaEl.querySelector(".note-date");
    const idNotaEl = notaEl.querySelector(".note-card");
    const btnEdit = notaEl.querySelector(".btn-edit");

    notaEl.querySelector('.container-display-mode').classList.add('data-note-id-display-' + nota.id);
    notaEl.querySelector('.container-edit-mode').classList.add('data-note-id-edit-' + nota.id);

    idNotaEl.setAttribute("data-nota-id", nota.id);
    btnEdit.setAttribute("data-note-id", nota.id);
    tituloEl.innerText = nota.titulo;
    contenidoEl.innerText = nota.contenido;
    fechaEl.innerText = nota.fecha_modificacion;

    notesContainer.appendChild(notaEl);
  });
  agregarEventosBotones();
}


function showHideNoteMode(noteId) {


  const content = document.querySelector('.data-note-id-display-' + noteId);
  const formEdit = document.querySelector('.data-note-id-edit-' + noteId);
  if(content.style.display != 'none') {
    content.style.display='none';
    formEdit.style.display="inline-block";
    formEdit.querySelector('.txtNoteTitle').value=content.querySelector(".note-title").innerText;
    formEdit.querySelector('.txtNoteDescr').value=content.querySelector(".note-content").innerText;

  }
  else {
    content.style.display='inline-block';
    formEdit.style.display="none";
  }
}

//Función para crear la nota nueva
async function crearNota(event) {
  event.preventDefault();

  if (noteTitle.value === "") {
    divError.innerText = "El título es obligatorio";
    divError.style.display = "block";
    return;
  } else if (noteContent.value === "") {
    divError.innerText = "El contenido de la nota no puede estar vacío";
    divError.style.display = "block";
    divError.classList.add("Fade");

    setTimeout(() => {
      divError.style.display = "none";
    }, 3000);
    return;
  }

  let titulo = noteTitle.value;
  let contenido = noteContent.value;

  const url = "../src/notas.php";
  const formData = new FormData();
  formData.append("titulo", titulo);
  formData.append("contenido", contenido);

  try {
    const res = await fetch(url, {
      method: "POST",
      body: formData,
    });
    
    const json = await res.json();

    if (json.code != 0) {
      divError.innerText = json.message;
      divError.style.display = "block";
      divError.classList.add("Fade");

      setTimeout(() => {
        divError.style.display = "none";
      }, 3000);
    } else {
      divSuccess.innerText = json.message;
      divSuccess.style.display = "block";
      divSuccess.classList.add("Fade");
      setTimeout(() => {
        divSuccess.style.display = "none";
      }, 3000);
    }
  } catch (err) {
    console.log(err);
  }
  cargarNotas();
  habilitarForm();
}


//Función para borrar la nota
async function borrarNota(event) {
  event.preventDefault();

  //this.closest() Se usa para poder recorrer el DOM
  // hasta llegar a la clase más cercana
  const notaCard = this.closest(".note-card");
  const idNota = notaCard.getAttribute("data-nota-id");

  if (!confirm("¿Seguro que quieres eliminar la nota?")) {
    return;
  } else {
    const url = "../src/notas.php";
    const formData = new FormData();
    formData.append("idNota", idNota);

    try {
      const res = await fetch(url, {
        method: "POST",
        body: formData,
      });
      const json = await res.json();

      if (json.code != 0) {
        divError.innerText = json.message;
        divError.style.display = "block";
        divError.classList.add("Fade");

        setTimeout(() => {
          divError.style.display = "none";
        }, 3000);
      } else {
        divSuccess.innerText = json.message;
        divSuccess.style.display = "block";
        divSuccess.classList.add("Fade");
        setTimeout(() => {
          divSuccess.style.display = "none";
        }, 3000);
      }
    } catch (err) {
      console.log(err);
    }
  }
  cargarNotas();
}

async function guardarCambiosNota() {
  const notaCard = this.closest(".note-card");
  const idNota = notaCard.getAttribute("data-nota-id");

  const formEdit = document.querySelector('.data-note-id-edit-' + idNota);

  const txtNoteTitle = formEdit.querySelector('.txtNoteTitle').value;

  const txtNoteDescr = formEdit.querySelector('.txtNoteDescr').value;

  if (txtNoteTitle.value === "") {
    divError.innerText = "El título es obligatorio";
    divError.style.display = "block";
    return;
  } else if (txtNoteDescr.value === "") {
    divError.innerText = "El contenido de la nota no puede estar vacío";
    divError.style.display = "block";
    divError.classList.add("Fade");

    setTimeout(() => {
      divError.style.display = "none";
    }, 3000);
    return;
  }

  const url = "../src/notas.php";
  const formData = new FormData();
  formData.append("titulo", txtNoteTitle);
  formData.append("contenido", txtNoteDescr);
  formData.append("idNota", idNota);

  console.log (formData);
  try {
    const res = await fetch(url, {
      method: "POST",
      body: formData,
    });
    
    const json = await res.json();

    if (json.code != 0) {
      divError.innerText = json.message;
      divError.style.display = "block";
      divError.classList.add("Fade");

      setTimeout(() => {
        divError.style.display = "none";
      }, 3000);
    } else {
      divSuccess.innerText = json.message;
      divSuccess.style.display = "block";
      divSuccess.classList.add("Fade");
      setTimeout(() => {
        divSuccess.style.display = "none";
      }, 3000);
    }
  } catch (err) {
    console.log(err);
  }
  cargarNotas();
}
//Función para añadir los eventos a los botones del template
function agregarEventosBotones() {
  const btnDelete = document.getElementsByClassName("btn-delete");
  const btnSaveNote = document.getElementsByClassName("btn-save-note");
  for (let i = 0; i < btnDelete.length; i++) {
    btnDelete[i].addEventListener("click", borrarNota);
  }
  for (let i = 0; i < btnSaveNote.length; i++) {
    btnSaveNote[i].addEventListener("click", guardarCambiosNota);
  }

}

formNotas.addEventListener("submit", crearNota);

document.addEventListener("DOMContentLoaded", function () {
  cargarNotas();
});
