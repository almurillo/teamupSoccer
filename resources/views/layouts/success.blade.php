@if(Session::has('message'))
 
       <div class="alert alert-success">

           <div class="text-center">
             
            {{ Session::get('message') }}
             
           </div>

         </div>

@endif