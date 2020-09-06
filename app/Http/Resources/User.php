<?php

namespace App\Http\Resources;

use Auth;
use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        $res = [
            'id' => $this->id,
            'name' => $this->name,
            'surname' => $this->surname,
            'avatar' => $this->avatar
        ];

        $user = Auth::user();
        $with = $request->query('with');
        if(!is_null($with)){
          $withParams = explode(',',$with);
          foreach ($withParams as $withParam) {
            switch($withParam){
              case 'user_email':
                if($user && $user->hasRole('admin')){
                    $res['email'] = $this->email;
                }
                break;
              default:
                break;
            }
          }
        }
        return $res;
    }
}
