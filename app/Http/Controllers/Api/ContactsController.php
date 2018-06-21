<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;

use App\Models\ContactType;
use App\Models\Contact;

class ContactsController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
        header("Access-Control-Allow-Origin: " . getOrigin($_SERVER));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $streamer = $user->streamer()->first();
        $contacts = $streamer->contacts()->get();
        for ($i = 0; $i < count($contacts); $i++) {
            $type = $contacts[$i]->type()->first();
            $contacts[$i]->type = $type['name'];
        }
        return response()->json(['data' => [
            'contacts' => $contacts,
        ]]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'contact'           => 'required|max:255|unique:contacts',
                'contact_type_id'   =>  'required|numeric|min:1',
            ]
        );
        $user = auth()->user();
        $streamer = $user->streamer()->first();

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        if (!ContactType::find($request->contact_type_id)) {
            return response()->json([
                'errors' => ['contact type id not found'],
            ]);
        }

        $contact = new Contact();
        $contact->contact = $request->contact;
        $contact->contact_type_id = $request->contact_type_id;
        $contact->streamer_id = $streamer->id;
        $contact->save();
        
        return response()->json([
            'message' => 'new contact created successful',
            'data' => [
                'id' => $contact->id,
            ]
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $id = $request->id;
        $contact = Contact::find($id);

        if (!$contact) {
            return response()->json([
                'errors' => ['contact id not found'],
            ]);
        }
        $type = $contact->type()->first();
        $contact->type = $type['name'];

        return response()->json([
            'data' => $contact,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'id'                => 'required|numeric|min:1',
                'contact'           => 'required|max:255|unique:contacts',
                'contact_type_id'   => 'required|numeric|min:1',
            ]);
        $user = auth()->user();
        $streamer = $user->streamer()->first();

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        if (!ContactType::find($request->contact_type_id)) {
            return response()->json([
                'errors' => ['contact type id not found'],
            ]);
        }
        $contact = Contact::find($request->id);
        if (!$contact) {
            return response()->json([
                'errors' => ['contact id not found'],
            ]);
        }

        $contact->contact = $request->contact;
        $contact->contact_type_id = $request->contact_type_id;
        $contact->streamer_id = $streamer->id;
        $contact->save();
        
        return response()->json([
            'message' => 'contact type update successful',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'       => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $contact = Contact::find($request->id);

        if (!$contact) {
            return response()->json([
                'errors' => ['contact id not found'],
            ]);
        }

        $contact->delete();
        return response()->json([
            'message' => 'contact delete successful',
        ]);
    }
}
