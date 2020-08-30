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

//constructor runs immediately whenever an object is created from a class
//arrow function donot manipulate the value of this keyword