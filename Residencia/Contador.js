// Contador de caracteres
const Textarea = document.getElementById('Comentarios');
const Contador = document.getElementById('Contador');

Textarea.addEventListener('input', function(e) {
    const target = e.target;
    const longitudMax = target.getAttribute('maxlength');
    const longitudAct = target.value.length;
    Contador.innerHTML = `${longitudAct}/${longitudMax}`;
});