<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Page;

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
        if(empty($urlslug)){
            $data = Page::where('is_default_home', true)->first();
            $this->title = $data->title;
            $this->content = $data->content;
        } else {
            //Get the page according to the url
            $data = Page::where('slug', $urlslug)->first();
            $this->title = $data->title;
            $this->content = $data->content;
            //If we can't retrieve anything, let's get the default 404 not found page
            if(!$data) {
                $data = Page::where('is_default_not_found', true)->first();
                $this->title = $data->title;
                $this->content = $data->content;
            }
        }


        $data = Page::where('slug', $urlslug)->first();
        $this->title = $data->title;
        $this->content = $data->content;
    }
    
    /**
     * The livewire mount function.
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.front-page')->layout('layouts.frontpage');
    }
}
