<div class="relative">
   
<input type="{{$type}}" name="{{$name}}" value="{{old($name, $value)}}" placeholder="{{$placeholder}}"
@class(['w-full rounded-md px-2 py-1 text-sm ring-1  placeholder:text-slate-400 focus:ring-2',
'pr-8=>$formRef', 
'ring-slate-300'=>!$errors->has($name),
'ring-red-300'=>$errors->has($name)])/>


   
@error($name)
    <div class="mt-1 text-sm text-red-500">
    {{$message}}
</div>
@enderror

</div>