<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use GuzzleHttp\Client;

use App\Members;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Str;


class MMController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected $membership_level_id = 7;
    
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $allmembers = (new Members)->where('user_id', $user->id)->get();
        $data = [];
        foreach ($allmembers as $member) {
            $data[] = [
                'email' => $user->email,
                'user_id'    => $member->thirdrdparty_user_id,
                'mmUserId'    => $member->mm_user_id,
                'status'       => ($member->is_active == 'yes') ? 'Active' : 'Inactive',
                'confirmationUrl'  => $member->confirmation_url
            ];
        }
        return response()->json([
            'data'  => $data
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $apiinfo = config('app.api');
        // dd($api['puat']);
        $user_id = $request->input('user_id');
        $api_user = $request->input('api_user');
        $email = $request->input('email');
        $membership_level_id = $request->input('membership_level_id');
        
        if($api_user == '')
            $api_user = $apiinfo['default'];

        if($membership_level_id == '')
            $membership_level_id = $this->membership_level_id;
            
        if($email && $user_id && $membership_level_id):

            $api = $apiinfo[$api_user];
            $member = new Members();
            $member = $member->getMember($email);
            if(!$member)
                $member = new Members();

            $member->email =$email;
            $member->thirdrdparty_user_id = $user_id;
            $member->membership_level_id = $membership_level_id;
            $member->referer_url = $request->headers->get('referer');
            $member->save();
            $passowrd = Str::random(8);
            $post = [
                'email' => $email,
                'password'  => $passowrd,
                'custom_field_1'  => $passowrd, // site added mm_member_add hook have an issue
                'membership_level_id'   => $membership_level_id,
                'apikey'   => $api['key'],
                'apisecret'   => $api['secret'],
            ];
            try {
                $client = new Client();
                $createTrans = $client->post(
                    $api['endpoint'].'?q=/createMember',
                    array(
                        'form_params' => $post,
                    )
                );

                $getResponse = json_decode($createTrans->getBody()->getContents());

                $responseCode = $getResponse->response_code;
                $response_message = $getResponse->response_message;

                if ($createTrans->getStatusCode() == 200) {
                    $response_data = $getResponse->response_data;
                    $member->mm_user_id = $response_data->member_id;
                    $member->confirmation_url = $response_data->confirmationUrl;
                    $member->user_id = $user->id;
                    $member->save();
                    return response()->json([
                        'data'  => $response_data,
                    ], 200);

                }else {
                    return response()->json([
                        'message'  => $response_message
                    ], $responseCode);
                }

            }catch(\Exception $exc) {
                $erromsge = $exc->getMessage();
                
                return response()->json([
                    'message' => $erromsge,
                ], $exc->getCode());
            }
        else:
            return response()->json([
                'message' => 'Submission Error. Please check posted data.',
            ], 400);
        endif;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($emailoruserid)
    {
        $members = new Members();
        $members = $members->getallMember($emailoruserid);
        $return = [];
        if ($members) {
            foreach ($members as $member ) {
                if ($member->is_active == 'no') :
                    $return[] = [
                        'email'     => $member->email,
                        'status'    => 'Member Not Active !!!',
                    ];                
                else :
                    $return[] = [
                        'email'             => $member->email,
                        'mmUserId'          => $member->mm_user_id,
                        'confirmationUrl'  => $member->confirmation_url
                    ];
                endif;
            }
            return response()->json($return, 200);
        } else {
            return response()->json([
                'message' => 'Member Not found !!!',
            ], 200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $email)
    {
        if(filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $members = new Members();
            $members = $members->getMember($email);
            if($members)
            {
                $return = [];
                foreach ($members as $key => $member) {
                    $membership_level_id = $request->input('membership_level_id');
                    $user_id = $request->input('user_id');
                    $status = $request->input('status');

                    $apiinfo = config('app.api');
                    $user_id = isset($user_id) ? $user_id : $member->thirdrdparty_user_id;
                    if(!array_key_exists($user_id, $apiinfo))
                        return response()->json([
                        'message' => '3rd Party User Id not found!!!',
                        ], 200);

                    $api = $apiinfo[$user_id];
                    $post = [
                        'email' => $email,
                        'membership_level_id' => isset($membership_level_id) ? $membership_level_id : $member->membership_level_id,
                        'status' => isset($status) ? $status : 1, // 1 (Active), 2 (Cancelled), 3 (Locked), 4 (Paused), 5 (Overdue)
                        'apikey' => $api['key'],
                        'apisecret' => $api['secret'],
                    ];

                    try {
                        $client = new Client();
                        $createTrans = $client->post(
                            $api['endpoint'].'?q=/updateMember',
                            array(
                                'form_params' => $post,
                            )
                        );

                        $getResponse = json_decode($createTrans->getBody()->getContents());
                        $responseCode = $getResponse->response_code;
                        $response_message = $getResponse->response_message;

                        if ($createTrans->getStatusCode() == 200) {
                            $member->membership_level_id = $membership_level_id;
                            $member->thirdrdparty_user_id = $user_id;
                            $member->is_active= 'yes';
                            $member->save();

                            $return[$member->email] = 'Member Updated';

                        }else {
                            $return[$member->email] = $response_message;
                        }

                    }catch(\Exception $exc) {
                        $erromsge = $exc->getMessage();
                        $return[$member->email] = $erromsge;
                    }
                }
                return response()->json($return, 200);
            }
            else 
            {
                return response()->json([
                'message' => 'Member Not found !!!',
                ], 200);
            }
            
        }
        else 
        {
            return response()->json([
                'message' => 'Invalid E-mail Address.',
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $emailoruserid)
    {
        /* if(filter_var($email, FILTER_VALIDATE_EMAIL))
        { */
            $members = new Members();
            $apiinfo = config('app.api');
            $api_user = $request->input('api_user');

            if($api_user == ''){
                $api_user = $apiinfo['default'];
            }
            $members = $members->getMember($emailoruserid);
            if($members)
            {
                $return = [];
                foreach ($members as $member) {
                    $api = $apiinfo[$api_user];
                    $post = [
                        'email' => $member->email,
                        'membership_level_id' => $member->membership_level_id,
                        'member_id' => $member->mm_user_id,
                        'status' => 2, // 1 (Active), 2 (Cancelled), 3 (Locked), 4 (Paused), 5 (Overdue)
                        'apikey' => $api['key'],
                        'apisecret' => $api['secret'],
                    ];


                    try {
                        $client = new Client();
                        $createTrans = $client->post(
                            $api['endpoint'].'?q=/updateMember',
                            array(
                                'form_params' => $post,
                            )
                        );

                        $getResponse = json_decode($createTrans->getBody()->getContents());
                        $responseCode = $getResponse->response_code;
                        $response_message = $getResponse->response_message;

                        if ($createTrans->getStatusCode() == 200) {
                            $member->is_active= 'no';
                            $member->save();

                            $return[$member->email] = 'Member De-activated';

                        }else {
                            $return[$member->email] = $response_message;
                        }

                    }catch(\Exception $exc) {
                        $erromsge = $exc->getMessage();
                        $return[$member->email] = $erromsge;
                    }
                }
                return response()->json($return, 200);
            }
            else 
            {
                return response()->json([
                'message' => 'Member Not found !!!',
            ], 200);
            }
            
        /* }
        else 
        {
            return response()->json([
                'message' => 'Invalid E-mail Address.',
            ], 400);
        } */
    }
}
