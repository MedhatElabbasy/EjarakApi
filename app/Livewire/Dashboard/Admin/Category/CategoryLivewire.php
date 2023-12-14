<?php

namespace App\Livewire\Dashboard\Admin\Category;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryLivewire extends Component
{

    use WithPagination;

    public $categoryId, $name, $discription,
    $media_id, $imagefile, $file_name;
    public $search='';


    public function amount()
    {
        $this->resetPage();
        
    }

    public function rules()
    {
        return [
            'name' => ['required'],
            'discription' => ['required'],
            // 'status' => ['required'],
        ];
    }

    public function closeModal()
    {
        $this->resetVars();
    }

    public function resetVars()
    {
        $this->name = null;
        $this->discription = null;
        $this->categoryId = null;
        // $this->search='';
        // $this->status = null;
    }

    public function saveCat()
    {

        // $validatedData = $this->validate();
        // Category::create($validatedData);
        $this->validate();
        $category = new Category();
        $category->name = $this->name;
        $category->discription = $this->discription;
        $category->status =1;
        $category->save();
        session()->flash('message', ' Category Added Successfully');

        $this->dispatch('close-modal');
        $this->resetVars();

    }

    public function render()
    {
        $categories = Category::where('name', 'like', '%' . $this->search . '%')->orderBy('id', 'DESC')->paginate(10);
        return view('livewire.dashboard.admin.category.category-livewire', [
            'categories' => $categories,
        ]);
    }
}