<?php

namespace App\Http\Controllers;
use Image;
use File;
use Storage;
use Str;
use App\Category;
use App\ImageFile;
use App\Objective;
use Illuminate\Http\Request;

class UserPanelController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Forces to be authenticated.
        $this->middleware('auth');
        $this->middleware('check_role:user');
    }

    public function base64ExtractData($data,$types){
        if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
            $data = substr($data, strpos($data, ',') + 1);
            $type = strtolower($type[1]); // jpg, png, gif

            if (!in_array($type, $types)) {
                abort(500,'Bad mime type');
            }

            if ($data === false) {
                abort(500,'base64_decode failed');                
            }
            return $type;
        } else {
            abort(500,'did not match data URI with image data');                
        }
    }

    public function index(Request $request){
        return view('panel.index');
    }

    public function viewListObjectives(Request $request){
        $objectives = Objective::whereHas('members', function ($q) use($request) {
                $q->where('user_id', $request->user()->id);
            })->paginate(5);
        return view('panel.objectives.list', ['objectives' => $objectives]);
    }

    public function viewListSubscriptions(Request $request){
        // $objectives = Objective::whereHas('subscribers', function ($q) use($request) {
        //         $q->where('subscriber_id', $request->user()->id);
        //     })->paginate(5);
        $subscriptions = $request->user()->subscriptions()->paginate(5);
        return view('panel.subscriptions.list', ['subscriptions' => $subscriptions]);
    }
    public function formUnsubSubscription(Request $request, $objId){
        $request->user()->subscriptions()->detach($objId);
        // $subscriptions = $request->user()->subscriptions()->paginate(5);
        return redirect()->route('panel.notifications')->with('success','Se desuscribió correctamente del objetivo');
    }

    public function viewListUnreadNotifications(Request $request){
        $notifications = $request->user()->unreadNotifications()->paginate(10);
        return view('panel.notifications.unread', ['notifications' => $notifications]);
    }

    public function formMarkAllUnreadNotifications(Request $request){
        $request->user()->unreadNotifications()->update(['read_at' => now()]);
        return redirect()->route('panel.notifications')->with('success','Todas las notificaciones pendientes fueron marcadas como leidas');
    }

    public function viewListNotifications(Request $request){
        $notifications = $request->user()->notifications()->paginate(10);
        return view('panel.notifications.list', ['notifications' => $notifications]);
    }
    public function viewAccountAvatar(Request $request){
        return view('panel.account.avatar');

    }

    public function formAccountAvatar(Request $request){
        $rules = [
            'avatar' => 'required|string|starts_with:data:image/',
        ];
        $request->validate($rules);
        $user = $request->user();
        // [ 'jpg', 'jpeg', 'gif', 'png' ];
        // Create Image
        $avatarImage = Image::make($request->input('avatar'));
        $avatarImage->resize(300, 300, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $avatarImageThumbnail = Image::make($request->input('avatar'));
        $avatarImageThumbnail->resize(96, 96, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        // Get Mime Type
        $mimeType = $avatarImage->mime();
        // Get Extension
        // $fileExtension = explode('/',$mimeType)[1];
        $fileExtension = 'jpg';
        // Create New Name
        $fileName = 'avatar-user-'.$user->id.'-'.substr(uniqid(),-5).'.'.$fileExtension;
        $fileNameThumbnail = 'avatar-user-'.$user->id.'-'.substr(uniqid(),-5).'-thumbnail.'.$fileExtension;
        // Get Size
        $fileSize = $avatarImage->filesize();
        // Make the File path
        $filePath = 'storage/avatars/'.$fileName;
        $filePathThumbnail = 'storage/avatars/'.$fileNameThumbnail;
        if(is_null($user->avatar)){
            // User doesn't have avatar... Create File and create relationship
            Storage::disk('public')->put("avatars/".$fileName, (string) $avatarImage->encode('jpg'));
            Storage::disk('public')->put("avatars/".$fileNameThumbnail, (string) $avatarImageThumbnail->encode('jpg'));
            $imageFile = new ImageFile();
            $imageFile->name = $fileName;
            $imageFile->size = $avatarImage->filesize();
            $imageFile->mime = $mimeType;
            $imageFile->path = $filePath;
            $imageFile->thumbnail_name = $fileNameThumbnail;
            $imageFile->thumbnail_size = $avatarImageThumbnail->filesize();
            $imageFile->thumbnail_mime = $mimeType;
            $imageFile->thumbnail_path = $filePathThumbnail;
            $user->avatar()->save($imageFile);
        } else {
            // User has avatar...
            // First, delete existing avatar
            $deletePath = Str::replaceFirst('storage/', '', $user->avatar->path);
            Storage::disk('public')->delete($deletePath);
            $deletePath = Str::replaceFirst('storage/', '', $user->avatar->thumbnail_path);
            Storage::disk('public')->delete($deletePath);
            // Create File and update relationship
            Storage::disk('public')->put("avatars/".$fileName, (string) $avatarImage->encode('jpg'));
            Storage::disk('public')->put("avatars/".$fileNameThumbnail, (string) $avatarImageThumbnail->encode('jpg'));
            $user->avatar->name = $fileName;
            $user->avatar->size = $fileSize;
            $user->avatar->mime = $mimeType;
            $user->avatar->path = $filePath;
            $user->avatar->thumbnail_name = $fileNameThumbnail;
            $user->avatar->thumbnail_size = $avatarImageThumbnail->filesize();
            $user->avatar->thumbnail_mime = $mimeType;
            $user->avatar->thumbnail_path = $filePathThumbnail;
            $user->avatar->save();
        }
        return response()->json(['message' => 'El avatar se subio correctamente'], 200);


        // $image = Image::make(base64_encode($request->input('avatar')));
        // echo $image->response('jpg', 70);  
        // $meee = base64_decode($imgData);
        // $data = getimagesizefromstring($meee);
        // data($data);
        // if($request->hasFile('avatar')){
        //     $newFile = new Image();
        //     // Get Extension
        //     $extension = $request->file('avatar')->getClientOriginalExtension();
        //     // Create New Name
        //     $fileName = 'avatar-user-'.$user->id.'.'.$extension;
        //     // Get Size
        //     $fileSize = $request->file('avatar')->getSize();
        //     // Get Mime Type
        //     $mimeType = $request->file('avatar')->getClientMimeType();
        //     // Save in storage/app/public/organizations
        //     $filePath = $request->file('avatar')->storeAs('avatars', $fileName,'public');
        //     $filePath = 'storage/'.$filePath;
        //     error_log('Filepath: '. $filePath);
        //     $newFile->name = $fileName;
        //     $newFile->size = $fileSize;
        //     $newFile->mime = $mimeType;
        //     $newFile->path= $filePath;
        //     $user->avatar()->save($newFile);
        //     $user->save();
            
        // }
        // return response()->json(['message' => 'Ocurrio un error procesando su avatar'], 500);
        // return redirect()->route('panel.account.avatar')->with('success','Se guardo su nuevo avatar');
    }

    public function viewAccountAccess(Request $request){
        return view('panel.account.access');
    }

    public function formAccountAccess(Request $request){
        $rules = [
            'old_password' => 'required|email',
            'new_password' => 'required|email',
        ];
        $request->validate($rules);
        dd($request->input());
        return redirect()->route('panel.account.access')->with('success','Se actualizo su contraseña');
    }

    public function viewAccountEmail(Request $request){

        return view('panel.account.email');
    }

    public function formAccountEmail(Request $request){
        $rules = [
            'old_email' => 'required|email',
            'new_email' => 'required|email',
        ];
        $request->validate($rules);
        dd($request->input());

        return redirect()->route('panel.account.access')->with('success','Se cambió su correo electrónico');
    }

    public function viewAccountNotifications(Request $request){

        return view('panel.account.notifications');
    }

    public function formAccountNotifications(Request $request){
        $rules = [
            'mailable' => 'nullable|string|in:true',
        ];
        $request->validate($rules);
        $isMailable = $request->input('mailable') == 'true' ? true : false;
        if($isMailable){
            $request->user()->notification_preferences = 'database,mail';
        } else {
            $request->user()->notification_preferences = 'database';
        }
        $request->user()->save();

        return redirect()->route('panel.account.notifications')->with('success','Se cambiaron sus preferencias de notificacion');
    }


}
