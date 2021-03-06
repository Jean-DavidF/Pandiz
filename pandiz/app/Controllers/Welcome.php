<?php
/**
 * Welcome controller
 *
 * @author David Carr - dave@novaframework.com
 * @version 3.0
 */

namespace App\Controllers;

use App\Core\Controller;

use App\Models\Chanson;
use App\Models\User;
use App\Models\Playlist;
use Nova\Support\Facades\Auth;
use Nova\Support\Facades\Input;
use Nova\Support\Facades\Redirect;
use View;


/**
 * Sample controller showing 2 methods and their typical usage.
 */
class Welcome extends Controller
{

    /**
     * Create and return a View instance.
     */
    public function index()
    {
        $message = __('Hello, welcome from the welcome controller! <br/>
this content can be changed in <code>/app/Views/Welcome/Welcome.php</code>');
        
        if (!isset($_POST['style']) || $_POST['style']=="tous") {
            $all = Chanson::all();
        } else {
            
        $all = Chanson::where('style', '=', $_POST['style'])->take(10)->get();
        
        /*$c = new Chanson();
        $c->nom = "Reminder";
        $c->duree = "00:03:12";
        $c->fichier = "blabla";
        $c->post_date = "2017-07-03";
        $c->style = "Pop";
        $c->utilisateur_id = 1;
        $c->save();*/
        }
        
        return View::make('Welcome/Welcome')
            ->shares('title', __('Welcome'))
            ->with('welcomeMessage', $message)
            ->with('all', $all)
            ->with('style',Input::get('style'));
        
        
    }
    
    public function formupload()
    {

        return View::make('Welcome/formupload')
            ->shares('title', 'nouvelle');
    }
    
    public function creechanson() {
        
        if(Input::has('nom') && 
           Input::has('style') && 
           Input::hasFile('chanson') && 
           Input::file('chanson')->isValid() && 
           Input::hasFile('pochette') && 
           Input::file('pochette')->isValid()){
            
            $file = Input::file('chanson')->getClientOriginalName();
            $f = Input::file('chanson')->move('assets/music/'.Auth::user()->username,$file);
            $file2 = Input::file('pochette')->getClientOriginalName();
            $f2 = Input::file('pochette')->move('assets/images/'.Auth::user()->username,$file2);
            
            $c = new Chanson();
            $c->nom = Input::get('nom');
            $c->style = Input::get('style');
            $c->fichier = "/".$f;
            $c->fichier2 = "/".$f2;
            $c->utilisateur_id = Auth::id();
            $c->duree = "";
            $c->post_date = date('Y-m-d h:i:s');
            $c->save();
            return Redirect::to('/');
        }
        
        echo "<pre>";
        echo "<br />";
        
        print_r($_POST);
        
        echo "<br />";
        print_r($_FILES);
        
        echo "</pre>";
        die(1);
    }
    
    public function avatar() {
        if(Input::hasFile('upload-photo-profil') && 
           Input::file('upload-photo-profil')->isValid()){
            
            $profil = Input::file('upload-photo-profil')->getClientOriginalName();
            $p = Input::file('upload-photo-profil')->move('assets/images/'.Auth::user()->username,$profil);
            Auth::user()->avatar ="/".$p;
            Auth::user()->save();

            return Redirect::to('/utilisateur/'.Auth::id());
            
        } else {
            Auth::user()->avatar = "assets/images/avatarbase.jpg";
        }
    }
    
     public function banner() {
        if(Input::hasFile('upload-banner') && 
           Input::file('upload-banner')->isValid()){
            
            $banner = Input::file('upload-banner')->getClientOriginalName();
            $b = Input::file('upload-banner')->move('assets/images/'.Auth::user()->username,$banner);
            Auth::user()->banner ="/".$b;
            Auth::user()->save();

            return Redirect::to('/utilisateur/'.Auth::id());
            
        } else {
            Auth::user()->banner = "assets/images/banneruserbase.png";
        }
    }

    /**
     * Create and return a View instance.
     */
    public function subPage()
    {
        $message = __('Hello, welcome from the welcome controller and subpage method! <br/>
This content can be changed in <code>/app/Views/Welcome/SubPage.php</code>');

        return $this->getView()
            ->shares('title', __('Subpage'))
            ->withWelcomeMessage($message);
    }
    
    public function about()
    {
        return View::make('Welcome/About')
            ->shares('title', 'About')
            ->with('nom','Clément');
        
    }
    
    public function param($id)
    {
        
        $c = Chanson::find($id);
        if($c==false)
            return View::make('Error/404')
                ->shares('title', 'non trouve');
        return View::make('Welcome/param')
            ->shares('title', 'param')
            ->with('chanson', $c);
        
    }
    
     public function utilisateur($id) {
        $u = User::find($id);
        if($u==false)
            return View::make('Error/404')
                ->shares('title', 'non trouve');
        $playlists =
            Playlist::whereRaw('utilisateur_id=?', array($id))->get();
         $all =
             Chanson::whereRaw('utilisateur_id=?', array($id))->get();
         return View::make('Welcome/utilisateur')
             ->shares('title', 'About')
             ->with('user', $u)
             ->with('all', $all)
             ->with('playlists', $playlists);
        
    }
    
    
    public function addtoplaylist($plid, $chid) {
        $pl = Playlist::find($plid);
        $pl->chansons()->attach($chid);
        
        foreach($pl->chansons as $c)
        echo $plid." ".$chid;
        die(1);
    }
    
    
    public function playlist()
    {
        return View::make('Welcome/playlist')
            ->shares('title', 'nouvelle');
    }
    
    public function creeplaylist() {
        $p = new Playlist();
        $p->nom = Input::get('nom');
        $p->utilisateur_id = Auth::id();
        if(Input::hasFile('pochette') && Input::file('pochette')->isValid()) {
            $file2 = Input::file('pochette')->getClientOriginalName();
            $f2 = Input::file('pochette')->move('assets/images/'.Auth::user()->username,$file2);
            $p->pochette = "/".$f2;
        } else 
            $p->pochette = "/assets/images/playlistbase.png";
        
        $p->save();
        
        Return Redirect::to("/");
        if (Request::ajax()) {
            $playlists =
                Playlist::whereRaw('utilisateur_id=?', array(Auth::id()))->get();
            return View::fetch('Welcome/playlist',
                array('playlist' => $playlists));
            
        }
    }

}
