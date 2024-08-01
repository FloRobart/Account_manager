{{--
 * Ce fichier fait partie du projet compte Manager
 * Copyright (C) 2024 Floris Robart <florobart.github.com>
--}}

<!-- Page d'accueil -->
@extends('layouts.page_template')
@section('title')
    Gestionnaire de comptes
@endsection

@section('content')
<!-- Titre de la page -->
<livewire:page-title :title="'Gestionnaire de comptes'" />

<!-- Messages d'erreur et de succès -->
<div class="colCenterContainer mt-8 px-4">
    @if ($errors->any())
        <div class="rowCenterContainer">
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="normalTextError text-center">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <livewire:information-message />
</div>


<!-- Contenu de la page -->
<section class="colCenterContainer gap-y-10 bgPage mb-[21rem] min-[400px]:mb-68 md:mb-[30rem] lg:mb-[21rem] xl:mb-52 mt-6">
    <!-- Information générale -->
    <div class="colCenterContainer">
        <h2 class="w-full bigTextBleuLogo text-center mb-3">Information générale</h2>

        <!-- Nombre de compte -->
        <div class="rowCenterContainer">
            <span class="normalText">Nombre d'investissement : <span class="normalTextBleuLogo font-bold">{{ $comptes->count() }}</span></span>
        </div>

        <!-- Nombre d'email différents -->
        <div class="rowCenterContainer">
            <span class="normalText">Nombre d'email différents : <span class="normalTextBleuLogo font-bold">{{ $comptes->unique('email')->count() }}</span></span>
        </div>
    </div>

    <!-- Barre de séparation -->
    <livewire:horizontal-separation />

    <div class="colCenterContainer">
        <h2 class="w-full bigTextBleuLogo text-center mb-3">Mes différents comptes</h2>
        <table class="w-full mt-2">
            <!-- Entête du tableau -->
            <thead class="w-full">
                <tr class="tableRow smallText text-center font-bold">
                    @php request()->get('order') == 'asc' ? $order = 'desc' : $order = 'asc'; @endphp
                    <th class="tableCell" title="Trier par ordre @if ($order == 'asc') alphabétique @else anti-alphabétique @endif du nom"><a href="{{ URL::current() . '?sort=date_transaction&order=' . $order }}">Nom du compte</a></th>
                    <th class="tableCell" title="Trier par ordre @if ($order == 'asc') alphabétique @else anti-alphabétique @endif de l'email"><a href="{{ URL::current() . '?sort=montant_transaction&order=' . $order }}">Email</a></th>
                    <th class="tableCell">Mot de passe</th>
                    <th class="tableCell" title="Trier par ordre @if ($order == 'asc') alphabétique @else anti-alphabétique @endif du pseudo"><a href="{{ URL::current() . '?sort=compte&order=' . $order }}">Pseudo</a></th>
                    <th class="tableCell" title="Trier par ordre chronologique"><a href="{{ URL::current() . '?sort=created_at&order=' . $order }}">Actions</a></th>
                </tr>
            </thead>

            <!-- Contenue du tableau -->
            <tbody class="w-full normalText">
                @if (isset($comptes))
                    @foreach ($comptes as $compte)
                        <tr class="tableRow smallText text-center">
                            <!-- Nom du compte -->
                            @if (str_contains(strtolower(URL::current()), 'name'))
                                <td class="tableCell">{{ $compte->name }}</td>
                            @else
                                @if (str_contains(strtolower(URL::current()), 'email'))
                                    @if (str_contains(strtolower(URL::current()), 'pseudo'))
                                        <td class="tableCell" title="Afficher les"><a href="{{ route('comptes.name.email.pseudo', ['name' => $compte->name, 'email' => $compte->email, 'pseudo' => $compte->pseudo]) }}" class="link">{{ $compte->name }}</a></td>
                                    @else
                                        <td class="tableCell" title="Afficher les"><a href="{{ route('comptes.name.email', ['name' => $compte->name, 'email' => $compte->email]) }}" class="link">{{ $compte->name }}</a></td>
                                    @endif
                                @else
                                    @if (str_contains(strtolower(URL::current()), 'pseudo'))
                                        <td class="tableCell" title="Afficher les"><a href="{{ route('comptes.name.pseudo', ['name' => $compte->name, 'pseudo' => $compte->pseudo]) }}" class="link">{{ $compte->name }}</a></td>
                                    @else
                                        <td class="tableCell" title="Afficher les"><a href="{{ route('comptes.name', ['name' => $compte->name]) }}" class="link">{{ $compte->name }}</a></td>
                                    @endif
                                @endif
                            @endif
                            
                            <!-- Email -->
                            @if (str_contains(strtolower(URL::current()), 'email'))
                                <td class="tableCell">{{ $compte->email }}</td>
                            @else
                                @if (str_contains(strtolower(URL::current()), 'name'))
                                    @if (str_contains(strtolower(URL::current()), 'pseudo'))
                                        <td class="tableCell" title="Afficher les"><a href="{{ route('comptes.name.email.pseudo', ['name' => $compte->name, 'email' => $compte->email, 'pseudo' => $compte->pseudo]) }}" class="link">{{ $compte->email }}</a></td>
                                    @else
                                        <td class="tableCell" title="Afficher les"><a href="{{ route('comptes.name.email', ['name' => $compte->name, 'email' => $compte->email]) }}" class="link">{{ $compte->email }}</a></td>
                                    @endif
                                @else
                                    @if (str_contains(strtolower(URL::current()), 'pseudo'))
                                        <td class="tableCell" title="Afficher les"><a href="{{ route('comptes.email.pseudo', ['email' => $compte->email, 'pseudo' => $compte->pseudo]) }}" class="link">{{ $compte->email }}</a></td>
                                    @else
                                        <td class="tableCell" title="Afficher les"><a href="{{ route('comptes.email', ['email' => $compte->email]) }}" class="link">{{ $compte->email }}</a></td>
                                    @endif
                                @endif
                            @endif
                            
                            <!-- Mot de passe -->
                            <td class="tableCell">{{ $compte->password }}</td>
                            
                            <!-- Pseudo -->
                            @if (str_contains(strtolower(URL::current()), 'pseudo'))
                                <td class="tableCell">{{ $compte->pseudo }}</td>
                            @else
                                @if (str_contains(strtolower(URL::current()), 'email'))
                                    @if (str_contains(strtolower(URL::current()), 'name'))
                                        <td class="tableCell" title="Afficher les"><a href="{{ route('comptes.name.email.pseudo', ['name' => $compte->name, 'email' => $compte->email, 'pseudo' => $compte->pseudo]) }}" class="link">{{ $compte->pseudo }}</a></td>
                                    @else
                                        <td class="tableCell" title="Afficher les"><a href="{{ route('comptes.email.pseudo', ['email' => $compte->email, 'pseudo' => $compte->pseudo]) }}" class="link">{{ $compte->pseudo }}</a></td>
                                    @endif
                                @else
                                    @if (str_contains(strtolower(URL::current()), 'name'))
                                        <td class="tableCell" title="Afficher les"><a href="{{ route('comptes.name.pseudo', ['name' => $compte->name, 'pseudo' => $compte->pseudo]) }}" class="link">{{  $compte->pseudo}}</a></td>
                                    @else
                                        <td class="tableCell" title="Afficher les"><a href="{{ route('comptes.pseudo', ['pseudo' => $compte->pseudo]) }}" class="link">{{ $compte->pseudo }}</a></td>
                                    @endif
                                @endif
                            @endif

                            <!-- Actions -->
                            <td class="smallRowCenterContainer px-1 min-[460px]:px-2 min-[500px]:px-4 py-2">
                                <!-- Modifier -->
                                <button onclick="editCompte('{{ str_replace('\'', '\\\'', $compte->name) }}', '{{ str_replace('\'', '\\\'', $compte->email) }}', '{{ str_replace('\'', '\\\'', $compte->password) }}', '{{ str_replace('\'', '\\\'', $compte->pseudo) }}', '{{ $compte->id }}')" class="smallRowCenterContainer w-fit smallTextReverse font-bold bgBleuLogo hover:bgBleuFonce focus:normalScale rounded-lg min-[500px]:rounded-xl py-1 px-1 min-[500px]:px-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="tinySizeIcons">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </button>

                                <!-- Supprimer -->
                                <a href="{{ route('compte.remove', $compte->id) }}" onclick="return confirm('Êtes-vous sûr de vouloir supprimer le compte {{ str_replace('\'', '\\\'', $compte->name) }} ? Cette action est irréversible.')" class="smallRowCenterContainer w-fit smallTextReverse font-bold bgError hover:bgErrorFonce focus:normalScale rounded-lg min-[500px]:rounded-xl py-1 px-1 min-[500px]:px-2 ml-1 min-[500px]:ml-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="tinySizeIcons">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        <!-- Formulaire pour ajouter une compte -->
        <form id="form" action="{{ route('compte.add') }}" method="POST" class="rowStartContainer hidden">
            @csrf
            <div class="colCenterContainer">
                <div class="colStartContainer lg:rowStartContainer">
                    <input id="name"     name="name"     required type="text" placeholder="Nom du compte" class="w-[55%] mx-2 min-[500px]:mx-4 my-2 text-center inputForm smallText">
                    <input id="email"    name="email"    required type="text" placeholder="Email"         class="w-[55%] mx-2 min-[500px]:mx-4 my-2 text-center inputForm smallText">
                    <input id="password" name="password" required type="text" placeholder="Mot de passe"  class="w-[55%] mx-2 min-[500px]:mx-4 my-2 text-center inputForm smallText">
                    <input id="pseudo"   name="pseudo"   required type="text" placeholder="Pseudo"        class="w-[55%] mx-2 min-[500px]:mx-4 my-2 text-center inputForm smallText">
                </div>
                <button id="formButton" class="buttonForm mx-2 min-[500px]:mx-4 my-2">Ajouter</button>
                <div class="w-full tableRowTop"></div>
            </div>
        </form>

        <!-- Bouton pour ajouter un compte -->
        <button onclick="showForm('Ajouter un compte', 'Ajouter', '{{ route('compte.add') }}')" id="button" class="buttonForm mt-8">Ajouter une épargne</a>
    </div>
</section>
@endsection

@section('scripts')
<script src="{{ asset('js/showForm.js') }}"></script>
<script>
    oldId = 0;
    /* Fonction pour modifier une épargne */
    function editCompte(name, email, password, pseudo, id) {
        /* Affichage du formulaire */
        hidden = document.getElementById('form').classList.contains('hidden');
        if (hidden || oldId == id) {
            showForm('Ajouter un compte', 'Modifier', '{{ route('compte.edit') }}');
        } else {
            document.getElementById('formButton').innerText = 'Modifier';
            document.getElementById('form').action = '{{ route('compte.edit') }}';
        }

        /* Remplissage du formulaire */
        document.getElementById('name').value = name;
        document.getElementById('email').value = email;
        document.getElementById('password').value = password;
        document.getElementById('pseudo').value = pseudo;

        if (document.getElementById('id') != null) {
            document.getElementById('id').remove();
        }
        document.getElementById('form').insertAdjacentHTML('beforeend', '<input type="hidden" id="id" name="id" value="' + id + '">');
        document.getElementById('form').scrollIntoView();

        oldId = id;
    }
</script>
@endsection