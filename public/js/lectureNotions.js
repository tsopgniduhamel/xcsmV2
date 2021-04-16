/**
 * Created by D'rin on 15/06/2017.
 */
$(document).ready(function () {

    localStorage.clear();

    $.ajax({
        type:'GET',
        url:'/lecture',
        dataType:'json',
        data:'',
        success:function(data){

            localStorage.setItem("currentCours",JSON.stringify(data));
            i = 0;
            localStorage.setItem("currentNotion",JSON.stringify(i));
            $("#part").text("Partie : "+data[0].partie.replace(/&quot;/g,'"'));
            $("#chap").text("Chapitre :"+data[0].chapitre.replace(/&quot;/g,'"'));
            $("#para").text("Paragraphe :"+data[0].paragraphe.replace(/&quot;/g,'"'));
            
            mettre(data[0].notion);
        }

    });


})


function next() {
    i= (JSON.parse(localStorage.getItem("currentNotion")));
    notions = JSON.parse(localStorage.getItem("currentCours"));
    
    if(i< notions.length-1 && i>=0){
        i++;
        $("#part").text("Partie : "+notions[i].partie.replace(/&quot;/g,'"'));
        $("#chap").text("Chapitre :"+notions[i].chapitre.replace(/&quot;/g,'"'));
        $("#para").text("Paragraphe :"+notions[i].paragraphe.replace(/&quot;/g,'"'));
        text = notions[i].notion;
        localStorage.setItem("currentNotion",JSON.stringify(i));
        mettre(text);
    }

}


function previous() {

    i= (JSON.parse(localStorage.getItem("currentNotion")));
    notions = JSON.parse(localStorage.getItem("currentCours"));
    
    if(i<notions.length && i>0){
        i--;
        $("#part").text("Partie : "+notions[i].partie.replace(/&quot;/g,'"'));
        $("#chap").text("Chapitre :"+notions[i].chapitre.replace(/&quot;/g,'"'));
        $("#para").text("Paragraphe :"+notions[i].paragraphe.replace(/&quot;/g,'"'));
        text = notions[i].notion;
        localStorage.setItem("currentNotion",JSON.stringify(i));
        mettre(text);
    }
}

function mettre(text){
    $('#contenuNotion').html(text);
}