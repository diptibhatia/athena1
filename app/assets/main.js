import 'bootstrap';
import './styles/style.scss';
import MobileMenu from './scripts/MobileMenu';


if(module.hot) {
    module.hot.accept();
}


let mobileMenu = new MobileMenu();