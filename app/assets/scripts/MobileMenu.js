class MobileMenu {
    constructor() {
        this.MenuIcon = document.querySelector(".site-header__menu-icon");
        this.MenuContent = document.querySelector(".site-header__menu-content");
        this.About = document.querySelector(".primary-nav .about");
        this.AboutMenu = document.querySelector(".primary-nav .about a");
        this.AboutMenuArrow = document.querySelector(".primary-nav .about a i");
        this.AboutSubMenu = document.querySelector(".about .secondary-nav");
        this.events();
    }

    events() {
        //event.preventDefault();
        if(this.MenuIcon)
        {
            this.MenuIcon.addEventListener("click", () => this.toggleTheAboutMenu());
        }
        if(this.AboutMenu)
        {
            this.AboutMenu.addEventListener("click", () => this.toggleTheAboutMenu());
        }
    }

    toggleTheMenu() {
        this.MenuContent.classList.toggle("site-header__menu-content--is-visible");
        this.MenuIcon.classList.toggle("site-header__menu-icon--close-x");
    }

    toggleTheAboutMenu() {
        this.About.classList.toggle("show");
        this.AboutMenuArrow.classList.toggle("up");
        this.AboutSubMenu.classList.toggle("show");
    }
}

export default MobileMenu;