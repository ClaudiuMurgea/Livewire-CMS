<?php

namespace App\Http\Livewire;

use App\Models\Page;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class Pages extends Component
{
    // https://www.youtube.com/watch?v=GN5BP86VjsE  cms~tutorial
    use WithPagination;
    public $modalFormVisible = false;
    public $modalConfirmDeleteVisible = false;
    public $modelId;
    public $slug;
    public $title;
    public $content;
    public $isSetToDefaultHomePage;
    public $isSetToDefaultNotfound;
    
    /**
     * The validation rules
     *
     * @return void
     */
    public function rules()
    {
        return [
            'title'  => 'required',
            'slug'   => 'required|unique:pages,slug,' . $this->modelId,
            'content'=> 'required'
        ];
    }
    
    /**
     * The livewire mount function.
     *
     * @return void
     */
    public function mount()
    {
        //Resets the pagination after reloading the page.
        $this->resetPage();
    }
    
    /**
     * Runs everytime the title
     * variable is updated.
     *
     * @param  mixed $value
     * @return void
     */
    public function updatedTitle($value)
    {
        $this->slug = Str::slug($value);  //does what commented generate slug func beneath aims
    }

    public function updatedIsSetToDefaultHomePage()
    {
        $this->isSetToDefaultNotfound = null;
    }

    public function updatedIsSetToDefaultNotFound()
    {
        $this->isSetToDefaultHomePage = null;
    }
        
    /**
     * The create function.
     *
     * @return void
     */
    public function create()
    {
        $this->validate();
        $this->unassignDefaultHomePage();
        $this->unassignDefaultNotFound();
        Page::create($this->modelData());
        $this->modalFormVisible = false;
        $this->ResetVars();
    }
    
    /**
     * The read function.
     *
     * @return void
     */
    public function read()
    {
        return Page::paginate(5);
    }
    
    /**
     * The update function.
     *
     * @return void
     */
    public function update()
    {
        $this->validate();
        $this->unassignDefaultHomePage();
        $this->unassignDefaultNotFound();
        Page::find($this->modelId)->update($this->modelData());
        $this->modalFormVisible = false;
    }

    public function delete()
    {
        Page::destroy($this->modelId);
        $this->modalConfirmDeleteVisible = false;
        $this->resetPage();
    }

    /**
     * Shows the form modal
     * of the create function.
     * 
     * @return void
     */
    public function createShowModal()
    {
        $this->resetValidation(); //built in func livewire
        $this->modalFormVisible = true;
        $this->resetVars(); // reset() built-in function that acts like commented resetvars func
    }
    
    /**
     * Shows the form modal
     * in update mode.
     *
     * @param  mixed $id
     * @return void
     */
    public function updateShowModal($id)
    {
        $this->resetValidation(); //built in func livewire
        $this->resetVars();
        $this->modelId = $id;
        $this->modalFormVisible = true;
        $this->loadModel();
    }
    
    /**
     * Shows the delete confirmation modal.
     *
     * @param  mixed $id
     * @return void
     */
    public function deleteShowModal($id)
    {
        $this->modelId = $id;
        $this->modalConfirmDeleteVisible = true;
    }
    
    /**
     * loads the model data
     * of this component.
     *
     * @return void
     */
    public function loadModel() 
    {
        $data = Page::find($this->modelId);
        $this->title = $data->title;
        $this->slug = $data->slug;
        $this->content = $data->content;
        $this->isSetToDefaultHomePage = !$data->is_default_home ? null : true;
        $this->isSetToDefaultNotfound = !$data->is_default_not_found ? null : true;
    }
    
    /**
     * The data for the model that mapped
     * in this component.
     *
     * @return void
     */
    public function modelData()
    {
        return [
            'title'                 => $this->title,
            'slug'                  => $this->slug,
            'content'               => $this->content,
            'is_default_home'       => $this->isSetToDefaultHomePage,
            'is_default_not_found'  => $this->isSetToDefaultNotfound
        ];
    }
    
    /**
     * Resets all the variables
     * to null.
     *
     * @return void
     */
    public function ResetVars()
    {
        $this->modelId  = null;
        $this->title    = null;
        $this->slug     = null;
        $this->content  = null;
        $this->isSetToDefaultHomePage = null;
        $this->isSetToDefaultNotfound = null;
    }
    
    /**
     * Generates a url slug
     * based on the title.
     *
     * @param  mixed $value
     * @return void
     */
    // public function generateSlug($value)
    // {
    //     $process1 = str_replace(' ', '-', $value);
    //     $process2 = strtolower($process1);
    //     $this->slug = $process2;
    // }
    
    /**
     * Unnasigns the default home page in the database table.
     *
     * @return void
     */
    private function unassignDefaultHomePage()
    {
        if($this->isSetToDefaultHomePage != null)
        {
            Page::where('is_default_home', true)->update([
                'is_default_home' => false,
            ]);
        }
    }

   /**
     * Unnasigns the default 404 page in the database table.
     *
     * @return void
     */
    private function unassignDefaultNotFound()
    {
        if($this->isSetToDefaultNotfound != null)
        {
            Page::where('is_default_not_found', true)->update([
                'is_default_not_found' => false,
            ]);
        }
    }
    
    /**
     * The livewire render function.
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.pages', [
            'data' => $this->read(),
        ]);
    }
}
