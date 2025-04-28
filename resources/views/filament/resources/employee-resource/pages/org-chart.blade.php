<x-filament-panels::page>

    <style>
    .fi-sidebar-item-icon {
    display: inline-block !important;
    opacity: 1 !important;
    visibility: visible !important;
}
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        :root {
            --accounting-color: #8e44ad;
            --accounting-light: #9b59b6;
            --accounting-gradient: linear-gradient(135deg, #8e44ad, #9b59b6);
            --sales-color: #f39c12;
            --sales-light: #f1c40f;
            --sales-gradient: linear-gradient(135deg, #f39c12, #f1c40f);
            --admin-color: #16a085;
            --admin-light: #1abc9c;
            --admin-gradient: linear-gradient(135deg, #16a085, #1abc9c);
            --owner-color: #2c3e50;
            --owner-light: #34495e;
            --owner-gradient: linear-gradient(135deg, #2c3e50, #34495e);
            --primary-btn: #3498db;
            --primary-btn-hover: #2980b9;
            --success-btn: #2ecc71;
            --success-btn-hover: #27ae60;
            --danger-btn: #e74c3c;
            --danger-btn-hover: #c0392b;
            --shadow-sm: 0 4px 6px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 6px 12px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.1);
            --border-radius: 12px;
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9fafb;
            color: #333;
            line-height: 1.6;
            
            min-height: 100vh;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
           
        }
        
        .org-chart {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            position: relative;
        }
        
        .level {
            display: flex;
            justify-content: center;
            width: 100%;
            margin-bottom: 50px;
            z-index: 1;
        }
        
        .department-container {
            display: flex;
            justify-content: space-around;
            width: 100%;
            flex-wrap: wrap;
        }
        
        .department {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0 15px 30px;
            min-width: 280px;
        }
        
        .employee-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 25px;
            margin-top: 30px;
        }
        h1.fi-header-heading {
            display: none !important;
        }
        .card {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-md);
            overflow: hidden;
            width: 260px;
            transition: all 0.3s ease;
            position: relative;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
        }
        
        .card-header {
            color: white;
            padding: 20px;
            text-align: center;
            position: relative;
            overflow: hidden;
            height: 75px;
        }
        
        .card-header::before {
            content: '';
            position: absolute;
            top: -10px;
            right: -10px;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }
        
        .card-header::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: -15px;
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
        }
        
        .accounting {
            background: var(--accounting-gradient);
        }
        
        .sales {
            background: var(--sales-gradient);
        }
        
        .administration {
            background: var(--admin-gradient);
        }
        
        .owner {
            background: var(--owner-gradient);
        }
        
        .card-body {
            padding: 20px;
            text-align: center;
            position: relative;
        }
        
        .profile-pic-container {
            margin-top: -50px;
            margin-bottom: 15px;
            position: relative;
            z-index: 2;
        }
        
        .profile-pic {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto;
            display: block;
            border: 4px solid white;
            box-shadow: var(--shadow-sm);
            background-color: #f1f1f1;
        }
        
        .upload-overlay {
            position: absolute;
            bottom: 0;
            right: 80px;
            background-color: var(--primary-btn);
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            opacity: 0;
            transition: opacity 0.3s ease;
            border: 2px solid white;
        }
        
        .profile-pic-container:hover .upload-overlay {
            opacity: 1;
        }
        
        .name {
            font-weight: 600;
            font-size: 20px;
            margin-bottom: 5px;
            color: #2c3e50;
        }
        
        .title {
            color: #7f8c8d;
            margin-bottom: 12px;
            font-size: 15px;
            font-weight: 500;
        }
        
        .email {
            color: var(--primary-btn);
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }
        
        .email-icon {
            width: 16px;
            height: 16px;
        }
        
        /* Connectors with animation */
        .connector {
            width: 8px;
            height: 40px;
            background-color: #ff6f00;
            margin: 0 auto;
            position: relative;
            z-index: 0;
        }
        
        .connector::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, transparent, rgba(52, 152, 219, 0.7));
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { opacity: 0; height: 0; }
            50% { opacity: 1; }
            100% { opacity: 0; height: 100%; }
        }
        
        .horizontal-connector {
            height: 12px;
            background-color: #bdc3c7;
            margin: 0 auto;
            width: 80%;
            position: relative;
        }
        
        .horizontal-connector::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to right, transparent, rgba(52, 152, 219, 0.7), transparent);
            animation: pulse-horizontal 2s infinite;
        }
        
        @keyframes pulse-horizontal {
            0% { opacity: 0; width: 0; left: 0; }
            50% { opacity: 1; }
            100% { opacity: 0; width: 100%; left: 0; }
        }
        
        .department-title {
            background-color: white;
            border-radius: var(--border-radius);
            padding: 15px 30px;
            text-align: center;
            margin-bottom: 15px;
            box-shadow: var(--shadow-sm);
            font-weight: 600;
            border: 1px solid rgba(0, 0, 0, 0.05);
            position: relative;
            overflow: hidden;
        }
        
        .department-title::before {
            content: '';
            position: absolute;
            width: 20px;
            height: 100%;
            background: rgba(52, 152, 219, 0.1);
            left: 0;
            top: 0;
        }
        
     
        .current-photo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #e0e0e0;
        }
        
      
        
       button:not(.fi-topbar-open-sidebar-btn):not(.fi-topbar-close-sidebar-btn) {
    padding: 12px 24px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    font-size: 15px;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}
        
        .btn-primary {
            background-color: var(--primary-btn);
            color: white;
        }
        
        .btn-primary:hover {
            background-color: var(--primary-btn-hover);
        }
        
        .btn-success {
            background-color: var(--success-btn);
            color: white;
        }
        
        .btn-success:hover {
            background-color: var(--success-btn-hover);
        }
        
        .btn-danger {
            background-color: var(--danger-btn);
            color: white;
        }
        
        .btn-danger:hover {
            background-color: var(--danger-btn-hover);
        }
        
        .btn-secondary {
            background-color: #ecf0f1;
            color: #7f8c8d;
        }
        
        .btn-secondary:hover {
            background-color: #bdc3c7;
            color: #2c3e50;
        }
        
        .actions {
            display: flex;
            gap: 15px;
            margin-top: 20px;
            justify-content: flex-end;
        }
        
        .add-employee {
            margin: 20px auto;
            padding: 15px 30px;
            border-radius: 30px;
            box-shadow: var(--shadow-sm);
            display: block;
            width: fit-content;
            font-weight: 500;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 50px;
            flex-wrap: wrap;
            gap: 20px;
        }
        
        .header h1 {
            font-weight: 700;
            color: #2c3e50;
            font-size: 32px;
            position: relative;
        }
        
        .header h1::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 60px;
            height: 3px;
            background: var(--primary-btn);
        }
        
        .search-container {
            display: flex;
            gap: 15px;
            position: relative;
        }
        
        .search-input {
            padding: 12px 20px 12px 45px;
            border: 1px solid #e0e0e0;
            border-radius: 50px;
            width: 300px;
            font-size: 15px;
            background-color: white;
            box-shadow: var(--shadow-sm);
        }
        
        .search-input:focus {
            outline: none;
            border-color: var(--primary-btn);
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
        }
        
        .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #bdc3c7;
        }
        
        /* Responsive styles */
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .department-container {
                flex-direction: column;
                align-items: center;
            }
            
            .search-input {
                width: 100%;
            }
            
            .search-container {
                width: 100%;
            }
            
            .modal-content {
                margin: 10% auto;
                width: 95%;
                padding: 20px;
            }
            
            .form-row {
                flex-direction: column;
            }
        }
      
        
        small {
            color: #7f8c8d;
            font-size: 12px;
            margin-top: 5px;
        }
    </style>

    <div class="container">
        <div class="header">
            <h1>Organization Chart</h1>
            <div class="search-container">
                <svg class="search-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
              <input type="text" id="searchInput" class="search-input" placeholder="Search by name, title or email..." wire:model.defer="search">
