<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;
use Response;

use App\DownloadableFile;
use Illuminate\Support\Facades\Input;
class FileDownloaderController extends Controller
{
    public function index()
    {
        $files = DownloadableFile::all();
    	return view('file.index',compact('files'));
    }
    public function itindex()
    {
    	$files = DownloadableFile::all();
    	return view('file.itindex',compact('files'));
    }
    public function delete(Request $request)
    {
        $id = $request->file_id;
        $file = DownloadableFile::findOrFail($id);
        $file_path = public_path().'/uploads/AdminHelpDesk/downloadableFiles/{$file->filename}';
        if(File::exists($file_path)){
            unlink($file_path);
        }
        $file->delete();

        return redirect()->back()->with('is_delete','Success');
    }
    public function itupload(Request $request)
    {
    	set_time_limit(0);	
    	ini_set('memory_limit',-1);    	
    	if($request->hasFile('filename')){    
            $files = Input::file('filename');                    
                   
                $destinationPath = public_path().'/uploads/AdminHelpDesk/downloadableFiles/';  

                   if (!\File::exists($destinationPath))
                {
                    mkdir($destinationPath, 0755, true); 
                }  
            foreach ($files as $file) {
                $filename = $file->getClientOriginalName();    
                $namefile = $filename;
                $exists = DownloadableFile::byName($namefile);
                if(!count($exists)>0){
                    // move_uploaded_file($destinationPath, $namefile);
                    $file->move($destinationPath, $namefile);
                    // $hashname = \Hash::make($namefile);
                    // $enc = str_replace("/","", $hashname);
                    $file = new DownloadableFile();
                    $file->filename = $namefile;     
                    $file->save();
                }
            }
            return redirect()->back()->with('is_success', 'Uploaded');
        }else{
        	return redirect()->back()->with('error', 'Error');
        }
    }
    public function download(Request $request)
    {
        $filename = $request->get('filename');
        $file = DownloadableFile::byName($filename);        

        try{
            $file_down= public_path().'/uploads/AdminHelpDesk/downloadableFiles/'.$file->filename;   
            return Response::download($file_down);
        }catch(\Exception $e){
            return redirect()->back()->with('error','error');
        }
    }
}
