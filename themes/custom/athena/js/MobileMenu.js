class MobileMenu {
    constructor() {
        this.MenuIcon = document.querySelector(".site-header__menu-icon");
        this.MenuContent = document.querySelector(".site-header__menu-content");
        this.About = document.querySelector(".primary-nav .about");
        this.AboutMenu = document.querySelector(".primary-nav .about a");
        this.AboutMenuArrow = document.querySelector(".primary-nav .about a i");
        this.AboutSubMenu = document.querySelector(".about .secondary-nav");
        this.events();
        if(window.innerWidth < 768)
        {
            document.getElementsByClassName("site-header__menu-content")[0].style.display = "none";
        }
    }

    events() {
        //event.preventDefault();
        if(this.MenuIcon)
        {
            this.MenuIcon.addEventListener("click", () => this.toggleTheMenu());
        }
        if(this.AboutMenu)
        {
            this.AboutMenu.addEventListener("click", () => this.toggleTheAboutMenu());
        }
    }

    toggleTheMenu() {
        this.MenuContent.classList.toggle("site-header__menu-content--is-visible");
        this.MenuIcon.classList.toggle("site-header__menu-icon--close-x");

        if(window.innerWidth<768)
        {
            if(!document.querySelector(".site-header_menu-content--is-visible") && !document.querySelector(".site-header_menu-icon--close-x"))
            {
                document.getElementsByClassName("site-header__menu-content")[0].style.display = "none";
            }
            else
            {
                document.getElementsByClassName("site-header__menu-content")[0].style.display = "block";
                document.getElementsByClassName("site-header__menu-content")[0].style.position = "absolute";
            }
        }
    }

    toggleTheAboutMenu() {
        this.About.classList.toggle("show");
        this.AboutMenuArrow.classList.toggle("up");
        this.AboutSubMenu.classList.toggle("show");
    }
}

export default MobileMenu;
