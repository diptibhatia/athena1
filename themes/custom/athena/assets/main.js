import 'bootstrap';
import './styles/style.scss';
import MobileMenu from './scripts/MobileMenu';
import CoursePage from './scripts/CoursePage';


if(module.hot) {
    module.hot.accept();
}


let mobileMenu = new MobileMenu();
let coursePage = new CoursePage();