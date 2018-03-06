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
        $workshops = Workshop::getListActiveWorkshops(1)->paginate(15); 
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
       

        $workshops = Workshop::getListActiveWorkshops(1)->paginate(15); 
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

    // vista para los publishers
    public function indexPublisher()
    {   
        //lista de talleres activos
       
        $workshops = Workshop::getListActiveWorkshops(1)->paginate(15); 
        $my_workshops = Workshop::join('students', function ($join) {
                            $join->on('students.workshop_id', '=', 'workshops.id')
                            ->where('students.user_id','=', Auth::user()->role_id );
                        })
                        ->get();
                    
        return view('dashboard_publisher', [
            'workshops' => $workshops,
            'my_workshops' => $my_workshops 
            ]);
    }
    
    public function indexSite()
    {   
        
        $banners = Banner::getListActiveBanners()->get(); 
        $workshops = Workshop::getListActiveWorkshops(1)->paginate(4); 
        $workshopsPrincipal = Workshop::getListActiveWorkshops(2)->paginate(1); 
        $posts = Post::GetListActivePost(1)->paginate(6); 
        $postsPrincipal = Post::GetListActivePost(2)->paginate(1); 
        
        return view('site/home', [  'workshops' => $workshops, 
                                    'posts' => $posts, 
                                    'banners' => $banners,
                                    'postsPrincipal' => $postsPrincipal,
                                    'workshopsPrincipal' => $workshopsPrincipal]);
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
        $workshops = Workshop::getListActiveWorkshops(1)->paginate(8); 
        return view('site/about_workshop', ['workshops' => $workshops]);
    }


    public function workshopsAll()
    {   
        $workshops = Workshop::getListActiveWorkshops(1)->paginate(8); 
        return view('site/workshops_all', ['workshops' => $workshops]);
    }

    public function showWorkshopDetail($slug = null)
    {   
        if ($slug) {
            $workshop = Workshop::where('url','=', $slug)->firstOrFail();           
            return view('site/workshop_detail', ['workshop' => $workshop ]);
        }
    }
    
 
    public function sendContact(Request $request)
    {
        $email = $request['email'];
        
        Mail::send('emails.contact-notification', $request->all(), function($msj){
            $msj->subject('Corrreo de contacto  - Corporación del Deporte Cerro Navia');
            $msj->to('contacto@deportescerronavia.cl');
        });

        Mail::send('emails.contact', $request->all(), function($msj) use ($email){
            $msj->subject('Contacto  - Corporación del Deporte Cerro Navia');
            $msj->from('contacto@deportescerronavia.cl');
            $msj->to($email);
        });

        if (Mail::failures()) {
            flash('Contacto no pudo ser enviado')->error();
            return view('site/contact');
        }

        flash('Contacto enviado correctamente!')->success();
        return view('site/contact');
                
    }

    public function showPostDetail($category = null, $slug = null)
    {   
        if ($slug) {
            $categoryObject = Category::where('url','=', $category)->firstOrFail();
            if ($categoryObject) {
                $postRelated = Post::where('category_id', $categoryObject->id)->orderBy('id')->take(3)->get();
            }

            $post = Post::where('url','=', $slug)->firstOrFail();
            return view('site/post_detail', ['post' => $post ,
                                            'postRelated' =>  $postRelated]);
        }
    }

    public function indexPosts(Request $request, $category = null)
    {   
        //
        if ($request->has('title')) {
            $column = "title";
            $posts = Post::filterByRequest($column, $request->get('title'))->paginate(6);
        } else if ($request->has('category')) {
            $column = "category";
            $posts = Post::filterByRequest($column, $request->get('category'))->paginate(6);
        } else if ($request->has('status')) {
            $column = "status";
            $posts = Post::filterByRequest($column, $request->get('status'))->paginate(6);
        } else if ($category) {
            $column = "category_get";
            $posts = Post::filterByRequest($column, $category)->paginate(4);
        } else {
            $posts = Post::getListActivePost(1)->paginate(6);
        }

        
        return view('site.post_categories', ['posts' => $posts, 
                                            'category' => $category,
                                            'categories' => Category::getListActiveCategories()->get(), 
                                            'tags' => Tag::getListActiveTags()->get() ]);
    }

    public function codeVerify(Request $request)
    {
        //
        if ($request->code) {

            $user = User::where('validate','=', $request->code)->first();
            
            if ($user) {
                if ($request->email ==  $user->email) {
                    $user->validate = null;
                    $user->status = 1;

                    if($user->save()){
                       flash('Usuario activado con éxito, ahora puedes iniciar sesión')->success();
                        return redirect('login');
                    }    
                    
                }
            } else {
                flash('Código erróneo')->error();
                return view('site/valid_user_token');
            }

        } else {
            flash('Código erróneo')->error();
            return view('site/valid_user_token');
        }
        

                
    }

    public function activateUser()
    {
        return view('site/valid_user_token');
    }


    
}