<button class="btn-primary" wire:click="searchEmployee">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="11" cy="11" r="8"></circle>
        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
    </svg>
    Search
</button>
            </div>
        </div>
 
<div class="org-chart">
    <div>
        @php
            $owners = $employees->where('role', 1);
            $managers = $employees->where('role', 2);
            $allEmployees = $employees->where('role',3);
        @endphp

        {{-- ✅ Show Owners if Available --}}
        @if ($owners->isNotEmpty())
            <div class="employee-container">
                @foreach ($owners as $owner)
                    <div class="">
                        <div class="card" wire:click="openEditModal({{ $owner->id }})"
                            wire:target="openEditModal"
                            wire:loading.class="opacity-50">
                            <div class="card-header owner"></div>
                            <div class="card-body">
                                <div class="profile-pic-container">
                                    <img class="profile-pic" src="{{ asset('storage/'. $owner->profile_pic) }}" alt="Profile"><div class="upload-overlay">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M12 20h9"></path>
        <path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19H3v-4L16.5 3.5z"></path>
    </svg>
</div>
                                </div>
                                <div class="name">{{ $owner->name }}</div>
                                <div class="title">{{ $owner->title }}</div>
                                <div class="email">{{ $owner->email }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="connector"></div>
            <div class="horizontal-connector"></div>
        @endif

        {{-- ✅ Show Managers Even if No Owners Exist --}}
        @if ($managers->isNotEmpty())
            <div class="department-container">
                @foreach ($managers as $manager)
                    <div class="department">
                        <div class="department-title">
                            {{ $departments[$manager->department_id] ?? 'General Department' }}
                        </div>
                        <div class="connector"></div>
                        <div class="card" wire:click="openEditModal({{ $manager->id }})"
                            wire:target="openEditModal"
                            wire:loading.class="opacity-50">
                            <div class="card-header" style="background-color: {{ $colors[$manager->department_id] ?? '#000000' }}"></div>
                            <div class="card-body">
                                <div class="profile-pic-container">
                                    <img class="profile-pic" src="{{ asset('storage/' . $manager->profile_pic) }}" alt="Profile">
                              <div class="upload-overlay">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M12 20h9"></path>
        <path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19H3v-4L16.5 3.5z"></path>
    </svg>
</div>  </div>
                                <div class="name">{{ $manager->name }}</div>
                                <div class="title">{{ $manager->title }}</div>
                                <div class="email">{{ $manager->email }}</div>
                            </div>
                        </div>

                        @php
                            $teamMembers = $employees->where('manager_id', $manager->id)->where('role', 3);
                        @endphp

                        {{-- ✅ Show Employees Even if No Managers Exist --}}
                        @if ($teamMembers->isNotEmpty())
                            <div class="connector"></div>
                            <div class="horizontal-connector"></div>
                            <div class="employee-container">
                                @foreach ($teamMembers as $member)
                                    <div class="card" wire:click="openEditModal({{ $member->id }})"
                                        wire:target="openEditModal"
                                        wire:loading.class="opacity-50">
                                        <div class="card-header" style="background-color: {{ $colors[$manager->department_id] ?? '#000000' }}"></div>
                                        <div class="card-body">
                                            <div class="profile-pic-container">
                                                <img class="profile-pic" src="{{ asset('storage/' . $member->profile_pic) }}" alt="Profile">
                       <div class="upload-overlay">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M12 20h9"></path>
        <path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19H3v-4L16.5 3.5z"></path>
    </svg>
</div>                     </div>
                                            <div class="name">{{ $member->name }}</div>
                                            <div class="title">{{ $member->title }}</div>
                                            <div class="email">{{ $member->email }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
             @php
            $employeesWithoutManagers = $allEmployees->whereNotIn('manager_id', $managers->pluck('id'));
        @endphp

        @if ($employeesWithoutManagers->isNotEmpty())
            <div class="employee-container">
                @foreach ($employeesWithoutManagers as $member)
                    <div class="card" wire:click="openEditModal({{ $member->id }})"

                                        wire:target="openEditModal"

                                        wire:loading.class="opacity-50">
                                        <div class="card-header" style="background-color: {{ $colors[$member->department_id] ?? '#000000' }}"></div>
                                        <div class="card-body">
                                            <div class="profile-pic-container">
                                                <img class="profile-pic" src="{{ asset('storage/' . $member->profile_pic) }}" alt="Profile">
                   <div class="upload-overlay">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M12 20h9"></path>
        <path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19H3v-4L16.5 3.5z"></path>
    </svg>
</div>                         </div>
                                            <div class="name">{{ $member->name }}</div>
                                            <div class="title">{{ $member->title }}</div>
                                            <div class="email">{{ $member->email }}</div>
                                        </div>
                                    </div>
                @endforeach
            </div>
        @endif
    
    </div>
        <div style="display: flex; justify-content: center; align-items: center; height: 100%; margin-top:12px;">
   <button style="--c-400:var(--primary-400);--c-500:var(--primary-500);--c-600:var(--primary-600);" class="fi-btn relative grid-flow-col items-center justify-center font-semibold outline-none transition duration-75 focus-visible:ring-2 rounded-lg fi-color-custom fi-btn-color-primary fi-color-primary fi-size-md fi-btn-size-md gap-1.5 px-3 py-2 text-sm inline-grid shadow-sm bg-custom-600 text-white hover:bg-custom-500 focus-visible:ring-custom-500/50 dark:bg-custom-500 dark:hover:bg-custom-400 dark:focus-visible:ring-custom-400/50 fi-ac-action fi-ac-btn-action" type="button" wire:loading.attr="disabled" wire:click="mountAction('addEmployee')">
    <!--[if BLOCK]><![endif]-->        <!--[if BLOCK]><![endif]-->            <!--[if BLOCK]><![endif]-->    <svg wire:loading.remove.delay.default="1" wire:target="mountAction('addEmployee')" class="fi-btn-icon transition duration-75 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path>
</svg><!--[if ENDBLOCK]><![endif]-->
        <!--[if ENDBLOCK]><![endif]-->

        <!--[if BLOCK]><![endif]-->            <svg fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="animate-spin fi-btn-icon transition duration-75 h-5 w-5 text-white" wire:loading.delay.default="" wire:target="mountAction('addEmployee')">
    <path clip-rule="evenodd" d="M12 19C15.866 19 19 15.866 19 12C19 8.13401 15.866 5 12 5C8.13401 5 5 8.13401 5 12C5 15.866 8.13401 19 12 19ZM12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" fill-rule="evenodd" fill="currentColor" opacity="0.2"></path>
    <path d="M2 12C2 6.47715 6.47715 2 12 2V5C8.13401 5 5 8.13401 5 12H2Z" fill="currentColor"></path>
</svg>
        <!--[if ENDBLOCK]><![endif]-->

        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
    <!--[if ENDBLOCK]><![endif]-->

    <span class="fi-btn-label">
        Add Employee
    </span>

    <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

    <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

    <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
</button>
</div>
</div>

        <script>

    </script>
   
    </x-filament-panels::page>