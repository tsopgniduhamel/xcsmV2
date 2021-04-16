<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\Object_;

class NavigationController extends Controller
{
    // Controller de navigation

    // Controller de navigation

    /**
     * @title Fonction qui renvoit le style d'un élément partie, chapitre ou paragraphe
     * @params objet
     * @return string
     */
    private  function getStyle ($attributs) {
        $style = "";
        if ($attributs['font-weight'] != null) {
            $style .= 'font-weight:' . $attributs['font-weight'] . ";";
        }
        if ($attributs['font-size'] != null) {
            $style .= 'font-size:' . $attributs['font-size'] . ";";
        }

        if ($attributs['font-family'] != null) {
            $style .= 'font-family:' . $attributs['font-family'] . ";";
        }

        if ($attributs['color'] != null) {
            $style .= 'color:' . $attributs['color'] . ";";
        }

        if ($attributs['text-decoration'] != null) {
            $style .= 'text-decoration:' . $attributs['text-decoration'] . ";";
        }

        if ($attributs['text-align'] != null) {
            $style .= 'text-align:' . $attributs['text-align'] . ";";
        }

        if ($attributs['text-indent'] != null) {
            $style .= 'text-indent:' . $attributs['text-indent'] . ";";
        }
        
        return $style;
    }

    // Fonction qui renvoit sur la page html représentant le contenu du cours
    /**
     * @return string
     */
    private function getNotions ($notions)
    {
        $nbrNotions = $notions->attributes()->nbrNotions;
        $notionsConvertis = [];

        //for ($i = 0; $i < $nbrNotions; $i++) {
        $i = 0;
        while(isset($notions->notion[$i])){
            $attributs = $notions->notion[$i]->attributes();
            $style = $this->getStyle($attributs);
            $text = "";
            foreach ($notions->notion[$i]->children() as $child) {
        		if(isset($child->attributes()->src)) {
                    
                    if(isset($child->attributes()->title)){
                        $text .= "<br/>";
                        $text .= "<img src='";
                        $text .= "../" . $child->attributes()->src;
                        $text .= "'>";
                        $text .= "<br/><br/>";
                        $text .= "<p style='";
                        $text .= $this->getStyle($notions->notion[$i]->attributes());
                        $text .= "'>";
                        $text .= $child->attributes()->title;
                        $text .= "</p>";             
                    }else{
                        $child->attributes()->src = "../".$child->attributes()->src;
                        $text .= $child->asXML();
                    }

        		}else{
                    $text .= $child->asXML();
                }

            }

            
            
            $notionHtml = "<div style='";
            $notionHtml .= $style;
            $notionHtml .= "'>";
            $notionHtml .= $text;
            $notionHtml .= "</div>";

            
            if(isset($notions->notion[$i]->attributes()->position)){
                $position = $notions->notion[$i]->attributes()->position;
                $notionsConvertis["".$position] = $notionHtml;
            }else{
                $position = $notions->notion[$i]->attributes()->id;
                $notionsConvertis["".$position] = $notionHtml;
            }

            $i++;
        }

        return $notionsConvertis;
    }

    // Fonction qui permet de retourner la forme Romaine d'un nombre
    function integerToRoman($integer)
    {
        // Convert the integer into an integer (just to make sure)
        $integer = intval($integer);
        $result = '';

        // Create a lookup array that contains all of the Roman numerals.
        $lookup = array('M' => 1000,
            'CM' => 900,
            'D' => 500,
            'CD' => 400,
            'C' => 100,
            'XC' => 90,
            'L' => 50,
            'XL' => 40,
            'X' => 10,
            'IX' => 9,
            'V' => 5,
            'IV' => 4,
            'I' => 1);

        foreach($lookup as $roman => $value){
            // Determine the number of matches
            $matches = intval($integer/$value);

            // Add the same number of characters to the string
            $result .= str_repeat($roman,$matches);

            // Set the integer to be the remainder of the integer and the value
            $integer = $integer % $value;
        }

        // The Roman numeral should be built, return it
        return $result;
    }




    // Fonction qui renvoie la structure de navigation de la page

