import { Controller } from 'stimulus';

/*
 * This is an example Stimulus controller!
 *
 * Any element with a data-controller="hello" attribute will cause
 * this controller to be executed. The name "hello" comes from the filename:
 * hello_controller.js -> "hello"
 *
 * Delete this file or adapt it for your use!
 */
export default class extends Controller {
    static targets = ['input', 'output']

    connect() {
        // this.element.textContent = 'Hello Stimulus! Edit me in assets/controllers/hello_controller.js';

        // console.log(this.inputTarget)
        // console.log(this.outputTarget)

        this.inputTarget.addEventListener('change', (event) => {

            // console.log('onChange', event.target, event.target.value);

            this.outputTarget.textContent = event.target.value;
        })
    }
}
