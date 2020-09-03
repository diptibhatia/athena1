class MobileMenu {
    constructor() {
        this.MenuIcon = document.querySelector(".site-header__menu-icon");
        this.MenuContent = document.querySelector(".site-header__menu-content");
        this.events();
    }

    events() {
        this.MenuIcon.addEventListener("click", () => this.toggleTheMenu());
    }

    toggleTheMenu() {
        this.MenuContent.classList.toggle("site-header__menu-content--is-visible");
        this.MenuIcon.classList.toggle("site-header__menu-icon--close-x");
    }
}

export default MobileMenu;