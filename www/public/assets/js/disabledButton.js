const input = document.getElementById('nombre');
const input2 = document.getElementById('email');
const input3 = document.getElementById('telefono');
const input4 = document.getElementById('direccion');
const boton = document.getElementById('btnGuardar');

input.addEventListener('input', function() {
    // Si hay texto, habilita el botón; si está vacío, lo deshabilita
    boton.disabled = input.value.trim() === '';
});

input2.addEventListener('input', function() {
    // Si hay texto, habilita el botón; si está vacío, lo deshabilita
    boton.disabled = input2.value.trim() === '';
});

input3.addEventListener('input', function() {
    // Si hay texto, habilita el botón; si está vacío, lo deshabilita
    boton.disabled = input3.value.trim() === '';
});

input4.addEventListener('input', function() {
    // Si hay texto, habilita el botón; si está vacío, lo deshabilita
    boton.disabled = input4.value.trim() === '';
});