    public function lectureNavigation(Request $request) {
        {
            // on charge le cours
            $folder=$request->input("folder");
            $tmp=explode("_", $folder);
            $folder=$tmp[0] . "_" . $tmp[1];
            
            $description = simplexml_load_file('xmoddledata/'.$folder.'/description.xml');
            $notions = simplexml_load_file('xmoddledata/'.$folder.'/descriptionNotions.xml');

            // Création d'un tableau associatif de notions avec l'id comme clé
            $notionsArray = $this->getNotions($notions);



            // Construction de la navigation
            $nav_parties = [];

            $text_parties = "";
	        $indicePartie = 0;
            for ($i = 0; $i < $description->attributes()->nbrParties; $i++) {
                if(!(isset($description->partie[$i]->attributes()->type) &&
                    $description->partie[$i]->attributes()->type."" == "mal classe")) {

                    $text_parties .= "<br/><br/>";
                    $text_parties .= "<div style='";
                    $text_parties .= $this->getStyle($description->partie[$i]->attributes());
                    $text_parties .= "'";
                    $text_parties .= " id='".$i."'>";

                    $nav_chapitres = [];
                    
                    $text_parties .= $this->integerToRoman($indicePartie+1)."-   ".$description->partie[$i]->attributes()->title;
                    $text_parties .= "</div>";
                    $text_parties .= "<br/><br/>";
		            $indicePartie++;

                }else {


                }
                
                $text_chapitres = "";
		        $indiceChapitre = 0;

                for ($j = 0; $j < $description->partie[$i]->attributes()->nbrChapitres; $j++) {

                    if(!(isset($description->partie[$i]->chapitre[$j]->attributes()->type) &&
                        $description->partie[$i]->chapitre[$j]->attributes()->type."" == "mal classe")) {

                        $text_chapitres .= "<br/>";
                        $text_chapitres .= "<div style='";
                        $text_chapitres .= $this->getStyle($description->partie[$i]->chapitre[$j]->attributes());
            			// Ajout d'une indentation
            			$text_chapitres .= " padding-left: 5em; ";                        
            			$text_chapitres .= "'";
                        $text_chapitres .= " id='".$i."_".$j."'>";
                        

                        $nav_paragraphes = [];

                        $text_chapitres .= ($indiceChapitre+1)."-  ".$description->partie[$i]->chapitre[$j]->attributes()->title;
                        $text_chapitres .= "</div>";
                        $text_chapitres .= "<br/><br/>";
			            $indiceChapitre++;

                    }else{
                        if(isset($description->partie[$i]->chapitre[$j]->attributes()->type)) {
                            
                            if(isset(($description->partie[$i]->chapitre[$j]->span)[0])){
                                $text_chapitres .= "<br/>";
                                $text_chapitres .= "<div style='";
                                $text_chapitres .= $this->getStyle($description->partie[$i]->chapitre[$j]->attributes());
                                
                                $text_chapitres .= "'>";
                                $nav_paragraphes = [];
                                $text_chapitres .=($description->partie[$i]->chapitre[$j]->span)[0]->asXML();
                                $text_chapitres .= "</div>";
                                $text_chapitres .= "<br/>";

                            }else if (isset(($description->partie[$i]->chapitre[$j]->img)[0])) {

                                $text_chapitres .= "<br/>";
                                $text_chapitres .= "<div>";
                                $text_chapitres .= "<img src='";
                                $text_chapitres .= "../" . ($description->partie[$i]->chapitre[$j]->img)[0]->attributes()->src;
                                $text_chapitres .= "'>";
                                $text_chapitres .= "<br/><br/>";
                                $text_chapitres .= "<p style='";
                                $text_chapitres .= $this->getStyle($description->partie[$i]->chapitre[$j]->attributes());
                                $text_chapitres .= "'>";

                                $text_chapitres .= ($description->partie[$i]->chapitre[$j]->img)[0]->attributes()->title;
                                $text_chapitres .= "</p>";
                                $text_chapitres .= "</div>";
                                
                                $nav_paragraphes = [];
                            }

                        }

                    }


                    $text_paragraphes = "";
		            $indiceParagraphe = 0;

                    for ($k = 0; $k < $description->partie[$i]->chapitre[$j]->attributes()->nbrParagraphes; $k++) {
                        if((!(isset($description->partie[$i]->chapitre[$j]->paragraphe[$k]->attributes()->type) 
                            && $description->partie[$i]->chapitre[$j]->paragraphe[$k]->attributes()->type."" == "mal classe")) 
                            && !($description->partie[$i]->chapitre[$j]->paragraphe[$k]->attributes()->title == "titre par defaut")) {
				
                            // On renseigne le titre du paragraphe
                            $text_paragraphes .= "<div style='";
                            $text_paragraphes .= $this->getStyle($description->partie[$i]->chapitre[$j]->paragraphe[$k]->attributes());

                            // Ajout d'une indentation
            			    $text_paragraphes .= " padding-left: 10em; "; 
            			    $text_paragraphes .= "'";

                            // Ajout d'un ancre de navigation
                            $text_paragraphes .= " id='".$i."_".$j."_".$k."'>";
                            $text_paragraphes .= chr(97 + $indiceParagraphe).")  ".$description->partie[$i]->chapitre[$j]->paragraphe[$k]->attributes()->title;
                            $text_paragraphes .= "</div>";
                            $text_paragraphes .= "<br/>";

                            // Navigation avec paragraphes
                            $titre = [];
                            $titre["title"] = $description->partie[$i]->chapitre[$j]->paragraphe[$k]->attributes()->title;
                            $nav_paragraphes["".$i."_".$j."_".$k] = (object) $titre;
			                $indiceParagraphe++;

                        } else {
                            if(isset($description->partie[$i]->chapitre[$j]->paragraphe[$k]->attributes()->type)) {
                            
                                if(isset(($description->partie[$i]->chapitre[$j]->paragraphe[$k]->span)[0])){
                                    // On renseigne le titre du paragraphe
                                    $text_paragraphes .= "<div style='";
                                    $text_paragraphes .= $this->getStyle($description->partie[$i]->chapitre[$j]->paragraphe[$k]->attributes());
                                    $text_paragraphes .= "'>";
                                    $text_paragraphes .=($description->partie[$i]->chapitre[$j]->paragraphe[$k]->span)[0]->asXML();
                                    $text_paragraphes .= "</div>";
                                    $text_paragraphes .= "<br/>";


                                }else if (isset(($description->partie[$i]->chapitre[$j]->paragraphe[$k]->img)[0])) {

                                    $text_paragraphes .= "<br/>";
                                    $text_paragraphes .= "<div>";
                                    $text_paragraphes .= "<img src='";
                                    $text_paragraphes .= "../" . ($description->partie[$i]->chapitre[$j]->paragraphe[$k]->img)[0]->attributes()->src;
                                    $text_paragraphes .= "'>";
                                    $text_paragraphes .= "<br/><br/>";
                                    $text_paragraphes .= "<p style='";
                                    $text_paragraphes .= $this->getStyle($$description->partie[$i]->chapitre[$j]->paragraphe[$k]->attributes());
                                    $text_paragraphes .= "'>";

                                    $text_paragraphes .= ($description->partie[$i]->chapitre[$j]->paragraphe[$k]->img)[0]->attributes()->title;
                                    $text_paragraphes .= "</p>";
                                    $text_paragraphes .= "</div>";
                                    
                                }

                            }
                            
                        }

                        // On remplit les notions contenues dans le paragraphe
                        //dd($notionsArray);

                        ///Si le cours est issu d'un fichier word
                        if(isset($notions->notion[0]->attributes()->position)){
                            for ($l = 0; $l < $description->partie[$i]->chapitre[$j]->paragraphe[$k]->attributes()->nbrNotions; $l++) {
                                //dd($description->partie[$i]->chapitre[$j]->paragraphe[$k]);
                                $text_paragraphes .= $notionsArray["".$description->partie[$i]->chapitre[$j]->paragraphe[$k]->notion[$l]->attributes()->position];
                            }    
                        }else{
                            if((!(isset($description->partie[$i]->chapitre[$j]->paragraphe[$k]->attributes()->type) 
                                && $description->partie[$i]->chapitre[$j]->paragraphe[$k]->attributes()->type."" == "mal classe")) 
                                && !($description->partie[$i]->chapitre[$j]->paragraphe[$k]->attributes()->title == "titre par defaut")) {
                    
                                for ($l = 0; $l < $description->partie[$i]->chapitre[$j]->paragraphe[$k]->attributes()->nbrNotions; $l++) {
                                    
                                    if(isset($description->partie[$i]->chapitre[$j]->paragraphe[$k]->notion[$l]->attributes()->position)){
                                        $text_paragraphes .= $notionsArray["".$description->partie[$i]->chapitre[$j]->paragraphe[$k]->notion[$l]->attributes()->position];    
                                    }else{
                                        $text_paragraphes .= $notionsArray["".$description->partie[$i]->chapitre[$j]->paragraphe[$k]->notion[$l]->attributes()->id];

                                    }
                                }

                            }
                        }
                        
                        $text_paragraphes .= "<br/>";
                    }

                    $text_chapitres .= $text_paragraphes;
                    $titre = [];
                    $titre["title"] = $description->partie[$i]->chapitre[$j]->attributes()->title;
                    if(!(isset($description->partie[$i]->chapitre[$j]->attributes()->type) &&
                        $description->partie[$i]->chapitre[$j]->attributes()->type == "mal classe")) {

                        $titre["fils"] = $nav_paragraphes;
                        $nav_chapitres["".$i."_".$j] = (object) $titre;
                    }

                }
                $text_parties .= $text_chapitres;
                $titre = [];
                $titre["title"] = $description->partie[$i]->attributes()->title;
                if(!(isset($description->partie[$i]->attributes()->type) &&
                    $description->partie[$i]->chapitre[$j]->attributes()->type == "mal classe")) {

                    $titre["fils"] = $nav_chapitres;
                    $nav_parties["".$i] = (object) $titre;

                }
            }
            // Ajout de 4 lignes vides à la fin du document pour améliorer la présentation
            $text_parties .= "<br/><br/><br/><br/><br/><br/><br/>";
            $contenu= $text_parties;
            $navigation= $nav_parties;

            return view('../navigation',compact('contenu','navigation','folder'));
        }
    }

}
