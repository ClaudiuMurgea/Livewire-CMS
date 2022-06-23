<div class="divide-y divide-gray-800" x-data="{ show: false}">  
   {{-- data to make commented show/hide: x-data="{showText: false, randomVariable: 'Random Text'} --}}
   <nav class="flex items-center bg-gray-900 px-3 py-2 shadow-lg">
      <div>
         <button @click="show =! show" class="block h-8 text-gray-400 items-center pr-4 hover:text-gray-200 focus:text-gray-200 focus:outline-none sm:hidden">
            <svg class="w-8 fill-current" viewBox="0 0 24 24">                            
               <path x-show="!show" fill-rule="evenodd" d="M4 5h16a1 1 0 0 1 0 2H4a1 1 0 1 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2z"/>
               <path x-show="show" fill-rule="evenodd" d="M18.278 16.864a1 1 0 0 1-1.414 1.414l-4.829-4.828-4.828 4.828a1 1 0 0 1-1.414-1.414l4.828-4.829-4.828-4.828a1 1 0 0 1 1.414-1.414l4.829 4.828 4.828-4.828a1 1 0 1 1 1.414 1.414l-4.828 4.829 4.828 4.828z"/>
            </svg>
         </button>
      </div>
      <div class="w-full items-center">
         <a href="{{ url('/') }}" class="w-full">
            <x-jet-application-mark class="block h-9 w-auto"/>
         </a>
      </div>
      <div class="flex justify-end sm:w-8/12">
         {{-- Top Navigation --}}
         <ul class="hidden sm:flex sm:flex sm:text-left text-gray-200 text-xs">
            @foreach ($topNavLinks as $item)
               <a href="{{ URL('/' . $item->slug) }}">
                  <li class="cursor-pointer px-4 py-2 hover:underline">{{ $item->label }}</li>
               </a>
            @endforeach
         </ul>
      </div>
   </nav>
   <div class="sm:flex sm:min-h-screen">
      <aside class="bg-gray-900 text-gray-700 divide-y divide-gray-700 divide-dashed w-48">
         {{-- Desktop Web View --}}
         <ul class="hidden text-gray-200 text-xs text-center sm:block pt-12">

            @foreach ($sideBarLinks as $item)
               <a href="{{ URL('/' . $item->slug) }}">
                  <li class="cursor-pointer px-4 py-2 hover:bg-gray-800">{{ $item->label }}</li>
               </a>
            @endforeach

         </ul>

         {{-- Mobile Web View --}}
         <div :class="show ? 'block' : 'hidden'" class="pb-3 divide-y divide-gray-800 block sm:hidden">
            <ul class="text-gray-200">
               
               @foreach ($sideBarLinks as $item)
                  <a href="{{ URL('/' . $item->slug) }}">
                     <li class="cursor-pointer px-4 py-2 hover:bg-gray-800">{{ $item->label }}</li>
                  </a>
               @endforeach

            </ul>

            {{-- Top Navigation Mobile Web View --}}
            <ul class="text-gray-200 text-xs">
               @foreach ($topNavLinks as $item)
                  <a href="{{ URL('/' . $item->slug) }}">
                     <li class="cursor-pointer px-4 py-2 hover:bg-gray-800">{{ $item->label }}</li>
                  </a>
               @endforeach
            </ul>
         </div>
      </aside>
      <main class="bg-gray-100 p-12 min-h-screen sm:w-8/12 md:w-9/12 lg:w-10/12">
         <section class="divide-y text-gray-900">

            {{-- <div x-text="show == true ? 'True' : 'False'"></div> --}}

            {{-- <button @click="
               showText = true;
               randomVariable='Any Text';
               alert('Show');"
               class="bg-green-500 p-3 text-white"
               >Show
            </button>
            <button @click="
               showText = false; 
               randomVariable='Changed Text';
               alert('Hide');" 
               :class="showText ? 'bg-red-900' : 'bg-yellow-500'"
               class="bg-gray-500 p-3 text-white mb-4"
               >Hide
            </button>

            <div x-show="showText">Shown when text variable is true</div>
            <div x-show="!showText">Shown when text variable is false</div>
            <div x-text="randomVariable"></div> --}}

            <h1 class="text-3xl font-bold">{{ $title }}</h1>
            <article>
               <div class="mt-5 text-sm">
                  {!! $content !!}
               </div>
            </article>
         </section>
      </main>
   </div>
   
</div>
