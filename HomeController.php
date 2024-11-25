<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

use App\Model\Posts;
use App\Model\Kategori;
use App\Model\Menu;
use App\Model\Album;
use App\Model\AlbumImage;
use App\Model\Advertising;
use App\Model\MenuCover;
use App\Model\MenuCoverSub;
use App\Model\DocSakip;
use App\Model\SatuanKerja;
use App\Model\Setting;
use App\Model\Info;
use App\Model\Video;
use App\Model\User;
use App\Model\Statistik;
use App\Model\DocIPKD;

use Custom;
use CustomFront;
use DB;


class HomeController extends Controller {
    protected $themes  = "";

	public function __construct() {
        $result = \App\Model\Setting::where("type", "themes")->first();
        $this->themes = $result->content;
    }

    public function cover() {
        $result_menu = MenuCover::where('publish','1')->orderBy('sort', 'ASC')->get();
        return view('cover', compact('result_menu'));
    }

    public function load_menu_cover(Request $request, $jenis, $id) {
        if($request->ajax()) {
            if ($jenis=="menu") {
                $result_sub_menu = MenuCoverSub::where(["publish"=>"1", "menu_id"=>Crypt::decrypt($id)])->orderBy("sort", "ASC")->get();
                return $result_sub_menu;
            } elseif ($jenis=="pages") {
                $result_sub_menu = Posts::find(Crypt::decrypt($id));
                return $result_sub_menu;
            } elseif ($jenis=="advertising") {
                $result_sub_menu = Advertising::find(Crypt::decrypt($id));
                return $result_sub_menu;
            }
        } else {
            return redirect('/');
        }
    }

    public function home() {

        $populers   = Posts::select('title_posts','slug_posts','thumbnail','hits')->where(["publish"=>"1",'type_posts'=>'posts'])->skip(0)->take(5)->orderBy('hits','desc')->get();
        $breakings  = Posts::where(["publish"=>"1","breaking"=>"1"])->where('thumbnail','!=','')->orderBy('id','desc')->limit(10)->get();
        $top_lists  = Posts::where(["publish"=>"1","top_list"=>"1"])->where('thumbnail','!=','')->orderBy('id','desc')->limit(6)->get();
        $albums     = AlbumImage::select("image")->inRandomOrder()->limit(6)->get();
        $news_posts = Posts::with('user')->where(['publish'=>'1','type_posts'=>'posts'])->where('thumbnail','!=','')->orderBy('id','desc')->limit(5)->get();
        $videos     = Video::orderBy('id','desc')->limit(5)->get();
        $infos      = Info::orderBy('id','desc')->limit(5)->get();

        return view($this->themes.".page.home", compact("albums","top_lists","breakings","populers","news_posts","videos","infos"));
    }

    public function cari($cari) {
        $search         = htmlentities($cari);
        $result_posts   = Posts::with("user")->where('type_posts', 'posts')->where('publish','1')->where('title_posts', 'like','%'.$search.'%')->orderBy('id','desc')->paginate(10);
        return view($this->themes.".page.search", compact("result_posts","search"));
    }

    public function load_home() {
        $populer    = Posts::select('title_posts','slug_posts','thumbnail','hits')->where(["publish"=>"1",'type_posts'=>'posts'])->skip(0)->take(5)->orderBy('hits','desc')->get();
        $breaking   = Posts::where(["publish"=>"1","breaking"=>"1"])->where('thumbnail','!=','')->orderBy('id','desc')->limit(10)->get();
        $top_list   = Posts::where(["publish"=>"1","top_list"=>"1"])->where('thumbnail','!=','')->orderBy('id','desc')->limit(10)->get();
        $album      = AlbumImage::select("image")->inRandomOrder()->limit(6)->get();
        $news_post  = Posts::with('user')->where(['publish'=>'1','type_posts'=>'posts'])->where('thumbnail','!=','')->orderBy('id','desc')->paginate(8);
        return view($this->themes.".page.home", compact("album","top_list","breaking","populer","news_post"));
    }

    public function load_pages($slug_menu='') {
        $slug_menu  = htmlentities($slug_menu);
        $res_menu = Menu::select('main_id')->where('type_menu','pages')->where('slug_menu', $slug_menu)->first();
        if($res_menu) {
            $result = Posts::with("user")->where(['type_posts'=>'pages', 'id'=>$res_menu->main_id])->firstOrFail();
            if(!Session::exists($result->slug_posts)) {
                Session::put($result->slug_posts, TRUE);
                $hits = ['hits' => $result->hits+1];
                Posts::where('slug_posts', $result->slug_posts)->update($hits);
            }
            return view($this->themes.'.page.pages', compact('result'));
        } else {
            return redirect('home');
        }
    }

