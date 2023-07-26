$(document).ready(function (){
    let nums = document.querySelectorAll(".precent .num1");
    let nums2 = document.querySelectorAll(".num_name .num2");
    nums.forEach((num) => startCount(num));
    nums2.forEach((num) => startCount(num));
    function startCount(el) {
        let goal = el.dataset.goal;
        if(goal>0){
            let count = setInterval(() => {
                el.textContent++;
                if (el.textContent == goal) {
                    clearInterval(count);
                }
            }, 2000 / goal);
        }
    }
})
