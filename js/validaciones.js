// Función para convertir el texto a mayúsculas y eliminar caracteres especiales
function sanitizeInput(element) {
  const value = element.value;
  const sanitizedValue = value.replace(/[^a-zA-Z0-9\s]/g, '').toUpperCase();
  element.value = sanitizedValue;
}

// Obtener todos los campos de texto y textarea en la página
const textInputs = document.querySelectorAll('input[type="text"], textarea');

// Agregar event listener a cada campo para capturar el evento de entrada
textInputs.forEach(function(input) {
  input.addEventListener('input', function() {
    sanitizeInput(this);
  });
});