    public function load_posts($slug_menu='') {
        $slug_menu      = htmlentities($slug_menu);
        $breaking       = Posts::where(["publish"=>"1","breaking"=>"1"])->get();
        $top_list       = Posts::where(["publish"=>"1","top_list"=>"1"])->get();
        $result_posts   = Posts::with("user")->where(['publish'=>'1','type_posts'=>'posts'])->orderBy('publish_date','desc')->paginate(10);
        return view($this->themes.'.page.posts', compact('result_posts', 'slug_menu', 'breaking', 'top_list'));
    }

    public function load_posts_kategori($slug_kategori='') {
        $slug_kategori  = htmlentities($slug_kategori);
        $result_posts = DB::table('app_kategori as a')
                ->select('a.kategori','c.title_posts','c.slug_posts','c.content','c.created_at','c.thumbnail','c.hits','d.nm_lengkap')
                ->join('app_kategori_relation_ships as b','a.id','=','b.kategori_id')
                ->join('app_posts as c','b.posts_id','=','c.id')
                ->leftJoin('app_users as d','c.user_id','=','d.id')
                ->where(['a.slug_kategori'=>$slug_kategori, 'c.type_posts'=>'posts','c.publish'=>'1'])->orderBy('c.id','desc')->paginate(10);
        $kategori = strtoupper(str_replace('_',' ',$slug_kategori));
        return view($this->themes.'.page.kategori', compact('result_posts','kategori'));
    }

    public function terkait($data_kategori) {
        $list_slug = [];
        foreach ($data_kategori as $res_slug) {
            $list_slug[] = $res_slug->slug_kategori;
        }
        $terkait = DB::table('app_kategori as a')
            ->select('a.kategori','c.title_posts','c.slug_posts','c.content','c.thumbnail','c.hits','c.created_at','d.nm_lengkap')
            ->join('app_kategori_relation_ships as b','a.id','=','b.kategori_id')
            ->join('app_posts as c','b.posts_id','=','c.id')
            ->leftJoin('app_users as d','c.user_id','=','d.id')
            ->whereIn('a.slug_kategori', $list_slug)
            ->where('c.thumbnail','!=','')
            ->where('publish','1')
            ->inRandomOrder()
            ->skip(0)
            ->take(5)
            ->get();

        return $terkait;
    }

    public function read_home($slug_posts='') {
        $slug_posts = htmlentities($slug_posts);
        $result     = Posts::with("user")->where(['slug_posts'=>$slug_posts,'publish'=>'1'])->firstOrFail();
        $publisher  = User::select("nm_lengkap")->find($result->publisher);
        $data_kategori = DB::table('app_kategori as a')
                ->select('a.kategori','a.slug_kategori')
                ->join('app_kategori_relation_ships as b','a.id','=','b.kategori_id')
                ->where('b.posts_id', $result->id)
                ->get();
        $terkait = HomeController::terkait($data_kategori);
        if(!Session::exists($slug_posts)) {
            Session::put($slug_posts, TRUE);
            $hits = ['hits' => $result->hits+1];
            Posts::where('slug_posts', $slug_posts)->update($hits);
        }
        return view($this->themes.'.page.read_posts', compact('result','data_kategori','terkait','publisher'));
    }

    public function read_posts($slug_menu='', $slug_posts='') {
        $slug_menu  = htmlentities($slug_menu);
        $slug_posts = htmlentities($slug_posts);

        $result     = Posts::with("user")->where(['slug_posts'=>$slug_posts,'publish'=>'1'])->firstOrFail();
        $publisher  = User::select("nm_lengkap")->find($result->publisher);
        $data_kategori = DB::table('app_kategori as a')
               ->select('a.kategori','a.slug_kategori')
                ->join('app_kategori_relation_ships as b','a.id','=','b.kategori_id')
                ->where('b.posts_id', $result->id)
                ->get();

        $terkait = HomeController::terkait($data_kategori);
        if(!Session::exists($slug_posts)) {
            Session::put($slug_posts, TRUE);
            $hits = ['hits' => $result->hits+1];
            Posts::where('slug_posts', $slug_posts)->update($hits);
        }
        return view($this->themes.'.page.read_posts', compact('result','data_kategori','terkait','publisher'));
    }

    public function load_album($slug_menu='') {
        $slug_menu  = htmlentities($slug_menu);
        $res_menu   = Menu::select('menu','slug_menu','main_id')->where('slug_menu', $slug_menu)->firstOrFail();
        if($res_menu) {
            $result= Album::with("albumimage")->where(['id'=>$res_menu->main_id])->firstOrFail();
            return view($this->themes.'.page.album', compact('result'));
        } else {
            return redirect('home');
        }
    }

