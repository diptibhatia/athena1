import 'bootstrap';
import './styles/style.scss';
import MobileMenu from './scripts/MobileMenu';
import CoursePage from './scripts/CoursePage';
import ExploreMenu from './scripts/ExploreMenu';


if(module.hot) {
    module.hot.accept();
}

function initialize()
{
    let mobileMenu = new MobileMenu();
    let coursePage = new CoursePage();
    let exploreMenu = new ExploreMenu();
}
window.onload = initialize;
/*
function events() {
    {
          this._MenuIcon = document.querySelector(".site-header__menu-icon");
          this._MenuContent = document.querySelector(".site-header__menu-content");
          this._About = document.querySelector(".primary-nav .about");
          this._AboutMenu = document.querySelector(".primary-nav .about a");
          this._AboutMenuArrow = document.querySelector(".primary-nav .about a i");
          this._AboutSubMenu = document.querySelector(".about .secondary-nav");
          //event.preventDefault();
          if(this._MenuIcon)
          {
             this._MenuIcon.addEventListener("click", () => {
                this._MenuContent.classList.toggle("site-header__menu-content--is-visible");
             this._MenuIcon.classList.toggle("site-header__menu-icon--close-x");
             });
          }
          if(this._AboutMenu)
          {
             this._AboutMenu.addEventListener("click", () => {

                this._About.classList.toggle("show");
             this._AboutMenuArrow.classList.toggle("up");
             this._AboutSubMenu.classList.toggle("show");
             });
          }
          {

                this.menuIcon = document.querySelector("#explore-menu-btn .btnLink");
                this.primaryMenu = document.querySelector("#explore-menu-btn .exp-primary-menu");
                this.mainMenuArrow = document.querySelector("#explore-menu-btn a i");
                this.close = document.querySelector("#explore-menu-btn .close-btn");
                this.secondaryMenuList = document.querySelectorAll("#explore-menu-btn .exp-primary-menu > li");
                this.secondaryMenuListLength = this.secondaryMenuList.length;
                this.tertiaryMenuList = document.querySelectorAll("#explore-menu-btn .exp-secondary-menu > li");
                this.tertiaryMenuListLength = this.tertiaryMenuList.length;
                
                if(this.menuIcon)
                {
                   this.menuIcon.addEventListener("click", (evt) => {
                         this.primaryMenu.classList.toggle('show');
                         this.close.classList.toggle('show');
                         this.mainMenuArrow.classList.toggle('show');
                   }); 
                } 

                if(this.close)
                {
                   this.close.addEventListener("click", (evt) => {
                         evt.stopPropagation();
                         this.primaryMenu.classList.toggle('show');
                         this.close.classList.toggle('show');
                         this.mainMenuArrow.classList.toggle('show');
                   });
                }

                showHide(this.secondaryMenuList, this.secondaryMenuListLength, ".exp-secondary-menu");

                showHide(this.tertiaryMenuList, this.tertiaryMenuListLength, ".exp-tertiary-menu");


          }
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

window.onload = events;*/