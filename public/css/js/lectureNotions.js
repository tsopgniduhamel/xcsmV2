/**
 * Created by D'rin on 15/06/2017.
 */
$(document).ready(function () {
    $.ajax({
        type:'GET',
        url:'/lecture',
        data:'',
        success:function(data){
            console.log(data);
            localStorage.setItem("currentCours",JSON.stringify(data));
            i = 0;
            localStorage.setItem("currentNotion",JSON.stringify(i));
            mettre(data[0]);
            console.log(data);
            console.log("zozo!");
        }
    });


})


function next() {

    i= (JSON.parse(localStorage.getItem("currentNotion")));
    notion = JSON.parse(localStorage.getItem("currentCours"));
    if(i<notion.length-1 && i>=0){
        i++;
        text = notion[i];
        localStorage.setItem("currentNotion",JSON.stringify(i));
        mettre(text);
    }

}
function previous() {

    i= (JSON.parse(localStorage.getItem("currentNotion")));
    notion = JSON.parse(localStorage.getItem("currentCours"));
    if(i<notion.length && i>0){
        i--;
        text = notion[i];
        localStorage.setItem("currentNotion",JSON.stringify(i));
        mettre(text);
    }
}

function mettre(text){
    $('#contenuNotion').html(text);
}