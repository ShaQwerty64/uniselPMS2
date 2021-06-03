<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\BigProject;
use App\Models\SubProject;
use Illuminate\Http\Request;

class AsignProject extends Component
{
    public $PTJ = 'CICT';

    // from FindUser
    public $search = '';
    public $users = [];
    public $highlightIndex = 0;
    public $active = false;

    public $ifRegistered = false;
    public $theUser;

    public function click(){
        $this->active = true;
    }

    public function resetX()
    {
        $this->ifRegistered();

        $this->highlightIndex = 0;
        $this->active = false;
    }

    public function highlightDown()
    {
        if ($this->highlightIndex + 1 < count($this->users))
        {
            $this->highlightIndex++;
            return;
        }
        $this->highlightIndex = 0;
    }

    public function highlightUp()
    {
        if ($this->highlightIndex != 0)
        {
            $this->highlightIndex--;
            return;
        }
        $this->highlightIndex = count($this->users) - 1;
    }

    public function selectEnter()
    {
        $this->search = $this->users[$this->highlightIndex]->name;
        $this->resetX();
    }

    public function select($name)
    {
        $this->search = $name;
        $this->resetX();
    }

    public function ifRegistered()
    {
        $this->ifRegistered = false;
        foreach ($this->users as $user) {
            if ($user->name == $this->search)
            {
                $this->ifRegistered = true;
                $this->theUser = $user;
                break;
            }
        }
    }

    //from FindOrMakeProject
    public $searchP = '';
    public $bigProjects = [];
    public $projects = [];
    public $highlightIndexP = 0;
    public $activeP = false;
    public $ifReal = false;

    public $usersCount = 0;
    public $closestLike = '';
    public $theBigProject = '[None]';
    public $theProject;
    public $bigSameName;

    public function clickP(){
        $this->activeP = true;
    }

    public function resetP()
    {
        $this->ifReal();

        $this->highlightIndexP = 0;
        $this->activeP = false;
    }

    public function highlightDownP()
    {
        if ($this->highlightIndexP + 1 < count($this->projects))
        {
            $this->highlightIndexP++;
            return;
        }
        $this->highlightIndexP = 0;
    }

    public function highlightUpP()
    {
        if ($this->highlightIndexP != 0)
        {
            $this->highlightIndexP--;
            return;
        }
        $this->highlightIndexP = count($this->projects) - 1;
    }

    public function selectEnterP()
    {
        if (!$this->projects === [])
        {
            $this->searchP = $this->projects[$this->highlightIndexP]->name;
        }
        $this->resetP();
    }

    public function selectP($name)
    {
        $this->searchP = $name;
        $this->resetP();
    }

    private function ifReal()
    {
        if (!$this->projects === [])
        {
            $this->closestLike = $this->projects[0]->name;
        }

        $this->ifReal = false;
        foreach ($this->projects as $project) {
            if ($project->name == $this->searchP)
            {
                $this->ifReal = true;
                $this->theProject = $project;
                break;
            }
        }
    }

