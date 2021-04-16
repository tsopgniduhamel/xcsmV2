<?php

namespace App\Http\Controllers;

use App\Http\Requests\CrsfRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Process\Process;
use App\ClasseEnseignant;
use App\Http\Controllers\NotificationController;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $classe=array();

        if(isset(Auth::user()->is_admin) && Auth::user()->is_admin==1){
            
            $data=ClasseEnseignant::where("Enseignant_id", Auth::user()->id)->get();

            for ($i=0; $i < count($data); $i++) { 
                array_push($classe, $data[$i]->Classe_code);
            }

        }else{
            array_push($classe, Auth::user()->class);
        }

        $this->listeDesCoursParClasses($classe);

        return view('dashboard');
    }

    public function mylogout()
    {
        Auth::logout();
        return view('\vendor\adminlte\login');
    }

    

    public function supprimerCours(Request $request){
        
        $id=$request->query('id');


        $metadata = simplexml_load_file("xmoddledata/metadata.xml");
        $nbrCours=$metadata->attributes()->nbrCours;
        $folderToDelete="";
        $courseName="";
        
        /**
        * Récupératon du nom du cours à supprimer à partir de son id
        *********/
        $index=0;
        for ($i=0; $i < $nbrCours; $i++) { 
            if($metadata->cours[$i]->attributes()->id==$id){
                $folderToDelete=$id . "_" . $metadata->cours[$i]->attributes()->title;
                $courseName=$metadata->cours[$i]->attributes()->title."";
                $metadata->attributes()->nbrCours=$metadata->attributes()->nbrCours-1;
                unset($metadata->cours[$i]);
                break;
            }
        }
        
        /**
        *  public_path() renvoit le chemin absolu du dossier public situé 
        *  à la racine de ce projet
        ************************/

        if(strlen($folderToDelete)!=0 && $folderToDelete!=""){
            $xmoddledata=public_path() . "/xmoddledata/";
            $folderToDelete=$xmoddledata . $folderToDelete;

            
            exec('java -jar ' . $xmoddledata . 'TRASH.jar ' . $folderToDelete);
            $metadata->asXML("xmoddledata/metadata.xml");
    
        }

        //Récupération des différentes classes
        $classes=ClasseEnseignant::where("Enseignant_id", Auth::user()->id)->get();
        for ($i=0; $i <count($classes) ; $i++) { 
            $belongTo=$this->supprimerCoursParClasse($classes[$i]->Classe_code,$id);
            if($belongTo==true){
                NotificationController::sendMultipleMail($classes[$i]->Classe_code, $courseName, false);
            }
        }

        
        return "";

    }

    public function supprimerCoursParClasse($code,$id){
        
        $classe = simplexml_load_file("xmoddledata/coursParClasses/". $code .".xml");
        $nbrCours=$classe->attributes()->nbrCours;
        $belongTo=false;
        /**
        * Récupératon du nom du cours à supprimer à partir de son id
        *********/
        for ($i=0; $i < $nbrCours; $i++) { 
            if($classe->cours[$i]->attributes()->id==$id){
                $classe->attributes()->nbrCours=$classe->attributes()->nbrCours-1;
                unset($classe->cours[$i]);
                $belongTo=true;
                break;
            }
        }

        $classe->asXML("xmoddledata/coursParClasses/". $code .".xml");
        return $belongTo;
        
    }

    public function store(CrsfRequest $request)
    {
        
        $file = $request->file("cours");

        $name = $request->input("name");
        $courseName = $request->input("name");

        $classes=$request->input("classe");

        $name = str_replace(" ","-",$name);

        $extension = $file->getClientOriginalExtension();

        $completName = $name . "." . $extension;

        if($extension=="pdf"){
            if ($file != null && ($file->getSize() / (1024 * 1024)) <= 175) {
                $listeCours = simplexml_load_file("xmoddledata/metadata.xml");
                $id = $listeCours->attributes()->indexMax + 1;
                $path = $file->storeAs($id . "_" . $name, $completName, "uploads");
                $path = "xmoddledata/" . $path;

                $pdfFileName=$name . ".pdf";
                $outputFolder="xmoddledata/" . $id . "_" . $name;

               exec("java -jar xmoddledata/PDF_to_XML.jar " . $pdfFileName . " " . $outputFolder . " " . $name);

                $listeCours->attributes()->nbrCours = $listeCours->attributes()->nbrCours + 1;
                $listeCours->attributes()->indexMax=$listeCours->attributes()->indexMax + 1;


                $cours = $listeCours->addChild('cours');
                $cours->addAttribute("id", $id);
                $cours->addAttribute("title", $name);
                $cours->addAttribute("email", Auth::user()->email);
                $date=date("d/m/Y, H:i");
                $cours->addAttribute("date_publication", $date);

                $listeCours->asXML("xmoddledata/metadata.xml");

                
                foreach ($classes as $select) {
                    $this->storeOnClassXml($id,$name,$date,$select);
                }

                NotificationController::sendMultipleMail($classes, $courseName, true);
                
            }
        }else if ($extension=="docx") {
            if ($file != null && ($file->getSize() / (1024 * 1024)) <= 175) {
                $listeCours = simplexml_load_file("xmoddledata/metadata.xml");
                $id = $listeCours->attributes()->indexMax + 1;
                $path = $file->storeAs($id . "_" . $name, $completName, "uploads");
                $path = "xmoddledata/" . $path;
                $foPath = "xmoddledata/" . $id . "_" . $name . "/" . $completName . ".fo";

                // parsage
                exec("java -jar xmoddledata/Docx_to_Fo_Parser.jar " . $path);

                // structuration
                exec("java -Dfile.encoding=UTF-8 -jar xmoddledata/FoToXml2.jar " . $foPath . " " . "xmoddledata/" . $id . "_" . $name . " " . $id, $op);

                $listeCours->attributes()->nbrCours = $listeCours->attributes()->nbrCours + 1;
                $listeCours->attributes()->indexMax=$listeCours->attributes()->indexMax + 1;

                $cours = $listeCours->addChild('cours');
                $cours->addAttribute("id", $id);
                $cours->addAttribute("title", $name);
                $cours->addAttribute("email", Auth::user()->email);
                $date=date("d/m/Y, H:i");
                $cours->addAttribute("date_publication", $date);

                $listeCours->asXML("xmoddledata/metadata.xml");

                foreach ($classes as $select) {
                    $this->storeOnClassXml($id,$name,$date,$select);
                }

                NotificationController::sendMultipleMail($classes, $courseName, true);

            }
        }else{
            abort(500);
        }


        return redirect("/");
    }

    private function storeOnClassXml($id,$name,$date,$code){
        $classe=simplexml_load_file("xmoddledata/coursParClasses/". $code .".xml");
        $cours=$classe->addChild("cours");
        $cours->addAttribute("id", $id);
        $cours->addAttribute("title", $name);
        $cours->addAttribute("email", Auth::user()->email);
        $cours->addAttribute("date_publication", $date);
        $classe->attributes()->nbrCours = $classe->attributes()->nbrCours + 1;
        $classe->asXML("xmoddledata/coursParClasses/". $code .".xml");
    }




    private function listeDesCours()
    {

        $liste = array();
        // on charge le cours

        $metadata = simplexml_load_file("xmoddledata/metadata.xml");

        // on Vérifie si le cours existe
        $nbrCours = $metadata->attributes()->nbrCours;
        $i = 0;
        for ($i = 0; $i < $nbrCours; $i++) {
            $tmp = $metadata->cours[$i]->attributes();
            $val = $tmp->id . "_" . $tmp->title . "_" . $tmp->date_publication;
            array_push($liste, $val);
        }

        Session::put('listecours', $liste);
    }

    private function listeDesCoursParClasses($classes)
    {

        $liste = array();
        $dejaPris=array();
        // on charge le cours

        for ($i=0; $i < count($classes); $i++) { 
            $metadata = simplexml_load_file("xmoddledata/coursParClasses/". $classes[$i] .".xml");

            // on Vérifie si le cours existe
            $nbrCours = $metadata->attributes()->nbrCours;
            $j = 0;
            for ($j = 0; $j < $nbrCours; $j++) {
                $tmp = $metadata->cours[$j]->attributes();
                $val = $tmp->id . "_" . $tmp->title . "_" . $tmp->date_publication;
                
                if(!in_array(strval($tmp->id), $dejaPris)){
                    array_push($liste, $val);
                    array_push($dejaPris, strval($tmp->id));
                }

            }    
        }
        

        Session::put('listecours', $liste);
    }

    public function lecture(Request $request)
    {
        $folder = Session::get("folder");

        $identity = explode("_", $folder);

        $title = $identity[1];

        $id = $identity[0];

        return $this->lectureDuCours($id, $title);

    }

    public function cours(Request $request)
    {
        Session::put("folder", $request->input("folder"));
        $folder = $request->input("folder");
        return view("notions", compact('folder'));
    }

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

    public function lectureDuCours($id, $title)
    {
        // on charge le cours
        $notionHtml = "";

        $metadata = simplexml_load_file("xmoddledata/metadata.xml");

        // on Vérifie si le cours existe
        $nbrCours = $metadata->attributes()->nbrCours;
        $isFound = false;
        $i = 0;
        for ($i = 0; $i < $nbrCours; $i++) {
            if ($metadata->cours[$i]->attributes()->title == $title && $metadata->cours[$i]->attributes()->id == $id) {
                $isFound = true;
                break;
            }
        }

        // si le cours existe on charge toutes ses notions
        if ($isFound) {

            $cours = simplexml_load_file("xmoddledata/" . $metadata->cours[$i]->attributes()->id . "_" . $metadata->cours[$i]->attributes()->title . "/descriptionNotions.xml");

            $structure = simplexml_load_file("xmoddledata/" . $metadata->cours[$i]->attributes()->id . "_" . $metadata->cours[$i]->attributes()->title . "/description.xml");

            $nbrNotions = $cours->attributes()->nbrNotions;
            
            $notionsConvertis = array();

            //Si le cours en question a été chargé dépuis un fichier word
            if(isset($cours->notion[0]->attributes()->position)){
                
                $nbrParties = $structure->attributes()->nbrParties;
                for ($j = 0; $j < $nbrParties; $j++) {
                    $nbrChapitres = $structure->partie[$j]->attributes()->nbrChapitres;
                    
                    $partie=$structure->partie[$j]->attributes()->title;

                    for ($k = 0; $k < $nbrChapitres; $k++) {
                        $nbrParagraphes = $structure->partie[$j]->chapitre[$k]->attributes()->nbrParagraphes;

                        $chapitre=$structure->partie[$j]->chapitre[$k]->attributes()->title;

                        for ($z = 0; $z < $nbrParagraphes; $z++) {
                            
                            $notionHtml = "";
                            $nbrNot = $structure->partie[$j]->chapitre[$k]->paragraphe[$z]->attributes()->nbrNotions;

                            $paragraphe=$structure->partie[$j]->chapitre[$k]->paragraphe[$z]->attributes()->title;

                            for ($h = 0; $h < $nbrNot; $h++) {

                                for ($i = 0; $i < $nbrNotions; $i++) {
                                    $idNot = $cours->notion[$i]->attributes()->id;
                                    $idNot .= "";
                                    $idC = ($j + 1) . "_" . ($k + 1) . "_" . ($z + 1) . "_" . ($h + 1);

                                    if ($idC == $idNot) {

                                        $attributs = $cours->notion[$i]->attributes();
                                        
                                        $style=$this->getStyle($attributs);

                                        $text = "";
                                        foreach ($cours->notion[$i]->children() as $child) {
                                            $temp="";
                                            $childString=((string)($child->asXML()));
                                            if(isset($child->attributes()->src)){
                                                $temp=str_replace("\"", "'", $childString);
                                            }elseif (isset($child->attributes()->style)) {
                                                $temp=str_replace("\"", "'", $childString);
                                            }else{
                                                $temp=str_replace("\"", "&quot;", $childString);
                                            }
                                            $text.=$temp;
                                        }


                                        $n = "<div style='";
                                        $n .= $style;
                                        $n .= "'>";
                                        $n .= $text;
                                        $n .= "</div>";

                                        $notionHtml .= "<br/>" . $n;
                                        
                                    }

                                }

                            }
                            
                            $partie=str_replace("\"", "&quot;", $partie);

                            $chapitre=str_replace("\"", "&quot;", $chapitre);
                            
                            $paragraphe=str_replace("\"", "&quot;", $paragraphe);


                            $notionDescription='{'
                                .'"partie":"'. $partie . '",'
                                .'"chapitre":"'. $chapitre . '",'
                                .'"paragraphe":"'. $paragraphe . '",'
                                .'"notion":"'. $notionHtml . '"'
                            .'}';

                            $notionDescription=stripslashes($notionDescription);
                            
                            /*$jsonResult=json_decode($notionDescription);

                            if($jsonResult==null){
                                array_push($notionsConvertis,$notionDescription);               
                            }else{

                                array_push($notionsConvertis,$jsonResult);
                            }*/

                            array_push($notionsConvertis,json_decode($notionDescription));
                        }
                    }
                }
                
            }else{

                //Si le fichier provient d'un fichier pdf
                $nbrParties = $structure->attributes()->nbrParties;
                for ($j = 0; $j < $nbrParties; $j++) {
                    $nbrChapitres = $structure->partie[$j]->attributes()->nbrChapitres;
                    
                    $partie=$structure->partie[$j]->attributes()->title;
                    
                    for ($k = 0; $k < $nbrChapitres; $k++) {
                        $nbrParagraphes = $structure->partie[$j]->chapitre[$k]->attributes()->nbrParagraphes;
                        
                        $chapitre=$structure->partie[$j]->chapitre[$k]->attributes()->title;
                        
                        for ($z = 0; $z < $nbrParagraphes; $z++) {
                            $nbrNot = $structure->partie[$j]->chapitre[$k]->paragraphe[$z]->attributes()->nbrNotions;

                            $paragraphe=$structure->partie[$j]->chapitre[$k]->paragraphe[$z]->attributes()->title;
                            
                            $firstNotionId=$structure->partie[$j]->chapitre[$k]->paragraphe[$z]->notion[0]->attributes()->id;
                            
                            for ($h = ($firstNotionId-1); $h < ($nbrNot+$firstNotionId-1); $h++) {

                                $notionHtml = "";
                                
                                $attributs = $cours->notion[$h]->attributes();
                                    
                                $style=$this->getStyle($attributs);

                                $text = "";

                                if($attributs->type == "image"){
                                    foreach ($cours->notion[$h]->children() as $child) {
                                        
                                        $temp=str_replace("\"", "'", ((string)($child->asXML())));

                                        $text .= "<br/>";
                                        $text .= "<div>";
                                        $text .= $temp;  
                                        $text .= "<br/><br/>";
                                        $text .= "<p style='";
                                        $text .= $this->getStyle($cours->notion[$h]->attributes());
                                        $text .= "'>";
                                        $text .= $child->attributes()->title;
                                        $text .= "</p>";
                                        $text .= "</div>";  

                                    }
                                }elseif ($attributs->type == "liste") {
                                    while ($attributs->type == "liste" && $h < ($nbrNot+$firstNotionId-1)) {

                                        foreach ($cours->notion[$h]->children() as $child) {
                                            $temp="<li>". str_replace("\"", "&quot;", ((string)$child))."</li>";
                                            $text .= $temp;  
                                        }

                                        $h++;

                                    }

                                }elseif ($attributs->type == "texte"){

                                    foreach ($cours->notion[$h]->children() as $child) {
                                        $temp="<span>". str_replace("\"", "&quot;", ((string)$child))."</span>";
                                        $text .= $temp;  
                                    }

                                }

                                $n = "<div style='";
                                $n .= $style;
                                $n .= "'>";
                                $n .= $text;
                                $n .= "</div>";
                                
                                $notionHtml .= "<br/>" . $n;

                                $partie=str_replace("\"", "&quot;", $partie);

                                $chapitre=str_replace("\"", "&quot;", $chapitre);
                                
                                $paragraphe=str_replace("\"", "&quot;", $paragraphe);


                                $notionDescription='{'
                                    .'"partie":"'. $partie . '",'
                                    .'"chapitre":"'. $chapitre . '",'
                                    .'"paragraphe":"'. $paragraphe . '",'
                                    .'"notion":"'. $notionHtml . '"'
                                .'}';

                                $notionDescription=stripslashes($notionDescription);
                                
                                // $jsonResult=json_decode($notionDescription);

                                /*if($jsonResult==null){
                                    array_push($notionsConvertis,$notionDescription);               
                                }else{

                                    array_push($notionsConvertis,$jsonResult);
                                }*/

                                array_push($notionsConvertis,json_decode($notionDescription));
                            }
                        }
                    }
                }

            }

        } else {
            return view("/");
        }

        $notions = $notionsConvertis;
        return response($notions,200); 

    }


    public function search(Request $request)
    {
        $key = $request->input("motclef");
        $listeCours = "";
        $isFound = false;
        $metadata = simplexml_load_file("xmoddledata/metadata.xml");
        $nbrCours = $metadata->attributes()->nbrCours;
        if (isset($key)) {

            for ($i = 0; $i < $nbrCours; $i++) {
//                dd(strpos($metadata->cours[$i]->attributes()->title, $key));
                if (strpos(strtolower($metadata->cours[$i]->attributes()->title), strtolower($key))!==false) {
                    $listeCours = $listeCours . "<li class='mysize1' >
                                            <a href='/cours?folder=" . $metadata->cours[$i]->attributes()->id . "_" . $metadata->cours[$i]->attributes()->title . " >
                                                <i class='fa fa-fw fa-file '></i>
                                                <span> " . $metadata->cours[$i]->attributes()->title . "</span>
                                            </a>
                                        </li>";

                    $isFound = true;
                }
            }

        } else {
            for ($i = 0; $i < $nbrCours; $i++) {
                $listeCours = $listeCours . "<li class='mysize1' >
                                            <a href='/cours?folder=" . $metadata->cours[$i]->attributes()->id . "_" . $metadata->cours[$i]->attributes()->title . " >
                                                <i class='fa fa-fw fa-file '></i>
                                                <span> " . $metadata->cours[$i]->attributes()->title . "</span>
                                            </a>
                                        </li>";

                $isFound = true;
            }

        }
        if ($isFound) {
            return $listeCours;
        } else {
            return "Aucun cours pour: " . $key;
        }
    }

    public function getClasses(){

        $id=Auth::user()->id;
        $classes=ClasseEnseignant::where("Enseignant_id", $id)->get();

        $data = '';

        for ($i=0; $i < count($classes); $i++) { 
            $data .= '<option value="'.$classes[$i]->Classe_code.'">'.$classes[$i]->Classe_code.'</option>';
        }

        return $data;
    }

}
