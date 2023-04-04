        //button selctor
        const add_Button = document.querySelector(".add"),
              removeButton = document.querySelector(".remove");

        const currentCupsEl = document.querySelector(".current-cups"),
              currentlitresEl = document.querySelector(".current-litres"),
              currentprogressEl = document.querySelector(".current-percentage"),
              progressArea = document.querySelector(".progress");



        const MAX_CUPS = 10, 
              MIN_CUPS = 0;

        let cups = 0,
            litres =0,
            percentage = 0;

        add_Button.addEventListener("click", addcup);
        removeButton.addEventListener("click",removeCup);


        function addcup(){
            cups++;
            litres += 250;
            percentage = (cups / MAX_CUPS) * 100;

            console.log(cups, litres, percentage);


            //updating
            updatedLayout();

            if(cups ===MAX_CUPS){
                add_Button.disabled = true;
            }else{
                removeButton.disabled = false;
            }
        };

        function removeCup(){
            cups--;
            litres -= 250;
            percentage = (cups / MAX_CUPS) * 100;

            console.log(cups, litres, percentage);
            //updating
            updatedLayout();
            

            if(cups ===MIN_CUPS){
                removeButton.disabled = true;
            }else{
                add_Button.disabled = false;
            }
        };

        function updatedLayout(){
            currentCupsEl.textContent = `${cups}/10`;
            currentlitresEl.textContent = `${litres/1000}l/2.5l`;
            currentprogressEl.textContent = `${percentage}%`;
            progressArea.style.height = `${percentage}%`;
        }