    public function document_sakip(Request $request, $slug_menu) {
        $tahun = !empty($request->tahun)?$request->tahun:'';
        $satuan_kerja_id = !empty($request->satuan_kerja)?$request->satuan_kerja:'';

        $data = DocSakip::with('satuan_kerja');
        if(!empty($tahun) && !empty($satuan_kerja_id)) {
            $data= $data->where(['tahun'=>$tahun,'satuan_kerja_id'=>$satuan_kerja_id]);
        } elseif(!empty($tahun)) {
            $data= $data->where('tahun',$tahun);
        } elseif(!empty($satuan_kerja_id)) {
            $data= $data->where('satuan_kerja_id',$satuan_kerja_id);
        }
        $data= $data->orderBy('id', 'DESC')->paginate(20);
        $satuan_kerja   = SatuanKerja::all();
        return view($this->themes.'.page.document_sakip', compact('slug_menu','data','satuan_kerja','tahun','satuan_kerja_id'));
    }



    //=========================================================
    public function all_informasi($slug_menu) {
		$slug_menu = htmlentities($slug_menu);
		// $data_info = Info::paginate(10);
		$data_info = DB::table('app_info')->orderBy('id', 'desc')->paginate(10);
		return view($this->themes.'.page.informasi', compact('slug_menu','data_info'));
	}

	public function detail_informasi($slug_menu, $slug_info) {
		$slug_info = htmlentities($slug_info);
		$data_info = Info::where('slug_info', $slug_info)->first();
		return view($this->themes.'.page.informasi_detail', compact('data_info'));
	}


    //===========================================================
    public function statistik() {
        $sub_kategori  = \App\Model\SubKategoriStatistik::all();
		return view($this->themes.'.page.statistik', compact('sub_kategori'));
	}

    //===========================================================
    public function show_contact_us() {
		return view($this->themes.'.page.contact');
	}

	public function send_contact_us(Request $request) {
		$messages = Custom::messages();
		$attribute = [
			'email'     => 'email',
			'full_name' => 'nama lengkap',
			'subject'   => 'subject',
			'massage'   => 'massage',
			'g-recaptcha-response'  => 'captcha',
		];

		$this->validate($request, [
			'email'      => 'required|max:200|string|email',
			'full_name'  => 'required|max:100',
			'subject'    => 'required|max:250',
			'massage'    => 'required|max:500',
			'g-recaptcha-response' => 'required',
		], $messages, $attribute);

		$secretKey 		= '6LdU-u4UAAAAANPYI5Y2fJJOz__xAY_TO8Qj5a5w';
		$captcha   		= $request['g-recaptcha-response'];
		$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretKey.'&response='.$captcha);
		$responseData 	= json_decode($verifyResponse);

		if ($responseData->success) {
			$data = [
				'email'         => htmlentities($request->email),
				'full_name'     => htmlentities($request->full_name),
				'subject'       => htmlentities($request->subject),
				'massage'       => htmlentities($request->massage)
			];
			$last_id = \App\Model\ContactUs::create($data)->id;
			$massage = "<b>".$request->full_name."</b> mengirimkan pesan dengan subject <b>".$request->subject."</b>";
			Custom::send_massage($last_id, "contact_us", $massage);
			Custom::send_telegram($massage, Crypt::encrypt($last_id), "contact_us");

			return redirect('/home/contact-us/hubungi-kami');
		} else {
			return redirect('/home/contact-us/hubungi-kami');
		}
	}

	public function document_ipkd(Request $request, $slug_menu) {

	    $tahun = substr($slug_menu, -4);

        $slug_menu = htmlentities($slug_menu);
		$data_info = DB::table('app_ipkd')->where('tahun', $tahun)->orderBy('id', 'desc')->paginate(10);
		return view($this->themes.'.page.ipkd', compact('slug_menu','data_info', 'tahun'));
        // $tahun = !empty($request->tahun)?$request->tahun:'';

        // $data = DocIPKD::query();
        //  if(!empty($tahun)) {
        //     $data= $data->where('tahun',$tahun);
        // }
        // $data= $data->orderBy('id', 'DESC')->paginate(20);
        // return view($this->themes.'.page.ipkd', compact('slug_menu','data','tahun'));
    }

    public function detail_ipkd($slug_menu, $slug_info) {
		$slug_info = htmlentities($slug_info);
		$data_info = DocIPKD::where('slug_info', $slug_info)->first();
		return view($this->themes.'.page.ipkd_detail', compact('data_info'));
	}


}
