export class CountStr{
    constructor(input_str, count_str){
        this.input_str = document.getElementById(input_str);
        this.count_str = document.getElementById(count_str);      
        this.count = null;      
    }

    updateCount(){
        this.input_str.addEventListener("keyup", function(){
            this.count = this.input_str.value.length;            
            this.count_str.innerText = this.count;
        }.bind(this));
    }
}