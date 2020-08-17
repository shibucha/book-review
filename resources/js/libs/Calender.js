export class Calender {
    constructor(els, options) {
        this.els = document.querySelectorAll(els);
        const defaultOptions = {
            locale: "ja",
            dateFormat: "Y/m/d",
            maxDate: "today"
        };
        this.options = Object.assign(defaultOptions, options);
        this._init();        
    }

    _init(){
        this.els.forEach(el=>{
            flatpickr(el, {
                locale: "ja",
                dateFormat: "Y/m/d",
                maxDate: "today"
            });
        });
    }
}
