document.addEventListener("click", event => {
    const isDropdownButton = event.target.matches("[data-dropdown-link]")
    if(!isDropdownButton && event.target.closest("[data-dropdown]") != null)
        return

    let currentDropdown
    if(isDropdownButton) {
        currentDropdown = event.target.closest("[data-dropdown]")
        currentDropdown.classList.toggle("active")
    }

    document.querySelectorAll("[data-dropdown].active").forEach(dropdown => {
        if(dropdown === currentDropdown)
            return
        dropdown.classList.remove("active")
    })

    let userProfile = document.getElementById('submenu-wrap');
    let userPfp = document.getElementById('user-pfp');
    if(!(event.target === userProfile) && !(event.target === userPfp))
        userProfile.classList.remove("open");

});

function openMenu() {
    document.getElementById('submenu-wrap').classList.toggle("open");
}