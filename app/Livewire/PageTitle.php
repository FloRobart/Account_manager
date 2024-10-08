<?php
namespace App\Livewire;

/*
 * Ce fichier fait partie du projet Account Manager
 * Copyright (C) 2024 Floris Robart <florobart.github@gmail.com>
 */

use Livewire\Component;

class PageTitle extends Component
{
    public $title;

    public function render()
    {
        return view('livewire.page-title');
    }
}
