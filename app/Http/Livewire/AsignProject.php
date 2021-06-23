<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\BigProject;
use App\Models\SubProject;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class AsignProject extends Component
{
    public string $PTJ = 'CICT';

    // from FindUser
    public string $search = '';
    public array|Collection $users = [];
    public int $highlightIndex = 0;
    public bool $active = false;

    public bool $ifRegistered = false;
    public User $theUser;
    // more in middle

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
        if ($this->users->count() == 0){return;}
        $this->search = $this->users[$this->highlightIndex]->name;
        $this->resetX();
    }

    public function select(string $name)
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
    public string $searchP = '';
    public Collection $bigProjects;
    public array|Collection $projects = [];
    public int $highlightIndexP = 0;
    public bool $activeP = false;
    public bool $ifExist = false;

    public int $usersCount = 0;
    public string $closestLike = '';
    public string $theBigProject = '[None]';
    public SubProject|BigProject $theProject;
    public bool $bigSameName;

    public function clickP(){
        $this->activeP = true;
    }

    public function resetP()
    {
        $this->ifExist();

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

    public function selectP(string $name)
    {
        $this->searchP = $name;
        $this->resetP();
    }

    private function ifExist()
    {
        if (!$this->projects === [])
        {
            $this->closestLike = $this->projects[0]->name;
        }

        $this->ifExist = false;
        foreach ($this->projects as $project) {
            if ($project->name == $this->searchP)
            {
                $this->ifExist = true;
                $this->theProject = $project;
                break;
            }
        }
    }

    public function makeBigProject(Request $request)
    {
        if ($this->ifRegistered && $this->searchP != '')
        {
            $message = "Admin '" . auth()->user()->name .  "' ";
            $bigID = null; $subID = null;
            if ($this->theBigProject == '[None]')
            {
                if ($this->ifExist)
                {
                    $this->theUser->sub_projects()->save($this->theProject);
                    $message .= "assigned sub project '" . $this->searchP . "' (" . $this->PTJ . ") to user '" . $this->theUser->name . "'";
                    $subID = $this->theProject->id;
                }
                else
                {
                    $project = new SubProject;
                    $project->name = $this->searchP;
                    $this->makePTJdefault()->sub_projects()->save($project);
                    $this->theUser->sub_projects()->save($project);

                    $message .= "add sub project '" . $this->searchP . "' (" . $this->PTJ . ") and assigned to user '" . $this->theUser->name . "'";
                    $subID = $project->refresh()->id;
                }
            }
            elseif ($this->theBigProject == '[Make New Big Project]')
            {
                if ($this->ifExist)
                {
                    $this->theUser->big_projects()->save($this->theProject);
                    $message .= "assigned big project '" . $this->searchP . "' (" . $this->PTJ . ") to user '" . $this->theUser->name . "'";
                    $bigID = $this->theProject->id;
                }
                else
                {
                    $this->makePTJdefault();
                    $project = new BigProject;
                    $project->name = $this->searchP;
                    $project->default = false;
                    $project->PTJ = $this->PTJ;
                    $project->save();
                    $this->theUser->big_projects()->save($project);

                    $message .= "add big project '" . $this->searchP . "' (" . $this->PTJ . ") and assigned to user '" . $this->theUser->name . "'";
                    $bigID = $project->refresh()->id;
                }
            }
            else
            {
                if ($this->ifExist)
                {
                    $this->theUser->sub_projects()->save($this->theProject);
                    $message .= "assigned sub project '" . $this->searchP . "' of big project '" . $this->bigProject->name . "' (" . $this->PTJ . ") to user '" . $this->theUser->name . "'";
                    $bigID = $this->bigProject->id;
                    $subID = $this->theProject->id;
                }
                else
                {
                    $project = new SubProject;
                    $project->name = $this->searchP;
                    $bigProject = BigProject::where('default',false)->where('name',$this->theBigProject)->first();
                    $bigProject->sub_projects()->save($project);
                    $project->save();
                    $this->theUser->sub_projects()->save($project);

                    $message .= "add sub project '" . $this->searchP . "' to big project '" . $bigProject->name . "' (" . $this->PTJ . ") and assigned to user '" . $this->theUser->name . "'";
                    $bigID = $bigProject->id;
                    $subID = $project->refresh()->id;
                }
            }

            $request->banner($message, 's', auth()->user()->id,$this->theUser->id,$bigID,$subID,$this->PTJ);
            if (!$this->theUser->hasAnyRole('projMan')){
                $this->theUser->assignRole('projMan');
                $request->banner("User '" . $this->theUser->id . "' now a project manager!", '.',auth()->user()->id,$this->theUser->id);
            }

            $this->search = '';
            $this->searchP = '';
            return redirect()->route('admin');
        }
    }

    private function makePTJdefault(): BigProject{
        $PTJ = BigProject::where('default',true)->where('PTJ',$this->PTJ)->get();
        if (count($PTJ) == 0)
        {
            $project0 = new BigProject;
            $project0->name = $this->PTJ . ' default';
            $project0->PTJ = $this->PTJ;
            $project0->default = true;
            $project0->save();
            $PTJ = BigProject::where('default',true)->where('PTJ',$this->PTJ)->get();
        }
        return $PTJ[0];
    }

    public function render()
    {
        if ($this->search != '' && $this->active)
        {
            $this->users =
            User::where('name', 'like', '%'.$this->search.'%')
            ->orWhere('email', 'like', '%'.$this->search.'%')
            ->take(10)
            ->get(['id','name','email']);
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
        $this->ifExist();

        return view('livewire.asign-project');
    }
}
