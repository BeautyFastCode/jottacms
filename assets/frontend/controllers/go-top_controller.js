import {Controller} from "stimulus";

export default class extends Controller {

    connect() {

        const btn = this.element;

        window.addEventListener('scroll', function() {

            if (window.scrollY >= 250) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }

        });
    }
}
