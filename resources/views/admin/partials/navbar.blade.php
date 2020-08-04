<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="{{route('admin.dashboard')}}">L6 Ecommerce</a>
    <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            <a class="nav-link" href="#">Sign out</a>
        </li>
    </ul>
</nav>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link @if(Request::url() === route('admin.dashboard')) {{'active'}} @endif"
                            href="{{route('admin.dashboard')}}">
                            <i data-feather="home"></i>
                            Dashboard <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i data-feather="file-text"></i>
                            Orders
                        </a>
                    </li>
                    <li class="nav-item">
                        <a id="navbarDropdown" href="{{route('admin.product.index')}}" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre
                            class="nav-link @if(Request::url() === route('admin.product.index')) {{'active'}} @endif dropdown-toggle"
                            href="{{route('admin.category.index')}}">
                            <i data-feather="shopping-cart"></i>
                            Products
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{route('admin.product.index')}}">All Products</a>
                            <a class="dropdown-item" href="{{route('admin.product.create')}}">Add Product</a>
                            <a class="dropdown-item" href="{{route('admin.product.trash')}}">Trash Products</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a id="navbarDropdown" href="{{route('admin.category.index')}}" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre
                            class="nav-link @if(Request::url() === route('admin.category.index')) {{'active'}} @endif dropdown-toggle"
                            href="{{route('admin.category.index')}}">
                            <i data-feather="tag"></i>
                            Categories
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{route('admin.category.index')}}">All Categories</a>
                            <a class="dropdown-item" href="{{route('admin.category.create')}}">Add Categories</a>
                            <a class="dropdown-item" href="{{route('admin.category.trash')}}">Trash Categories</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i data-feather="users"></i>
                            Customers
                        </a>
                    </li>
                    <li class="nav-item">
                        <a id="navbarDropdown" href="{{route('admin.category.index')}}" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre
                            class="nav-link @if(Request::url() === route('admin.profile.index')) {{'active'}} @endif dropdown-toggle"
                            href="{{route('admin.profile.index')}}">
                            <i data-feather="users"></i>
                            Users
                        </a>
                        <div class="dropdown-menu dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{route('admin.profile.index')}}">All Users</a>
                            <a class="dropdown-item" href="{{route('admin.profile.create')}}">Add User</a>
                            <a class="dropdown-item" href="{{route('admin.profile.trash')}}">Trash Users</a>
                        </div>
                    </li>
                </ul>

                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Saved reports</span>
                    <a class="d-flex align-items-center text-muted" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-plus-circle">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="16"></line>
                            <line x1="8" y1="12" x2="16" y2="12"></line>
                        </svg>
                    </a>
                </h6>
                <ul class="nav flex-column mb-2">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-file-text">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                            Current month
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-file-text">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                            Last quarter
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-file-text">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                            Social engagement
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-file-text">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                            Year-end sale
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>