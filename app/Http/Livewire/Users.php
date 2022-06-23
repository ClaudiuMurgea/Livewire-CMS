<?php 

namespace App\Http\Livewire;

use App\Models\Users;
use Livewire\Component;
use Livewire\WithPagination;

class User extends Component
{
    use WithPagination;
    
    public $modalFormVisible;
    public $modalConfirmDeleteVisible;
    public $modelId;

    /**
    *   Put your custom public properties here!
    */

    /**
     * The validation rules
     *
     * @return void
    */
    protected function rules()
    {
        return [
            
        ];
    }

    /**
     * Load the model modelData
     * of this component.
     *
     * @return void
    */
    public function loadModel()
    {
        $data = Users::find($this->modelId);
        //Assign the variables here.
    }

    /**
     * The data for the model mapped
     * in this component.
     *
     * @return void
    */
    public function modelData()
    {
        return [

        ];
    }

    /**
     * The create function.
     *
     * @return void
    */
    public function create() 
    {
        $this->validate();
        Users::create($this->modelData());
        $this->reset();
    }

    /**
     * The read function.
     *
     * @return void
    */
    public function read()
    {
        return Users::paginate(5);
    }
    
    /**
     * The update function.
     *
     * @return void
    */
    public function update()
    {
        $this->validate();
        Users::find($this->modelId)->update($this->modelData());
        $this->modalFormVisible = false;
    }
    
    /**
     * The delete function.
     *
     * @return void
    */
    public function delete()
    {
        Users::destroy($this->modelId);
        $this->modalConfirmDeleteVisible = false;
        $this->resetPage();
    }
}