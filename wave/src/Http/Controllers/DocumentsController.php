<?php

namespace Wave\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Wave\Document;
use Auth;
class DocumentsController extends Controller
{
    //
    public function index() {
        
        $userId = Auth::id();
        $documents = Document::all()->where('user_id', Auth::id());

        return view("theme::documents.index", compact('userId', 'documents'));
    }


    public function store(Request $request) {
        /*$request->validate([
        'title' => 'required|max:255',
        'body' => 'required'
        ]);*/


        // Store the file in storage\app\public folder
        $file = $request->file('file_upload');
        $fileName = $file->getClientOriginalName();
        $filePath = $file->store('uploads', 'public');

        # Get OCR text
        $post = array (
            'api-key' => '2A6F1N8D', 
            'file' => curl_file_create ($file)
        );

        $ch = curl_init ("https://api.sumnrise.com/oneshot-ocr");
        curl_setopt ($ch, CURLOPT_POST, 1);
        curl_setopt ($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $result=curl_exec ($ch);
        curl_close ($ch); 
        
        $decoded_json = json_decode($result, false);
        
        $ocr_text = $decoded_json->text;
        $ocr_text = str_replace('"','\'',$ocr_text);

        ############################################################################ Detect File Type
        $prompt_second = 'For the given text, can you provide a JSON representation with key and values in hebrew that strictly follows this schema:{ }';
        $post_second = array (
            'api-key' => '2A6F1N8D', 
            'text' => $ocr_text,
            'prompt' =>  $prompt_second
        );
        $ch = curl_init ("https://api.sumnrise.com/oneshot-dataextraction");
        curl_setopt ($ch, CURLOPT_POST, 1);
        curl_setopt ($ch, CURLOPT_POSTFIELDS, $post_second);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        $result_curl_second=curl_exec ($ch);
        curl_close ($ch); 
        

        // Store file information in the database
        $uploadedFile = new Document();
        $uploadedFile->filename = $fileName;
        $uploadedFile->original_name = $file->getClientOriginalName();
        $uploadedFile->file_path = $filePath;
        $uploadedFile->ocr_txt = $ocr_text;
        $uploadedFile->ocr_json = $result_curl_second;
        $uploadedFile->user_id = Auth::id();

        $uploadedFile->save();



        //Post::create($request->all());
        $documents = Document::all()->where('user_id', Auth::id());
       // return view('theme::documents.index'/*, compact('uploadedFile')*/);
        return view("theme::documents.index", compact('documents'));

        /*return redirect()->route('documents.show')
        ->with('success', 'Documents created successfully.');*/
    }
}
