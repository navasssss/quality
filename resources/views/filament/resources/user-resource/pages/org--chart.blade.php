<x-filament-panels::page>
<div class="org-chart" id="orgChart">
        @foreach($users as $user)
            <div class="card">
                <div class="card-header owner">
                    <h3>{{ $user->name }}</h3>
                </div>
                <div class="card-body">
                    <p class="title">{{ $user->email }}</p>
                </div>
            </div>
        @endforeach
    </div>
</x-filament-panels::page>
