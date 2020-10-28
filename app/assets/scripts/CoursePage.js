class CoursePage {
    constructor() {
        this.showBtn = document.getElementById("course-show-more");
        this.modules = document.querySelectorAll("#course-intro-card-container .module");
        this.overlay = document.querySelector("#course-intro-card-container .module-overlay");
        this.events();
    }

    events() {
        this.showBtn.addEventListener("click", evt => {
            console.log('btn clicked');
            if(evt.target.innerHTML == "Show More") {
                for (let i = 0; i < this.modules.length; i++) {
                    this.modules[i].classList.remove('hide');
                }
                this.overlay.classList.add('hide');
                evt.target.innerHTML = "Show Less";
            } else {
                for (let i = 0; i < this.modules.length; i++) {
                    this.modules[i].classList.add('hide');
                }
                this.overlay.classList.remove('hide');
                evt.target.innerHTML = "Show More";
            }
        });
    }
}

export default CoursePage;