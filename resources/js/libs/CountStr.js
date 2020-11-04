export class CountStr{
    constructor(input_str, count_str){
        this.input_str = document.querySelectorAll(input_str);
        this.count_str = document.querySelectorAll(count_str);      
        this.count = null;      
    }

    updateCount(){
        this.input_str.forEach(input=>{
            input.addEventListener("keyup", function(){
                this.count = input.value.length;

                this.count_str.forEach(count=>{
                    count.innerText = this.count;
                });

            }.bind(this));
        }); 
    }
}