// Confirmação de exclusão
function confirmarExclusao(mensagem) {
    return confirm(mensagem || 'Deseja excluir este registro?');
}

// Ocultar alertas automaticamente após 4 segundos
document.addEventListener('DOMContentLoaded', function () {
    const alertas = document.querySelectorAll('.alert');
    alertas.forEach(function (alerta) {
        setTimeout(function () {
            alerta.style.transition = 'opacity 0.5s';
            alerta.style.opacity = '0';
            setTimeout(function () { alerta.remove(); }, 500);
        }, 4000);
    });
});
