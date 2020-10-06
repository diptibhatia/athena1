class ExploreMenu {
    constructor() {
        this.menuIcon = document.querySelector("#explore-menu-btn .btnLink");
        this.primaryMenu = document.querySelector("#explore-menu-btn .exp-primary-menu");
        this.mainMenuArrow = document.querySelector("#explore-menu-btn a i");
        this.close = document.querySelector("#explore-menu-btn .close-btn");
        this.secondaryMenuList = document.querySelectorAll("#explore-menu-btn .exp-primary-menu > li");
        this.secondaryMenuListLength = this.secondaryMenuList.length;
        this.tertiaryMenuList = document.querySelectorAll("#explore-menu-btn .exp-secondary-menu > li");
        this.tertiaryMenuListLength = this.tertiaryMenuList.length;
        this.events();
    }

    events() {

        this.menuIcon.addEventListener("click", (evt) => {
            this.primaryMenu.classList.toggle('show');
            this.close.classList.toggle('show');
            this.mainMenuArrow.classList.toggle('show');
        }); 

        this.close.addEventListener("click", (evt) => {
            evt.stopPropagation();
            this.primaryMenu.classList.toggle('show');
            this.close.classList.toggle('show');
            this.mainMenuArrow.classList.toggle('show');
        });

        showHide(this.secondaryMenuList, this.secondaryMenuListLength, ".exp-secondary-menu");

        showHide(this.tertiaryMenuList, this.tertiaryMenuListLength, ".exp-tertiary-menu");
    }
}

function showHide(list, length, className) {
    for(let i = 0; i < length; i++) {
        list[i].addEventListener("click", (evt) => {
            evt.stopPropagation();
            if(evt.target.querySelector(className)) {
                evt.target.classList.toggle('show');
                evt.target.querySelector(className).classList.toggle('show');
                if(evt.target.querySelector(".secondary-arrow")) {
                    evt.target.querySelector(".secondary-arrow").classList.toggle('show');
                }
            }
            for(let j = 0; j < length; j++) {
                if((list[j] != evt.target) && (list[j].querySelector(className))) {
                    list[j].classList.remove('show');
                    list[j].querySelector(className).classList.remove('show');
                    if(list[j].querySelector(".secondary-arrow")) {
                        list[j].querySelector(".secondary-arrow").classList.remove('show');
                    }
                }
            }  
        });
    }
}

export default ExploreMenu;