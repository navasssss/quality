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
        
        /* Modal Styling */
        .modal {
            display: none;
            position: fixed;
            z-index: 10;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(3px);
            animation: fadeIn 0.3s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideIn {
            from { transform: translateY(-50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        
        .modal-content {
            background-color: white;
            margin: 5% auto;
            padding: 30px;
            width: 90%;
            max-width: 600px;
            border-radius: var(--border-radius);
            position: relative;
            box-shadow: var(--shadow-lg);
            animation: slideIn 0.4s ease;
        }
        
        .close {
            position: absolute;
            right: 25px;
            top: 20px;
            font-size: 28px;
            font-weight: 700;
            cursor: pointer;
            transition: color 0.3s;
            color: #95a5a6;
        }
        
        .close:hover {
            color: var(--danger-btn);
        }
        
        .edit-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        
        .form-row {
            display: flex;
            gap: 20px;
        }
        
        .form-row .form-group {
            flex: 1;
        }
        
        label {
            font-weight: 500;
            color: #2c3e50;
            font-size: 15px;
        }
        
        input, select {
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 15px;
            color: #333;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s;
            background-color: #f9fafb;
        }
        
        input:focus, select:focus {
            outline: none;
            border-color: var(--primary-btn);
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
            background-color: white;
        }
        
        .photo-upload-container {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .current-photo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #e0e0e0;
        }
        
        .file-upload {
            position: relative;
            overflow: hidden;
            display: inline-block;
        }
        
        .file-upload-btn {
            border: 2px dashed #bdc3c7;
            color: #7f8c8d;
            background-color: #f9fafb;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 500;
            display: flex;
            gap: 10px;
            align-items: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .file-upload-btn:hover {
            border-color: var(--primary-btn);
            color: var(--primary-btn);
        }
        
        .file-upload input[type=file] {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
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
        
        .department-input-container {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        
        .add-dept-btn {
            height: 42px;
            width: 42px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
        }
        
        textarea {
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 15px;
            resize: vertical;
            font-family: 'Poppins', sans-serif;
            min-height: 80px;
            background-color: #f9fafb;
        }
        
        textarea:focus {
            outline: none;
            border-color: var(--primary-btn);
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
            background-color: white;
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
                <input type="text" id="searchInput" class="search-input" placeholder="Search by name, title or email...">
                <button class="btn-primary" onclick="searchEmployee()">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    Search
                </button>
            </div>
        </div>
        
        <div class="org-chart" id="orgChart">
            <!-- Chart will be dynamically generated here -->
        </div>
        
        <button class="add-employee btn-success" onclick="showAddEmployeeModal()">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Add New Employee
        </button>
    </div>
    
    <div class="modal" id="employeeModal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2 id="modalTitle">Edit Employee</h2>
            <form id="employeeForm" class="edit-form">
                <div class="photo-upload-container">
                    <img id="currentPhoto" class="current-photo" src="/api/placeholder/80/80" alt="Profile Photo">
                    <div class="file-upload">
                        <label for="photoUpload" class="file-upload-btn">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="17 8 12 3 7 8"></polyline>
                                <line x1="12" y1="3" x2="12" y2="15"></line>
                            </svg>
                            Upload Photo
                        </label>
                        <input type="file" id="photoUpload" accept="image/*" onchange="previewImage(this)">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" required placeholder="John Doe">
                    </div>
                    <div class="form-group">
                        <label for="title">Job Title</label>
                        <input type="text" id="title" required placeholder="Sales Manager">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" required placeholder="john.doe@company.com">
                </div>
                
                <div class="form-group">
                    <label for="responsibility">Responsibility</label>
                    <textarea id="responsibility" rows="3" placeholder="Enter job responsibilities or notes"></textarea>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="department">Department</label>
                        <div class="department-input-container">
                            <select id="department" required>
                                <option value="">Select Department</option>
                                <!-- Departments will be populated dynamically -->
                            </select>
                            <button type="button" class="btn-primary add-dept-btn" onclick="showAddDepartmentModal()">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="manager">Manager</label>
                        <select id="manager">
                            <option value="">None (Department Head)</option>
                        </select>
                    </div>
                </div>
                
                <input type="hidden" id="employeeId">
                <div class="actions">
                    <button type="button" class="btn-danger" id="deleteButton" onclick="confirmDelete()" style="display: none;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            <line x1="10" y1="11" x2="10" y2="17"></line>
                            <line x1="14" y1="11" x2="14" y2="17"></line>
                        </svg>
                        Delete
                    </button>
                    <button type="button" class="btn-secondary" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn-success">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                            <polyline points="17 21 17 13 7 13 7 21"></polyline>
                            <polyline points="7 3 7 8 15 8"></polyline>
                        </svg>
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="modal" id="departmentModal">
        <div class="modal-content">
            <span class="close" onclick="closeDepartmentModal()">&times;</span>
            <h2>Add New Department</h2>
            <form id="departmentForm" class="edit-form">
                <div class="form-group">
                    <label for="deptId">Department ID</label>
                    <input type="text" id="deptId" required placeholder="e.g., marketing, hr, it">
                    <small>Use lowercase letters without spaces (will be used as identifier)</small>
                </div>
                <div class="form-group">
                    <label for="deptName">Department Name</label>
                    <input type="text" id="deptName" required placeholder="e.g., Marketing, Human Resources, IT">
                </div>
                <div class="form-group">
                    <label for="deptColor">Department Color</label>
                    <input type="color" id="deptColor" value="#3498db">
                </div>
                <div class="actions">
                    <button type="button" class="btn-secondary" onclick="closeDepartmentModal()">Cancel</button>
                    <button type="submit" class="btn-success">Add Department</button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="modal" id="confirmModal">
        <div class="modal-content">
            <h2>Confirm Deletion</h2>
            <p>Are you sure you want to delete this employee? This action cannot be undone.</p>
            <div class="actions">
                <button type="button" class="btn-secondary" onclick="closeConfirmModal()">Cancel</button>
                <button type="button" class="btn-danger" onclick="deleteEmployee()">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                    </svg>
                    Delete
                </button>
            </div>
        </div>
    </div>
    
    <script>
       let employeesData = [
    {
        id: 1,
        name: "George Kaplan",
        title: "Owner",
        email: "g.kaplan@xyz.com",
        department: null,
        role: "owner",
        profilePic: "/api/placeholder/100/100",
        responsibility: "Overall business strategy and leadership."
    },
    {
        id: 2,
        name: "Sandra Sellers",
        title: "Accounting Manager",
        email: "s.sellers@xyz.com",
        department: "accounting",
        role: "manager",
        profilePic: "/api/placeholder/100/100",
        responsibility: "Managing financial operations and accounting team."
    },
    {
        id: 3,
        name: "Daniel Weaver",
        title: "Sales Manager",
        email: "d.weaver@xyz.com",
        department: "sales",
        role: "manager",
        profilePic: "/api/placeholder/100/100",
        responsibility: "Overseeing sales targets, client relationships, and sales team."
    },
    {
        id: 4,
        name: "Megan Findley",
        title: "Office Manager",
        email: "m.findley@xyz.com",
        department: "administration",
        role: "manager",
        profilePic: "/api/placeholder/100/100",
        responsibility: "Coordinating office operations and administrative staff."
    },
    {
        id: 5,
        name: "Carly Jenkins",
        title: "Accountant",
        email: "c.jenkins@xyz.com",
        department: "accounting",
        role: "employee",
        manager: 2, 
        profilePic: "/api/placeholder/100/100",
        responsibility: "Managing accounts payable and monthly financial reports."
    },
    {
        id: 6,
        name: "Dennis Arthur",
        title: "Accountant",
        email: "d.arthur@xyz.com",
        department: "accounting",
        role: "employee",
        manager: 2, 
        profilePic: "/api/placeholder/100/100",
        responsibility: "Managing accounts receivable and payroll processing."
    },
    {
        id: 7,
        name: "Amanda Byron",
        title: "Sales Associate",
        email: "a.byron@xyz.com",
        department: "sales",
        role: "employee",
        manager: 3, 
        profilePic: "/api/placeholder/100/100",
        responsibility: "New client acquisition and territory management."
    },
    {
        id: 8,
        name: "John Johnson",
        title: "Sales Associate",
        email: "j.johnson@xyz.com",
        department: "sales",
        role: "employee",
        manager: 3, 
        profilePic: "/api/placeholder/100/100",
        responsibility: "Account management for existing clients."
    },
    {
        id: 9,
        name: "Annie Lee",
        title: "Admin Assistant",
        email: "a.lee@xyz.com",
        department: "administration",
        role: "employee",
        manager: 4, 
        profilePic: "/api/placeholder/100/100",
        responsibility: "Reception, correspondence, and office supply management."
    }
];
        // Department information
        let departments = {
    accounting: {
        name: "Accounting & Finance",
        class: "accounting"
    },
    sales: {
        name: "Sales",
        class: "sales"
    },
    administration: {
        name: "Administration",
        class: "administration"
    }
};

        // Function to render the org
        function renderOrgChart() {
    const orgChart = document.getElementById("orgChart");
    orgChart.innerHTML = "";

    // Get the owner (CEO)
    const owner = employeesData.find(emp => emp.role === "owner");

    // Create the owner level
    const ownerLevel = document.createElement("div");
    ownerLevel.className = "level";
    ownerLevel.appendChild(createEmployeeCard(owner));
    orgChart.appendChild(ownerLevel);

    // Connector from Owner to Departments
    const connector = document.createElement("div");
    connector.className = "connector";
    orgChart.appendChild(connector);

    // Get all managers (heads of departments)
    const managers = employeesData.filter(emp => emp.role === "manager");

    // Create a container for department heads
    const departmentLevel = document.createElement("div");
    departmentLevel.className = "department-container";

    managers.forEach(manager => {
        const department = document.createElement("div");
        department.className = "department";

        // Create Department Title
        const departmentTitle = document.createElement("div");
        departmentTitle.className = "department-title";
        departmentTitle.textContent = departments[manager.department]?.name || "General Department";
        department.appendChild(departmentTitle);

        // Create connector
        const deptConnector = document.createElement("div");
        deptConnector.className = "connector";
        department.appendChild(deptConnector);

        // Add the manager card
        department.appendChild(createEmployeeCard(manager));

        // Find employees under this manager
        const teamMembers = employeesData.filter(emp => emp.manager === manager.id);

        if (teamMembers.length > 0) {
            // Connector to Employees
            const teamConnector = document.createElement("div");
            teamConnector.className = "connector";
            department.appendChild(teamConnector);

            // Horizontal Connector
            const teamHorizontalConnector = document.createElement("div");
            teamHorizontalConnector.className = "horizontal-connector";
            department.appendChild(teamHorizontalConnector);

            // Employee Container
            const teamContainer = document.createElement("div");
            teamContainer.className = "employee-container";

            // Add employees under this manager
            teamMembers.forEach(member => {
                teamContainer.appendChild(createEmployeeCard(member));
            });

            department.appendChild(teamContainer);
        }

        departmentLevel.appendChild(department);
    });

    orgChart.appendChild(departmentLevel);
}

// Function to create employee card
function createEmployeeCard(employee) {
    const card = document.createElement("div");
    card.className = "employee-card";
    
    const profilePic = document.createElement("img");
    profilePic.src = employee.profilePic;
    profilePic.alt = employee.name;
    
    const name = document.createElement("h4");
    name.textContent = employee.name;

    const title = document.createElement("p");
    title.textContent = employee.title;

    card.appendChild(profilePic);
    card.appendChild(name);
    card.appendChild(title);

    return card;
}    // Function to create an employee card
        function createEmployeeCard(employee) {
            const card = document.createElement("div");
            card.className = "card";
            card.onclick = () => showEditEmployeeModal(employee.id);
            
            const cardHeader = document.createElement("div");
            cardHeader.className = "card-header";
            
            if (employee.department) {
                cardHeader.classList.add(departments[employee.department].class);
            } else {
                cardHeader.classList.add("owner");
            }
            
            const cardBody = document.createElement("div");
            cardBody.className = "card-body";
            
            const profilePicContainer = document.createElement("div");
            profilePicContainer.className = "profile-pic-container";
            
            const profilePic = document.createElement("img");
            profilePic.className = "profile-pic";
            profilePic.src = employee.profilePic || "/api/placeholder/100/100";
            profilePic.alt = employee.name;
            
            const uploadOverlay = document.createElement("div");
            uploadOverlay.className = "upload-overlay";
            uploadOverlay.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>';
            
            profilePicContainer.appendChild(profilePic);
            profilePicContainer.appendChild(uploadOverlay);
            
            const name = document.createElement("div");
            name.className = "name";
            name.textContent = employee.name;
            
            const title = document.createElement("div");
            title.className = "title";
            title.textContent = employee.title;
            
            const email = document.createElement("div");
            email.className = "email";
            email.innerHTML = `
                <svg class="email-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                    <polyline points="22,6 12,13 2,6"></polyline>
                </svg>
                ${employee.email}
            `;
            
            cardBody.appendChild(profilePicContainer);
            cardBody.appendChild(name);
            cardBody.appendChild(title);
            cardBody.appendChild(email);
            
            card.appendChild(cardHeader);
            card.appendChild(cardBody);
            
            return card;
        }
        
        // Modal functions
        function showEditEmployeeModal(employeeId) {
            const modal = document.getElementById("employeeModal");
            const form = document.getElementById("employeeForm");
            const modalTitle = document.getElementById("modalTitle");
            const deleteButton = document.getElementById("deleteButton");
            modalTitle.textContent = "Edit Employee";
            
            const employee = employeesData.find(emp => emp.id === employeeId);
            
            document.getElementById("name").value = employee.name;
            document.getElementById("title").value = employee.title;
            document.getElementById("email").value = employee.email;
            document.getElementById("department").value = employee.department || "";
            document.getElementById("currentPhoto").src = employee.profilePic || "/api/placeholder/100/100";
            document.getElementById("responsibility").value = employee.responsibility || "";
            
            // Show delete button for existing employees
            deleteButton.style.display = "flex";
            
            // Populate manager dropdown
            populateManagerDropdown(employee.department, employee.id);
            
            document.getElementById("manager").value = employee.manager || "";
            document.getElementById("employeeId").value = employee.id;
            
            modal.style.display = "block";
        }
        
        // Function to show add employee modal
        function showAddEmployeeModal() {
            const modal = document.getElementById("employeeModal");
            const form = document.getElementById("employeeForm");
            const modalTitle = document.getElementById("modalTitle");
            const deleteButton = document.getElementById("deleteButton");
            modalTitle.textContent = "Add New Employee";
            
            // Clear form
            form.reset();
            document.getElementById("employeeId").value = "";
            document.getElementById("currentPhoto").src = "/api/placeholder/100/100";
            document.getElementById("responsibility").value = "";
            
            // Hide delete button for new employees
            deleteButton.style.display = "none";
            
            // Populate department dropdown
            populateDepartmentDropdown();
            
            // Populate manager dropdown with all potential managers
            populateManagerDropdown();
            
            modal.style.display = "block";
        }
        
        function closeModal() {
            const modal = document.getElementById("employeeModal");
            modal.style.display = "none";
        }
        
        // Function to populate department dropdown
        function populateDepartmentDropdown() {
            const departmentDropdown = document.getElementById("department");
            
            // Clear existing options except the first one
            while (departmentDropdown.options.length > 1) {
                departmentDropdown.remove(1);
            }
            
            // Add department options
            Object.keys(departments).forEach(deptKey => {
                const option = document.createElement("option");
                option.value = deptKey;
                option.textContent = departments[deptKey].name;
                departmentDropdown.appendChild(option);
            });
        }
        
        // Function to populate manager dropdown based on department
        function populateManagerDropdown(department = null, employeeId = null) {
            const managerDropdown = document.getElementById("manager");
            
            // Clear existing options except the first one
            while (managerDropdown.options.length > 1) {
                managerDropdown.remove(1);
            }
            
            // Owner is always a potential manager
            const owner = employeesData.find(emp => emp.manager === null);
            const ownerOption = document.createElement("option");
            ownerOption.value = owner.id;
            ownerOption.textContent = `${owner.name} (${owner.title})`;
            managerDropdown.appendChild(ownerOption);
            
            // If department is selected, add department head as an option
            if (department) {
                const departmentHead = employeesData.find(
                    emp => emp.department === department && 
                    emp.manager === owner.id &&
                    emp.id !== employeeId
                );
                
                if (departmentHead) {
                    const deptHeadOption = document.createElement("option");
                    deptHeadOption.value = departmentHead.id;
                    deptHeadOption.textContent = `${departmentHead.name} (${departmentHead.title})`;
                    managerDropdown.appendChild(deptHeadOption);
                }
            } else {
                // If no department selected, add all department heads
                const departmentHeads = employeesData.filter(
                    emp => emp.manager === owner.id && emp.id !== employeeId
                );
                
                departmentHeads.forEach(head => {
                    const option = document.createElement("option");
                    option.value = head.id;
                    option.textContent = `${head.name} (${head.title})`;
                    managerDropdown.appendChild(option);
                });
            }
        }
        
        // Preview image before upload
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    document.getElementById('currentPhoto').src = e.target.result;
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }
        
        // Function to show add department modal
        function showAddDepartmentModal() {
            const modal = document.getElementById("departmentModal");
            document.getElementById("departmentForm").reset();
            modal.style.display = "block";
        }
        
        // Function to close department modal
        function closeDepartmentModal() {
            const modal = document.getElementById("departmentModal");
            modal.style.display = "none";
        }
        
        // Function to confirm deletion
        function confirmDelete() {
            const modal = document.getElementById("confirmModal");
            modal.style.display = "block";
            
            // Hide the employee modal
            document.getElementById("employeeModal").style.display = "none";
        }
        
        // Function to close confirm modal
        function closeConfirmModal() {
            const confirmModal = document.getElementById("confirmModal");
            confirmModal.style.display = "none";
            
            // Show the employee modal again
            document.getElementById("employeeModal").style.display = "block";
        }
        
        // Function to delete an employee
        function deleteEmployee() {
            const employeeId = parseInt(document.getElementById("employeeId").value);
            
            // Check if any employees report to this person
            const hasReports = employeesData.some(emp => emp.manager === employeeId);
            
            if (hasReports) {
                alert("Cannot delete this employee. Please reassign their direct reports first.");
                closeConfirmModal();
                document.getElementById("employeeModal").style.display = "block";
                return;
            }
            
            // Remove employee from array
            employeesData = employeesData.filter(emp => emp.id !== employeeId);
            
            // Close all modals
            closeConfirmModal();
            closeModal();
            
            // Redraw org chart
            renderOrgChart();
        }
        
        // Function to add department style
        function addDepartmentStyle(deptId, color) {
            const style = document.createElement('style');
            const lightColor = adjustColor(color, 20); // Create a lighter version
            
            style.textContent = `
                .${deptId} {
                    background: linear-gradient(135deg, ${color}, ${lightColor});
                }
            `;
            
            document.head.appendChild(style);
        }
        
        // Function to adjust color brightness
        function adjustColor(color, percent) {
            const num = parseInt(color.replace("#", ""), 16),
                amt = Math.round(2.55 * percent),
                R = (num >> 16) + amt,
                G = (num >> 8 & 0x00FF) + amt,
                B = (num & 0x0000FF) + amt;
                
            return "#" + (
                0x1000000 +
                (R < 255 ? (R < 0 ? 0 : R) : 255) * 0x10000 +
                (G < 255 ? (G < 0 ? 0 : G) : 255) * 0x100 +
                (B < 255 ? (B < 0 ? 0 : B) : 255)
            ).toString(16).slice(1);
        }
        
        // Search function
        function searchEmployee() {
            const searchTerm = document.getElementById("searchInput").value.toLowerCase();
            
            if (!searchTerm) {
                renderOrgChart();
                return;
            }
            
            const matchingEmployees = employeesData.filter(emp => 
                emp.name.toLowerCase().includes(searchTerm) || 
                emp.title.toLowerCase().includes(searchTerm) || 
                emp.email.toLowerCase().includes(searchTerm)
            );
            
            if (matchingEmployees.length === 0) {
                alert("No employees found matching your search.");
                return;
            }
            
            // Display only matching employees
            const orgChart = document.getElementById("orgChart");
            orgChart.innerHTML = "";
            
            const searchResultsContainer = document.createElement("div");
            searchResultsContainer.className = "employee-container";
            searchResultsContainer.style.marginTop = "20px";
            
            const searchHeader = document.createElement("h2");
            searchHeader.textContent = "Search Results";
            searchHeader.style.width = "100%";
            searchHeader.style.textAlign = "center";
            
            orgChart.appendChild(searchHeader);
            
            matchingEmployees.forEach(employee => {
                searchResultsContainer.appendChild(createEmployeeCard(employee));
            });
            
            orgChart.appendChild(searchResultsContainer);
            
            // Add a button to go back to full chart
            const backButton = document.createElement("button");
            backButton.textContent = "Back to Full Organization Chart";
            backButton.onclick = renderOrgChart;
            backButton.style.margin = "20px auto";
            backButton.style.display = "block";
            
            orgChart.appendChild(backButton);
        }
        
        // Setup event listeners when the DOM is fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Populate department dropdown on initial load
            populateDepartmentDropdown();
            
            // Handle department change
            document.getElementById("department").addEventListener("change", function() {
                const department = this.value;
                const employeeId = document.getElementById("employeeId").value;
                populateManagerDropdown(department, employeeId ? parseInt(employeeId) : null);
            });
            
            // Handle form submission for employee
            document.getElementById("employeeForm").addEventListener("submit", function(e) {
                e.preventDefault();
                
                const employeeId = document.getElementById("employeeId").value;
                const name = document.getElementById("name").value;
                const title = document.getElementById("title").value;
                const email = document.getElementById("email").value;
                const department = document.getElementById("department").value;
                const manager = document.getElementById("manager").value;
                const responsibility = document.getElementById("responsibility").value;
                const photoEl = document.getElementById('currentPhoto');
                
                if (employeeId) {
                    // Update existing employee
                    const employee = employeesData.find(emp => emp.id === parseInt(employeeId));
                    employee.name = name;
                    employee.title = title;
                    employee.email = email;
                    employee.department = department || null;
                    employee.manager = manager ? parseInt(manager) : null;
                    employee.responsibility = responsibility;
                    
                    // Update profile pic if changed
                    if (photoEl.src !== employee.profilePic) {
                        employee.profilePic = photoEl.src;
                    }
                } else {
                    // Add new employee
                    const newId = Math.max(...employeesData.map(emp => emp.id)) + 1;
                    employeesData.push({
                        id: newId,
                        name,
                        title,
                        email,
                        department: department || null,
                        manager: manager ? parseInt(manager) : null,
                        profilePic: photoEl.src,
                        responsibility: responsibility
                    });
                }
                
                // Redraw org chart
                renderOrgChart();
                closeModal();
            });
            
            // Handle form submission for department
            document.getElementById("departmentForm").addEventListener("submit", function(e) {
                e.preventDefault();
                
                const deptId = document.getElementById("deptId").value;
                const deptName = document.getElementById("deptName").value;
                const deptColor = document.getElementById("deptColor").value;
                
                // Check if department ID already exists
                if (departments[deptId]) {
                    alert("Department ID already exists. Please choose a different one.");
                    return;
                }
                
                // Add new department
                departments[deptId] = {
                    name: deptName,
                    class: deptId
                };
                
                // Add department style
                addDepartmentStyle(deptId, deptColor);
                
                // Update department dropdown
                populateDepartmentDropdown();
                
                // Close modal
                closeDepartmentModal();
            });
            
            // Initialize chart
            renderOrgChart();
        });
    </script>
    </x-filament-panels::page>