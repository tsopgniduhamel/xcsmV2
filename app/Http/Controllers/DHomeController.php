<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Process\Process;


class DHomeController extends Controller
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
        Session::forget("folder");
        Auth::logout();
        
        return redirect("/login");



    }

    public function save(Request $request)
    {
        $file = $request->file("cours");

        $name = $request->input("name");

        $extension = "docx";

        $completName = $name . "." . $extension;

        if ($file != null && ($file->getSize() / (1024 * 1024)) <= 175) {
            $listeCours = simplexml_load_file("xmoddledata/metadata.xml");
            $id = $listeCours->attributes()->nbrCours + 1;
            $path = $file->storeAs($id . "_" . $name, $completName, "uploads");
            $path = "xmoddledata/" . $path;
            $foPath = "xmoddledata/" . $id . "_" . $name . "/" . $completName . ".fo";

            // parsage
            exec("java -jar xmoddledata/Docx_to_Fo_Parser.jar " . $path);

//            dd($foPath);

            // structuration
            exec("java -Dfile.encoding=UTF-8 -jar xmoddledata/FoToXml2.jar " . $foPath . " " . "xmoddledata/" . $id . "_" . $name, $op);
            // dd($op);
//            $parsage = new Process("java -jar xmoddledata/Docx_to_Fo_Parser.jar ".$path);
//
//            if($pr)

            $listeCours->attributes()->nbrCours = $id;

            $cours = $listeCours->addChild('cours');
            $cours->addAttribute("id", $id);
            $cours->addAttribute("title", $name);

            $listeCours->asXML("xmoddledata/metadata.xml");

        }

        return redirect("/");
    }

    public function save1(Request $request)
    {
        $file = $request->file("cours");

        $name = $request->input("name");

        $extension = "docx";

        $completName = $name . "." . $extension;

        if ($file != null && ($file->getSize() / (1024 * 1024)) <= 175) {
            $listeCours = simplexml_load_file("xmoddledata/metadata.xml");
            $id = $listeCours->attributes()->nbrCours + 1;
            $path = $file->storeAs($id . "_" . $name, $completName, "uploads");
            $path = "xmoddledata/" . $path;
            $foPath = "xmoddledata/" . $id . "_" . $name . "/" . $completName . ".fo";

            // parsage
            exec("java -jar xmoddledata/Docx_to_Fo_Parser.jar " . $path);

//            dd($foPath);

            // structuration
            exec("java -Dfile.encoding=UTF-8 -jar xmoddledata/FoToXml2.jar " . $foPath . " " . "xmoddledata/" . $id . "_" . $name, $op);
            // dd($op);
//            $parsage = new Process("java -jar xmoddledata/Docx_to_Fo_Parser.jar ".$path);
//
//            if($pr)

            $listeCours->attributes()->nbrCours = $id;

            $cours = $listeCours->addChild('cours');
            $cours->addAttribute("id", $id);
            $cours->addAttribute("title", $name);

            $listeCours->asXML("xmoddledata/metadata.xml");

        }

        return redirect("/");
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
            $val = $tmp->id . "_" . $tmp->title;
            array_push($liste, $val);
        }

        Session::put('listecours', $liste);
    }

    public function lecture(Request $request)
    {
        $folder = Session::get("folder");

        $identity = explode("_", $folder);

        $title = $identity[1];

        $id = $identity[0];

        return $this->lectureDuCours($id,$title);

    }
    public function cours(Request $request)
    {
        Session::put("folder",$request->input("folder"));

        return view("notions");
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

        // si le cours existe on charges toutes ces notions
        if ($isFound) {
            $cours = simplexml_load_file("xmoddledata/" . $metadata->cours[$i]->attributes()->id . "_" . $metadata->cours[$i]->attributes()->title . "/descriptionNotions.xml");
            $structure = simplexml_load_file("xmoddledata/" . $metadata->cours[$i]->attributes()->id . "_" . $metadata->cours[$i]->attributes()->title . "/description.xml");


            $nbrNotions = $cours->attributes()->nbrNotions;
            $notionsConvertis = array();

            $nbrParties = $structure->attributes()->nbrParties;
            for($j = 0; $j< $nbrParties;$j++){
                $nbrChapitres = $structure->partie[$j]->attributes()->nbrChapitres;
                for($k = 0; $k< $nbrChapitres;$k++){
                    $nbrParagraphes = $structure->partie[$j]->chapitre[$k]->attributes()->nbrParagraphes;

                    for($z = 0; $z< $nbrParagraphes;$z++){
                        $notionHtml="";
                        $nbrNot = $structure->partie[$j]->chapitre[$k]->paragraphe[$z]->attributes()->nbrNotions;
                        for($h = 0; $h< $nbrNot;$h++){

//                            Log::info("Logging one variable: " . $idC."   ".$idNot);
                            for ($i = 0; $i < $nbrNotions; $i++) {
                                $idNot = $cours->notion[$i]->attributes()->id;
                                $idNot .= "";
                                $idC = ($j+1)."_".($k+1)."_".($z+1)."_".($h+1);
//                                dd($idC, $idNot."");

                                if($idC==$idNot){

                                    $attributs = $cours->notion[$i]->attributes();
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

                                    $text = "";
                                    foreach ($cours->notion[$i]->children() as $child) {
                                        $text .= $child->asXML();
                                    }
                                    $n = "<div style='";
                                    $n .= $style;
                                    $n .= "'>";
                                    $n .= $text;
                                    $n .= "</div>";

                                    $notionHtml .="<br/>".$n;
                                    //dd(strval($text));
                                }


                            }
//                            dd($notionHtml);
//                            echo $idNot;

                        }
                        array_push($notionsConvertis, $notionHtml);



                    }
                }
            }
        }else{
            return view("/");
        }
        $notions = $notionsConvertis;
        return response()->json($notions,200);

    }

}
