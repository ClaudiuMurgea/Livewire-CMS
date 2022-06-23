<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;

class LivewireCustomCrudCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:livewire:crud
    {nameOfTheClass? : The name of the class.}, 
    {nameOfTheModelClass? : The name of the model class.}';
    //if we say nameOfTheClass? with ? after , it means the parameters will not be required anymore, cus they are required by default

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a custom Livewire CRUD.';

    /**
     * Our custom properties here!
     */
    protected $nameOfTheClass;
    protected $nameOfTheModelClass;
    protected $file;
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->file = new Filesystem();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //Gathers all parameters
        $this->gatherParameters();

        //Generates the Livewire Class File
        $this->generateLivewireCrudClassFile();

        //Generates the View File
        $this->generateLivewireCrudViewFile();
    }
    
    /**
     * Gathers all necessary parameters.
     *
     * @return void
     */
    protected function gatherParameters()
    {
        $this->nameOfTheModelClass = $this->argument('nameOfTheModelClass');
        $this->nameOfTheClass = $this->argument('nameOfTheClass');

        //If you didn't input the name of the class
        if(!$this->nameOfTheClass) {
            $this->nameOfTheClass = $this->ask('Enter class name');
        }
        
        //If you didn't input the name of the model
        if(!$this->nameOfTheModelClass) {
            $this->nameOfTheModelClass = $this->ask('Enter model name');
        }


        //Convert to studly case
        $this->nameOfTheModelClass = Str::studly($this->nameOfTheModelClass);
        $this->nameOfTheClass = Str::studly($this->nameOfTheClass);


        $this->info($this->nameOfTheClass . ' ' . $this->nameOfTheModelClass);
    }
    
    /**
     * Generates the CRUD class file
     *
     * @return void
     */
    protected function generateLivewireCrudClassFile()
    {
        //Set the origin and destination for the livewire class file
        $fileOrigin = base_path('/stubs/custom.livewire.crud.stub');
        $fileDestination = base_path('/app/Http/Livewire/' .$this->nameOfTheModelClass . '.php');

        if($this->file->exists($fileDestination)){
            $this->info('This class file already exists: '. $this->nameOfTheClass . '.php');
            $this->info('Aborting class file creation.');
            return false;
        }

        //Get the original string content of the file
        $fileOriginalString = $this->file->get($fileOrigin);
        // $this->info($fileOriginalString); this will display the content of our custom stub on the screen after command is used

        //Replace the strings specified in the array sequantially
        $replaceFileOriginalString = Str::replaceArray('{{}}', 
            [
                $this->nameOfTheModelClass,
                $this->nameOfTheClass,
                $this->nameOfTheModelClass,
                $this->nameOfTheModelClass,
                $this->nameOfTheModelClass,
                $this->nameOfTheModelClass,
                $this->nameOfTheModelClass,
                Str::kebab($this->nameOfTheClass), //From "FooBar" to "foo-bar"
            ],
            $fileOriginalString
        );

        //Put the content into the destination directory
        $this->file->put($fileDestination, $replaceFileOriginalString);
        $this->info('Livewire class file created: ' . $fileDestination);
    }
        
    /**
     * generateLivewireCrudViewFile
     *
     * @return void
     */
    protected function generateLivewireCrudViewFile()
    {
         //Set the origin and destination for the livewire class file
         $fileOrigin = base_path('/stubs/custom.livewire.crud.view.stub');
         $fileDestination = base_path('/resources/views/livewire/' . Str::kebab($this->nameOfTheClass) . '.blade.php' );

         if($this->file->exists($fileDestination)){
            $this->info('This view file already exists: '. Str::kebab($this->nameOfTheClass) . '.php');
            $this->info('Aborting view file creation.');
            return false;
        }

         //Copy file to destination
         $this->file->copy($fileOrigin, $fileDestination);
         $this->info('Livewire view file created: ' . $fileDestination);
    }
}
