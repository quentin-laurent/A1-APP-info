let deleteButtons = document.querySelectorAll('.delete-button');
console.log(deleteButtons);
deleteButtons.forEach(function (btn) {
    btn.addEventListener('click', function (event) {
        if(!confirm(`Confirmer la suppression de l\'utilisateur ${btn.value} ?`))
            event.preventDefault();
    });
})
