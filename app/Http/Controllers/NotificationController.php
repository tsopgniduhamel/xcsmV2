<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\notificationMail;
use Illuminate\Support\Facades\Session;
use Mail;
use App\User;

class NotificationController extends Controller
{

    public $data;
    public function __construct(){}

    public function send(Request $request){
        
    
        $data['message']=$request->input('message');
        $data['partie']=$request->input('partie');
        $data['chapitre']=$request->input('chapitre');
        $data['paragraphe']=$request->input('paragraphe');
        $data['cours']=Session::get("folder");

        $idcours=explode("_", $data['cours'])[0];
        $listeCours = simplexml_load_file("xmoddledata/metadata.xml");
        $nbrCours=$listeCours->attributes()->nbrCours;
        $email="";

        for ($i=0; $i <$nbrCours ; $i++) { 
            if(strcmp($listeCours->cours[$i]->attributes()->id, $idcours)==0){
                $email=$listeCours->cours[$i]->attributes()->email . "";
                
                break;
            }   
        }

        $not=new notificationMail($data);
        Mail::to($email)->send($not);

        return ;
    }

    public static function sendMultipleMail($classes, $cours, $isLoading){
        
        if($isLoading==true){
            $data['message']="Le cours " . $cours . " vient d'être chargé sur la plateforme XCSM. Bien vouloir le consulter...";
            $data['sujet']="Chargement d'un nouveau cours";
        }else{
            $data['message']="Le cours " . $cours . " vient d'être supprimé sur la plateforme XCSM.";
            $data['sujet']="Suppresion d'un cours";
        }

        if($isLoading==true){
            for ($i=0; $i < count($classes) ; $i++) { 
                $emails=User::where('class', $classes[$i])->get();
                if(count($emails)!=0){
                    $not=new notificationMail($data);
                    Mail::to($emails)->queue($not);
                }
            }
        }else{
            $emails=User::where('class', $classes)->get();
            if(count($emails)!=0){
                $not=new notificationMail($data);
                Mail::to($emails)->queue($not);
            }
        }

        return ;
    }




    /*public function store(Request $request){
        $message =$request->get("message");

        $ids = $request->get("ids");


        $sendSms = $request->get("sendSms");
        $sendMail = $request->get('sendMail');
        foreach ($ids as $id){
            $notification=Notification::create(['user_id' =>$id,'message' =>$message,'sendSms' => $sendSms,'sendEmail' => $sendMail]);

            //si on doit notifier par mail

            $user = User::find($id);

            if ($sendMail){
                Mail::send("mail",compact('notification'),function ($message) use ($user){
                    $message->from('xcsm.2018@gmail.com', 'XCSM');
                    $message->to($user->email);
                    $message->subject('XCSM notification');
                });
            }
        }
    }


    public function index(){
        $notifications = Notification::with("user")->where(['sendSms' => true,'smsIsSend' => false])->get();

        foreach ($notifications as $notification){
            $notification->smsIsSend = true;
            $notification->save();
        }

        return Response::json($notifications,200,[],JSON_NUMERIC_CHECK);
    }*/
}