    //this
    public function makeBigProject(Request $request)
    {
        if ($this->ifRegistered && $this->searchP != '')
        {
            $message = '';
            if ($this->theBigProject == '[None]')
            {
                if ($this->ifReal)
                {
                    $this->theUser->sub_projects()->save($this->theProject);
                    $message = '"' . $this->searchP . '" project assigned to "' . $this->theUser->name . '"!';
                }
                else
                {
                    $project = new SubProject;
                    $project->name = $this->searchP;
                    $bigProject = BigProject::where('default',true)->where('PTJ',$this->PTJ)->get();
                    if (count($bigProject) == 0)
                    {
                        $project0 = new BigProject;
                        $project0->name = $this->PTJ . ' default';
                        $project0->PTJ = $this->PTJ;
                        $project0->default = true;
                        $project0->save();
                        $bigProject = BigProject::where('default',true)->where('PTJ',$this->PTJ)->get();
                    }
                    $bigProject[0]->sub_projects()->save($project);
                    $this->theUser->sub_projects()->save($project);

                    $message = '"' . $this->searchP . '" project added and assigned to "' . $this->theUser->name . '"!';
                }
            }
            elseif ($this->theBigProject == '[Make New Big Project]')
            {
                if ($this->ifReal)
                {
                    $this->theUser->big_projects()->save($this->theProject);
                    $message = '"' . $this->searchP . '" big project assigned to "' . $this->theUser->name . '"!';
                }
                else
                {
                    if (count(BigProject::where('default',true)->where('PTJ',$this->PTJ)->get()) == 0)
                    {
                        $project = new BigProject;
                        $project->name = $this->PTJ . ' default';
                        $project->PTJ = $this->PTJ;
                        $project->default = true;
                        $project->save();
                    }
                    $project = new BigProject;
                    $project->name = $this->searchP;
                    $project->default = false;
                    $project->PTJ = $this->PTJ;
                    $project->save();
                    $this->theUser->big_projects()->save($project);

                    $message = '"' . $this->searchP . '" big project added and assigned to "' . $this->theUser->name . '"!';
                }
            }
            else
            {
                if ($this->ifReal)
                {
                    $this->theUser->sub_projects()->save($this->theProject);
                    $message = '"' . $this->searchP . '" project assigned to "' . $this->theUser->name . '"!';
                }
                else
                {
                    $project = new SubProject;
                    $project->name = $this->searchP;
                    $bigProject = BigProject::where('default',false)->where('name',$this->theBigProject)->first();
                    $bigProject->sub_projects()->save($project);
                    $project->save();
                    $this->theUser->sub_projects()->save($project);

                    $message = '"' . $this->searchP . '" project added to "' . $bigProject->name . '" and assigned to "' . $this->theUser->name . '"!';
                }
            }

            $request->session()->put('banner.m', $message);
            $request->session()->put('banner.t', 's');
            // $this->reAllUsersManager();
            $this->theUser->assignRole('projMan');

            $this->search = '';
            $this->searchP = '';
            return redirect()->route('admin');
        }
    }

    public function reAllUsersManager(){
        foreach (User::role('projMan')->get() as $user){
            // if ($user->hasPermissionTo('edit projects')){
                // $user->revokePermissionTo('edit projects');
            // }$user->hasRole('projMan');
            $user->removeRole('projMan');
        }
        foreach (BigProject::all() as $bigProject){
            foreach ($bigProject->users as $user){
                $user->assignRole('projMan');
            }
            foreach ($bigProject->sub_projects as $subProject){
                foreach ($subProject->users as $user){
                    $user->assignRole('projMan');
                }
            }
        }
    }

    // public $allUsers;
    // public function mount(){
    //     $this->allUsers = User::all();
    // }
    // private function usersLike(string $search): array{
    //     $array = [];
    //     $pattern = '/' . $search . '/i';
    //     $count = 0;
    //     foreach ($this->allUsers as $user){
    //         if (preg_match($pattern,$user->name) || preg_match($pattern,$user->email)){
    //             $array[] = $user;
    //             $count++;
    //         }
    //         if ($count == 10){
    //             break;
    //         }
    //     }
    //     return $array;
    // }

    public function render()
    {
        if ($this->search != '' && $this->active)
        {
            $this->users =
            User::where('name', 'like', '%'.$this->search.'%')
            ->orWhere('email', 'like', '%'.$this->search.'%')->take(10)->get();
            // $this->usersLike($this->search);
        }

        if (!$this->users === [] && $this->users[0]->name == $this->search)
        {
            $this->resetX();
        }

        $this->ifRegistered();

        if ($this->searchP != '' && $this->activeP)
        {
            $this->bigSameName = true;
            if ($this->theBigProject == '[Make New Big Project]')
            {
                $this->projects = BigProject::where('name', 'like', '%'.$this->searchP.'%')->where('default',false)->where('PTJ',$this->PTJ)->take(15)->get();
                $this->bigSameName = BigProject::select('name')->where('name', $this->searchP)->where('default' ,false)->where('PTJ' , '!=', $this->PTJ)->first() === null;
            }
            else
            {
                $bigProject = [];
                if ($this->theBigProject == '[None]'){
                    $bigProject = BigProject::where('default',true)->where('PTJ',$this->PTJ)->get();
                }
                else{$bigProject = BigProject::where('name',$this->theBigProject)->take(1)->get();}

                if (count($bigProject) != 0){
                    $this->projects = $bigProject[0]->sub_projects()->where('name', 'like', '%'.$this->searchP.'%')->take(15)->get();
                }
            }

            $project = SubProject::where('name', $this->searchP)->first();
            if ($project != null){
                $this->usersCount = $project->users()->count();
            }
        }

        if (count($this->projects) != 0){
            if ($this->projects[0]->name == $this->searchP){
                $this->resetP();
            }
        }

        $this->bigProjects = BigProject::where('default',false)->where('PTJ',$this->PTJ)->get();
        $this->ifReal();

        return view('livewire.asign-project');
    }
}
