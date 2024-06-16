<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $distributor_count = 0;
        $agent_count = 0;
        $user_count = 0;
        if(Auth::user()->role == 'agent') {
            $user_count = User::where('role','user')->where('agent_id',Auth::user()->id)->count();
        } else if(Auth::user()->role == 'distributor') {
            $agent_count = User::where('role','agent')->where('distributor_id',Auth::user()->id)->count();
            $user_count = User::where('role','user')->where('distributor_id',Auth::user()->id)->count();
        } else {
            $distributor_count = User::where('role','distributor')->count();
            $agent_count = User::where('role','agent')->count();
            $user_count = User::where('role','user')->count();
        }
        $data['distributor_count'] =  $distributor_count;
        $data['agent_count'] =  $agent_count;
        $data['user_count'] =  $user_count;
        return view('home',$data);
    }

    public function distributors() {
        $data['distributor'] = User::where('role','distributor')->get();
        return view('distributor.list',$data);
    }
    public function create_distributor() {
        return view('distributor.create');
    }
    public function store_distributor(Request $request) {
        $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'role' => 'distributor'
        ]);

        return back()->with('success','Distributor created successfully');
    }

    public function agents(){
        if(Auth::user()->role == 'distributor') {
            $agents = User::select('users.name','users.email','dist.name as dist_name')->where('users.role','agent')->where('users.distributor_id',Auth::user()->id);
            $agents = $agents->join('users as dist','users.distributor_id','dist.id');
            $agents = $agents->get();
            
        } else {
            $agents = User::select('users.name','users.email','dist.name as dist_name')->where('users.role','agent');
            $agents = $agents->join('users as dist','users.distributor_id','dist.id');
            $agents = $agents->get();
        }
        $data['agents'] = $agents;
        return view('agent.list',$data);

    }
    public function create_agent(){
        if(Auth::user()->role == 'distributor') {
            $distributor = User::where('id',Auth::user()->id)->get();
        } else {
            $distributor = User::where('role','distributor')->get();
        }
        $data['distributor'] = $distributor;
        return view('agent.create',$data);
    }
    public function store_agent(Request $request){
        $request->validate([
            'distributor' => ['required'],
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'role' => 'agent',
            'distributor_id' => $request['distributor'],
        ]);

        return back()->with('success','Agent created successfully');
        
    }

    public function users() {
        if(Auth::user()->role == 'agent') {
            $agents = User::select('users.name','users.email','dist.name as dist_name','agent.name as agent_name')->where('users.role','user')->where('users.agent_id',Auth::user()->id);
            $agents = $agents->join('users as dist','users.distributor_id','dist.id');
            $agents = $agents->join('users as agent','users.agent_id','agent.id');
            $agents = $agents->get();
        } else if(Auth::user()->role == 'distributor') {
            $agents = User::select('users.name','users.email','dist.name as dist_name','agent.name as agent_name')->where('users.role','user')->where('users.distributor_id',Auth::user()->id);
            $agents = $agents->join('users as dist','users.distributor_id','dist.id');
            $agents = $agents->join('users as agent','users.agent_id','agent.id');
            $agents = $agents->get();
        } else {
            $agents = User::select('users.name','users.email','dist.name as dist_name','agent.name as agent_name')->where('users.role','user');
            $agents = $agents->join('users as dist','users.distributor_id','dist.id');
            $agents = $agents->join('users as agent','users.agent_id','agent.id');
            $agents = $agents->get();
        }
        $data['users'] = $agents;
        return view('user.list',$data);
    }

    public function create_user(){
        $agent = [];
        $distributor_id = 0;
        if(Auth::user()->role == 'agent') {
            $distributor_id = Auth::user()->distributor_id;
            $distributor = User::where('role','distributor')->where('id',Auth::user()->distributor_id)->get();
            $agent = User::where('role','agent')->where('id',Auth::user()->id)->get();
        } else if(Auth::user()->role == 'distributor') {
            $distributor_id = Auth::user()->id;
            $distributor = User::where('role','distributor')->where('id',Auth::user()->id)->get();
            $agent = User::where('role','agent')->where('distributor_id',Auth::user()->id)->get();
        } else {
            $distributor = User::where('role','distributor')->get();
        }
        $data['distributor_id'] = $distributor_id;
        $data['distributor'] = $distributor;
        $data['agent'] = $agent;
        return view('user.create',$data);
    }

    public function store_user(Request $request){
        $request->validate([
            'distributor' => ['required'],
            'agent' => ['required'],
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'role' => 'user',
            'distributor_id' => $request['distributor'],
            'agent_id' => $request['agent'],
        ]);

        return back()->with('success','User created successfully');
    }

    public function agent_data(Request $request){
        $distributor_id = $request['distributor_id'];
        $agents = User::where('role','agent')->where('distributor_id',$distributor_id)->get();
        $options = '';
        foreach($agents as $val){
            $options .= '<option value="'.$val->id.'">'.$val->name.'</option>';
        }
        echo $options;
    }
}
