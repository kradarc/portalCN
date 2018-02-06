<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Category;
use App\Gallery;
use App\Tag;
use App\User;
use App\Workshop;
use App\Student;
use App\Teacher;
use App\Banner;
use Mail;
use Auth;
use Image;


class HomeController extends Controller
{
    //iran todo las views del sitio publico
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    // vista para los admins
    public function index()
    {
        return view('dashboard_admin');
    }

    // vista para los profes
    public function indexTeacher()
    {   
        $workshops = Workshop::getListActiveWorkshops()->paginate(15); 
        $my_workshops = Workshop::join('students', function ($join) {
                            $join->on('students.workshop_id', '=', 'workshops.id')
                            ->where('students.user_id','=', Auth::user()->role_id );
                        })
                        ->get();
                        

        return view('dashboard_public', [
            'workshops' => $workshops,
            'my_workshops' => $my_workshops
            ]);       
    }

    // vista para los alumnos
    public function indexPublic()
    {   
        //lista de talleres activos
       

        $workshops = Workshop::getListActiveWorkshops()->paginate(15); 
        $my_workshops = Workshop::join('students', function ($join) {
                            $join->on('students.workshop_id', '=', 'workshops.id')
                            ->where('students.user_id','=', Auth::user()->role_id );
                        })
                        ->get();
                        

        return view('dashboard_public', [
            'workshops' => $workshops,
            'my_workshops' => $my_workshops 
            ]);
    }
    
    public function indexSite()
    {   
        
        $banners = Banner::getListActiveBanners()->paginate(4); 
        $workshops = Workshop::getListActiveWorkshops()->paginate(4); 
        $posts = Post::getListActivePost()->paginate(5); 
        return view('site/home', ['workshops' => $workshops, 'posts' => $posts, 'banners' => $banners]);
    }


    public function about()
    {   
        return view('site/about');
    }

    public function team()
    {   
        return view('site/team');
    }

    public function contact()
    {
        return view('site/contact');
    }

    public function aboutWorkshop()
    {   
        $workshops = Workshop::getListActiveWorkshops()->paginate(5); 
        return view('site/about_workshop', ['workshops' => $workshops]);
    }

    public function newsWorkshops()
    {   
        $workshops = Workshop::getListActiveWorkshops()->paginate(5); 
        return view('site/workshops', ['workshops' => $workshops]);
    }

    public function workshopsAll()
    {   
        $workshops = Workshop::getListActiveWorkshops()->paginate(4); 
        return view('site/workshops_all', ['workshops' => $workshops]);
    }
    
 
    public function sendContact(Request $request)
    {
        //
        
        Mail::send('emails.contact-notification', $request->all(), function($msj){
            $msj->subject('Corrreo de contacto  - Corporación del Deporte Cerro Navia');
            $msj->to('contacto@deportescerronavia.cl');
        });

        $email = $request->all();
        /*
        Mail::send('emails.contact', $request->all(), function($msj){
            $msj->subject('Corrreo de contacto  - Corporación del Deporte Cerro Navia');
            $msj->to($email['email']);
        });
            */
        flash('Contacto enviado correctamente!')->success();
        return view('site/contact');
                
    }

    public function showPostDetail($category = null, $slug = null)
    {   
        if ($slug) {
            $post = Post::where('url','=', $slug)->firstOrFail();
            return view('site/post_detail', ['post' => $post]);
        }
    }

    public function indexPosts(Request $request, $category = null)
    {   
         //
        if ($request->has('title')) {
            $column = "title";
            $posts = Post::filterByRequest($column, $request->get('title'))->paginate(5);
        } else if ($request->has('category')) {
            $column = "category";
            $posts = Post::filterByRequest($column, $request->get('category'))->paginate(5);
        } else if ($request->has('status')) {
            $column = "status";
            $posts = Post::filterByRequest($column, $request->get('status'))->paginate(5);
        } else if ($category) {
            $column = "category_get";
            $posts = Post::filterByRequest($column, $category)->paginate(5);
        } else {
            $posts = Post::getListActivePost()->paginate(5);
        }

        return view('site.post_categories', ['posts' => $posts, 
                                            'category' => $category,
                                            'categories' => Category::getListActiveCategories()->get(), 
                                            'tags' => Tag::getListActiveTags()->get() ]);
    }

    public function codeVerify(Request $request)
    {
        //
        die('verificanco');
        
        Mail::send('emails.contact', $request->all(), function($msj){
            $msj->subject('Corrreo de contacto');
            $msj->to('daniel.janorc@gmail.com');
        });

        flash('Contacto enviado correctamente!')->success();
        return view('site/contact');
                
    }


    
}
