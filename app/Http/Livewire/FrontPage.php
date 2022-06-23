<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Page;
use Illuminate\Support\Facades\DB;

class FrontPage extends Component
{
    public $title;
    public $content;
        
    /**
     * The livewire mount function.
     *
     * @param  mixed $urlslug
     * @return void
     */
    public function mount($urlslug = null)
    {
        $this->retrieveContent($urlslug);
    }
    
    /**
     * Retrieves the content of the page.
     *
     * @param  mixed $urlslug
     * @return void
     */
    public function retrieveContent($urlslug)
    {
        //Get Home Page if slug is empty
        if(empty($urlslug)) {
            $data = Page::where('is_default_home', true)->first();
        } else {

            //Get the page according to the slug value
            $data = Page::where('slug', $urlslug)->first();

            //If we can't retrieve anything, we return 404 not found page
            if(!$data) {
                $data = Page::where('is_default_not_found', true)->first();
            }
        }
        
        $this->title = "TEST";
        $this->content = "TEST";
    }
    
    /**
     * Gets all the sidebar links
     *
     * @return void
     */
    private function sideBarLinks()
    {
        return DB::table('navigation_menus')
        ->where('type', '=', 'SidebarNav')
        ->orderBy('sequence', 'asc')
        ->orderBy('created_at', 'asc')
        ->get();
    }
    
    /**
     * Gets all the top navbar links
     *
     * @return void
     */
    private function topNavLinks()
    {
        return DB::table('navigation_menus')
        ->where('type', '=', 'TopNav')
        ->orderBy('sequence', 'asc')
        ->orderBy('created_at', 'asc')
        ->get();
    }
    
    /**
     * The livewire mount function.
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.front-page', [
            'sideBarLinks' => $this->sidebarLinks(),
            'topNavLinks'  => $this->topNavLinks(),
        ])->layout('layouts.frontpage');
    }
}
