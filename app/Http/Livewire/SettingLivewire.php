<?php

namespace App\Http\Livewire;

use Exception;
use App\Models\Setting;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;

class SettingLivewire extends Component
{
    use WithFileUploads;
    public $name_web,  $logo, $logo_actual, $logo_oscuro, $logo_oscuro_actual, $icono, $icono_actual;

    public function render()
    {
        return view('livewire.setting-livewire');
    }

    public function loadData()
    {
        $this->name_web = $this->Setting->app_name;
        $this->logo_actual = $this->Setting->logo;
        $this->logo_oscuro_actual = $this->Setting->logo_dark;
        $this->icono_actual = $this->Setting->icono;
    }

    public function storegeneral()
    {
        $this->validate([
            'name_web' => 'required|min:2|max:120',
            'logo' => 'nullable|image|max:5500|dimensions:width=214,height=60',
            'logo_oscuro' => 'nullable|image|max:5500|dimensions:width=214,height=60',
            'icono' => 'nullable|image|max:5500|dimensions:width=512,height=512|mimes:png',
        ]);

        DB::beginTransaction();
        try {
            $this->Setting->app_name = $this->name_web;
            if ($this->logo) {
                $imgname2 = Str::slug(Str::limit('logo', 6, '')) . '-' . Str::random(4);
                $imageName2 = $imgname2 . '.' . $this->logo->extension();
                $this->logo->storeAs('public', $imageName2, 'public');
                $this->Setting->logo = $imageName2;
            }
            if ($this->logo_oscuro) {
                $imgname2 = Str::slug(Str::limit('logo_oscuro', 6, '')) . '-' . Str::random(4);
                $imageName2 = $imgname2 . '.' . $this->logo_oscuro->extension();
                $this->logo_oscuro->storeAs('public', $imageName2, 'public');
                $this->Setting->logo_dark = $imageName2;
            }
            if ($this->icono) {
                $imgname2 = Str::slug(Str::limit('favicon', 6, '')) . '-' . Str::random(4);
                $imageName2 = $imgname2 . '.' . $this->icono->extension();
                $this->icono->storeAs('public', $imageName2, 'public');
                $this->Setting->icono = $imageName2;
            }
            $this->Setting->update();
            DB::commit();
            $this->dispatchBrowserEvent('saved');
        } catch (Exception $e) {
            DB::rollBack();
            $this->dispatchBrowserEvent('errores', ['error' => $e->getMessage()]);
        }
    }

    public function getSettingProperty()
    {
        return Setting::findorfail(1);
    }
}
