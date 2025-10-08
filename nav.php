<header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
        <span class="d-none d-lg-block">Geo|Attendance</span>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>
    
    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            <li class="nav-item dropdown">
                <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-bell"></i>
                    <span class="badge bg-primary badge-number">2</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                    <li class="dropdown-header">
                        You have 2 new notifications
                        <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li class="notification-item">
                        <i class="bi bi-exclamation-circle text-warning"></i>
                        <div>
                            <h4>SUBJECT: Reminder</h4>
                            <p>- Attendance: Submit attendance before time is up<br></p>
                            <p>10 min. ago</p>
                        </div>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li class="notification-item">
                        <i class="bi bi-x-circle text-danger"></i>
                        <div>
                            <h4>SUBJECT: Successfully submitted attendance</h4>
                            <p>Attendance Successfully submitted</p>
                            <p>20 hr. ago</p>
                        </div>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li class="dropdown-footer">
                        <a href="#">Show all notifications</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown pe-3">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <span class="d-none d-md-block dropdown-toggle ps-2">Hope Soko</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6>Hope Soko</h6>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                            <i class="bi bi-gear"></i>
                            <span>Account Settings</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="logout.php">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Sign Out</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</header>
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-heading">MENU</li>
        <li class="nav-item">
            <a class="nav-link " href="view.php">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <!--<li class="nav-item">
            <a class="nav-link collapsed" href="events.html">
                <i class="bi bi-card-list"></i>
                <span>Events</span>-->
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="attendance.php">
                <i class="bi bi-person-check-fill"></i>
                <span>Attendance Recorder</span>
            </a>
        </li>
        <!--<li class="nav-item">
            <a class="nav-link collapsed" href="leave.html">
                <i class="bi bi-box-arrow-in-right"></i>
                <span>Leave Management</span>
            </a>
        </li>-->
        <li class="nav-item">
            <a class="nav-link collapsed" href="summary.php">
                <i class="bi bi-clipboard-data"></i>
                <span>Attendance Summary</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="task.php">
                <i class="bi bi-calendar-event-fill"></i>
                <span>Task Board</span>
            </a>
        </li>
        <!--<li class="nav-item">
            <a class="nav-link collapsed" href="users.php">
                <i class="bi bi-person"></i>
                <span>Profile</span>-->
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="logout.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
            </a>
        </li>
    </ul>
</aside>