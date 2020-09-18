class MobileMenu {
    constructor() {
        this.MenuIcon = document.querySelector(".site-header__menu-icon");
        this.MenuContent = document.querySelector(".site-header__menu-content");
        this.AboutMenu = document.querySelector(".primary-nav .about a");
        this.AboutSubMenu = document.querySelector(".about .secondary-nav");
        this.events();
    }

    events() {
        this.MenuIcon.addEventListener("click", () => this.toggleTheMenu());
        this.AboutMenu.addEventListener("click", () => this.toggleTheAbout());
    }

    toggleTheMenu() {
        this.MenuContent.classList.toggle("site-header__menu-content--is-visible");
        this.MenuIcon.classList.toggle("site-header__menu-icon--close-x");
    }

    toggleTheAbout() {
        this.AboutSubMenu.classList.toggle("show");
    }
}

export default MobileMenu;