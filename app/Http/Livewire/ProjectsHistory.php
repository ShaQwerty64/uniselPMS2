<?php

namespace App\Http\Livewire;

use App\Models\BigProject;
use App\Models\ProjectsHistory as ModelsProjectsHistory;
use App\Models\SubProject;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class ProjectsHistory extends Component
{
    public User|BigProject|SubProject|string $subject0;

    public User $user;
    public array $subjects;
    public int $target = 0; public $tarOps  = [];
    public int $sort   = 0; public $sortOps = ['desc','asc'];
    public int $limit  = 0; public $limOps  = [15,50,100,250,1000];

    public Collection $histories;

    public function mount()
    {
        if ($this->subject0 instanceof User){
            $this->user = $this->subject0;
            $this->tarOps[] = 'User';
            $this->subjects[] = $this->subject0;
            if ($this->subject0->big_projects()->count() + $this->subject0->sub_projects()->count() > 1){
                $this->tarOps[] = 'All projects';
                $this->subjects[] = 'All projects';
            }
            foreach ($this->subject0->big_projects as $big){
                $this->tarOps[] = $big->name . ' (Big Project)';
                $this->subjects[] = $big;
                foreach ($big->sub_projects as $sub){
                    $this->tarOps[] = $sub->name . ' (Sub Project)';
                    $this->subjects[] = $sub;
                }
            }
            foreach ($this->subject0->sub_projects as $sub){
                $this->tarOps[] = $sub->name . ' (Sub Project)';
                $this->subjects[] = $sub;
            }
        }
        elseif ($this->subject0 instanceof BigProject){
            $this->tarOps[] = $this->subject0->name . ' (Big Project)';
        }
        elseif ($this->subject0 instanceof SubProject){
            $this->tarOps[] = $this->subject0->name . ' (Sub Project)';
        }
        else{
            $this->tarOps[] = $this->subject0;
        }
    }

    public function render()
    {
        $this->histories =
        $this->query($this->subjects[$this->target])
        ->take($this->limOps[$this->limit])
        ->orderBy('created_at', $this->sortOps[$this->sort])
        ->get();
        return view('livewire.projects-history');
    }

    private function query(User|BigProject|SubProject|string|array $subject): Builder
    {
        $q = ModelsProjectsHistory::where('id',0);
        if ($subject instanceof User){
            if ($subject->hasRole('admin')){
                $q = $q->orWhere('admin_id',$subject->id);
            }
            if ($subject->hasRole('topMan')){
                $q = $q->orWhere('user_id',$subject->id);
            }
            return $q;
        }
        elseif ($subject instanceof BigProject){
            return $q->orWhere('big_project_id',$subject->id);
        }
        elseif ($subject instanceof SubProject){
            return $q->orWhere('sub_project_id',$subject->id);
        }
        elseif (is_array($subject)){
            return $this->query_array($subject);
        }
        elseif ($subject == 'All projects'){
            return $this->query_allProject();
        }
        else{
            return $q->orWhere('PTJ',$subject);
        }
    }

    //quick fix, for some reason, Models in an array will turn into arrays after some time...
    private function query_array(array $subject): Builder
    {
        $q = ModelsProjectsHistory::where('id',0);
        if (array_key_exists("email",$subject)){
            if ($this->user->hasRole('admin')){
                $q = $q->orWhere('admin_id',$subject['id']);
            }
            if ($this->user->hasRole('topMan')){
                $q = $q->orWhere('user_id',$subject['id']);
            }
        }
        elseif (array_key_exists("PTJ",$subject)){
            $q = $q->orWhere('big_project_id',$subject['id']);
        }
        elseif (array_key_exists("big_project_id",$subject)){
            $q = $q->orWhere('sub_project_id',$subject['id']);
        }
        return $q;
    }

    private function query_allProject(): Builder
    {
        $q = ModelsProjectsHistory::where('id',0);
        foreach ($this->subjects as $subj)
        {
            if (is_array($subj))
            {
                if (array_key_exists("PTJ",$subj)){
                    $q = $q->orWhere('big_project_id',$subj['id']);
                }
                elseif (array_key_exists("big_project_id",$subj)){
                    $q = $q->orWhere('sub_project_id',$subj['id']);
                }
            }
        }
        return $q;
    }
}
