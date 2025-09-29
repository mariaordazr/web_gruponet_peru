/*===================== SHOW NAVBAR ====================*/
const showMenu = (headerToggle, navbarId) => {
    const toggleBtn = document.getElementById(headerToggle),
        nav = document.getElementById(navbarId)

    // Validate that variables exist
    if (headerToggle && navbarId) {
        toggleBtn.addEventListener('click', () => {
            // We add the show-menu class to the div tag with the nav__menu class
            nav.classList.toggle('show-menu')

            // Change icon
            toggleBtn.classList.toggle('bx-x')
        })
    }
}
showMenu('header-toggle', 'navbar')

/*===================== SHOW NAVBAR ====================*/
const linkColor = document.querySelectorAll('.nav__link')

function colorLink() {
    linkColor.forEach(l => l.classList.remove('active'))
    this.classList.add('active')
}

linkColor.forEach(l => l.addEventListener('click', colorLink))

/*===================== FUNCION UPLOAD =========================*/
const selectImage = document.querySelector('.select-image');
const inputFile = document.querySelector('#file');
const imgArea = document.querySelector('.img-area');
const previewImage = document.getElementById('preview-image'); // Agrega esta línea

selectImage.addEventListener('click', function () {
    inputFile.click();
})

inputFile.addEventListener('change', function () {
    const image = this.files[0]
    if (image.size < 2000000) {
        const reader = new FileReader();
        reader.onload = () => {
            const allImg = imgArea.querySelectorAll('img');
            allImg.forEach(item => item.remove());
            const imgUrl = reader.result;
            const img = document.createElement('img');
            img.src = imgUrl;
            imgArea.appendChild(img);
            imgArea.classList.add('active');
            imgArea.dataset.img = image.name;

            // Actualiza la vista previa en el elemento con el id 'preview-image'
            console.log(image.name)
            previewImage.src = imgUrl;
        }
        reader.readAsDataURL(image);
    } else {
        alert("Image size more than 2MB");
    }
})


/*===================== MODAL AGREGAR =========================*/
const section = document.querySelector("section"),
    overlay = document.querySelector(".overlay"),
    showBtn = document.querySelector(".show-modal"),
    closeBtn = document.querySelector(".close-btn");

showBtn.addEventListener("click", () => section.classList.add("active"));

overlay.addEventListener("click", () =>
    section.classList.remove("active")
);



/*===================== ELIMINAR =========================*/

function confirmDeletePortada(portadaId) {
    // Muestra una alerta de confirmación
    const confirmMessage = confirm("¿Estás seguro de que deseas eliminar esta portada?");

    // Si el usuario hace clic en "Aceptar", redirige a eliminar_portada.php con el ID de la portada
    if (confirmMessage) {
        window.location.href = `eliminar_portada.php?id=${portadaId}`;
    }
    // Si el usuario hace clic en "Cancelar", no se realiza ninguna acción
}

function confirmDelete(productId) {
    // Muestra una alerta de confirmación
    const confirmMessage = confirm("¿Estás seguro de que deseas eliminar este producto?");

    // Si el usuario hace clic en "Aceptar", redirige a eliminar_producto.php con el ID del producto
    if (confirmMessage) {
        window.location.href = `eliminar_producto.php?id=${productId}`;
    }
    // Si el usuario hace clic en "Cancelar", no se realiza ninguna acción
}

function confirmDeleteMarca(marcaId) {
    // Muestra una alerta de confirmación
    const confirmMessage = confirm("¿Estás seguro de que deseas eliminar esta marca?");

    // Si el usuario hace clic en "Aceptar", redirige a eliminar_producto.php con el ID del producto
    if (confirmMessage) {
        window.location.href = `eliminar_marca.php?id=${marcaId}`;
    }
    // Si el usuario hace clic en "Cancelar", no se realiza ninguna acción
}


function confirmDeleteCategoria(categoriaId) {
    // Muestra una alerta de confirmación
    const confirmMessage = confirm("¿Estás seguro de que deseas eliminar esta categoria?");

    // Si el usuario hace clic en "Aceptar", redirige a eliminar_producto.php con el ID del producto
    if (confirmMessage) {
        window.location.href = `eliminar_categoria.php?id=${categoriaId}`;
    }
    // Si el usuario hace clic en "Cancelar", no se realiza ninguna acción
}

function confirmDeleteEmpresa(empresaId) {
    // Muestra una alerta de confirmación
    const confirmMessage = confirm("¿Estás seguro de que deseas eliminar esta empresa?");

    // Si el usuario hace clic en "Aceptar", redirige a eliminar_producto.php con el ID del producto
    if (confirmMessage) {
        window.location.href = `eliminar_empresa.php?id=${empresaId}`;
    }
    // Si el usuario hace clic en "Cancelar", no se realiza ninguna acción
}

function confirmDeleteOferta(ofertaId) {
    // Muestra una alerta de confirmación
    const confirmMessage = confirm("¿Estás seguro de que deseas eliminar esta oferta?");

    // Si el usuario hace clic en "Aceptar", redirige a eliminar_producto.php con el ID del producto
    if (confirmMessage) {
        window.location.href = `eliminar_promociones.php?id=${ofertaId}`;
    }
    // Si el usuario hace clic en "Cancelar", no se realiza ninguna acción
}

function confirmDeleteLiqui(liquiId) {
    // Muestra una alerta de confirmación
    const confirmMessage = confirm("¿Estás seguro de que deseas eliminar esta liquidacion?");

    // Si el usuario hace clic en "Aceptar", redirige a eliminar_producto.php con el ID del producto
    if (confirmMessage) {
        window.location.href = `eliminar_liquidacion.php?id=${liquiId}`;
    }
    // Si el usuario hace clic en "Cancelar", no se realiza ninguna acción
}

