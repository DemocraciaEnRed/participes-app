<?php

namespace App\Http\Controllers;
use Image;
use File;
use Storage;
use Str;
use Hash;
use App\User;
use App\Category;
use App\ImageFile;
use App\Objective;
use App\Rules\MatchOldPassword;
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
    public function formUnsubSubscription(Request $request, $objectiveId){
        $request->user()->subscriptions()->detach($objectiveId);
        // $subscriptions = $request->user()->subscriptions()->paginate(5);
        return redirect()->route('panel.subscriptions')->with('success','Se desuscribió correctamente del objetivo');
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
        $uniqueHash = substr(uniqid(),-5);
        $fileName = 'avatar-user-'.$user->id.'-'.$uniqueHash.'.'.$fileExtension;
        $fileNameThumbnail = 'avatar-user-'.$user->id.'-'.$uniqueHash.'-thumbnail.'.$fileExtension;
        // Make the File path
        $filePath = '/storage/avatars/'.$fileName;
        $filePathThumbnail = '/storage/avatars/'.$fileNameThumbnail;
        if(is_null($user->avatar)){
            // User doesn't have avatar... Create File and create relationship
            Storage::disk('avatars')->put($fileName, (string) $avatarImage->encode('jpg'));
            Storage::disk('avatars')->put($fileNameThumbnail, (string) $avatarImageThumbnail->encode('jpg'));
            $imageFile = new ImageFile();
            $imageFile->name = $fileName;
            $imageFile->size = Storage::disk('avatars')->size($fileName);
            $imageFile->mime = $mimeType;
            $imageFile->path = $filePath;
            $imageFile->thumbnail_name = $fileNameThumbnail;
            $imageFile->thumbnail_size = Storage::disk('avatars')->size($fileNameThumbnail);
            $imageFile->thumbnail_mime = $mimeType;
            $imageFile->thumbnail_path = $filePathThumbnail;
            $user->avatar()->save($imageFile);
        } else {
            // User has avatar...
            // First, delete existing avatar
            $deletePath = Str::replaceFirst('storage/', '', $user->avatar->path);
            Storage::disk('avatars')->delete($deletePath);
            $deletePath = Str::replaceFirst('storage/', '', $user->avatar->thumbnail_path);
            Storage::disk('avatars')->delete($deletePath);
            // Create File and update relationship
            Storage::disk('avatars')->put($fileName, (string) $avatarImage->encode('jpg'));
            Storage::disk('avatars')->put($fileNameThumbnail, (string) $avatarImageThumbnail->encode('jpg'));
            $user->avatar->name = $fileName;
            $user->avatar->size = Storage::disk('public')->size("avatars/".$fileName);
            $user->avatar->mime = $mimeType;
            $user->avatar->path = $filePath;
            $user->avatar->thumbnail_name = $fileNameThumbnail;
            $user->avatar->thumbnail_size = Storage::disk('avatars')->size($fileNameThumbnail);
            $user->avatar->thumbnail_mime = $mimeType;
            $user->avatar->thumbnail_path = $filePathThumbnail;
            $user->avatar->save();
        }
        return response()->json(['message' => 'El avatar se subio correctamente'], 200);
    }

    public function viewAccountAccess(Request $request){
        return view('panel.account.access');
    }

    public function formAccountAccess(Request $request){
        $rules = [
            'current_password' =>  ['required', new MatchOldPassword],
            'new_password' => 'required|string',
            'repeat_password' => 'required|same:new_password',
        ];
        
        $request->validate($rules);
        if (Hash::check($request->input('current_password'), auth()->user()->password)) {
            User::find(auth()->user()->id)->update(['password'=> Hash::make($request->input('new_password'))]);
        } else {
            return redirect()->route('panel.account.access')->with('danger','La contraseña actual no corresponde');
        }
    
        return redirect()->route('panel.account.access')->with('success','Se actualizo su contraseña');
    }

    public function viewVerifyAccount(Request $request){

        return view('panel.account.verify');
    }

    public function viewAccountEmail(Request $request){

        return view('panel.account.email');
    }

    public function formAccountEmail(Request $request){
        $rules = [
            'email' => 'required|email',
        ];
        $request->validate($rules);
        User::find(auth()->user()->id)->update(['email'=> $request->input('email')]);
        return redirect()->route('panel.account.email')->with('success','Se cambió su correo electrónico');
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
