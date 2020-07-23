@php
$defaultClass = 'rounded-circle align-middle';
$theSize = isset($size) ? $size : 32;
$useThumbnail = isset($thumbnail) ? $thumbnail == true : false;
$classes = isset($class) ? "$defaultClass $class" : $defaultClass;
$thePath = isset($avatar) ? ( $useThumbnail ? asset($avatar->thumbnail_path) : asset($avatar->path) ) : asset('img/default-avatar.png');
@endphp

<img src="{{$thePath}}" alt="" class="{{$classes}}" style="width: {{$theSize}}px">
